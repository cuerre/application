@extends('layouts.dash')


@section('menu')
    {{-- Documentation --}}
    <x-dashboard-menu header="Introduction">
        <x-dashboard-menu-item 
            icon="label"
            content="FAQ" 
            :link="url('documentation/faq')">
        </x-dashboard-menu-item>
    </x-dashboard-menu>

    {{-- API --}}
    <x-dashboard-menu header="API">
        <x-dashboard-menu-item 
            icon="update"
            content="Releases" 
            :link="url('documentation/api/releases')">
        </x-dashboard-menu-item>
    </x-dashboard-menu>

    {{-- API (v1.x) --}}
    <x-dashboard-menu header="api · v1">
        <x-dashboard-menu-item 
            icon="swap_vertical_circle"
            content="encode" 
            :link="url('documentation/api/v1/encode')">
        </x-dashboard-menu-item>
        <x-dashboard-menu-item 
            icon="swap_vertical_circle"
            content="decode" 
            :link="url('documentation/api/v1/decode')">
        </x-dashboard-menu-item>
    </x-dashboard-menu>

    {{-- Contracts --}}
    <x-dashboard-menu header="Contracts">
        <x-dashboard-menu-item 
            icon="description"
            content="Terms" 
            :link="url('documentation/contracts/terms')">
        </x-dashboard-menu-item>
        <x-dashboard-menu-item 
            icon="security"
            content="Privacy" 
            :link="url('documentation/contracts/privacy')">
        </x-dashboard-menu-item>
    </x-dashboard-menu>
@endsection


@section('module')
    @yield('module')
@endsection
