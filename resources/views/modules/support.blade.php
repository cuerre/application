@extends('layouts.dashboard')



@section('module')
    {{-- Top title --}}
    <x-card-header
        title="Support"
        hint="dashboard">
    </x-card-header>

    {{-- Errors --}}
    <x-alert-errors /> 

    {{-- Message bag --}}
    @if( Session::has('message') )
        <x-alert 
            type="light">
            {{ Session::get('message') }}
        </x-alert>
    @endif


    <form action="{{ url('dashboard/support') }}" method="POST">
        @csrf
        <div class="row align-items-end m-0 rounded bg-white py-4">
            <div class="col-md align-self-stretch px-0">
                <p class="text-muted">
                    {{ __('Sometimes, the digital world stops.') }}
                    {{ __('for those moments, we are here for you to make it rotate again.') }}
                    {{ __('That is the reason you can see just a box where you can scream.') }}
                    {{ __('You are living the experience of big data made simple.') }}
                </p>
            </div>
        </div>

        <div class="row align-items-end m-0 rounded bg-light py-4 px-2">
            <div class="col-md align-self-stretch">
                <textarea 
                    name="text" 
                    class="form-control" 
                    rows="5" 
                    placeholder="{{ __('Write your message here') }}">
                </textarea>
            </div>
        </div>

        <div class="row align-items-end m-0 rounded bg-light py-4 px-2">
            <div class="col-md align-self-stretch">
                <x-submit-button
                    content="Send">
                </x-submit-button>
            </div>
        </div>

    </form>

@endsection
