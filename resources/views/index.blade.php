@extends('layouts.app')



@push('styles.tablet')
    #sidePanel {
        display: block !important;
    }
@endpush



@section('content')

<div class="max-w-sm rounded overflow-hidden shadow-lg">
  <img class="w-full" src="/img/card-top.jpg" alt="Sunset in the mountains">
  <div class="px-6 py-4">
    <div class="font-bold text-xl mb-2">The Coldest Sunset</div>
    <p class="text-gray-700 text-base">
      Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et perferendis eaque, exercitationem praesentium nihil.
    </p>
  </div>
  <div class="px-6 py-4">
    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">#photography</span>
    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">#travel</span>
    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">#winter</span>
  </div>
</div>  

<div class="bg-indigo-900 text-center py-4 lg:px-4">
  <div class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex" role="alert">
    <span class="flex rounded-full bg-indigo-500 uppercase px-2 py-1 text-xs font-bold mr-3">New</span>
    <span class="font-semibold mr-2 text-left flex-auto">Get the coolest t-shirts from our brand new store</span>
    <svg class="fill-current opacity-75 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z"/></svg>
  </div>
</div>



<div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
  <div class="flex">
    <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
    <div>
      <p class="font-bold">Our privacy policy has changed</p>
      <p class="text-sm">Make sure you know how these changes affect you.</p>
    </div>
  </div>
</div>

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
                                    :link="url('sales')">
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
