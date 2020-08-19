@php
    $defaultClass = 'btn btn-primary text-white mb-4';
@endphp
{{-- Collapsable menu toggler --}}
<button class="@if( !empty($class) ) {{ $class }} @else {{ $defaultClass }} @endif" 
        type="button" 
        data-toggle="collapse" 
        data-target="#{{ $prefix }}-toggleContent" 
        aria-controls="{{ $prefix }}-toggleContent" 
        aria-expanded="false" 
        aria-label="Toggle zone">
    <span class="material-icons align-middle">menu</span>
</button>

{{-- Collapsable menu --}}
<div class="collapse" id="{{ $prefix }}-toggleContent">
    {{ $slot }}
</div>