<div class="d-flex justify-content-start form-group w-100">
    <button 
        type="submit" 
        class="btn btn-primary @if (!is_null($size)) btn-{{ $size }} @endif @if ($block == true) btn-block @endif">
        {{ $content }}
    </button>
</div>

