@component('mail::message')

# {{ __('Hello there') }}
{{ __('A customer has requested for **support** in our dashboard.') }}
{{ __('Please, remember to be as kind as possible and solve the problem.') }}
<br>
<br>

## Personal data
@component('mail::panel')
{{ __('Name:') }} {{ $user->name }}

{{ __('Email:') }} <{{$user->email}}>
@endcomponent
<br>

## The problem
@component('mail::panel')
*{{ $content }}*
@endcomponent
<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
