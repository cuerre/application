@extends('layouts.dashboard')



@section('module')

    {{-- Top title --}}
    <x-card-header
        title="Codes"
        hint="dashboard">
        <div class="my-auto">
            <x-link-button 
                icon="add"
                content="New"
                :link="url('dashboard/codes/creation')">
            </x-link-button >
        </div>
    </x-card-header>
    
    {{-- Code list --}}
    @forelse ($codes->items() as $code)
        @php
            $codeUrl = App\Http\Controllers\CodesController::GetImageUrl($code['id']);
        @endphp
        
        <div class="row m-0 bg-light rounded mb-4 p-3 justify-content-center">
            <div class="col-md-auto p-3">
                <div class="d-flex justify-content-center">
                    <img src="{{ $codeUrl }}" class="rounded-lg shadow-sm" style="width: 6rem !important;">
                </div>
            </div>
            <div class="col p-0">
                <div class="d-flex flex-column h-100 w-100">
                    {{-- Top bar container --}}
                    <div class="p-2 text-break mb-auto">
                        <small class="text-uppercase text-muted">Code name</small>
                        <p class="text-dark">{{ $code['name'] }}</p>
                    </div>
                    
                    {{-- Targets bar container --}}
                    <div class="p-2 text-break mb-auto">
                        <small class="text-uppercase text-muted">Targets</small>
                        <div>    
                            @foreach ( $code['data']['targets'] as $target )
                                <a href="{{ $target['url'] }}" target="_blank" class="text-decoration-none">
                                    <button type="button" class="btn btn-sm bg-secondary text-light"
                                        data-toggle="tooltip" 
                                        data-placement="top" 
                                        title="{{ $target['url'] }}">
                                            <span class="text-capitalize">
                                                {{ $target['system'] }}
                                            </span>
                                    </button>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    
                    {{-- Bottom bar container --}}
                    <div class="d-flex flex-row w-100 py-2">
                    
                        {{-- Stats --}}
                        <a href="#" role="button" class="btn btn-sm text-dark text-decoration-none mr-1">
                            <i class="material-icons align-middle">bar_chart</i>
                        </a>

                        {{-- Download dropdown --}}
                        <div class="dropdown">
                            <button 
                                class="btn btn-sm dropdown-toggle mr-1" 
                                data-display="static" 
                                type="button" 
                                data-toggle="dropdown" 
                                aria-haspopup="true" 
                                aria-expanded="false">
                                <i class="material-icons align-middle">save_alt</i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ $codeUrl }}&output=PNG&dotsize=5&dpi=100&download">.PNG</a>
                                <a class="dropdown-item" href="{{ $codeUrl }}&output=SVG&download">.SVG</a>
                                <a class="dropdown-item" href="{{ $codeUrl }}&output=EPS&download">.EPS</a>
                            </div>
                        </div>
                        
                        {{-- Delete --}}
                        <form id="delete-code-form" action="{{ url('dashboard/code') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $code['id'] }}">
                            <button type="submit" class="btn btn-sm mr-1" onclick="return confirm('Are you sure?')">
                                <i class="material-icons align-middle">delete</i>
                            </button>
                        </form>
                        
                    </div>

                </div>
            </div>
        </div>
        
    @empty
        
        <div class="card border-0">
            <div class="card-body bg-light rounded text-secondary">
                <p class="card-text">
                    Touch <kbd class="mx-2">+ New</kbd> on the top to create 
                    a new super vitamin code 
                </p>
            </div>
        </div>
        
    @endforelse
    
    {{-- Paginator --}}
    @if ( $codes->lastPage() > 1)
        <div class="d-flex justify-content-end mt-3">
            {{ $codes->links() }}
        </div>
    @endif
    

@endsection

