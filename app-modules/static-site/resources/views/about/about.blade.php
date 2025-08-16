<x-customer-frontend-layout::layout>
    <x-slot name="title">{{ __('messages.about_us') }} - {{ __('messages.eco_travel') }}</x-slot>
    <x-slot name="meta_description">{{ __('messages.about_meta_description') }}</x-slot>

    @if(app()->getLocale() == 'en')
        @include('static-site::about.about-content-en')
    @else
        @include('static-site::about.about-content-bn')
    @endif
</x-customer-frontend-layout::layout>