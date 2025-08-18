<?php

namespace Modules\SupportTicket\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\SupportTicket\Models\SupportTicket;
use Illuminate\Support\Facades\Auth;

class SupportTicketController extends Controller
{
    /**
     * Display customer's support tickets.
     */
    public function index()
    {
        $tickets = SupportTicket::with(['messages.author'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('support-ticket::tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new ticket.
     */
    public function create()
    {
        $categories = SupportTicket::getAvailableCategories();
        $priorities = SupportTicket::getAvailablePriorities();
        
        return view('support-ticket::tickets.create', compact('categories', 'priorities'));
    }

    /**
     * Store a newly created ticket.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'category' => 'nullable|string|max:255',
            'priority' => 'required|in:low,normal,high,urgent',
        ]);

        $ticket = SupportTicket::create([
            'user_id' => Auth::id(),
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'category' => $validatedData['category'],
            'priority' => $validatedData['priority'],
            'status' => 'new',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('support-ticket::tickets.show', $ticket)
                        ->with('success', __('messages.support_ticket_created_successfully'));
    }

    /**
     * Display the specified ticket.
     */
    public function show(SupportTicket $ticket)
    {
        // Ensure user can only view their own tickets
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to view this ticket.');
        }

        $ticket->load(['user', 'assignedTo', 'messages.author']);

        return view('support-ticket::tickets.show', compact('ticket'));
    }

    /**
     * Get ticket statistics for customer dashboard.
     */
    public function getStats()
    {
        $userId = Auth::id();
        
        $stats = [
            'total' => SupportTicket::where('user_id', $userId)->count(),
            'new' => SupportTicket::where('user_id', $userId)->where('status', 'new')->count(),
            'open' => SupportTicket::where('user_id', $userId)->where('status', 'open')->count(),
            'in_progress' => SupportTicket::where('user_id', $userId)->where('status', 'in_progress')->count(),
            'resolved' => SupportTicket::where('user_id', $userId)->where('status', 'resolved')->count(),
            'closed' => SupportTicket::where('user_id', $userId)->where('status', 'closed')->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Search tickets for customer.
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $status = $request->get('status', '');
        
        $tickets = SupportTicket::where('user_id', Auth::id())
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%");
                });
            })
            ->when($status, function ($queryBuilder) use ($status) {
                $queryBuilder->where('status', $status);
            })
            ->with(['messages'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'html' => view('support-ticket::tickets.partials.ticket-list', compact('tickets'))->render(),
                'pagination' => $tickets->links()->toHtml()
            ]);
        }

        return view('support-ticket::tickets.index', compact('tickets'));
    }

    /**
     * Close a ticket (customer can only close their own tickets).
     */
    public function close(SupportTicket $ticket)
    {
        // Ensure user can only close their own tickets
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to close this ticket.');
        }

        // Only allow closing if ticket is not already closed
        if ($ticket->isClosed()) {
            return redirect()->back()->with('error', 'This ticket is already closed.');
        }

        $ticket->markAsClosed();

        return redirect()->back()->with('success', __('messages.support_ticket_closed_successfully'));
    }

    /**
     * Reopen a closed ticket.
     */
    public function reopen(SupportTicket $ticket)
    {
        // Ensure user can only reopen their own tickets
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to reopen this ticket.');
        }

        // Only allow reopening if ticket is closed
        if (!$ticket->isClosed()) {
            return redirect()->back()->with('error', 'This ticket is not closed.');
        }

        $ticket->update([
            'status' => 'open',
            'closed_at' => null
        ]);

        return redirect()->back()->with('success', __('messages.support_ticket_reopened_successfully'));
    }

    /**
     * Rate the support experience (if implementing rating system).
     */
    public function rate(Request $request, SupportTicket $ticket)
    {
        // Ensure user can only rate their own tickets
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to rate this ticket.');
        }

        $validatedData = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:1000',
        ]);

        // This would require adding rating fields to the tickets table
        // For now, just return success
        return response()->json([
            'success' => true,
            'message' => __('messages.support_ticket_rated_successfully')
        ]);
    }

    /**
     * Check if user has permission to perform action on ticket.
     */
    private function canAccessTicket(SupportTicket $ticket): bool
    {
        return $ticket->user_id === Auth::id();
    }

    /**
     * Get recent tickets for dashboard widget.
     */
    public function getRecentTickets(int $limit = 5)
    {
        $tickets = SupportTicket::where('user_id', Auth::id())
            ->with(['messages'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'tickets' => $tickets->map(function ($ticket) {
                return [
                    'id' => $ticket->id,
                    'title' => $ticket->title,
                    'status' => $ticket->status,
                    'status_badge' => $ticket->status_badge,
                    'priority' => $ticket->priority,
                    'priority_badge' => $ticket->priority_badge,
                    'created_at' => $ticket->created_at->format('M d, Y'),
                    'created_at_human' => $ticket->created_at->diffForHumans(),
                    'message_count' => $ticket->message_count,
                    'url' => route('support-ticket::tickets.show', $ticket),
                ];
            })
        ]);
    }

    /**
     * Export user's tickets (CSV format).
     */
    public function export()
    {
        $tickets = SupportTicket::where('user_id', Auth::id())
            ->with(['messages'])
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'my_support_tickets_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($tickets) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Ticket ID',
                'Title',
                'Description',
                'Status',
                'Priority',
                'Category',
                'Messages',
                'Created At',
                'Closed At'
            ]);

            // CSV data
            foreach ($tickets as $ticket) {
                fputcsv($file, [
                    $ticket->id,
                    $ticket->title,
                    $ticket->description,
                    $ticket->status,
                    $ticket->priority,
                    $ticket->category,
                    $ticket->message_count,
                    $ticket->created_at->format('Y-m-d H:i:s'),
                    $ticket->closed_at ? $ticket->closed_at->format('Y-m-d H:i:s') : ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}