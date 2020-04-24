@extends('layouts.dashboard')



@section('module')
    {{-- Top title --}}
    <x-card-header
        :title="__('Delete your account')"
        :hint="__('dashboard')">
    </x-card-header>
    
    <form action="{{ url('dashboard/profile') }}" method="POST">
        @csrf
        @method('DELETE')
        
        <div class="mb-4">
            {{ __('If you really want to remove your account, be sure, because this') }}
            {{ __('action is permanent and your data will be deleted from our systems.') }}
        </div>
        
        <x-submit-button
            :content="__('Delete my account')">
        </x-submit-button>
    </form>
@endsection
