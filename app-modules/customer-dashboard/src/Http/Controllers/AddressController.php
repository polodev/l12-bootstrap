<?php

namespace Modules\CustomerDashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\UserData\Models\UserAddress;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $addresses = $request->user()->addresses()->orderBy('is_default', 'desc')->orderBy('created_at', 'desc')->get();
        
        return view('customer-dashboard::addresses.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('customer-dashboard::addresses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|in:home,work,other',
            'name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'address_line_1' => 'required|string|max:500',
            'address_line_2' => 'nullable|string|max:500',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'is_default' => 'boolean',
        ]);

        $validated['user_id'] = $request->user()->id;

        // If this is set as default, remove default from other addresses
        if (!empty($validated['is_default'])) {
            $request->user()->addresses()->update(['is_default' => false]);
        }

        $address = UserAddress::create($validated);

        // Update user's default address if this is set as default
        if ($address->is_default) {
            $request->user()->update(['default_address_id' => $address->id]);
        }

        return redirect()->route('accounts.addresses.index')->with('status', __('messages.address_created_successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, UserAddress $address): View
    {
        // Ensure user can only edit their own addresses
        if ($address->user_id !== $request->user()->id) {
            abort(403);
        }

        return view('customer-dashboard::addresses.edit', compact('address'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserAddress $address): RedirectResponse
    {
        // Ensure user can only update their own addresses
        if ($address->user_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'type' => 'required|in:home,work,other',
            'name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'address_line_1' => 'required|string|max:500',
            'address_line_2' => 'nullable|string|max:500',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'is_default' => 'boolean',
        ]);

        // If this is set as default, remove default from other addresses
        if (!empty($validated['is_default'])) {
            $request->user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $address->update($validated);

        // Update user's default address if this is set as default
        if ($address->is_default) {
            $request->user()->update(['default_address_id' => $address->id]);
        } elseif ($request->user()->default_address_id === $address->id && !$address->is_default) {
            // If this was the default address and is no longer default, clear user's default
            $request->user()->update(['default_address_id' => null]);
        }

        return redirect()->route('accounts.addresses.index')->with('status', __('messages.address_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, UserAddress $address): RedirectResponse
    {
        // Ensure user can only delete their own addresses
        if ($address->user_id !== $request->user()->id) {
            abort(403);
        }

        // If deleting the default address, clear user's default address
        if ($request->user()->default_address_id === $address->id) {
            $request->user()->update(['default_address_id' => null]);
        }

        $address->delete();

        return redirect()->route('accounts.addresses.index')->with('status', __('messages.address_deleted_successfully'));
    }

    /**
     * Set an address as default
     */
    public function setDefault(Request $request, UserAddress $address): RedirectResponse
    {
        // Ensure user can only set their own addresses as default
        if ($address->user_id !== $request->user()->id) {
            abort(403);
        }

        // Remove default from all other addresses
        $request->user()->addresses()->update(['is_default' => false]);
        
        // Set this address as default
        $address->update(['is_default' => true]);
        $request->user()->update(['default_address_id' => $address->id]);

        return redirect()->route('accounts.addresses.index')->with('status', __('messages.default_address_updated'));
    }
}