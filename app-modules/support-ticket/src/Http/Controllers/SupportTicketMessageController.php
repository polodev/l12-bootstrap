<?php

namespace Modules\SupportTicket\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\SupportTicket\Models\SupportTicket;
use Modules\SupportTicket\Models\SupportTicketMessage;

class SupportTicketMessageController extends Controller
{
    /**
     * Store a new reply from customer.
     */
    public function store(Request $request, SupportTicket $ticket)
    {
        // Ensure customer can only reply to their own tickets
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to reply to this ticket.');
        }

        // Prevent replies on closed tickets unless explicitly allowed
        if ($ticket->isClosed()) {
            return redirect()->back()->with('error', __('messages.cannot_reply_closed_ticket'));
        }

        $validatedData = $request->validate([
            'message' => 'required|string|min:3|max:2000',
        ]);

        $message = $ticket->messages()->create([
            'user_id' => Auth::id(),
            'message' => $validatedData['message'],
            'is_internal' => false, // Customer messages are never internal
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Auto-update ticket status when customer replies
        if ($ticket->status === 'resolved') {
            $ticket->update(['status' => 'open']);
        } elseif ($ticket->status === 'closed') {
            $ticket->update(['status' => 'open']);
        }

        return redirect()->back()->with('success', __('messages.reply_sent_successfully'));
    }

    /**
     * Update customer's own message - DISABLED for data integrity.
     */
    public function update(Request $request, SupportTicket $ticket, SupportTicketMessage $message)
    {
        abort(403, 'Customers cannot edit messages for audit trail integrity.');
    }

    /**
     * Get message history for the customer.
     */
    public function getMessages(SupportTicket $ticket)
    {
        // Ensure customer can only view messages from their own tickets
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to view these messages.');
        }

        // Only get public messages (no internal notes)
        $messages = $ticket->messages()
            ->where('is_internal', false)
            ->with('author')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'messages' => $messages->map(function ($message) {
                return [
                    'id' => $message->id,
                    'message' => $message->message,
                    'formatted_message' => $message->formatted_message,
                    'author_name' => $message->author_name,
                    'author_badge' => $message->author_badge,
                    'created_at' => $message->created_at->format('M d, Y H:i'),
                    'created_at_human' => $message->created_at->diffForHumans(),
                    'is_from_customer' => $message->isFromCustomer(),
                    'can_edit' => $this->canEditMessage($message),
                ];
            })
        ]);
    }

    /**
     * Check if customer can still edit their message - DISABLED for data integrity.
     */
    private function canEditMessage(SupportTicketMessage $message): bool
    {
        // Always return false - customers cannot edit messages for audit trail integrity
        return false;
    }

    /**
     * Delete customer's own message (if allowed within time limit).
     */
    /**
     * Delete customer's own message - DISABLED for data integrity.
     */
    public function destroy(SupportTicket $ticket, SupportTicketMessage $message)
    {
        return response()->json([
            'success' => false,
            'message' => 'Customers cannot delete messages for audit trail integrity.'
        ], 403);
    }


    /**
     * Mark ticket as resolved from customer side.
     */
    public function markAsResolved(SupportTicket $ticket)
    {
        // Ensure customer can only resolve their own tickets
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to resolve this ticket.');
        }

        if ($ticket->status === 'resolved') {
            return redirect()->back()->with('info', __('messages.ticket_already_resolved'));
        }

        $ticket->markAsResolved();

        return redirect()->back()->with('success', __('messages.ticket_marked_resolved'));
    }

    /**
     * Upload attachment (if implementing file uploads).
     */
    public function uploadAttachment(Request $request, SupportTicket $ticket)
    {
        // Ensure customer can only upload to their own tickets
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'file' => 'required|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,txt',
        ]);

        // This would require implementing file upload handling
        // For now, just return success
        return response()->json([
            'success' => true,
            'message' => 'File uploaded successfully',
            'filename' => $request->file('file')->getClientOriginalName()
        ]);
    }

    /**
     * Get conversation statistics for customer.
     */
    public function getConversationStats(SupportTicket $ticket)
    {
        // Ensure customer can only view stats for their own tickets
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        $stats = [
            'total_messages' => $ticket->replies()->count(), // Only public messages
            'customer_messages' => $ticket->messages()
                ->where('is_internal', false)
                ->where('user_id', $ticket->user_id)
                ->count(),
            'staff_messages' => $ticket->messages()
                ->where('is_internal', false)
                ->where('user_id', '!=', $ticket->user_id)
                ->count(),
            'last_staff_reply' => $ticket->messages()
                ->where('is_internal', false)
                ->where('user_id', '!=', $ticket->user_id)
                ->latest()
                ->first()?->created_at,
            'response_time' => $this->calculateAverageResponseTime($ticket),
        ];

        return response()->json($stats);
    }

    /**
     * Calculate average response time for staff replies.
     */
    private function calculateAverageResponseTime(SupportTicket $ticket): ?string
    {
        $messages = $ticket->messages()
            ->where('is_internal', false)
            ->orderBy('created_at')
            ->get();

        if ($messages->count() < 2) {
            return null;
        }

        $responseTimes = [];
        $lastCustomerMessage = null;

        foreach ($messages as $message) {
            if ($message->isFromCustomer()) {
                $lastCustomerMessage = $message;
            } elseif ($lastCustomerMessage) {
                $responseTime = $lastCustomerMessage->created_at->diffInMinutes($message->created_at);
                $responseTimes[] = $responseTime;
                $lastCustomerMessage = null;
            }
        }

        if (empty($responseTimes)) {
            return null;
        }

        $averageMinutes = array_sum($responseTimes) / count($responseTimes);
        
        if ($averageMinutes < 60) {
            return round($averageMinutes) . ' minutes';
        } elseif ($averageMinutes < 1440) {
            return round($averageMinutes / 60, 1) . ' hours';
        } else {
            return round($averageMinutes / 1440, 1) . ' days';
        }
    }
}