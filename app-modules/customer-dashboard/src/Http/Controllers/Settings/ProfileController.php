<?php

namespace Modules\CustomerDashboard\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(Request $request): View
    {
        return view('customer-dashboard::settings.profile-view', [
            'user' => $request->user(),
        ]);
    }

    public function edit(Request $request): View
    {
        return view('customer-dashboard::settings.profile-edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'remove_avatar' => ['nullable', 'boolean'],
        ]);

        // Update name
        $user->fill(['name' => $validated['name']]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Clear existing avatar
            $user->clearMediaCollection('avatar');
            
            // Add new avatar
            $user->addMediaFromRequest('avatar')
                 ->toMediaCollection('avatar');
        }

        // Handle avatar removal
        if ($request->boolean('remove_avatar')) {
            $user->clearMediaCollection('avatar');
        }

        $user->save();

        return to_route('accounts.settings.profile')->with('status', __('Profile updated successfully'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('home');
    }
}
