@component('mail::message')

# {{ __('Hello there') }}
{{ __('A customer has requested for **sales** in our web.') }}
{{ __('Please, remember to be as kind as possible and solve the problem.') }}
<br>
<br>

## Personal data
@component('mail::panel')
{{ __('Name:') }} {{ $name }}

{{ __('Email:') }} <{{$email}}>
@endcomponent
<br>

## The problem
@component('mail::panel')
*{{ $message }}*
@endcomponent
<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
