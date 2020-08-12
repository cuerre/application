@extends('layouts.web')



@section('content')

    {{-- Error --}}
    <div class="container-fluid text-muted bg-white border-bottom py-5 mb-5">
        <div class="container h-100 py-5">
            <div class="row justify-content-center">
                <div class="col-lg-auto text-center pb-5 pb-lg-0">
                    <img src="{{ asset('imgs/logo-sad.png') }}" 
                        alt="{{ __('Logo with a sad face') }}"
                        style="height: 10rem; width: 10rem;"/>
                </div>
                <div class="col-lg-auto">
                    <p class="h1 font-weight-bold mb-4 align-self-center text-center">
                        {{ __('We made a mistake') }}
                    </p>
                    <p class="h1 font-weight-normal mb-4 align-self-center text-center">
                        @yield('code') - @yield('message')
                    </p>
                    <div class="mb-4 align-self-center text-center">
                        <x-link-button
                            :content="__('Go Home')"
                            :link="url('/')"
                            size="lg" 
                            color="primary">
                        </x-link-button>
                    </div>
                    
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
