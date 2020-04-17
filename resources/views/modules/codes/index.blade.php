@extends('layouts.dashboard')



@section('module')

    {{-- Top title --}}
    <div class="d-flex justify-content-between mb-5 pb-3 border-bottom border-secondary">
        <h1 class="my-auto">Codes</h1>
        <button type="button" class="btn btn-primary my-auto">
            <i class="material-icons align-middle">add</i>
            <span class="align-middle">New code</span>
        </button>
    </div>
    
    {{-- Code list --}}
    @forelse ($codes->items() as $code)
        @php
            $codeUrl = App\Http\Controllers\CodesController::GetImageUrl($code['id']);
        @endphp
    
        <div class="media bg-secondary p-3 rounded mb-4">
            <img src="{{ $codeUrl }}" class="mr-3 rounded-lg" style="width: 6rem !important;">
            
            <div class="media-body align-self-stretch">
            
                <div class="d-flex align-items-start flex-column h-100" >
                
                    {{-- Top bar container --}}
                    <div class="mb-auto w-100">
                        <h5 class="mt-0">{{ $code['name'] }}</h5>
                    </div>
                    
                    {{-- Bottom bar container --}}
                    <div class="d-flex flex-row w-100">
                    
                        {{-- Stats --}}
                        <a href="#" role="button" class="btn btn-secondary mr-1">
                            <i class="material-icons align-middle">bar_chart</i>
                        </a>

                        {{-- Download dropdown --}}
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle mr-1" id="dropdownMenu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons align-middle">save_alt</i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu">
                                <a class="dropdown-item" href="{{ $codeUrl }}&output=PNG&download">.PNG</a>
                                <a class="dropdown-item" href="{{ $codeUrl }}&output=SVG&download">.SVG</a>
                                <a class="dropdown-item" href="{{ $codeUrl }}&output=EPS&download">.EPS</a>
                            </div>
                        </div>
                        
                        {{-- Delete --}}
                        <a href="#" role="button" class="btn btn-secondary mr-1">
                            <i class="material-icons align-middle">delete</i>
                        </a>
                        
                    </div>
                </div>
            </div>
        </div>
        
    @empty
        <p>No users</p>
    @endforelse
    
    {{-- Paginator --}}
    <div class="d-flex justify-content-end">
        {{ $codes->links() }}
    </div>

@endsection

