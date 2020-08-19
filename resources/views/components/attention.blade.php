<div>
    @unless( $show == true )
        <p>
            <button 
                class="btn btn-light text-primary bg-white" 
                type="button" 
                data-toggle="collapse" 
                data-target="#collapseAttention" 
                aria-expanded="false" 
                aria-controls="collapseAttention"
                style="border: 2px solid WhiteSmoke !important;">
                <i class="material-icons align-middle">announcement</i>
                {{ __('Attention') }}
            </button>
        </p>
    @endunless
    <div class="@if( $show == true ) collapse.show @else collapse @endif" id="collapseAttention">
        <div class="card card-body mb-4 text-muted"
             style="border: 2px solid WhiteSmoke !important;">

            @if( $show == true )
                <p class="text-primary">
                    <i class="material-icons align-middle">announcement</i>
                    {{ __('Attention') }}
                </p>
            @endif
            
            {{ $slot }}
        </div>
    </div>
</div>