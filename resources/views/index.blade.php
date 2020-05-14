@extends('layouts.app')



@push('styles.tablet')
    #sidePanel {
        display: block !important;
    }
@endpush



@section('content')

    {{-- Section: Slogan --}}
    <div class="container-fluid text-muted bg-light py-5">
        <div class="container h-100 my-5">
            <div class="row my-auto">
                <div class="col-lg py-3">
                    <div>
                        <p class="h1 font-weight-bold">
                            {{ __('The perfect place') }} 
                        </p>
                        <p class="h1 font-weight-bold mb-4">
                            {{ __('to enjoy QR codes') }}
                        </p>
                        <p class="h5 font-weight-normal">
                            {{ __('With Cuerre, you can know information') }}
                            {{ __('about the people who enter your QR codes') }},
                            {{ __('generate or decode them, reuse your QR') }} 
                            {{ __('between different marketing campaigns') }}, 
                            {{ __('and so much more') }}.
                        </p>
                        <p class="h5 font-weight-normal">
                            {{ __('Fast') }} • 
                            {{ __('Simple to use') }} • 
                            {{ __('Developers friendly') }} • 
                            {{ __('Accurate') }}
                        </p>
                        <div class="d-flex mt-5">
                            <div class="mr-3">
                                <x-link-button
                                    :content="__('Register for free')"
                                    size="lg" 
                                    :link="url('register')">
                                </x-link-button>
                            </div>
                            <div class="mr-3">
                                <x-link-button
                                    :content="__('Contact Sales')"
                                    size="lg"
                                    color="outline-primary"
                                    :link="url('contact')">
                                </x-link-button>   
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg offset-lg-1 py-3">
                    <img src="{{ asset('imgs/pieces/4.png') }}" class="w-100 shadow-lg rounded"/>
                </div>
            </div>
        </div>
    </div>



    {{-- The ribbon --}}
    {{--
    <div class="container-fluid text-light bg-secondary">
        <div class="container h-100 my-5">
            <div class="row">
                <div class="col-lg py-3">
                    
                </div>
                <div class="col-lg py-3">
                    
                </div>
                <div class="col-lg py-3">
                    
                </div>
            </div>
        </div>
    </div>
    --}}



    {{-- Powerful stats --}}
    <div class="container-fluid text-muted border-top bg-white">
        <div class="container h-100 my-5">
            <div class="row">
                <div class="col-lg py-3">
                    <img src="{{ asset('imgs/pieces/6.png') }}" class="w-100 shadow-lg rounded-lg"/>
                </div>
                <div class="col-lg offset-lg-1 py-3">
                    <div>
                        <p class="h3 font-weight-bold mb-4">
                            {{ __('Powerful easy statistics') }}
                        </p>
                        <p class="h5 font-weight-normal">
                            {{ __('Know your customers better by operating system') }}, 
                            {{ __('browser or device type. Find the best moment to launch a product') }} 
                            {{ __('showing visitors of the last week, last month and even last year') }}.
                        </p>
                        <p class="h5 font-weight-normal">
                            {{ __('Moreover, we have added some easy-to-understand explanations') }} 
                            {{ __('to help you interpret the data') }}.
                        </p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>



    {{-- Segmentate customers --}}
    <div class="container-fluid text-muted border-top bg-light">
        <div class="container h-100 my-5">
            <div class="row">
                <div class="col-lg py-3">
                    <div>
                        <p class="h3 font-weight-bold mb-4">
                            {{ __('Segmentate your customers') }}
                        </p>
                        <p class="h5 font-weight-normal">
                            {{ __('Decide where to send your customers according') }} 
                            {{ __('to the operating system they come from or send everyone to') }} 
                            {{ __('the same place. It is your decision!') }}'
                        </p>
                    </div>
                </div>
                <div class="col-lg offset-lg-1 py-3">
                    <img src="{{ asset('imgs/pieces/1.png') }}" class="w-100 shadow-lg rounded-lg"/>
                </div>
            </div>
        </div>
    </div>



    {{-- Developers friendly --}}
    <div class="container-fluid text-muted border-top bg-white">
        <div class="container h-100 my-5">
            <div class="row">
                <div class="col-lg py-3">
                    <img src="{{ asset('imgs/pieces/3.png') }}" class="w-100 shadow-lg rounded-lg"/>
                </div>
                <div class="col-lg offset-lg-1 py-3">
                    <div>
                        <p class="h3 font-weight-bold mb-4">
                            {{ __('Integrations done in minutes') }}
                        </p>
                        <p class="h5 font-weight-normal">
                            {{ __('Our API is easy to use and') }} 
                            <a href="{{ url('documentation/api/v1/prologue') }}">
                                {{ __('well documented') }}
                            <a>. 
                            {{ __('In about 10 minutes can be integrated in almost') }} 
                            {{ __('everything, for example: your application') }}
                        </p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@endsection
