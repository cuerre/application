@extends('layouts.desk')



@section('module')

    {{-- Top title --}}
    <x-card-header
        :title="__('Modify code')"
        :hint="__('desk')">
    </x-card-header>
    
    {{-- Errors --}}
    <x-alert-errors /> 

    {{-- Messages bag --}}
    <x-alert-messages />

    <x-attention>
        {{ __('You are going to change the targets of this QR code.') }}
        {{ __('Make sure what you are doing because this can be risky on marketing campaigns.') }}
    </x-attention>

    <x-box>
        <form action="{{ url('desk/codes') }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <x-box-header>{{ __('Name') }}</x-box-header>
            <x-input
                name="name" 
                type="text"  
                :pre="__('Give it a name')"
                :value="$code['name']">
            </x-input>

            <input type="hidden" name="code" value="{{ $code['id'] }}" />

            <div class="mb-5">
                {{-- Targets --}} 
                <x-box-header>{{ __('Targets') }}</x-box-header>

                {{-- Target Buttons --}}
                <div class="d-flex justify-content-start">
                    <div class="btn-group rounded" role="group">
                        <button type="button" class="btn btn-light" v-on:click="addTarget()">
                            <i class="material-icons align-middle text-muted">add</i>
                        </button>
                        <button type="button" class="btn btn-light" v-on:click="removeTarget()">
                            <i class="material-icons align-middle text-muted">remove</i>
                        </button>
                    </div>
                </div>
            
                {{-- Target Fields --}}
                <codes-target-selector 
                    v-for="item in codes.targets" 
                    v-bind:name="item">
                </codes-target-selector>
            </div>
            
            
    
            {{-- Submit button --}}
            <div class="d-flex justify-content-end">
                <x-submit-button 
                    :content="__('Create!')">
                </x-submit-button>
            </div>
            
        </form>
    </x-box>
    
@endsection