@extends('layouts.app')



{{-- > Smartphones --}}
@push('styles.phone.portrait')

    .dashboard-sidebar-wrapper {}

    .dashboard-content-wrapper {}

    .dashboard-sidebar-menu-expanded {
        display: none;
    }

    .dashboard-sidebar-menu-collapsed {
        display: block;
    }

@endpush



{{-- > Tablets --}}
@push('styles.tablet')
    .dashboard-sidebar-wrapper {
        overflow-x: hidden;
        overflow-y: auto;
        position: fixed; 
        width: 20rem; 
        height:100%;
    }

    .dashboard-content-wrapper {
        margin-left: 20rem;
    }

    .dashboard-sidebar-menu-expanded {
        display: block;
    }

    .dashboard-sidebar-menu-collapsed {
        display: none;
    }
@endpush



@section('wrapper')
    
    {{-- Sidebar --}}
    <div class="px-5 py-4 bg-white shadow-sm dashboard-sidebar-wrapper">
        <div class="mb-4">
            {{-- Logo --}}
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('imgs/logo-title.png') }}" 
                        style="max-height: 2rem;" 
                        class="align-middle"/>
            </a>
            {{-- Version --}}
            <p class="text-muted small">
                {{ __('Version') }}: {{ config('cuerre.version') }}
            </p>
        </div>


        

        {{-- Responsive menu: expanded --}}
        <div class="dashboard-sidebar-menu-expanded">
            @yield('menu')
        </div>

        {{-- Responsive menu: collapsed --}}
        <div class="dashboard-sidebar-menu-collapsed">
            <x-collapsible-box class="btn btn-block btn-light border text-muted mb-4">
                @yield('menu')
            </x-collapsible-box>
        </div>
        
    </div>
    

    {{-- Content --}}
    <div class="dashboard-content-wrapper">                        
        <div class="container-fluid bg-light">
            <div class="row justify-content-center">
                <div class="col-md-12 p-0" style="min-height: 100vh !important;">

                    <x-dashboard-topbar>
                        @stack('dashboard.topbar')
                    </x-dashboard-topbar>

                    <div class="container" style="padding: 3rem 2.5rem 0 2.5rem !important;">
                        @yield('module') 
                    </div>

                </div>
            </div>            
        </div>        
    </div>

    


    
        

@endsection
