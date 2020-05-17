@php
    try {
        $used       = false;
        $grace      = config('cuerre.products.tokens.grace');
        $lastFree   = \Carbon\Carbon::now()->subHours($grace);
        $lastUsed   = \Carbon\Carbon::parse($last);

        if( $lastUsed->isAfter($lastFree) && !is_null($last) ){
            $used = true;
        }
    } catch ( Exception $e ){
        $used = false;
    }
@endphp


<div class="d-inline ml-2">
    @if( $used )
        <span 
            class="badge badge-primary rounded-pill" 
            style="background-color: LightSeaGreen !important;">
            {{ __('Used') . ': '. $lastUsed->calendar() }}
        </span>
    @else
        <span 
            class="badge badge-secondary rounded-pill"
            style="background-color: LightCoral !important;">
            {{ __('Inactive') }}
        </span>
    @endif
</div>