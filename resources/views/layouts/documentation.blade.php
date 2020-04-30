@extends('layouts.dash')


@section('menu')
    {{-- Navigation --}}
    <x-dashboard-menu header="Documentation">
        <x-dashboard-menu-item 
            icon="label"
            content="introduction" 
            :link="url('documentation/introduction')">
        </x-dashboard-menu-item>
        <x-dashboard-menu-item 
            icon="label"
            content="Tools" 
            :link="url('documentation/tools')">
        </x-dashboard-menu-item>
    </x-dashboard-menu>

    {{-- Navigation --}}
    <x-dashboard-menu header="API">
        <x-dashboard-menu-item 
            icon="label"
            content="Fair use" 
            :link="url('documentation/fair-use')">
        </x-dashboard-menu-item>
        <x-dashboard-menu-item 
            icon="label"
            content="Recommendations" 
            :link="url('documentation/recommendations')">
        </x-dashboard-menu-item>
        <x-dashboard-menu-item 
            icon="label"
            content="encode QR" 
            :link="url('documentation/encode')">
        </x-dashboard-menu-item>
        <x-dashboard-menu-item 
            icon="label"
            content="decode QR" 
            :link="url('documentation/decode')">
        </x-dashboard-menu-item>
    </x-dashboard-menu>
@endsection


@section('module')
    @yield('module')
@endsection
