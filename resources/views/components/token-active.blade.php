<div class="d-inline ml-2">
    @if( $active )
        <span 
            class="badge badge-primary rounded-pill" 
            style="background-color: LightSeaGreen !important;">
            {{ __('Active') }}
        </span>
    @else
        <span 
            class="badge badge-secondary rounded-pill"
            style="background-color: LightCoral !important;">
            {{ __('Inactive') }}
        </span>
    @endif
</div>