@extends('layouts.centered')

@section('module')
<div class="container d-flex align-items-center p-0">
    <div class="row justify-content-center w-100 m-0">
        <div class="col-lg-6 p-0">
        
            <x-striped-card>
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }},
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    
                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                        {{ __('click here to request another') }}
                    </button>.
                </form>
            </x-striped-card>
            
        </div>
    </div>
</div>
@endsection
