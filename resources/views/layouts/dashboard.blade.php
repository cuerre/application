@extends('layouts.app')



@section('content')
    <div class="container h-100">
    
        <div class="row">
        
            {{-- Side menu --}}
            <div id="sidePanel" class="col-md-4 border-bottom border-secondary pb-4">
            
                {{-- Search box --}}
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
                
                {{-- Navigation --}}
                <p class="mt-5 text-uppercase text-muted ml-3">
                    Dashboard
                </p>
                <div class="nav flex-column nav-pills">
                    <a href="#" class="nav-link active text-light">Home</a>
                    <a href="#" class="nav-link text-light">Profile</a>
                    <a href="#" class="nav-link text-light">Codes</a>
                    <a href="#" class="nav-link text-light">Contact</a>
                </div>
                
                {{-- Navigation extra --}}
                <p class="mt-5 text-uppercase text-muted ml-3">
                    More
                </p>
                <div class="nav flex-column nav-pills">
                    <a href="#" class="nav-link text-light">Developers</a>
                </div>
            </div>
            
            {{-- Module --}}
            <div id="module" class="col-md-8 p-5 text-light">
                @yield('module')
            </div>
        </div>
        
    </div>
@endsection
