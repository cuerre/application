<div class="d-flex justify-content-between mb-5 py-3">
    <div class="d-flex flex-column">
        @if( !is_null($hint) )
            <div>
                <span class="text-uppercase text-muted mb-auto">
                    {{ $hint }}
                </span>
            </div>
        @endif
        <div class="p-0">
            <h3 class="mb-auto text-dark font-weight-normal">
                {{ $title }}
            </h3>
        </div>
    </div>
    
    {{ $slot }}
</div>
