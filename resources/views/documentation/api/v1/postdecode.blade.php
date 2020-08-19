@extends('layouts.documentation')


@section('module')
    <x-card-header
        title="POST decode"
        hint="documentation / api · v1">
    </x-card-header>

    <div class="mb-5">
        <h4>Introduction</h4>
        <p>
            This route is used to read a QR code from a picture you send us. We will return back 
            the content without any effort.
        </p>
    </div>

    <div class="mb-5">
        <h4>Methods</h4>
        <p>
            <span class="badge badge-primary">POST</span>
        </p>
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
        <x-snippet 
            class="mb-5"
            language="html"
            snippet="documentation.decode.html-form">
        </x-snippet>
        <p>
            In the following example, the request is made with Ajax to give a useful example for daily purposes.
        </p>
        <x-snippet 
            class="mb-5"
            language="javascript"
            snippet="documentation.decode.ajax-request">
        </x-snippet>
    </div>
    


@endsection
