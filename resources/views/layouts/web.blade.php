@extends('layouts.app')

@section('wrapper')

    {{-- Navbar --}}
    <x-web-navbar/>
    
    {{-- Content --}}
    @yield('content')

    
    {{-- Footer --}}
    <x-web-footer/>
@endsection
        
   