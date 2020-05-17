@extends('layouts.dashboard')



@section('module')

    {{-- Top title --}}
    <x-card-header
        :title="__('Codes')"
        :hint="__('dashboard')">
        <div class="my-auto">
            <x-link-button 
                icon="add"
                :content="__('New')"
                :link="url('dashboard/codes/creation')">
            </x-link-button >
        </div>
    </x-card-header>

    {{-- Errors --}}
    <x-alert-errors /> 

    {{-- Messages bag --}}
    <x-alert-messages />

    {{-- Disclaimer --}}
    <x-attention>
        <p>
            {{ __('You can create QR codes for testing purposes.') }}
        </p>
        <p>
            <code>{{ __('As a premium service') }},</code> 
            {{ __('codes can be used to see the statistics, be downloaded, etc.') }} 
            {{ __('The scanned codes will not go to the desired targets') }} 
            {{ __('unless they are active.') }}
        </p>
        <p>
            {{ __('Each night, codes must be paid and it is possible you have not enough') }} 
            {{ __('credits to pay them all in your account.') }} 
            {{ __('In that case, the system will try to pay older ones') }} 
            {{ __('and set as inactive newer ones.') }} 

            <p class="mt-3">
                <x-link-button
                    :content="__('Check the prices')"
                    :link="url('pricing')"
                    size="sm" 
                    color="light">
                </x-link-button>
            </p>
        </p>
    </x-attention>
    
    {{-- Code list --}}
    @forelse ($codes->items() as $code)
        <x-box>
        
            <div class="row justify-content-center">
                <div class="col-md-auto p-3">
                    <x-code-image :id="$code['id']" />
                </div>
                <div class="col p-0">
                    <div class="d-flex flex-column h-100 w-100">
                        {{-- Top bar container --}}
                        <div class="p-2 text-break mb-auto">
                            <small class="text-uppercase text-muted">
                                {{ __('Code name') }}
                            </small>

                            {{-- Active badge --}}
                            <x-code-active :active="$code['active']" />
                            
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
                            <a href="{{ url('dashboard/codes/stats?code=' . $code['id']) }}" role="button" class="btn btn-sm text-dark text-decoration-none mr-1">
                                <i class="material-icons align-middle">bar_chart</i>
                            </a>

                            {{-- Download dropdown --}}
                            <x-code-download :id="$code['id']" />

                            {{-- Settings dropdown --}}
                            <x-code-options :id="$code['id']" />
                        </div>

                    </div>
                </div>
            </div>

        </x-box>
        
    @empty

        

        {{-- Void placeholder --}}
        <x-card-empty-message>
            {{ __('Touch') }} 
            <kbd class="mx-2">
                + {{ __('New') }}
            </kbd> 
            {{ __('on the top to create a new super vitamin code') }}
        </x-card-empty-message>
    @endforelse
    
    {{-- Paginator --}}
    @if ( $codes->lastPage() > 1)
        <div class="d-flex justify-content-end mt-3">
            {{ $codes->links() }}
        </div>
    @endif
    
@endsection

