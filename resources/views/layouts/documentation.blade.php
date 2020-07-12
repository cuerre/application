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
            icon="notes"
            content="Prologue" 
            :link="url('documentation/api/v1/prologue')">
        </x-dashboard-menu-item>
        <x-dashboard-menu-item 
            icon="swap_vertical_circle"
            content="{http:get} or {http:post} /encode" 
            :link="url('documentation/api/v1/encode')">
        </x-dashboard-menu-item>
        <x-dashboard-menu-item 
            icon="swap_vertical_circle"
            content="{http:post} /decode" 
            :link="url('documentation/api/v1/decode')">
        </x-dashboard-menu-item>
        <x-dashboard-menu-item 
            icon="swap_vertical_circle"
            content="{http:get} /code/list" 
            :link="url('documentation/api/v1/getcodelist')">
        </x-dashboard-menu-item>
        <x-dashboard-menu-item 
            icon="swap_vertical_circle"
            content="{http:get} /code" 
            :link="url('documentation/api/v1/getcode')">
        </x-dashboard-menu-item>
        <x-dashboard-menu-item 
            icon="swap_vertical_circle"
            content="{http:get} /code/image" 
            :link="url('documentation/api/v1/getcodeimage')">
        </x-dashboard-menu-item>
        <x-dashboard-menu-item 
            icon="swap_vertical_circle"
            content="{http:post} /code" 
            :link="url('documentation/api/v1/postcode')">
        </x-dashboard-menu-item>
        <x-dashboard-menu-item 
            icon="swap_vertical_circle"
            content="{http:put} /code" 
            :link="url('documentation/api/v1/putcode')">
        </x-dashboard-menu-item>
        <x-dashboard-menu-item 
            icon="swap_vertical_circle"
            content="{http:delete} /code" 
            :link="url('documentation/api/v1/code/delete')">
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
