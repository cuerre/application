@extends('layouts.desk')



@section('module')
    {{-- Top title --}}
    <x-card-header
        :title="__('Support')"
        :hint="__('desk')">
    </x-card-header>

    {{-- Errors --}}
    <x-alert-errors /> 

    {{-- Messages bag --}}
    <x-alert-messages />

    <x-box>
        <form action="{{ url('desk/support') }}" method="POST">
            @csrf
            <div class="row align-items-end rounded py-4">
                <div class="col-md align-self-stretch">
                    <p class="text-muted">
                        {{ __('Sometimes, the digital world stops.') }}
                        {{ __('for those moments, we are here for you to make it rotate again.') }}
                        {{ __('That is the reason you can see just a box where you can scream.') }}
                        {{ __('You are living the experience of big data made simple.') }}
                    </p>
                </div>
            </div>

            <div class="row align-items-end rounded py-4">
                <div class="col-md align-self-stretch">
                    <textarea 
                        name="text" 
                        class="form-control" 
                        rows="5" 
                        placeholder="{{ __('Write your message here') }}">
                    </textarea>
                </div>
            </div>

            <div class="row align-items-end rounded py-4">
                <div class="col-md align-self-stretch">
                    <x-submit-button
                        :content="__('Send')">
                    </x-submit-button>
                </div>
            </div>

        </form>
    </x-box>

@endsection
