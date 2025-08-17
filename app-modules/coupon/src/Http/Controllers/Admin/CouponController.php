<?php

namespace Modules\Coupon\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Coupon\Models\Coupon;
use Modules\Subscription\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CouponController extends Controller
{
    public function index()
    {
        return view('coupon::admin.coupons.index');
    }

    public function json(Request $request)
    {
        $query = Coupon::query()->withCount('usages');

        return DataTables::of($query)
            ->addColumn('coupon_info', function ($coupon) {
                return view('coupon::admin.coupons.partials.coupon-info', compact('coupon'))->render();
            })
            ->addColumn('discount_info', function ($coupon) {
                return view('coupon::admin.coupons.partials.discount-info', compact('coupon'))->render();
            })
            ->addColumn('usage_info', function ($coupon) {
                return view('coupon::admin.coupons.partials.usage-info', compact('coupon'))->render();
            })
            ->addColumn('validity_info', function ($coupon) {
                return view('coupon::admin.coupons.partials.validity-info', compact('coupon'))->render();
            })
            ->addColumn('status_badge', function ($coupon) {
                if ($coupon->is_active && (!$coupon->expires_at || $coupon->expires_at->isFuture())) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Active</span>';
                } elseif ($coupon->expires_at && $coupon->expires_at->isPast()) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Expired</span>';
                } else {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">Inactive</span>';
                }
            })
            ->addColumn('actions', function ($coupon) {
                return view('coupon::admin.coupons.partials.actions', compact('coupon'))->render();
            })
            ->rawColumns(['coupon_info', 'discount_info', 'usage_info', 'validity_info', 'status_badge', 'actions'])
            ->make(true);
    }

    public function create()
    {
        $subscriptionPlans = SubscriptionPlan::active()->ordered()->get();
        return view('coupon::admin.coupons.create', compact('subscriptionPlans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:coupons,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'minimum_amount' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_user' => 'nullable|integer|min:1',
            'applicable_plans' => 'nullable|array',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:starts_at',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['code'] = strtoupper($request->code);
        $data['is_active'] = $request->has('is_active');
        $data['created_by'] = auth()->id();

        Coupon::create($data);

        return redirect()->route('coupon::admin.coupons.index')
            ->with('success', 'Coupon created successfully.');
    }

    public function show(Coupon $coupon)
    {
        $coupon->load(['usages.user', 'usages.userSubscription.subscriptionPlan']);
        
        return view('coupon::admin.coupons.show', compact('coupon'));
    }

    public function edit(Coupon $coupon)
    {
        $subscriptionPlans = SubscriptionPlan::active()->ordered()->get();
        return view('coupon::admin.coupons.edit', compact('coupon', 'subscriptionPlans'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:coupons,code,' . $coupon->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'minimum_amount' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_user' => 'nullable|integer|min:1',
            'applicable_plans' => 'nullable|array',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:starts_at',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['code'] = strtoupper($request->code);
        $data['is_active'] = $request->has('is_active');

        $coupon->update($data);

        return redirect()->route('coupon::admin.coupons.index')
            ->with('success', 'Coupon updated successfully.');
    }

    public function destroy(Coupon $coupon)
    {
        // Check if coupon has been used
        if ($coupon->usages()->exists()) {
            return back()->with('error', 'Cannot delete coupon that has been used.');
        }

        $coupon->delete();

        return redirect()->route('coupon::admin.coupons.index')
            ->with('success', 'Coupon deleted successfully.');
    }

    public function toggleStatus(Coupon $coupon)
    {
        $coupon->update(['is_active' => !$coupon->is_active]);

        $status = $coupon->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Coupon {$status} successfully.");
    }

    public function usageReport()
    {
        return view('coupon::admin.coupons.usage-report');
    }

    public function usageReportJson(Request $request)
    {
        $query = Coupon::withCount(['usages'])
            ->withSum('usages', 'discount_amount')
            ->orderBy('usages_count', 'desc');

        return DataTables::of($query)
            ->addColumn('coupon_info', function ($coupon) {
                return view('coupon::admin.coupons.partials.coupon-info', compact('coupon'))->render();
            })
            ->addColumn('usage_stats', function ($coupon) {
                return view('coupon::admin.coupons.partials.usage-stats', compact('coupon'))->render();
            })
            ->addColumn('discount_stats', function ($coupon) {
                return view('coupon::admin.coupons.partials.discount-stats', compact('coupon'))->render();
            })
            ->addColumn('status_badge', function ($coupon) {
                if ($coupon->is_active) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Active</span>';
                } else {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Inactive</span>';
                }
            })
            ->addColumn('actions', function ($coupon) {
                return view('coupon::admin.coupons.partials.actions', compact('coupon'))->render();
            })
            ->rawColumns(['coupon_info', 'usage_stats', 'discount_stats', 'status_badge', 'actions'])
            ->make(true);
    }
}