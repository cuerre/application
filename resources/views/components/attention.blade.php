<div>
    {{-- @if( $show == false ) --}}
        <p>
            <button 
                class="btn btn-light text-primary" 
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
    {{-- @endif --}}
    <div class="@if( $show == true ) collapse.show @else collapse @endif" id="collapseAttention">
        <div class="card card-body mb-4 text-muted">
            {{ $slot }}
        </div>
    </div>
</div>