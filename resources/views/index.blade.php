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
                            The perfect place 
                        </p>
                        <p class="h1 font-weight-bold mb-4">
                            to enjoy QR codes
                        </p>
                        <p class="h5 font-weight-normal">
                            With Cuerre, you can know information
                            about the people who enter your QR codes,
                            generate or decode them, reuse your QR 
                            between different marketing campaigns, and 
                            so much more.
                        </p>
                        <p class="h5 font-weight-normal">
                            Fast • Simple to use • Developers friendly • Accurate
                        </p>
                        <div class="d-flex mt-5">
                            <div class="mr-3">
                                <x-link-button
                                    content="Register for free"
                                    size="lg" 
                                    link="#">
                                </x-link-button>
                            </div>
                            <div class="mr-3">
                                <x-link-button
                                    content="Contact Sales"
                                    size="lg"
                                    color="outline-primary"
                                    link="#">
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
                            Powerful easy statistics
                        </p>
                        <p class="h5 font-weight-normal">
                            Know your customers better by operating system, browser
                            or device type. Find the best moment to launch a product 
                            showing visitors of the last week, last month and even last year.
                        </p>
                        <p class="h5 font-weight-normal">
                            Moreover, we have added some easy-to-understand explanations 
                            to help you interpret the data.
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
                            Segmentate your customers
                        </p>
                        <p class="h5 font-weight-normal">
                            Decide where to send your customers according 
                            to the operating system they come from or send everyone to 
                            the same place. It is your decision!
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
                            Integrations done in minutes
                        </p>
                        <p class="h5 font-weight-normal">
                            Our API is easy to use and <a href="{{ url('documentation/api/v1/prologue') }}">well documented<a>. 
                            In about 10 minutes can be integrated in almost 
                            everything, for example: your application
                        </p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@endsection
