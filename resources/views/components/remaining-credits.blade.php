<x-box>
    <x-box-header>
        {{ __('Remaining credits') }}
    </x-box-header>

    <p class="h2 mb-3 text-break text-muted">
        {{ Auth::user()->credits }} €
    </p>
</x-box>