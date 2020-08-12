@extends('layouts.app') 



{{-- Smartphones & bigger --}}
@push('styles.phone.portrait')
    .error-description-wrapper {
        max-width: 100% !important;
    }
@endpush



{{-- Desktop & bigger --}}
@push('styles.large')
    .error-description-wrapper {
        max-width: 25rem !important;
    }
@endpush



@section('wrapper')

    <div class="d-flex flex-column justify-content-center align-items-center border vh-100">
        <div class="row justify-content-center">
            <div class="col-lg-auto text-center pb-5 pb-lg-0">
                <img src="{{ asset('imgs/logo-sad.png') }}" 
                    alt="{{ __('Logo with a sad face') }}"
                    style="height: 10rem; width: 10rem;"/>
            </div>
            <div class="col-lg-auto">
                <p class="h1 font-weight-bold text-muted mb-4 text-center text-lg-left">
                    @yield('code')
                </p>
                <p class="h3 font-weight-normal text-muted mb-4 text-center text-lg-left">
                    @yield('message')
                </p>
                <div class="error-description-wrapper px-5 px-lg-0">
                    <p class="h5 font-weight-normal text-muted mb-4 text-center text-lg-left text-justify">
                        @yield('description')
                    </p>
                </div>
                
                <div class="mb-4 align-self-center text-center text-lg-left">
                    <a href="{{ url('/') }}" class="btn btn-light btn-lg text-primary active">{{ __('Go Home') }}</a>
                </div>
                
            </div>
        </div>
    </div>

@endsection


{{--
@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found'))
--}}
