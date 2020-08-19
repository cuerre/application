@extends('layouts.desk')



@section('module')
    {{-- Top title --}}
    <x-card-header
        :hint="__('desk')"
        :title="__('Personal data')">
    </x-card-header>

    {{-- Errros --}}
    <x-alert-errors />
    
    <x-box class="mb-5">
        <x-box-header>
            {{ __('Change your name') }}
        </x-box-header>

        <form action="{{ url('desk/profile/name') }}" method="POST">
            @csrf
            @method('PUT')
            <x-input
                name="name"
                type="text" 
                :pre="__('Write your name')">
            </x-input>
            
            <x-submit-button
                :content="__('Change it')">
            </x-submit-button>
        </form>
        
        <div class="small text-muted mt-4">
            {{ __('If you are billing credits') }} 
            {{ __('you must be sure to use the same name that is set in your payment method') }}
        </div>
    </x-box>
@endsection
