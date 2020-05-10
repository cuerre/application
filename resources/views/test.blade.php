@extends('layouts.app')



@push('styles.tablet')

@endpush



@section('content')
    <p>
        <a href="{{ route('payment') }}" class="btn btn-success">Pay polvo from Paypal</a>
    </p>
@endsection
