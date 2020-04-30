@extends('layouts.app')



@push('styles.tablet')
    #sidePanel {
        display: block !important;
    }
@endpush



@section('content')
    <div class="container">

        {{-- Offers --}}
        <div class="row mb-5">
            {{-- Free offer --}}
            <div class="col-lg">
                <x-striped-card>
                    <div class="d-flex justify-content-center">
                        <p class="font-weight-bolder text-uppercase">Free</p>
                    </div>
                    <div class="d-flex justify-content-center align-items-end">
                        <div>
                            <span class="h1 font-weight-bold text-uppercase">
                                0€
                            </span>
                        </div>
                        <div class="ml-2">
                            <small>/ month</small>
                        </div>
                    </div>
                    <div>
                        <x-action-list>
                            <x-action-list-item
                                value="Create QR codes">
                            </x-action-list-item>
                            <x-action-list-item
                                value="Decode QR codes">
                            </x-action-list-item>
                            <x-action-list-item
                                value="1k requests per hour">
                            </x-action-list-item>
                        </x-action-list>
                    </div>

                </x-striped-card>
            </div>
            {{-- Premium offer --}}
            <div class="col-lg ">
                <x-striped-card>
                    <div class="d-flex justify-content-center">
                        <p class="font-weight-bolder text-uppercase">Premium</p>
                    </div>
                    <div class="d-flex justify-content-center align-items-end">
                        <div>
                            <span class="h1 font-weight-bold text-uppercase">
                                30€
                            </span>
                        </div>
                        <div class="ml-2">
                            <small>/ month</small>
                        </div>
                    </div>
                    <div>
                        <x-action-list>
                            <x-action-list-item
                                value="Free, plus...">
                            </x-action-list-item>
                            {{--
                            <x-action-list-item
                                value="20k requests per hour">
                            </x-action-list-item>
                            --}}
                            <x-action-list-item
                                value="Reuse QR between campaigns">
                            </x-action-list-item>
                            <x-action-list-item
                                value="Detailed stats about visits">
                            </x-action-list-item>
                            <x-action-list-item
                                value="Set different targets">
                            </x-action-list-item>
                            <x-action-list-item
                                value="Technical support">
                            </x-action-list-item>
                        </x-action-list>
                    </div>
                </x-striped-card>
            </div>
        </div>

        {{-- Enterprise --}}
        <div class="row rounded p-3 py-5 mx-1 bg-white shadow-sm mb-5">
            <div class="col-lg">
                <p class="text-uppercase font-weight-bolder">ENTERPRISE SOLUTION</p>
                <p>
                    Need more or have custom needs?
                </p>
                <x-link-button
                    content="CONTACT US"
                    link="#">
                </x-link-button>

            </div>
        </div>

        {{-- Enterprise --}}
        <div class="row justify-content-md-center rounded p-3 mx-1 bg-light">
            <div class="col-lg-8 p-0">
                <div class="d-flex justify-content-center mb-4">
                    <p class="h2 font-weight-bolder">
                        Commonly Asked Questions
                    </p>
                </div>
                <div class="container">
                    <x-action-list>
                        <x-action-list-item
                            field="Is there a minimum subscription period?" 
                            value="No, you can cancel or make changes to your subscription at any time, there's no lock in.">
                        </x-action-list-item>
                        <x-action-list-item
                            field="Why a free plan?" 
                            value="This is done thinking on app makers who need working with QR codes without hard coding solutions">
                        </x-action-list-item>
                        <x-action-list-item
                            field="Why just one premium plan?" 
                            value="QR codes have been hard to use by enterprises for years. We try to keep them as simple as possible. Just one paid plan let us to concentrate into the important: make it better">
                        </x-action-list-item>
                    </x-action-list>
                </div>

            </div>
        </div>


    </div>
@endsection
