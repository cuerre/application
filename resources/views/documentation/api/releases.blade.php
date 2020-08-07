@extends('layouts.documentation')


@section('module')
    <x-card-header
        title="Releases"
        hint="documentation / api">
    </x-card-header>

    <div class="mb-5">
        <h4>Where to follow</h4>
        <p class="mb-5">
            Just here. The most reliable place to know about new releases is 
            the documentation you have in front of your eyes.
        </p>

        {{-- Releases table --}}
        <div class="row align-items-center border border-light rounded">
            <div class="col bg-light">
                <span class="font-weight-bold">Version</span>
            </div>
            <div class="col bg-light">
                <span class="font-weight-bold">Details</span>
            </div>
            <div class="w-100 border border-light"></div>
            <div class="col">
                <p class="my-auto">1.0</p>
            </div>
            <div class="col">
                <div>
                    <code>Route</code>
                    <span class="small">{{ secure_url('/') }}/api/v1</span>
                </div>
                <div>
                    <code>Released</code> 
                    <span class="small">30/04/2020</span>
                </div>
                <div>
                    <code>Maturity</code> 
                    <span class="small">Stable</span>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-5">
        <h4>Maturity matters</h4>
        <p class="mb-5">
            When new features are released, not always are available for all users at the beginning. 
            This is because we would like to guarantee the quality of service and launch them under controlled 
            environment with few users. If a feature is mature enough to handle high levels of requests, then we release 
            it for the rest of users. 
        </p>
    </div>

@endsection
