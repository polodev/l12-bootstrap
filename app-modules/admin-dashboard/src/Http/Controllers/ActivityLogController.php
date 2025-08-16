<?php

namespace Modules\AdminDashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logNames = Activity::distinct()->pluck('log_name')->filter()->values()->toArray();
        $subjects = Activity::distinct()->pluck('subject_type')->filter()->values()->toArray();
        
        return view('admin-dashboard::activity-logs.index', compact('logNames', 'subjects'));
    }

    public function indexJson(Request $request)
    {
        $model = Activity::with(['subject', 'causer'])->orderBy('created_at', 'desc');
        
        return DataTables::eloquent($model)
            ->filter(function ($query) use ($request) {
                // Log name filter
                if ($request->has('log_name') && $request->get('log_name')) {
                    $query->whereIn('log_name', $request->get('log_name'));
                }
                
                // Subject type filter
                if ($request->has('subject_type') && $request->get('subject_type')) {
                    $query->whereIn('subject_type', $request->get('subject_type'));
                }
                
                // Date range filters
                if ($request->has('starting_date') && $request->get('starting_date')) {
                    $query->whereDate('created_at', '>=', $request->get('starting_date'));
                }
                if ($request->has('ending_date') && $request->get('ending_date')) {
                    $query->whereDate('created_at', '<=', $request->get('ending_date'));
                }
                
                // Search text filter
                if ($request->has('search_text') && $request->get('search_text')) {
                    $searchText = $request->get('search_text');
                    $query->where(function ($q) use ($searchText) {
                        $q->where('description', 'like', "%{$searchText}%")
                          ->orWhere('log_name', 'like', "%{$searchText}%");
                    });
                }
            }, true)
            ->addColumn('activity_type', function (Activity $activity) {
                $badgeClasses = [
                    'user' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                    'auth' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                    'admin' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                    'system' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300'
                ];
                
                $badgeClass = $badgeClasses[$activity->log_name] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $badgeClass . '">' . ucfirst($activity->log_name) . '</span>';
            })
            ->addColumn('causer_info', function (Activity $activity) {
                if ($activity->causer) {
                    return '<div class="text-sm">
                                <div class="font-medium text-gray-900 dark:text-gray-100">' . e($activity->causer->name) . '</div>
                                <div class="text-gray-500 dark:text-gray-400 text-xs">' . e($activity->causer->email) . '</div>
                                <div class="text-gray-500 dark:text-gray-400 text-xs">Role: ' . ucfirst($activity->causer->role ?? 'None') . '</div>
                            </div>';
                } else {
                    return '<span class="text-gray-500 dark:text-gray-400 text-sm">System</span>';
                }
            })
            ->addColumn('subject_info', function (Activity $activity) {
                if ($activity->subject) {
                    $subjectName = class_basename($activity->subject_type);
                    $subjectId = $activity->subject_id;
                    
                    if ($activity->subject_type === 'App\Models\User') {
                        $user = $activity->subject;
                        return '<div class="text-sm">
                                    <div class="font-medium text-gray-900 dark:text-gray-100">User: ' . e($user->name) . '</div>
                                    <div class="text-gray-500 dark:text-gray-400 text-xs">' . e($user->email) . '</div>
                                    <div class="text-gray-500 dark:text-gray-400 text-xs">ID: ' . $subjectId . '</div>
                                </div>';
                    }
                    
                    return '<div class="text-sm">
                                <div class="font-medium text-gray-900 dark:text-gray-100">' . $subjectName . '</div>
                                <div class="text-gray-500 dark:text-gray-400 text-xs">ID: ' . $subjectId . '</div>
                            </div>';
                } else {
                    return '<span class="text-gray-500 dark:text-gray-400 text-sm">Deleted</span>';
                }
            })
            ->addColumn('changes_summary', function (Activity $activity) {
                $properties = $activity->properties;
                $changes = [];
                
                if (isset($properties['attributes']) && isset($properties['old'])) {
                    $attributes = $properties['attributes'];
                    $old = $properties['old'];
                    
                    foreach ($attributes as $key => $newValue) {
                        $oldValue = $old[$key] ?? null;
                        
                        if ($oldValue !== $newValue) {
                            if ($key === 'email_verified_at') {
                                if ($oldValue === null && $newValue !== null) {
                                    $changes[] = '<span class="text-green-600 dark:text-green-400">✓ Email Verified</span>';
                                } elseif ($oldValue !== null && $newValue === null) {
                                    $changes[] = '<span class="text-red-600 dark:text-red-400">✗ Email Unverified</span>';
                                }
                            } else {
                                $changes[] = '<div class="text-xs">
                                                <span class="font-medium">' . ucfirst($key) . ':</span>
                                                <br><span class="text-red-600 dark:text-red-400">- ' . ($oldValue ?? 'null') . '</span>
                                                <br><span class="text-green-600 dark:text-green-400">+ ' . ($newValue ?? 'null') . '</span>
                                              </div>';
                            }
                        }
                    }
                }
                
                return $changes ? implode('<br>', $changes) : '<span class="text-gray-500 dark:text-gray-400 text-sm">No changes</span>';
            })
            ->addColumn('created_at_formatted', function (Activity $activity) {
                return '<div class="text-sm">
                            <div class="text-gray-900 dark:text-gray-100">' . $activity->created_at->format('M d, Y H:i') . '</div>
                            <div class="text-gray-500 dark:text-gray-400 text-xs">' . $activity->created_at->diffForHumans() . '</div>
                        </div>';
            })
            ->addColumn('action', function (Activity $activity) {
                return '<a href="' . route('admin-dashboard.activity-logs.show', $activity->id) . '" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 transition-colors" title="View Details">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                         </a>';
            })
            ->rawColumns(['activity_type', 'causer_info', 'subject_info', 'changes_summary', 'created_at_formatted', 'action'])
            ->toJson();
    }

    public function show(Activity $activity)
    {
        $activity->load(['subject', 'causer']);
        return view('admin-dashboard::activity-logs.show', compact('activity'));
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
        
        return redirect()
            ->route('admin-dashboard.activity-logs.index')
            ->with('status', 'Activity log deleted successfully.');
    }
}