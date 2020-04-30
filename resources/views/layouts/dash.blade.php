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
            <div id="sidePanel" class="d-none col-md-4">
                @yield('menu')
            </div>
            
            {{-- Module --}}
            <div class="col-md-8 p-0">
                <x-striped-card>
                    @yield('module')
                </x-striped-card>
            </div>
        </div>
        
    </div>
@endsection
