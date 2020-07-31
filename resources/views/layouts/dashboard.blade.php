@extends('layouts.app')



{{-- > Smartphones --}}
@push('styles.phone.portrait')

    .dashboard-sidebar-wrapper {}

    .dashboard-content-wrapper {}

@endpush



{{-- > Tablets --}}
@push('styles.tablet')
    .dashboard-sidebar-wrapper {
        position: fixed; 
        width: 20rem; 
        height:100%;
    }

    .dashboard-content-wrapper {
        margin-left: 20rem;
    }
@endpush



@section('wrapper')
    
    {{-- Sidebar --}}
    <div class="pl-5 pt-4 bg-light shadow-sm dashboard-sidebar-wrapper">
        <div class="mb-4">
            {{-- Logo --}}
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('imgs/logo-title.png') }}" 
                        style="max-height: 2rem;" 
                        class="align-middle"/>
            </a>
        </div>
        @yield('menu')
    </div>
    

    {{-- Content --}}
    <div class="dashboard-content-wrapper">                        
        <div class="container-fluid bg-white">
            <div class="row justify-content-center">
                <div class="col-md-12 p-0" style="min-height: 100vh !important;">

                    <x-dashboard-topbar>
                        @stack('dashboard.topbar')
                    </x-dashboard-topbar>

                    <div class="container-fluid" style="padding: 3rem 2.5rem 0 2.5rem !important;">
                        @yield('module') 
                    </div>

                </div>
            </div>            
        </div>        
    </div>

    


    
        

@endsection
