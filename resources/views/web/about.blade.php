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



@section('content')
{{-- Mision --}}
<div class="container-fluid text-muted bg-light pt-5 " >
    <div class="container h-100 py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <p class="h1 font-weight-bold mb-4 align-self-center text-center">
                    {{ __('The perfect place to enjoy QR codes') }}
                </p>
                <p class="h3 font-weight-normal align-self-center text-center">
                    {{ __('Founded in 2019 by engineer Alby Hernández') }}, 
                    {{ __('Cuerre has the mission to provide the most valuable service for QR codes at global scale.') }}
                    {{ __('We process and use big data to produce our accurate statistics') }}, 
                    {{ __('QR creation and reading and other super fast tools.') }}
                </p>
            </div>
        </div>
    </div>
</div>

{{-- People --}}
<div class="container-fluid text-muted bg-white pt-5 border-top" >
    <div class="container h-100 py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <p class="h1 font-weight-bold mb-4 align-self-center text-center">
                    {{ __('People behind the scene') }}
                </p>
                <p class="h3 font-weight-normal align-self-center text-center">
                    {{ __('Tiny team doing big things.') }} 
                </p>
            </div>
        </div>

        <x-web-people-container>
            <x-web-people
                picture="face-alby.png"
                name="Alby Hernández"
                description="Founder & Developer">
            </x-web-people>

            <x-web-people
                picture="face-kevin.png"
                name="Kevin Machuca"
                description="Developer">
            </x-web-people>
        </x-web-people-container>
        
    </div>
</div>


{{-- Sign up invitation --}}
<div class="container-fluid text-light bg-primary pt-5 border-top" >
    <div class="container h-100 py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <p class="h1 font-weight-bold mb-4 align-self-center text-center">
                    {{ __('Start working with QR codes today') }}
                </p>
                <p class="h3 font-weight-normal align-self-center text-center">
                    {{ __('Sign up for free to start working with our tool.') }} 
                    {{ __('It is fast, reliable and improves every day.') }}
                </p>
                <div class="d-flex justify-content-center my-5">
                    <x-link-button
                        :content="__('Register for free')"
                        :link="url('register')"
                        size="lg" 
                        color="light">
                    </x-link-button>
                </div>

            </div>
        </div>
    </div>
</div>





@endsection



@push('scripts')
    
@endpush