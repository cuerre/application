@if ($errors->any())
    <x-alert type="danger">
        <ul class="list-unstyled my-auto">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-alert>
@endif
