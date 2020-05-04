@extends('layouts.dashboard')



@section('module')

    {{-- Top title --}}
    <x-card-header
        title="New code"
        hint="dashboard">
    </x-card-header>
    
    {{-- Errors --}}
    <x-alert-errors /> 
    
    <form action="{{ url('dashboard/codes') }}" method="POST">
        @csrf

        {{-- Name --}}
        <x-input
            name="name" 
            type="text" 
            pre="Give it a name">
        </x-input>
        
        {{-- Buttons --}}
        <div class="d-flex justify-content-end">
            <div class="btn-group rounded" role="group">
                <button type="button" class="btn btn-light" v-on:click="addTarget()">
                    <i class="material-icons align-middle">add</i>
                </button>
                <button type="button" class="btn btn-light" v-on:click="removeTarget()">
                    <i class="material-icons align-middle">remove</i>
                </button>
            </div>
        </div>
        
        {{-- Targets --}}     
        <codes-target-selector 
            v-for="item in codes.targets" 
            v-bind:name="item">
        </codes-target-selector>
   
        {{-- Submit button --}}
        <div class="d-flex justify-content-end">
            <x-submit-button 
                content="Create!">
            </x-submit-button>
        </div>
        
    </form>
    
@endsection