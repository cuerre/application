@php
    switch ( $type ){
        case 'danger':
            $color = 'LightCoral';
            break;

        case 'success':
            $color = 'LightSeaGreen';
            break;

        case 'warning':
            $color = 'LemonChiffon';
            break;

        case 'info':
            $color = 'CornflowerBlue';
            break;

        default:
            $color = 'AliceBlue';
    }
@endphp

<div 
    class="alert alert-{{ $type }} bg-light border-top-0 border-right-0 border-bottom-0 text-muted my-4" 
    role="alert" 
    style="border-left: .25rem solid {{ $color }} !important;">

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

