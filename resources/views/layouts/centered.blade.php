@extends('layouts.web')



@push('styles.tablet')
    #sidePanel {
        display: block !important;
    }
@endpush




@section('content')
    <div class="container-fluid d-flex justify-content-center mt-5 py-4 px-0">
        @yield('module')
    </div>
@endsection
