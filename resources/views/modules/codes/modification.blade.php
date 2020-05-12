@extends('layouts.dashboard')



@section('module')

    {{-- Top title --}}
    <x-card-header
        title="Modify code"
        hint="dashboard">
    </x-card-header>
    
    {{-- Errors --}}
    <x-alert-errors /> 

    <x-attention>
        {{ __('You are going to change the targets of this QR code.') }}
        {{ __('Make sure what you are doing because this can be risky on marketing campaigns.') }}
    </x-attention>

    <x-box>
        <form action="{{ url('dashboard/codes') }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <x-input
                name="name" 
                type="text"  
                :pre="__('Give it a name')"
                :value="$code['name']">
            </x-input>

            <input type="hidden" name="code" value="{{ $code['id'] }}" />
            
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
                    :content="__('Create!')">
                </x-submit-button>
            </div>
            
        </form>
    </x-box>
    
@endsection