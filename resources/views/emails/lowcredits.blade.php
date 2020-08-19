@component('mail::message')

# {{ __('Hello') }}, {{ $user->name }}
{{ __('You have some premium service with us and we have detected low amount of credits.') }}
{{ __('Please, remember that if you have not credits when billing, some premium services will be automatically cancelled.') }}
<br>
<br>

@component('mail::button', ['url' => url('dashboard/billing') ])
Buy credits
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
