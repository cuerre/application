<x-box>
    <x-box-header>
        {{ __('Remaining credits') }}
    </x-box-header>

    <p class="text-break text-muted mb-4">
        {{ __('Credits are the coins you need to use our premium services.') }} 
        {{ __('You can buy the amount you need and they will be added to your account.') }} 
        {{ __('Each day, some of them will be substracted in order to pay.') }} 
    </p>

    <p class="h2 mb-3 text-break text-muted">
        {{ Auth::user()->credits }} €
    </p>
</x-box>