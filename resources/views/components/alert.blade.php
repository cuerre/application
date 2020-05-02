<div class="alert alert-{{ $type }} border-0 shadow-sm" role="alert">
    <div class="d-flex flex-row w-100">
        <div class="flex-column flex-shrink-1">
            <i class="material-icons align-middle">
                error_outline
            </i>
        </div>
        <div class="flex-column flex-grow-1 px-2 py-0 text-break">
            {{ $slot }}
        </div>
    </div>
</div>

