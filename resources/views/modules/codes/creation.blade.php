@extends('layouts.dashboard')



@section('module')

    {{-- Top title --}}
    <div class="d-flex justify-content-between mb-5 pb-3 border-bottom border-secondary">
        <div class="d-flex flex-column">
            <div>
                <span class="text-uppercase text-muted mb-auto">
                    Dashboard
                </span>
            </div>
            <div class="p-0">
                <h3 class="mb-auto text-light font-weight-normal">New code</h3>
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
    
    
    
    
    
    
    
    
    <form action="{{ url('code') }}" method="POST">
        @csrf

        {{-- Name --}}
        <div class="form-group mb-5">
            <input type="text" name="name" class="form-control" placeholder="Give it a name">
        </div>
        
        {{-- Buttons --}}
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-secondary" v-on:click="addTarget()">
                <i class="material-icons align-middle">add</i>
            </button>
            <button type="button" class="btn btn-secondary" v-on:click="removeTarget()">
                <i class="material-icons align-middle">remove</i>
            </button>
        </div>
        
        {{-- Targets --}}     
        <codes-target-selector v-for="item in range" v-bind:name="item">
        </codes-target-selector>
   
        {{-- Submit button --}}
        <div class="form-group mt-5 ">
            <button type="submit" class="btn btn-primary">
                Create!
            </button>
        </div>
        
    </form>
    
@endsection



{{-- Javascript for this form --}}
@push('scripts')
    <script>
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
                    <div class="row align-items-end m-0 border border-secondary rounded bg-secondary py-4 px-2">
                        <div class="col-md-4">
                            <select class="form-control text-secondary" :name="setTargetSystem()">
                                <option value="win10">Windows 10</option>
                                <option value="android">Android</option>
                                <option value="ios">iOS</option>
                                <option value="any" selected>Any</option>
                            </select>
                            <label class="small text-dark text-monospace">User system</label>
                        </div>
                        <div class="col-md">
                            <input type="text" class="form-control text-secondary" :name="setTargetUrl()" placeholder="http://destination.url">
                            <label class="small text-dark text-monospace">Destination url</label>
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
        
    </script>
@endpush

