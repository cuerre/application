<x-box>
    <x-box-header>
        {{ __('Remaining credits') }}
    </x-box-header>

    <p class="text-break text-muted mb-4">
        {{ __('Credits are what you need to use our premium services.') }} 
        {{ __('You can buy the amount you want and they will be added to your account.') }} 
        {{ __('If you are using some paid service, each day, some of them will be used to pay.') }} 
    </p>

    <p class="h2 mb-3 text-break text-muted">
        {{ Auth::user()->credits }} €
    </p>
</x-box>