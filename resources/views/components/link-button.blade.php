<div>
    <a href="{{ $link }}" role="button" class="btn btn-{{ $color }} @if (!is_null($size)) btn-{{ $size }} @endif @if ($block == true) btn-block @endif">
        @if( !is_null($icon) )
            <i class="material-icons align-middle">{{ $icon }}</i>
        @endif
        <span class="align-middle">
            {{ $content }}
        </span>
    </a>
</div>
