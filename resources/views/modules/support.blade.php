@extends('layouts.dashboard')



@section('module')
    {{-- Top title --}}
    <x-card-header
        title="Support"
        hint="dashboard">
    </x-card-header>

    {{-- Errors --}}
    <x-alert-errors /> 


    <form action="" method="">
        <div class="row align-items-end m-0 rounded bg-light py-4 px-2">
            <div class="col-md align-self-stretch">
                <p class="text-muted font-weight-bolder">
                    {{ __('Sometimes, the digital world stops') }}
                </p>
                <p class="text-muted">
                    {{ __('For those moments, we are here for you trying to make it rotate again with ease.') }}
                    {{ __('That is the reason you can see just a box where you can write and ask for help.') }}
                    {{ __('You are living the experience of big data made simple.') }}
                </p>
            </div>
        </div>

        <div class="row align-items-end m-0 rounded bg-light py-4 px-2">
            <div class="col-md align-self-stretch">
                <textarea class="form-control" rows="5"></textarea>
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
