@extends('layouts.dashboard')



@section('module')

    {{-- Top title --}}
    <div class="d-flex justify-content-between mb-5 py-3">
        <div class="d-flex flex-column">
            <div>
                <span class="text-uppercase text-muted mb-auto">
                    Dashboard
                </span>
            </div>
            <div class="p-0">
                <h3 class="mb-auto text-dark font-weight-normal">New code</h3>
            </div>
        </div>
    </div>
    
    {{-- Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="list-unstyled">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ url('dashboard/code') }}" method="POST">
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
            v-for="item in range" 
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



{{-- Javascript for this form --}}
@push('scripts')
        //Register Page header component
        Vue.component('codes-target-selector', {
            props: ['name'],
            methods: {
                setTargetSystem: function() {
                    return "targets["+this.$props.name+"][system]";
                },
                setTargetUrl: function() {
                    return "targets["+this.$props.name+"][url]";
                }
            },
            template: `
                <div class="my-4">
                    <div class="row align-items-end m-0 rounded bg-light py-4 px-2">
                        <div class="col-md-4 align-self-stretch">
                            <select class="form-control form-control-sm py-4 mb-3 text-secondary" :name="setTargetSystem()">
                                <option selected>Choose a target...</option>
                                <option value="win10">Windows 10</option>
                                <option value="android">Android</option>
                                <option value="ios">iOS</option>
                                <option value="any">Any</option>
                            </select>
                        </div>
                        <div class="col-md align-self-stretch">
                            <input 
                                type="text" 
                                class="form-control form-control-sm py-4 text-secondary" 
                                :name="setTargetUrl()" 
                                placeholder="http://goto.destination.com">
                        </div>
                    </div>
                </div>
            `
        });
        
        
        //Root Instance
        var Vue = new Vue({
            el: '#app',
            data: {
                range: 1
            },

            methods: {
                addTarget: function() {
                    this.range += 1;
                },
                removeTarget: function() {
                    if ( this.range > 1 ) {
                        this.range -= 1;
                    }
                }
            }
        })
        
@endpush

