@extends('layouts.desk')



@section('module')

    {{-- Top title --}}
    <x-card-header
        :title="__('New code')"
        :hint="__('desk')">
    </x-card-header>
    
    {{-- Errors --}}
    <x-alert-errors /> 

    {{-- Messages bag --}}
    <x-alert-messages />

    <x-box>
        <form action="{{ url('desk/codes') }}" method="POST">
            @csrf

            {{-- Name --}}
            <div class="mb-5">
                <x-box-header>{{ __('Name') }}</x-box-header>
                <x-input
                    name="name" 
                    type="text" 
                    :pre="__('Give it a name')">
                </x-input>
            </div>
            
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
                    :content="__('Create code')"
                    block>
                </x-submit-button>
            </div>
            
        </form>
    </x-box>
    
@endsection