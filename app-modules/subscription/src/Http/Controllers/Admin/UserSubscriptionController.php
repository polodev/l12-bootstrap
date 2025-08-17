<?php

namespace Modules\Subscription\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Subscription\Models\UserSubscription;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserSubscriptionController extends Controller
{
    public function index()
    {
        return view('subscription::admin.user-subscriptions.index');
    }

    public function json(Request $request)
    {
        $query = UserSubscription::with(['user', 'subscriptionPlan', 'payment', 'coupon']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('plan_id')) {
            $query->where('subscription_plan_id', $request->plan_id);
        }

        if ($request->filled('search_text')) {
            $search = $request->search_text;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        return DataTables::of($query)
            ->addColumn('user_info', function ($subscription) {
                return view('subscription::admin.user-subscriptions.partials.user-info', compact('subscription'))->render();
            })
            ->addColumn('plan_info', function ($subscription) {
                return view('subscription::admin.user-subscriptions.partials.plan-info', compact('subscription'))->render();
            })
            ->addColumn('subscription_period', function ($subscription) {
                return view('subscription::admin.user-subscriptions.partials.subscription-period', compact('subscription'))->render();
            })
            ->addColumn('payment_info', function ($subscription) {
                return view('subscription::admin.user-subscriptions.partials.payment-info', compact('subscription'))->render();
            })
            ->addColumn('status_badge', function ($subscription) {
                $statusColors = [
                    'active' => 'green',
                    'expired' => 'red',
                    'cancelled' => 'gray',
                    'pending' => 'yellow'
                ];
                
                $color = $statusColors[$subscription->status] ?? 'gray';
                $status = ucfirst($subscription->status);
                
                return "<span class=\"inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{$color}-100 text-{$color}-800 dark:bg-{$color}-900 dark:text-{$color}-200\">{$status}</span>";
            })
            ->addColumn('actions', function ($subscription) {
                return view('subscription::admin.user-subscriptions.partials.actions', compact('subscription'))->render();
            })
            ->rawColumns(['user_info', 'plan_info', 'subscription_period', 'payment_info', 'status_badge', 'actions'])
            ->make(true);
    }

    public function show(UserSubscription $subscription)
    {
        $subscription->load(['user', 'subscriptionPlan', 'payment', 'coupon']);
        
        return view('subscription::admin.user-subscriptions.show', compact('subscription'));
    }

    public function cancel(Request $request, UserSubscription $subscription)
    {
        if ($subscription->status !== 'active') {
            return back()->with('error', 'Only active subscriptions can be cancelled.');
        }

        $subscription->update([
            'status' => 'cancelled',
            'cancelled_at' => now()
        ]);

        return back()->with('success', 'Subscription cancelled successfully.');
    }

    public function extend(Request $request, UserSubscription $subscription)
    {
        $request->validate([
            'months' => 'required|integer|min:1|max:24',
            'reason' => 'nullable|string|max:255'
        ]);

        $oldEndDate = $subscription->ends_at;
        $newEndDate = $subscription->ends_at->addMonths($request->months);

        $subscription->update([
            'ends_at' => $newEndDate,
            'status' => 'active' // Reactivate if it was expired
        ]);

        // Log the extension (you could create an activity log here)
        
        return back()->with('success', "Subscription extended by {$request->months} months until {$newEndDate->format('M j, Y')}.");
    }
}