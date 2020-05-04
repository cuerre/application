@extends('layouts.documentation')


@section('module')
    <x-card-header
        title="Decode"
        hint="documentation / api · v1">
    </x-card-header>

    <div class="mb-5">
        <h4>Methods</h4>
        <p>
            Decoding a QR code requires to send data to our service. For that task,
            the most convenient method is <code>POST</code> 
            and we only accept that method for this, by the moment.
        </p>
        <p>
            All requests have to be sent to <code>{{ secure_url('/') }}/api/v1/decode</code>
        </p>
    </div>

    <div class="mb-5">
        <h4>Parameters</h4>
        <p>
            The only one parameter we need is <code>photo</code>. This parameter is an input field of type 
            'file' called simply 'photo'. The upload can be achieved with a simple HTML form as follows:
        </p>
        <x-code 
            class="mb-5"
            language="html"
            snippet="documentation.decode.html-form">
        </x-code>
        <p>
            The problem with this is that <code>Authorization</code> header is not included so the example wont work.
            To solve this problem we need make the request with other tools like <code>Ajax</code> or <code>cURL</code>.
            In the following example, the request is made with Ajax to give a useful example for daily purposes.
        </p>
        <x-code 
            class="mb-5"
            language="javascript"
            snippet="documentation.decode.ajax-request">
        </x-code>
    </div>
    


@endsection
