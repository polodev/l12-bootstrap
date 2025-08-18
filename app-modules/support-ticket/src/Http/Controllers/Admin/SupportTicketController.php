<?php

namespace Modules\SupportTicket\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Modules\SupportTicket\Models\SupportTicket;
use Yajra\DataTables\Facades\DataTables;

class SupportTicketController extends Controller
{
    public function index()
    {
        return view('support-ticket::admin.tickets.index');
    }

    public function indexJson(Request $request)
    {
        try {
            $model = SupportTicket::with(['user', 'assignedTo']);

        return DataTables::eloquent($model)
            ->filter(function ($query) use ($request) {
                if ($request->filled('search_text')) {
                    $searchText = $request->get('search_text');
                    $query->where(function ($q) use ($searchText) {
                        $q->where('title', 'like', "%{$searchText}%")
                          ->orWhere('description', 'like', "%{$searchText}%")
                          ->orWhereHas('user', function ($userQuery) use ($searchText) {
                              $userQuery->where('name', 'like', "%{$searchText}%")
                                       ->orWhere('email', 'like', "%{$searchText}%");
                          });
                    });
                }
                
                if ($request->filled('status')) {
                    $query->where('status', $request->get('status'));
                }
                
                if ($request->filled('priority')) {
                    $query->where('priority', $request->get('priority'));
                }
                
                if ($request->filled('category')) {
                    $query->where('category', $request->get('category'));
                }
                
                if ($request->filled('assigned_to')) {
                    $query->where('assigned_to', $request->get('assigned_to'));
                }
                
                if ($request->filled('user_id')) {
                    $query->where('user_id', $request->get('user_id'));
                }
            }, true)
            ->addColumn('formatted_id', function (SupportTicket $ticket) {
                if (!$ticket || !$ticket->id) {
                    return '<span class="text-gray-400">#ERROR</span>';
                }
                return '<a href="' . route('support-ticket::admin.tickets.show', $ticket) . '" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-blue-600 dark:bg-blue-500 rounded hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors shadow-sm" title="View Ticket">' .
                       '<span class="font-mono">#' . $ticket->id . '</span>' .
                       '</a>';
            })
            ->addColumn('ticket_info', function (SupportTicket $ticket) {
                $html = '<div class="max-w-xs">';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100 truncate" title="' . htmlspecialchars($ticket->title) . '">' . htmlspecialchars($ticket->title) . '</div>';
                $html .= '<div class="text-xs text-gray-500 dark:text-gray-400 mt-1">' . $ticket->truncated_description . '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('customer_info', function (SupportTicket $ticket) {
                $user = $ticket->user;
                if (!$user) {
                    return '<div class="text-red-500 text-xs">User not found</div>';
                }
                $html = '<div class="flex items-center">';
                $html .= '<div>';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . htmlspecialchars($user->name) . '</div>';
                $html .= '<div class="text-xs text-gray-500 dark:text-gray-400">' . htmlspecialchars($user->email) . '</div>';
                $html .= '</div></div>';
                return $html;
            })
            ->addColumn('status_badge', function (SupportTicket $ticket) {
                return $ticket->status_badge;
            })
            ->addColumn('priority_badge', function (SupportTicket $ticket) {
                return $ticket->priority_badge;
            })
            ->addColumn('category_badge', function (SupportTicket $ticket) {
                return $ticket->category_badge;
            })
            ->addColumn('assigned_info', function (SupportTicket $ticket) {
                if (!$ticket->assignedTo) {
                    return '<span class="text-gray-400 dark:text-gray-500 text-xs">Unassigned</span>';
                }
                return '<div class="text-sm font-medium text-gray-900 dark:text-gray-100">' . htmlspecialchars($ticket->assignedTo->name) . '</div>';
            })
            ->addColumn('messages_count', function (SupportTicket $ticket) {
                if (!$ticket || !$ticket->id) {
                    return '<div class="text-center text-gray-400">0</div>';
                }
                $count = $ticket->messages()->count();
                $lastMessage = $ticket->messages()->latest('created_at')->first();
                $html = '<div class="text-center">';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . $count . '</div>';
                if ($lastMessage) {
                    $html .= '<div class="text-xs text-gray-500 dark:text-gray-400">' . $lastMessage->created_at->diffForHumans() . '</div>';
                }
                $html .= '</div>';
                return $html;
            })
            ->addColumn('created_at_formatted', function (SupportTicket $ticket) {
                return $ticket->created_at->format('M d, Y H:i');
            })
            ->addColumn('action', function (SupportTicket $ticket) {
                if (!$ticket || !$ticket->id) {
                    return '<div class="text-gray-400 text-xs">N/A</div>';
                }
                $actions = '<div class="flex items-center justify-center space-x-1">';
                $actions .= '<a href="' . route('support-ticket::admin.tickets.show', $ticket) . '" class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded hover:bg-blue-200" title="View">';
                $actions .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>';
                $actions .= '</a>';
                $actions .= '<a href="' . route('support-ticket::admin.tickets.edit', $ticket) . '" class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 rounded hover:bg-yellow-200" title="Edit">';
                $actions .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>';
                $actions .= '</a>';
                $actions .= '</div>';
                return $actions;
            })
            ->rawColumns(['formatted_id', 'ticket_info', 'customer_info', 'status_badge', 'priority_badge', 'category_badge', 'assigned_info', 'messages_count', 'action'])
            ->make(true);
        } catch (\Exception $e) {
            \Log::error('Support Ticket DataTables Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'draw' => $request->get('draw', 1),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'Error loading data: ' . $e->getMessage()
            ]);
        }
    }

    public function show(SupportTicket $ticket)
    {
        $ticket->load(['user', 'assignedTo', 'messages.author']);
        $assignableUsers = User::whereIn('role', ['admin', 'employee', 'developer'])->get();
        
        return view('support-ticket::admin.tickets.show', compact('ticket', 'assignableUsers'));
    }

    public function edit(SupportTicket $ticket)
    {
        $assignableUsers = User::whereIn('role', ['admin', 'employee', 'developer'])->get();
        
        return view('support-ticket::admin.tickets.edit', compact('ticket', 'assignableUsers'));
    }

    public function update(Request $request, SupportTicket $ticket)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:new,open,in_progress,resolved,closed',
            'priority' => 'required|in:low,normal,high,urgent',
            'category' => 'nullable|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        // Handle status change to closed/resolved
        if (in_array($validatedData['status'], ['closed', 'resolved']) && !$ticket->isClosed()) {
            $validatedData['closed_at'] = now();
        } elseif (!in_array($validatedData['status'], ['closed', 'resolved']) && $ticket->isClosed()) {
            $validatedData['closed_at'] = null;
        }

        $ticket->update($validatedData);
        
        return redirect()->route('support-ticket::admin.tickets.index')
                        ->with('success', 'Support ticket updated successfully.');
    }

    public function destroy(SupportTicket $ticket)
    {
        // Prevent ticket deletion for data integrity and audit trail
        return response()->json([
            'success' => false, 
            'message' => 'Support tickets cannot be deleted for audit trail integrity. Please close the ticket instead.'
        ], 403);
    }

    /**
     * Get statistics for dashboard.
     */
    public function getStats()
    {
        $stats = [
            'total' => SupportTicket::count(),
            'new' => SupportTicket::where('status', 'new')->count(),
            'open' => SupportTicket::where('status', 'open')->count(),
            'in_progress' => SupportTicket::where('status', 'in_progress')->count(),
            'resolved' => SupportTicket::where('status', 'resolved')->count(),
            'closed' => SupportTicket::where('status', 'closed')->count(),
            'unassigned' => SupportTicket::whereNull('assigned_to')->count(),
            'high_priority' => SupportTicket::where('priority', 'high')->count(),
            'urgent' => SupportTicket::where('priority', 'urgent')->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Quick assign ticket to current user.
     */
    public function assignToMe(SupportTicket $ticket)
    {
        $ticket->assignTo(auth()->user());
        
        return response()->json([
            'success' => true,
            'message' => 'Ticket assigned to you successfully.'
        ]);
    }

    /**
     * Bulk update tickets.
     */
    public function bulkUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'ticket_ids' => 'required|array',
            'ticket_ids.*' => 'exists:support_tickets,id',
            'action' => 'required|in:assign,status,priority',
            'value' => 'required',
        ]);

        $ticketIds = $validatedData['ticket_ids'];
        $action = $validatedData['action'];
        $value = $validatedData['value'] ?? null;

        try {
            switch ($action) {
                case 'assign':
                    SupportTicket::whereIn('id', $ticketIds)->update(['assigned_to' => $value]);
                    $message = 'Tickets assigned successfully.';
                    break;
                    
                case 'status':
                    $updateData = ['status' => $value];
                    if (in_array($value, ['closed', 'resolved'])) {
                        $updateData['closed_at'] = now();
                    }
                    SupportTicket::whereIn('id', $ticketIds)->update($updateData);
                    $message = 'Ticket status updated successfully.';
                    break;
                    
                case 'priority':
                    SupportTicket::whereIn('id', $ticketIds)->update(['priority' => $value]);
                    $message = 'Ticket priority updated successfully.';
                    break;
                    
                case 'delete':
                    // Prevent ticket deletion for data integrity and audit trail
                    return response()->json([
                        'success' => false,
                        'message' => 'Support tickets cannot be deleted for audit trail integrity. Please close tickets instead.'
                    ], 403);
            }

            return response()->json(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error performing bulk update: ' . $e->getMessage()
            ], 500);
        }
    }
}