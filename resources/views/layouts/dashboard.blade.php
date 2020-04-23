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
                <x-dashboard-menu header="dashboard">
                    <x-dashboard-menu-item 
                        icon="house" 
                        content="Home" 
                        :link="url('dashboard/home')">
                    </x-dashboard-menu-item>
                    
                    <x-dashboard-menu-item 
                        icon="crop_square" 
                        content="Codes" 
                        :link="url('dashboard/codes')">
                    </x-dashboard-menu-item>
                    
                    <x-dashboard-menu-item 
                        icon="face" 
                        content="Profile" 
                        link="#">
                    </x-dashboard-menu-item>
                    
                    <x-dashboard-menu-item 
                        icon="monetization_on" 
                        content="Billing" 
                        link="#">
                    </x-dashboard-menu-item>
                    
                    <x-dashboard-menu-item 
                        icon="mail" 
                        content="Support" 
                        link="#">
                    </x-dashboard-menu-item>
                </x-dashboard-menu>
                
                {{-- Navigation extra --}}
                <x-dashboard-menu header="more">
                    <x-dashboard-menu-item 
                        icon="code" 
                        content="Developers" 
                        link="#">
                    </x-dashboard-menu-item>
                </x-dashboard-menu>
                
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
