@extends('layouts.web')



@push('styles.large')
    #sidePanel {
        display: block !important;
    }

    .overShadow {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        transition: box-shadow 0.3s ease-in-out;
    }

    .overShadow:hover {
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
    }

    .pattern {
        background-color: #f8f9fa;
        background-image: url("data:image/svg+xml,%3Csvg width='70' height='70' viewBox='0 0 70 70' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23dee2e6' fill-opacity='0.1' fill-rule='evenodd'%3E%3Cpath d='M0 0h35v35H0V0zm5 5h25v25H5V5zm5 5h15v15H10V10zm5 5h5v5h-5v-5zM40 5h25v25H40V5zm5 5h15v15H45V10zm5 5h5v5h-5v-5zM70 35H35v35h35V35zm-5 5H40v25h25V40zm-5 5H45v15h15V45zm-5 5h-5v5h5v-5zM30 40H5v25h25V40zm-5 5H10v15h15V45zm-5 5h-5v5h5v-5z'/%3E%3C/g%3E%3C/svg%3E");
    }
@endpush



@push('scripts')
    function onSubmit(token) {
        document.getElementById("sales").submit();
    }
@endpush



@section('content')

{{-- Mision --}}
<div class="container-fluid text-muted py-5" style="background-image: linear-gradient(#F8F9FA 70%, #007BFF 30%);">
    <div class="container h-100 py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <p class="h1 font-weight-bold mb-4 align-self-center text-center">
                    {{ __('Contact our sales team') }}
                </p>

                <p class="h3 font-weight-normal align-self-center text-center">
                    {{ __('Our team will answer all your questions with a smile.') }} 
                    {{ __('Fill out the form and we’ll be in touch as soon as possible.') }}
                </p>

                {{-- The box with the contact form --}}
                <div class="container d-flex flex-column mt-5 px-4 bg-white rounded shadow-sm">

                    <div>
                        <x-alert-errors />
                        <x-alert-messages />
                    </div>

                    <div>
                        <form action="{{ url('sales') }}" method="POST" id="sales">
                            @csrf
                            <div class="row my-5">
                                <div class="col-4">
                                    {{ __('Your full name') }}
                                </div>
                                <div class="col-8">
                                    <x-input
                                        name="name"
                                        type="text" 
                                        pre="John Doe">
                                    </x-input>
                                </div>
                                <div class="w-100"></div>
                                <div class="col-4">
                                    {{ __('Your work email') }}
                                </div>
                                <div class="col-8">
                                    <x-input
                                        name="email"
                                        type="email" 
                                        pre="john.doe@example.com">
                                    </x-input>
                                </div>
                                <div class="w-100"></div>
                                <div class="col-4">
                                    {{ __('Your message') }}
                                </div>
                                <div class="col-8">
                                    <textarea 
                                        name="message" 
                                        class="form-control" 
                                        rows="5" 
                                        placeholder="{{ __('Write your message here') }}">
                                    </textarea>
                                </div>
                                <div class="w-100"></div>
                                <div class="col-4 py-3"></div>
                                <div class="col-8 py-3">
                                    <button class="g-recaptcha btn btn-primary btn-lg btn-block" 
                                            data-sitekey="6Ldx_fwUAAAAAEzAKkjJE1slKqJI0ImcORaBCtq2" 
                                            data-callback='onSubmit' 
                                            data-action='submit'>
                                        {{ __('Contact sales') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection



@push('scripts')
    
@endpush