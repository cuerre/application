@extends('layouts.app')



@push('styles.tablet')
    
@endpush



@section('wrapper')

    {{-- <x-dashboard-navbar/> --}}

    <div>
    
        {{-- Sidebar --}}
        <div style="position: fixed; width: 20rem; height:100%;" 
             class="pl-5 pt-4 bg-light shadow-sm">
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
        <div style="margin-left: 20rem;">                        
            <div class="container-fluid bg-white">
                <div class="row justify-content-center">
                    <div class="col-md-12 p-0" style="min-height: 100vh !important;">
                        <x-dashboard-topbar sentence=""/>
                        <div class="container-fluid" style="padding: 3rem 2.5rem 0 2.5rem !important;">
                            @yield('module') 
                        </div>
                    </div>
                </div>            
            </div>        
        </div>

    </div>


    
        

@endsection
