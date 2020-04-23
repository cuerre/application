@extends('layouts.app')



@push('styles.tablet')
    #sidePanel {
        display: block !important;
    }
    
    #module {
        padding: 2rem !important;
    }
@endpush



@section('content')
    <div class="container">
    
        <div class="row">
        
            {{-- Side menu --}}
            <div id="sidePanel" class="d-none col-md-4 pt-5">
            
                {{-- Search box --}}
                <!--
                <div class="bg-secondary rounded-lg mt-5">
                    <div class="d-flex flex-row">
                      <div class="flex-grow-1">
                        <input type="text" class="form-control border-0 bg-transparent text-light" placeholder="Search">
                      </div>
                      <div class="my-auto">
                        <button type="button" class="btn btn-sm text-light">
                            <i class="material-icons md-18">search</i>
                        </button>
                      </div>
                    </div>
                </div>
                -->
                
                {{-- Navigation --}}
                <p class="text-uppercase text-muted ml-3">
                    Dashboards
                </p>
                <div class="nav flex-column nav-pills">
                    <a href="#" class="nav-link active">
                        <i class="material-icons align-middle mr-2">house</i>
                        <span class="align-middle">Home</span>
                    </a>
                    <a href="{{ url('codes') }}" class="nav-link text-secondary">
                        <i class="material-icons align-middle mr-2">crop_square</i>
                        <span class="align-middle">Codes</span>
                    </a>
                    
                    <a href="#" class="nav-link text-secondary">
                        <i class="material-icons align-middle mr-2">face</i>
                        <span class="align-middle">Profile</span>
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
            <div id="module" class="col-md-8 text-light bg-white rounded shadow-sm">
                @yield('module')
            </div>
        </div>
        
    </div>
@endsection
