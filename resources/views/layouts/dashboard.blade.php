@extends('layouts.app')



@push('styles.tablet')
    #sidePanel {
        display: block !important;
    }
@endpush



@section('content')
    <div class="container">
    
        <div class="row">
        
            {{-- Side menu --}}
            <div id="sidePanel" class="d-none col-md-4 pt-5">
                           
                {{-- Navigation --}}
                <p class="text-uppercase text-muted ml-3">
                    Dashboards
                </p>
                <div class="nav flex-column nav-pills">
                    <a href="#" class="nav-link text-secondary">
                        <i class="material-icons align-middle mr-2">house</i>
                        <span class="align-middle">Home</span>
                    </a>
                    <a href="{{ url('dashboard/codes') }}" class="nav-link text-secondary">
                        <i class="material-icons align-middle mr-2">crop_square</i>
                        <span class="align-middle">Codes</span>
                    </a>
                    
                    <a href="#" class="nav-link text-secondary">
                        <i class="material-icons align-middle mr-2">face</i>
                        <span class="align-middle">Profile</span>
                    </a>
                    <a href="#" class="nav-link text-secondary">
                        <i class="material-icons align-middle mr-2">monetization_on</i>
                        <span class="align-middle">Billing</span>
                    </a>
                    <a href="#" class="nav-link text-secondary">
                        <i class="material-icons align-middle mr-2">mail</i>
                        <span class="align-middle">Support</span>
                    </a>
                </div>
                
                {{-- Navigation extra --}}
                <p class="mt-5 text-uppercase text-muted ml-3">
                    More
                </p>
                <div class="nav flex-column nav-pills">
                    <a href="#" class="nav-link text-secondary">
                        <i class="material-icons align-middle mr-2">code</i>
                        <span class="align-middle">Developers</span>
                    </a>
                </div>
            </div>
            
            {{-- Module --}}
            
            <div class="col-md-8 p-0">
                <div class="p-1 bg-primary rounded-top m-0"></div>
                <div id="module" class="text-light bg-white rounded shadow-sm p-5">
                    @yield('module')
                </div>
            </div>
        </div>
        
    </div>
@endsection
