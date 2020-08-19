@if( Session::has('message') )
    <x-alert 
        type="info">
        {{ Session::get('message') }}
    </x-alert>
@endif