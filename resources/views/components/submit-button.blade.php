<div class="d-flex justify-content-start form-group w-100">
    <button 
        type="submit" 
        class="btn btn-primary @if (!is_null($size)) btn-{{ $size }} @endif @if ($block == true) btn-block @endif"
        @if( !is_null($confirmation) )
            onclick="return confirm('{{ $confirmation }}')"
        @endif
        >
        {{ $content }}
    </button>
</div>

