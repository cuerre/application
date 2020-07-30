@extends('layouts.dashboard')


{{-- Extra content on the topbar--}}
@push('dashboard.topbar')
    
@endpush



@section('menu')
    {{-- Products --}}
    <x-dashboard-menu header="products">
        <x-dashboard-menu-item 
            icon="crop_square" 
            content="Codes" 
            :link="url('desk/codes')">
        </x-dashboard-menu-item>

        <x-dashboard-menu-item 
            icon="vpn_key" 
            content="Tokens" 
            :link="url('desk/tokens')">
        </x-dashboard-menu-item>
    </x-dashboard-menu>

    {{-- Credits --}}
    <x-dashboard-menu header="credits">       
        <x-dashboard-menu-item 
            icon="monetization_on" 
            content="Billing" 
            :link="url('desk/billing')">
        </x-dashboard-menu-item>
    </x-dashboard-menu>

    {{-- Settings --}}
    <x-dashboard-menu header="settings">
        <x-dashboard-menu-item 
            icon="face" 
            content="Profile" 
            :link="url('desk/profile')">
        </x-dashboard-menu-item>
        
        <x-dashboard-menu-item 
            icon="mail" 
            content="Support" 
            :link="url('desk/support')">
        </x-dashboard-menu-item>
    </x-dashboard-menu>
    
    {{-- Navigation extra --}}
    <x-dashboard-menu header="more">
        <x-dashboard-menu-item 
            icon="code" 
            content="Documentation" 
            :link="url('documentation/api/releases')">
        </x-dashboard-menu-item>
    </x-dashboard-menu>
@endsection

@section('module')
    @yield('module')
@endsection