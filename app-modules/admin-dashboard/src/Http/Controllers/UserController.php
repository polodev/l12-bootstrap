<?php

namespace Modules\AdminDashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $roles = User::whereNotNull('role')
            ->distinct()
            ->pluck('role')
            ->filter()
            ->values()
            ->toArray();

        return view('admin-dashboard::users.index', compact('roles'));
    }

    public function indexJson(Request $request)
    {
        $model = User::query();
        
        return DataTables::eloquent($model)
            ->filter(function ($query) use ($request) {
                // Role filter
                if ($request->has('role') && $request->get('role')) {
                    $query->whereIn('role', $request->get('role'));
                }
                
                // Email verification filter
                if ($request->has('email_verified') && $request->get('email_verified')) {
                    if ($request->get('email_verified') === 'verified') {
                        $query->whereNotNull('email_verified_at');
                    } elseif ($request->get('email_verified') === 'unverified') {
                        $query->whereNull('email_verified_at');
                    }
                }
                
                // Date range filters
                if ($request->has('starting_date_of_user_create_at') && $request->get('starting_date_of_user_create_at')) {
                    $query->whereDate('created_at', '>=', $request->get('starting_date_of_user_create_at'));
                }
                if ($request->has('ending_date_of_user_created_at') && $request->get('ending_date_of_user_created_at')) {
                    $query->whereDate('created_at', '<=', $request->get('ending_date_of_user_created_at'));
                }
                
                // Search text filter
                if ($request->has('search_text') && $request->get('search_text')) {
                    $searchText = $request->get('search_text');
                    $query->where(function ($q) use ($searchText) {
                        $q->where('name', 'like', "%{$searchText}%")
                          ->orWhere('email', 'like', "%{$searchText}%")
                          ->orWhere('role', 'like', "%{$searchText}%");
                    });
                }
            }, true)
            ->addColumn('id_formatted', function (User $user) {
                return '<a href="' . route('admin-dashboard.users.show', $user->id) . '" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium">#' . $user->id . '</a>';
            })
            ->addColumn('role_badge', function (User $user) {
                if (!$user->role) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">No Role</span>';
                }
                
                $badgeClasses = [
                    'developer' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                    'admin' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                    'employee' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
                    'accounts' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                    'customer' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'
                ];
                
                $badgeClass = $badgeClasses[$user->role] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $badgeClass . '">' . Str::headline($user->role) . '</span>';
            })
            ->addColumn('email_verified_badge', function (User $user) {
                if ($user->email_verified_at) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Verified
                            </span>';
                } else {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                Unverified
                            </span>';
                }
            })
            ->addColumn('action', function (User $user) {
                $actions = '<div class="flex items-center space-x-2">';
                
                $actions .= '<a href="' . route('admin-dashboard.users.show', $user->id) . '" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 transition-colors" title="View">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                             </a>';
                             
                $actions .= '<a href="' . route('admin-dashboard.users.edit', $user->id) . '" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded text-white bg-green-600 hover:bg-green-700 transition-colors" title="Edit">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                             </a>';
                
                // Only show delete for non-critical roles
                if (!in_array($user->role, ['developer', 'admin'])) {
                    $actions .= '<button onclick="deleteUser(' . $user->id . ')" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 transition-colors" title="Delete">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                 </button>';
                }
                
                $actions .= '</div>';
                return $actions;
            })
            ->addColumn('created_at_formatted', function (User $user) {
                return '<div class="text-sm">
                            <div class="text-gray-900 dark:text-gray-100">' . $user->created_at->format('M d, Y') . '</div>
                            <div class="text-gray-500 dark:text-gray-400 text-xs">' . $user->created_at->diffForHumans() . '</div>
                        </div>';
            })
            ->addColumn('last_login_formatted', function (User $user) {
                if (isset($user->last_login_at) && $user->last_login_at) {
                    return '<div class="text-sm">
                                <div class="text-gray-900 dark:text-gray-100">' . $user->last_login_at->format('M d, Y') . '</div>
                                <div class="text-gray-500 dark:text-gray-400 text-xs">' . $user->last_login_at->diffForHumans() . '</div>
                            </div>';
                } else {
                    return '<span class="text-gray-500 dark:text-gray-400 text-sm">Never</span>';
                }
            })
            ->setRowClass(function (User $user) {
                $classes = 'hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors';
                if ($user->role === 'developer') {
                    $classes .= ' bg-blue-50 dark:bg-blue-900/20';
                } elseif ($user->role === 'admin') {
                    $classes .= ' bg-yellow-50 dark:bg-yellow-900/20';
                }
                return $classes;
            })
            ->rawColumns(['id_formatted', 'action', 'created_at_formatted', 'last_login_formatted', 'role_badge', 'email_verified_badge'])
            ->toJson();
    }

    public function create()
    {
        $availableRoles = ['developer', 'admin', 'employee', 'accounts', 'customer'];
        return view('admin-dashboard::users.create', compact('availableRoles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'country' => 'nullable|string|max:3',
            'country_code' => 'nullable|string|max:5',
            'mobile' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'nullable|string|in:developer,admin,employee,accounts,customer'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'country' => $request->country,
            'country_code' => $request->country_code,
            'mobile' => $request->mobile,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'email_verified_at' => now(), // Auto-verify admin created users
        ]);

        return redirect()->route('admin-dashboard.users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('admin-dashboard::users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $availableRoles = ['developer', 'admin', 'employee', 'accounts', 'customer'];
        return view('admin-dashboard::users.edit', compact('user', 'availableRoles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'country' => 'nullable|string|max:3',
            'country_code' => 'nullable|string|max:5',
            'mobile' => 'nullable|string|max:20',
            'role' => 'nullable|string|in:developer,admin,employee,accounts,customer',
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        $data = $request->only(['name', 'email', 'country', 'country_code', 'mobile', 'role']);
        
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        // Reset mobile verification if mobile number changes
        if ($request->mobile !== $user->mobile) {
            $data['mobile_verified_at'] = null;
        }

        $user->update($data);

        return redirect()->route('admin-dashboard.users.show', $user)
            ->with('success', 'User updated successfully.');
    }

    public function verifyEmail(User $user)
    {
        if ($user->email_verified_at) {
            return response()->json(['error' => 'Email is already verified'], 400);
        }

        $user->email_verified_at = now();
        $user->save();

        return response()->json(['success' => 'Email verified successfully']);
    }

    public function verifyMobile(User $user)
    {
        if ($user->mobile_verified_at) {
            return response()->json(['error' => 'Mobile is already verified'], 400);
        }

        if (!$user->mobile) {
            return response()->json(['error' => 'User has no mobile number'], 400);
        }

        $user->mobile_verified_at = now();
        $user->save();

        return response()->json(['success' => 'Mobile verified successfully']);
    }

    public function destroy(User $user)
    {
        // Prevent deletion of critical users
        if (in_array($user->role, ['developer', 'admin'])) {
            return response()->json(['error' => 'Cannot delete admin or developer users'], 403);
        }

        $user->delete();

        return response()->json(['success' => 'User deleted successfully']);
    }
}