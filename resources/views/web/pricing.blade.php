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
{{-- Dialog --}}
<div class="container-fluid text-muted bg-light pt-5 " >
    <div class="container h-100 pt-5">
        <div class="d-flex flex-column justify-content-center">
            <p class="h1 font-weight-bold mb-4 align-self-center">
                {{ __('The right price for you, whoever you are') }}
            </p>
            <p class="h5 font-weight-normal align-self-center">
                {{ __('Just buy credits and enjoy the magic') }}
            </p>
        </div>
        
    </div>
</div>


{{-- Offers --}}
<div class="container-fluid text-muted bg-light py-5" >
    <div class="container h-100 py-5">
        <div class="row mb-5">



            {{-- Small offer --}}
            <div class="col-lg ">
                <div class="overShadow rounded h-100">
                    <x-striped-card>
                        <div class="d-flex justify-content-center">
                            <p class="font-weight-bolder text-uppercase">
                                {{ __('SMALL PACK') }}
                            </p>
                        </div>
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <div>
                                <span class="h1 font-weight-bold text-uppercase">
                                    0.2€
                                </span>
                                <small>/ {{ __('day') }} ({{ __('each code') }})</small>
                            </div>
                            <div class="my-3">
                                <span class="font-weight-normal small">{{ __('* -50 codes') }}</span>
                            </div>
                        </div>
                        
                        <div class="py-3">
                            <x-link-button
                                content="SELECT"
                                :link="url('register')"
                                size="md" 
                                block
                                color="primary">
                            </x-link-button>
                        </div>
                        
                        <div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item border-0">
                                    <i class="material-icons align-middle text-success">check_circle_outline</i>
                                    <small>{{ __('Create QR that redirects') }}</small>
                                </li>
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
                                    <small>{{ __('API access') }}</small>
                                </li>
                                <li class="list-group-item border-0">
                                    <i class="material-icons align-middle text-success">check_circle_outline</i>
                                    <small>{{ __('Technical support') }}</small>
                                </li>
                            </ul>
                        </div>
                    </x-striped-card>
                </div>
            </div>



            {{-- Codes offer --}}
            <div class="col-lg ">
                <div class="overShadow rounded h-100">
                    <x-striped-card>
                        <div class="d-flex justify-content-center">
                            <p class="font-weight-bolder text-uppercase">
                                {{ __('MEDIUM PACK') }}
                            </p>
                        </div>
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <div>
                                <span class="h1 font-weight-bold text-uppercase">
                                    0.15€
                                </span>
                                <small>/ {{ __('day') }} ({{ __('each code') }})</small>
                            </div>
                            <div class="my-3">
                                <span class="font-weight-normal small">{{ __('* 50 - 100 codes') }}</span>
                            </div>
                        </div>
                        
                        <div class="py-3">
                            <x-link-button
                                content="SELECT"
                                :link="url('register')"
                                size="md" 
                                block
                                color="primary">
                            </x-link-button>
                        </div>
                        
                        <div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item border-0">
                                    <i class="material-icons align-middle text-success">check_circle_outline</i>
                                    <small>{{ __('Create QR that redirects') }}</small>
                                </li>
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
                                    <small>{{ __('API access') }}</small>
                                </li>
                                <li class="list-group-item border-0">
                                    <i class="material-icons align-middle text-success">check_circle_outline</i>
                                    <small>{{ __('Technical support') }}</small>
                                </li>
                            </ul>
                        </div>
                    </x-striped-card>
                </div>
            </div>



            {{-- Tokens offer --}}
            <div class="col-lg">
                <div class="overShadow rounded h-100">
                    <x-striped-card>
                        <div class="d-flex justify-content-center">
                            <p class="font-weight-bolder text-uppercase">
                                {{ __('LARGE PACK') }}
                            </p>
                        </div>
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <div>
                                <span class="h1 font-weight-bold text-uppercase">
                                    0.1€
                                </span>
                                <small>/ {{ __('day') }} ({{ __('each code') }})</small>
                            </div>
                            <div class="my-3">
                                <span class="font-weight-normal small">{{ __('* 100+ codes') }}</span>
                            </div>
                        </div>

                        <div class="py-3">
                            <x-link-button
                                content="SELECT"
                                :link="url('register')"
                                size="md" 
                                block
                                color="primary">
                            </x-link-button>
                        </div>

                        <div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item border-0">
                                    <i class="material-icons align-middle text-success">check_circle_outline</i>
                                    <small>{{ __('Create QR that redirects') }}</small>
                                </li>
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
                                    <small>{{ __('API access') }}</small>
                                </li>
                                <li class="list-group-item border-0">
                                    <i class="material-icons align-middle text-success">check_circle_outline</i>
                                    <small>{{ __('Technical support') }}</small>
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
                    {{ __('Need more or have custom needs? Need to bill by year?') }}
                </p>
                <ul class="bg-primary p-0">
                    <li class="list-group-item border-0 bg-primary text-light">
                        <i class="material-icons align-middle text-success">check_circle_outline</i>
                        <small>{{ __('Billed by periods') }}</small>
                    </li>
                    <li class="list-group-item border-0 bg-primary text-light">
                        <i class="material-icons align-middle text-success">check_circle_outline</i>
                        <small>{{ __('Vitamin API') }}</small>
                    </li>
                    <li class="list-group-item border-0 bg-primary text-light">
                        <i class="material-icons align-middle text-success">check_circle_outline</i>
                        <small>{{ __('High priority technical support') }}</small>
                    </li>
                </ul>
                <x-link-button
                    content="CONTACT SALES"
                    :link="url('sales')" 
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
                            :value="__('No, you just buy credits that are used daily, there is no lock in.')">
                        </x-action-list-item>
                        <x-action-list-item
                            :field="__('Why so few plans?')" 
                            :value="
                                __('We would like to keep it simple to help everyone to understand it.') . ' ' . 
                                __('Once you are inside, you will discover a lot of extra features on your own.')">
                        </x-action-list-item>
                        <x-action-list-item
                            :field="__('Why an enterprise solution?')" 
                            :value="
                                __('Some companies use massive resources or simply need to be isolated.') . ' '. 
                                __('We analyse the requirements of those companies and help them from start to end.')">
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