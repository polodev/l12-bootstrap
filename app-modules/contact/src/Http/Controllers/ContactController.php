<?php

namespace Modules\Contact\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Contact\Models\Contact;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact::contacts.index');
    }

    public function indexJson(Request $request)
    {
        $model = Contact::with(['user']);

        return DataTables::eloquent($model)
            ->filter(function ($query) use ($request) {
                if ($request->filled('search_text')) {
                    $searchText = $request->get('search_text');
                    $query->where(function ($q) use ($searchText) {
                        $q->where('name', 'like', "%{$searchText}%")
                          ->orWhere('email', 'like', "%{$searchText}%")
                          ->orWhere('organization', 'like', "%{$searchText}%")
                          ->orWhere('topic', 'like', "%{$searchText}%")
                          ->orWhere('message', 'like', "%{$searchText}%")
                          ->orWhere('mobile', 'like', "%{$searchText}%");
                    });
                }
                if ($request->filled('department')) {
                    $query->where('department', $request->get('department'));
                }
                if ($request->filled('has_reply')) {
                    $query->where('has_reply', $request->boolean('has_reply'));
                }
                if ($request->filled('page')) {
                    $query->where('page', 'like', "%{$request->get('page')}%");
                }
            }, true)
            ->addColumn('formatted_id', function (Contact $contact) {
                return '<a href="' . route('contact::admin.contacts.show', $contact) . '" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-blue-600 dark:bg-blue-500 rounded hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors shadow-sm" title="View Contact">' .
                       '<span class="font-mono">#' . $contact->id . '</span>' .
                       '</a>';
            })
            ->addColumn('contact_info', function (Contact $contact) {
                $html = '<div class="flex items-center">';
                $html .= '<div>';
                $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . htmlspecialchars($contact->name) . '</div>';
                $html .= '<div class="text-xs text-gray-500 dark:text-gray-400">' . htmlspecialchars($contact->email) . '</div>';
                if ($contact->mobile) {
                    $html .= '<div class="text-xs text-gray-500 dark:text-gray-400">' . htmlspecialchars($contact->mobile) . '</div>';
                }
                $html .= '</div></div>';
                return $html;
            })
            ->addColumn('organization_info', function (Contact $contact) {
                $html = '<div class="text-sm">';
                if ($contact->organization) {
                    $html .= '<div class="font-medium text-gray-900 dark:text-gray-100">' . htmlspecialchars($contact->organization) . '</div>';
                }
                if ($contact->designation) {
                    $html .= '<div class="text-xs text-gray-500 dark:text-gray-400">' . htmlspecialchars($contact->designation) . '</div>';
                }
                if (!$contact->organization && !$contact->designation) {
                    $html .= '<span class="text-gray-400 dark:text-gray-500 text-xs">Not specified</span>';
                }
                $html .= '</div>';
                return $html;
            })
            ->addColumn('topic_message', function (Contact $contact) {
                $html = '<div class="text-sm">';
                if ($contact->topic) {
                    $html .= '<div class="font-medium text-gray-900 dark:text-gray-100 mb-1">' . htmlspecialchars($contact->topic) . '</div>';
                }
                $html .= '<div class="text-xs text-gray-500 dark:text-gray-400">' . $contact->truncated_message . '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('department_badge', function (Contact $contact) {
                return $contact->department_badge;
            })
            ->addColumn('reply_status', function (Contact $contact) {
                return $contact->reply_status_badge;
            })
            ->addColumn('page_info', function (Contact $contact) {
                if (!$contact->page) {
                    return '<span class="text-gray-400 dark:text-gray-500 text-xs">Not specified</span>';
                }
                return '<div class="text-xs text-blue-600 dark:text-blue-400 font-mono">' . htmlspecialchars($contact->page) . '</div>';
            })
            ->addColumn('created_at_formatted', function (Contact $contact) {
                return $contact->created_at->format('M d, Y H:i');
            })
            ->addColumn('action', function (Contact $contact) {
                $actions = '<div class="flex items-center justify-center space-x-1">';
                $actions .= '<a href="' . route('contact::admin.contacts.show', $contact) . '" class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded hover:bg-blue-200" title="View">';
                $actions .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>';
                $actions .= '</a>';
                $actions .= '<a href="' . route('contact::admin.contacts.edit', $contact) . '" class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 rounded hover:bg-yellow-200" title="Edit">';
                $actions .= '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>';
                $actions .= '</a>';
                $actions .= '</div>';
                return $actions;
            })
            ->rawColumns(['formatted_id', 'contact_info', 'organization_info', 'topic_message', 'department_badge', 'reply_status', 'page_info', 'action'])
            ->make(true);
    }

    public function show(Contact $contact)
    {
        $contact->load(['user']);
        return view('contact::contacts.show', compact('contact'));
    }

    public function edit(Contact $contact)
    {
        return view('contact::contacts.edit', compact('contact'));
    }

    public function update(Request $request, Contact $contact)
    {
        $validatedData = $request->validate([
            'has_reply' => 'boolean',
            'remarks' => 'nullable|string',
        ]);

        $contact->update($validatedData);
        return redirect()->route('contact::admin.contacts.index')->with('success', 'Contact updated successfully.');
    }

    public function destroy(Contact $contact)
    {
        try {
            $contact->delete();
            return response()->json(['success' => true, 'message' => 'Contact deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting contact: ' . $e->getMessage()], 500);
        }
    }
}