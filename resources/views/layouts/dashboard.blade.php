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
            icon="monetization_on" 
            content="Billing" 
            link="#">
        </x-dashboard-menu-item>
        
        <x-dashboard-menu-item 
            icon="mail" 
            content="Support" 
            :link="url('dashboard/support')">
        </x-dashboard-menu-item>
    </x-dashboard-menu>
    
    {{-- Navigation extra --}}
    <x-dashboard-menu header="more">
        <x-dashboard-menu-item 
            icon="code" 
            content="Developers" 
            link="#">
        </x-dashboard-menu-item>
    </x-dashboard-menu>
@endsection


@section('module')
    @yield('module')
@endsection