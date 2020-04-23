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
                <h3 class="mb-auto text-dark font-weight-normal">Codes</h3>
            </div>
        </div>
        <div class="my-auto">
            <a href="{{ url('dashboard/codes/creation') }}" role="button" class="btn btn-primary">
                <i class="material-icons align-middle">add</i>
                <span class="align-middle">New</span>
            </a>
        </div>
    </div>
    
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
                            <button class="btn btn-sm dropdown-toggle mr-1" data-display="static" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons align-middle">save_alt</i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ $codeUrl }}&output=PNG&dotsize=5&dpi=100&download">.PNG</a>
                                <a class="dropdown-item" href="{{ $codeUrl }}&output=SVG&download">.SVG</a>
                                <a class="dropdown-item" href="{{ $codeUrl }}&output=EPS&download">.EPS</a>
                            </div>
                        </div>
                        
                        {{-- Delete --}}
                        <form id="delete-code-form" action="{{ url('code') }}" method="POST">
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
            <div class="card-body bg-light rounded text-secondary border">
                <p class="card-text">
                    Touch <kbd>+ New</kbd> on the top to create 
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

