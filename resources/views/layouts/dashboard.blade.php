@extends('layouts.dash')


@section('menu')
    {{-- Navigation --}}
    <x-dashboard-menu header="dashboard">
        <x-dashboard-menu-item 
            icon="crop_square" 
            content="Codes" 
            :link="url('dashboard/codes')">
        </x-dashboard-menu-item>
        
        <x-dashboard-menu-item 
            icon="face" 
            content="Profile" 
            :link="url('dashboard/profile')">
        </x-dashboard-menu-item>

        <x-dashboard-menu-item 
            icon="vpn_key" 
            content="Tokens" 
            :link="url('dashboard/tokens')">
        </x-dashboard-menu-item>
        
        <x-dashboard-menu-item 
            icon="monetization_on" 
            content="Billing" 
            :link="url('dashboard/billing')">
        </x-dashboard-menu-item>
        
        <x-dashboard-menu-item 
            icon="mail" 
            content="Support" 
            :link="url('dashboard/support')">
        </x-dashboard-menu-item>
    </x-dashboard-menu>
    
    {{-- Navigation extra --}}
    {{--
    <x-dashboard-menu header="more">
        <x-dashboard-menu-item 
            icon="code" 
            content="Developers" 
            :link="url('documentation/api/releases')">
        </x-dashboard-menu-item>
    </x-dashboard-menu>
    --}}
@endsection


@section('module')
    @yield('module')
@endsection