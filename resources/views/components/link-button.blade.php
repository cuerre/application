<div>
    <a href="{{ $link }}" role="button" class="btn btn-primary">
        @if( !is_null($icon) )
            <i class="material-icons align-middle">{{ $icon }}</i>
        @endif
        <span class="align-middle">
            {{ $content }}
        </span>
    </a>
</div>
