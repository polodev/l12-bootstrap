<?php

namespace Modules\SupportTicket\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\SupportTicket\Models\SupportTicket;
use Modules\SupportTicket\Models\SupportTicketMessage;

class SupportTicketMessageController extends Controller
{
    /**
     * Store a new reply to a ticket.
     */
    public function store(Request $request, SupportTicket $ticket)
    {
        $validatedData = $request->validate([
            'message' => 'required|string|min:3',
            'is_internal' => 'boolean',
        ]);

        $message = $ticket->messages()->create([
            'user_id' => auth()->id(),
            'message' => $validatedData['message'],
            'is_internal' => $validatedData['is_internal'] ?? false,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Auto-update ticket status based on message type
        if (!$message->is_internal) {
            // If it's a public reply from admin, update status
            if ($ticket->status === 'new') {
                $ticket->update(['status' => 'open']);
            } elseif ($ticket->status === 'closed') {
                $ticket->update(['status' => 'open']);
            }
        }

        $messageType = $message->is_internal ? 'internal note' : 'reply';
        return redirect()->back()->with('success', "Your {$messageType} has been added successfully.");
    }

    /**
     * Update an existing message.
     */
    public function update(Request $request, SupportTicket $ticket, SupportTicketMessage $message)
    {
        // Only allow admins to edit admin messages, not customer messages
        if ($message->isFromCustomer()) {
            return response()->json([
                'success' => false,
                'message' => 'Customer messages cannot be edited for audit trail integrity.'
            ], 403);
        }

        $validatedData = $request->validate([
            'message' => 'required|string|min:3',
            'is_internal' => 'boolean',
        ]);

        $message->update([
            'message' => $validatedData['message'],
            'is_internal' => $validatedData['is_internal'] ?? $message->is_internal,
        ]);

        // Return JSON for AJAX requests
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Message updated successfully.'
            ]);
        }

        return redirect()->back()->with('success', 'Message updated successfully.');
    }

    /**
     * Delete a message.
     */
    public function destroy(SupportTicket $ticket, SupportTicketMessage $message)
    {
        // Only allow admins to delete admin messages, not customer messages
        if ($message->isFromCustomer()) {
            return response()->json([
                'success' => false,
                'message' => 'Customer messages cannot be deleted for audit trail integrity.'
            ], 403);
        }

        try {
            $message->delete();
            return response()->json([
                'success' => true,
                'message' => 'Message deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting message: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Quick reply with predefined templates.
     */
    public function quickReply(Request $request, SupportTicket $ticket)
    {
        $validatedData = $request->validate([
            'template' => 'required|string|in:resolved,more_info,investigating,escalated',
            'is_internal' => 'boolean',
        ]);

        $templates = [
            'resolved' => 'Thank you for contacting us. Your issue has been resolved. If you need further assistance, please don\'t hesitate to reach out.',
            'more_info' => 'Thank you for your message. To better assist you, could you please provide more details about the issue you\'re experiencing?',
            'investigating' => 'Thank you for reporting this issue. We are currently investigating and will get back to you as soon as possible.',
            'escalated' => 'Your ticket has been escalated to our senior support team. You can expect a response within 24 hours.',
        ];

        $message = $ticket->messages()->create([
            'user_id' => auth()->id(),
            'message' => $templates[$validatedData['template']],
            'is_internal' => $validatedData['is_internal'] ?? false,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Auto-update ticket status based on template
        switch ($validatedData['template']) {
            case 'resolved':
                $ticket->update(['status' => 'resolved']);
                break;
            case 'investigating':
                $ticket->update(['status' => 'in_progress']);
                break;
            default:
                if ($ticket->status === 'new') {
                    $ticket->update(['status' => 'open']);
                }
        }

        $messageType = $message->is_internal ? 'internal note' : 'reply';
        return redirect()->back()->with('success', "Quick {$messageType} added successfully.");
    }

    /**
     * Get message history for AJAX requests.
     */
    public function getMessages(SupportTicket $ticket)
    {
        $messages = $ticket->messages()
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
                    'is_internal' => $message->is_internal,
                    'author_name' => $message->author_name,
                    'author_badge' => $message->author_badge,
                    'type_badge' => $message->type_badge,
                    'created_at' => $message->created_at->format('M d, Y H:i'),
                    'created_at_human' => $message->created_at->diffForHumans(),
                    'is_from_customer' => $message->isFromCustomer(),
                    'can_edit' => auth()->user()->can('update', $message),
                    'can_delete' => auth()->user()->can('delete', $message),
                ];
            })
        ]);
    }

    /**
     * Mark all messages as read (if implementing read status).
     */
    public function markAsRead(SupportTicket $ticket)
    {
        // This could be implemented if you want to track read status
        // For now, just return success
        return response()->json([
            'success' => true,
            'message' => 'Messages marked as read.'
        ]);
    }

    /**
     * Convert internal note to public reply or vice versa.
     */
    public function toggleVisibility(SupportTicket $ticket, SupportTicketMessage $message)
    {
        $this->authorize('update', $message);

        $message->update([
            'is_internal' => !$message->is_internal
        ]);

        $newType = $message->is_internal ? 'internal note' : 'public reply';
        return response()->json([
            'success' => true,
            'message' => "Message converted to {$newType} successfully.",
            'is_internal' => $message->is_internal
        ]);
    }

    /**
     * Get message statistics.
     */
    public function getStats(SupportTicket $ticket)
    {
        $stats = [
            'total_messages' => $ticket->messages()->count(),
            'public_replies' => $ticket->replies()->count(),
            'internal_notes' => $ticket->internalNotes()->count(),
            'customer_messages' => $ticket->messages()->whereHas('author', function ($query) use ($ticket) {
                $query->where('id', $ticket->user_id);
            })->count(),
            'staff_messages' => $ticket->messages()->whereHas('author', function ($query) use ($ticket) {
                $query->where('id', '!=', $ticket->user_id);
            })->count(),
            'last_message_at' => $ticket->messages()->latest()->first()?->created_at,
            'last_staff_reply_at' => $ticket->messages()
                ->whereHas('author', function ($query) use ($ticket) {
                    $query->where('id', '!=', $ticket->user_id);
                })
                ->where('is_internal', false)
                ->latest()
                ->first()?->created_at,
        ];

        return response()->json($stats);
    }
}