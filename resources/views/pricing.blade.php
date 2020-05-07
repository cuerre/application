@extends('layouts.app')



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
{{-- Dialog --}}
<div class="container-fluid text-muted bg-light pt-5 " >
    <div class="container h-100 pt-5">
        <div class="d-flex flex-column justify-content-center">
            <p class="h1 font-weight-bold mb-4 align-self-center">
                The right price for you, whoever you are
            </p>
            <p class="h5 font-weight-normal align-self-center">
                Just buy credits and enjoy the magic
            </p>
        </div>
        
    </div>
</div>


{{-- Offers --}}
<div class="container-fluid text-muted bg-light py-5" >
    <div class="container h-100 py-5">
        <div class="row mb-5">

            {{-- Free offer --}}
            <div class="col-lg">
                <div class="overShadow rounded h-100">
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
                        {{--
                        <div class="py-3">
                            <x-link-button
                                content="SELECT"
                                link="#"
                                size="md" 
                                block
                                color="primary">
                            </x-link-button>
                        </div>
                        --}}
                        <div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item border-0">
                                    <i class="material-icons align-middle text-success">check_circle_outline</i>
                                    <small>{{ __('Create QR codes') }}</small>
                                </li>
                                <li class="list-group-item border-0">
                                    <i class="material-icons align-middle text-success">check_circle_outline</i>
                                    <small>{{ __('Read QR codes') }}</small>
                                </li>
                                <li class="list-group-item border-0">
                                    <i class="material-icons align-middle text-success">check_circle_outline</i>
                                    <small>{{ __('1k request per hour') }}</small>
                                </li>
                            </ul>
                        </div>
                    </x-striped-card>
                </div>
            </div>


            {{-- Premium offer --}}
            <div class="col-lg ">
                <div class="overShadow rounded h-100">
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
                        {{--
                        <div class="py-3">
                            <x-link-button
                                content="SELECT"
                                link="#"
                                size="md" 
                                block
                                color="primary">
                            </x-link-button>
                        </div>
                        --}}
                        <div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item border-0">
                                    <i class="material-icons align-middle text-success">check_circle_outline</i>
                                    <small>{{ __('Reuse QR between campaigns') }}</small>
                                </li>
                                <li class="list-group-item border-0">
                                    <i class="material-icons align-middle text-success">check_circle_outline</i>
                                    <small>{{ __('Detailed stats about visits') }}</small>
                                </li>
                                <li class="list-group-item border-0">
                                    <i class="material-icons align-middle text-success">check_circle_outline</i>
                                    <small>{{ __('Set different targets') }}</small>
                                </li>
                                <li class="list-group-item border-0">
                                    <i class="material-icons align-middle text-success">check_circle_outline</i>
                                    <small>{{ __('Prior Technical Support') }}</small>
                                </li>
                            </ul>
                        </div>
                    </x-striped-card>
                </div>
            </div>

        </div>


        {{-- Enterprise --}}
        <div class="row rounded p-3 py-5 mx-1 bg-primary shadow-sm mb-5 overShadow">
            <div class="col-lg">
                <p class="text-uppercase font-weight-bolder text-light">
                    {{ __('ENTERPRISE SOLUTION') }}
                </p>
                <p class="text-light">
                    {{ __('Need more or have custom needs?') }}
                </p>
                <x-link-button
                    content="CONTACT US"
                    link="#" 
                    color="outline-light">
                </x-link-button>
            </div>
        </div>


    </div>
</div>


<div class="container-fluid text-muted bg-white py-5 border-top">
    <div class="container h-100 py-5">

        {{-- FAQ --}}
        <div class="row justify-content-md-center rounded p-3 mx-1 bg-white">
            <div class="col-lg-8 p-0">
                <div class="d-flex justify-content-center mb-4">
                    <p class="h2 font-weight-bolder">
                        {{ __('Commonly Asked Questions') }}
                    </p>
                </div>
                <div class="container">
                    <x-action-list>
                        <x-action-list-item
                            :field="__('Is there a minimum subscription period?')" 
                            :value="__('No, you just buy credits that are used monthly, there is no lock in.')">
                        </x-action-list-item>
                        <x-action-list-item
                            :field="__('Why a free plan?')" 
                            :value="__('This is done thinking on app makers who need working with QR codes without hard coding solutions')">
                        </x-action-list-item>
                        <x-action-list-item
                            :field="__('Why just one premium plan?')" 
                            :value="
                                __('QR codes have been hard to use by enterprises for years.') . ' '. 
                                __('We try to keep them as simple as possible.') . ' ' . 
                                __('Just one paid plan let us to concentrate into the important: make it better')">
                        </x-action-list-item>
                    </x-action-list>
                </div>

            </div>
        </div>
    </div>
</div>


@endsection



@push('scripts')
    
@endpush