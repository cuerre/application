@extends('layouts.desk')



@section('module')
    {{-- Top title --}}
    <x-card-header
        :title="__('Change your name')"
        :hint="__('desk')">
    </x-card-header>

    {{-- Errros --}}
    <x-alert-errors />
    
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
    
    <div class="small text-muted">
        {{ __('If you are billing credits') }} 
        {{ __('you must be sure to use the same name that is set in your payment method') }}
    </div>
@endsection
