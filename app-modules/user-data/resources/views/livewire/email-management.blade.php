<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\Rule;
use Modules\UserData\Services\UserNotificationService;

new class extends Component {
    public string $email = '';
    public string $verification_code = '';
    public bool $verification_sent = false;
    public bool $is_verified = false;
    public string $generated_code = '';
    public bool $edit_mode = false;
    public string $current_email = '';
    public ?int $cooldown_until = null;
    
    public function mount()
    {
        $this->current_email = Auth::user()->email ?? '';
        $this->email = $this->current_email;
        $this->checkCooldown();
    }
    
    public function startEdit()
    {
        $this->edit_mode = true;
        $this->email = $this->current_email;
        $this->reset(['verification_sent', 'is_verified', 'verification_code', 'generated_code']);
    }
    
    public function cancelEdit()
    {
        $this->edit_mode = false;
        $this->email = $this->current_email;
        $this->reset(['verification_sent', 'is_verified', 'verification_code', 'generated_code']);
    }
    
    public function getEmailChangedProperty()
    {
        return $this->email !== $this->current_email;
    }
    
    public function checkCooldown()
    {
        $cacheKey = 'email_verification_cooldown_' . Auth::id();
        $this->cooldown_until = cache($cacheKey);
        
        if (!$this->cooldown_until || $this->cooldown_until <= time()) {
            $this->cooldown_until = null;
        }
    }
    
    public function getCooldownActiveProperty()
    {
        return $this->cooldown_until && $this->cooldown_until > time();
    }
    
    public function saveEmail()
    {
        $this->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore(Auth::id())
            ]
        ]);
        
        // Check if email exists for another user
        $existingUser = User::where('email', $this->email)
                          ->where('id', '!=', Auth::id())
                          ->first();
        
        if ($existingUser) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => __('messages.email_already_exists') . ": {$existingUser->id}"
            ]);
            return;
        }
        
        // Check if email is the same as current email
        if ($this->email === $this->current_email) {
            // No change, just save without verification
            $this->edit_mode = false;
            
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => __('messages.email_saved_successfully')
            ]);
            return;
        }
        
        // Email is different, proceed with OTP verification
        $this->sendVerification();
    }
    
    public function sendVerification()
    {
        // Check cooldown first
        $this->checkCooldown();
        
        if ($this->cooldown_active) {
            $this->dispatch('toast', [
                'type' => 'warning',
                'message' => __('messages.wait_1_minute_before_requesting')
            ]);
            return;
        }
        
        // Generate 4-digit verification code
        $this->generated_code = UserNotificationService::generateVerificationCode(4);
        
        // Send email verification using custom service
        $emailSent = UserNotificationService::sendEmailVerification(
            Auth::id(),
            $this->email,
            $this->generated_code
        );
        
        if ($emailSent) {
            // Set cooldown for 1 minute (60 seconds)
            $cacheKey = 'email_verification_cooldown_' . Auth::id();
            $this->cooldown_until = time() + 60;
            cache([$cacheKey => $this->cooldown_until], 60);
            
            $this->verification_sent = true;
            
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => __('messages.verification_code_sent_success')
            ]);
        } else {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => __('messages.failed_send_verification_email')
            ]);
        }
    }
    
    public function verifyCode()
    {
        $this->validate([
            'verification_code' => 'required|string|size:4'
        ]);
        
        if ($this->verification_code === $this->generated_code) {
            // Update user email
            $user = Auth::user();
            $user->update([
                'email' => $this->email,
                'email_verified_at' => now()
            ]);
            
            // Update current email and exit edit mode
            $this->current_email = $this->email;
            $this->edit_mode = false;
            $this->is_verified = true;
            $this->verification_sent = false;
            
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => __('messages.email_verified_updated_success')
            ]);
            
            // Reset form
            $this->reset(['verification_code', 'generated_code', 'is_verified']);
        } else {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => __('messages.invalid_verification_code')
            ]);
        }
    }
    
    public function cancelVerification()
    {
        $this->reset(['verification_code', 'verification_sent', 'generated_code']);
        $this->email = Auth::user()->email ?? '';
    }
    
    public function resendVerification()
    {
        $this->sendVerification();
    }
}; ?>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
            <i class="fas fa-envelope mr-2 text-blue-500"></i>
            {{ __('messages.email_management') }}
        </h3>
        @if(!$edit_mode && !$verification_sent)
            <button 
                wire:click="startEdit"
                wire:loading.attr="disabled"
                class="inline-flex items-center px-3 py-1 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
            >
                <span wire:loading.remove wire:target="startEdit">
                    <i class="fas fa-edit mr-2"></i>
                    {{ __('messages.edit') }}
                </span>
                <span wire:loading wire:target="startEdit">
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    {{ __('messages.loading') }}
                </span>
            </button>
        @endif
    </div>
    
    @if(!$edit_mode && !$verification_sent)
        <!-- View Mode -->
        <div class="space-y-4">
            <div>
                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.current_email') }}:</span>
                <div class="mt-1 flex items-center">
                    <p class="text-sm text-gray-900 dark:text-white">
                        {{ $current_email ?: __('messages.not_provided') }}
                    </p>
                    @if($current_email && Auth::user()->email_verified_at)
                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                            <i class="fas fa-check-circle mr-1"></i>
                            {{ __('messages.verified') }}
                        </span>
                    @elseif($current_email)
                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ __('messages.not_verified') }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @elseif($edit_mode && !$verification_sent && !$is_verified)
        <form wire:submit="saveEmail" class="space-y-4">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('messages.email_address') }}
                </label>
                <input 
                    type="email" 
                    id="email"
                    wire:model.live="email"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                    placeholder="{{ __('messages.enter_email_address') }}"
                    required
                >
                @error('email')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
                
                @if($this->email_changed)
                    <p class="mt-1 text-sm text-amber-600 dark:text-amber-400">
                        <i class="fas fa-info-circle mr-1"></i>
                        {{ __('messages.email_changed_verification_required') }}
                    </p>
                @endif
            </div>
            
            <div class="flex gap-3">
                <button 
                    type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove>
                        @if($this->email_changed)
                            <i class="fas fa-paper-plane mr-2"></i>
                            {{ __('messages.send_verification') }}
                        @else
                            <i class="fas fa-save mr-2"></i>
                            {{ __('messages.save') }}
                        @endif
                    </span>
                    <span wire:loading>
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                        @if($this->email_changed)
                            {{ __('messages.sending') }}
                        @else
                            {{ __('messages.saving') }}
                        @endif
                    </span>
                </button>
                
                <button 
                    type="button"
                    wire:click="cancelEdit"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    <i class="fas fa-times mr-2"></i>
                    {{ __('messages.cancel') }}
                </button>
            </div>
        </form>
    @endif
    
    @if($verification_sent)
        <div class="space-y-4">
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-md p-4">
                <div class="flex">
                    <i class="fas fa-info-circle text-blue-400 mr-3 mt-0.5"></i>
                    <div>
                        <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                            {{ __('messages.verification_code_sent') }}
                        </h4>
                        <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">
                            {{ __('messages.verification_code_sent_to') }}: <strong>{{ $email }}</strong>
                            <br>
                            <em class="text-xs">{{ __('messages.check_logs_for_code') }}</em>
                        </p>
                    </div>
                </div>
            </div>
            
            <form wire:submit="verifyCode" class="space-y-4">
                <div>
                    <label for="verification_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('messages.verification_code') }}
                    </label>
                    <input 
                        type="text" 
                        id="verification_code"
                        wire:model="verification_code"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('verification_code') border-red-500 @enderror"
                        placeholder="{{ __('messages.enter_4_digit_code') }}"
                        maxlength="4"
                        required
                    >
                    @error('verification_code')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex gap-3">
                    <button 
                        type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove>
                            <i class="fas fa-check mr-2"></i>
                            {{ __('messages.verify_code') }}
                        </span>
                        <span wire:loading>
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                            {{ __('messages.verifying') }}
                        </span>
                    </button>
                    
                    <button 
                        type="button"
                        wire:click="resendVerification"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove wire:target="resendVerification">
                            <i class="fas fa-redo mr-2"></i>
                            {{ __('messages.resend_code') }}
                        </span>
                        <span wire:loading wire:target="resendVerification">
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                            {{ __('messages.sending') }}
                        </span>
                    </button>
                    
                    <button 
                        type="button"
                        wire:click="cancelVerification"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        <i class="fas fa-times mr-2"></i>
                        {{ __('messages.cancel') }}
                    </button>
                </div>
            </form>
        </div>
    @endif
    
    @if($is_verified)
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-md p-4">
            <div class="flex">
                <i class="fas fa-check-circle text-green-400 mr-3 mt-0.5"></i>
                <div>
                    <h4 class="text-sm font-medium text-green-800 dark:text-green-200">
                        {{ __('messages.email_verified_successfully') }}
                    </h4>
                    <p class="text-sm text-green-700 dark:text-green-300 mt-1">
                        {{ __('messages.email_verified_and_updated') }} <strong>{{ $email }}</strong>
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>