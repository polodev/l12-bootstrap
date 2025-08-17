<?php

namespace Modules\Subscription\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\Helpers;
use Modules\Subscription\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        return view('subscription::admin.plans.index');
    }

    public function json(Request $request)
    {
        $query = SubscriptionPlan::query()->withCount('userSubscriptions');

        return DataTables::of($query)
            ->addColumn('plan_info', function ($plan) {
                return view('subscription::admin.plans.partials.plan-info', compact('plan'))->render();
            })
            ->addColumn('pricing_info', function ($plan) {
                return view('subscription::admin.plans.partials.pricing-info', compact('plan'))->render();
            })
            ->addColumn('status_badge', function ($plan) {
                if ($plan->is_active) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Active</span>';
                } else {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Inactive</span>';
                }
            })
            ->addColumn('subscribers_count', function ($plan) {
                return '<span class="text-sm font-medium text-gray-900 dark:text-gray-100">' . $plan->user_subscriptions_count . '</span>';
            })
            ->addColumn('created_at_formatted', function ($plan) {
                return Helpers::getFormattedDateForDataTable($plan->created_at);
            })
            ->addColumn('actions', function ($plan) {
                return view('subscription::admin.plans.partials.actions', compact('plan'))->render();
            })
            ->rawColumns(['plan_info', 'pricing_info', 'status_badge', 'subscribers_count', 'created_at_formatted', 'actions'])
            ->make(true);
    }

    public function create()
    {
        return view('subscription::admin.plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'plan_title.en' => 'required|string|max:255',
            'plan_title.bn' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_months' => 'required|integer|min:1',
            'currency' => 'required|string|max:3',
            'features.en' => 'nullable|string',
            'features.bn' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        SubscriptionPlan::create($data);

        return redirect()->route('subscription::admin.plans.index')
            ->with('success', 'Subscription plan created successfully.');
    }

    public function show(SubscriptionPlan $plan)
    {
        $plan->load(['userSubscriptions' => function ($query) {
            $query->latest()->limit(10);
        }]);

        return view('subscription::admin.plans.show', compact('plan'));
    }

    public function edit(SubscriptionPlan $plan)
    {
        return view('subscription::admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, SubscriptionPlan $plan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'plan_title.en' => 'required|string|max:255',
            'plan_title.bn' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_months' => 'required|integer|min:1',
            'currency' => 'required|string|max:3',
            'features.en' => 'nullable|string',
            'features.bn' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        $plan->update($data);

        return redirect()->route('subscription::admin.plans.index')
            ->with('success', 'Subscription plan updated successfully.');
    }

    public function destroy(SubscriptionPlan $plan)
    {
        // Check if plan has active subscriptions
        if ($plan->userSubscriptions()->where('status', 'active')->exists()) {
            return back()->with('error', 'Cannot delete plan with active subscriptions.');
        }

        $plan->delete();

        return redirect()->route('subscription::admin.plans.index')
            ->with('success', 'Subscription plan deleted successfully.');
    }

    public function toggleStatus(SubscriptionPlan $plan)
    {
        $plan->update(['is_active' => !$plan->is_active]);

        $status = $plan->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Subscription plan {$status} successfully.");
    }
}