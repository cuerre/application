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
                <h3 class="mb-auto text-light">Creating a code</h3>
            </div>
        </div>
        <div class="my-auto">
            <!--
            <button type="button" class="btn btn-primary shadow">
                <i class="material-icons align-middle">add</i>
                <span class="align-middle">New code</span>
            </button>
            -->
        </div>
    </div>
    
    
    <form action="{{ url('code') }}" method="POST">
        @csrf

        <div class="form-group mb-5">
            <input type="text" class="form-control" placeholder="Give it a name">
        </div>
        
        <div class="form-group mb-5">
            <button type="button" class="btn btn-sm btn-primary rounded-circle">
                <i class="material-icons align-middle">add</i>
            </button>
            Agrega objetivos
        </div>
        
        <div class="row align-items-end m-0 border border-secondary rounded bg-secondary py-4 px-2">
            <div class="col col-md-4">
                <label class="small">Your target</label>
                <select class="form-control" name="target[0][system]">
                    <option value="android" selected>Android</option>
                    <option value="ios">iOS</option>
                    <option value="any">Any</option>
                </select>
            </div>
            <div class="col col-md-6">
                <label class="small">Destination url</label>
                <input type="text" class="form-control" name="target[0][url]" placeholder="URL de destino">
            </div>
            <div class="col col-md-2">
                <button type="button" class="btn btn-secondary active">
                    <i class="material-icons align-middle">delete</i>
                </button>
            </div>
        </div>
        
        <div class="form-group mt-5">
            <button type="submit" class="btn btn-primary">
                Create!
            </button>
        </div>
    </form>
    
@endsection



{{-- Javascript for this form --}}
@push('scripts')
    <script>
    
    </script>
@endpush

