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
            and we only accept that method by the moment.
        </p>
        <p>
            All requests have to be sent to <code>{version}.api.cuerre.io/decode</code>
        </p>
    </div>

    <div class="mb-5">
        <h4>Headers</h4>
        <p>
            Looking for ease, we work with only few headers like <code>Authorization</code>, 
            <code>Content-Type</code> or <code>Accept</code> and need no more of them. Let us to explain.
        </p>
        <p>
            If you are Premium user, it is possible you need a lot of requests and the first header is there 
            for you to pass us your <code>API KEY</code> as a bearer token:
        </p>
        <x-code 
            class="mb-5"
            language="HTTP">
            Authorization: Bearer {API KEY}
        </x-code>
        <p>
            If the <code>Authorization</code> header is not present on the request, we consider you a free 
            user and limit your requests quota per hour. Remember we would like you to be premium and the free 
            quota is big enough for many applications. Moreover, free users are limited on the size of QR image 
            they can upload. This limitation may vary on the future but is set to 1MiB by the moment.
        </p>
        <p>
            <code>Content-Type</code> is mandatory and must be set as follows
        </p>
        <x-code 
            class="mb-5"
            language="HTTP">
            Content-Type: multipart/form-data
        </x-code>
        <p>
            In the same way, <code>Accept</code> is mandatory and must be set as follows because our API only 
            answer with JSON responses by the moment.
        </p>
        <x-code 
            class="mb-5"
            language="HTTP">
            Accept: application/json
        </x-code>
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
    </div>

    <div class="mb-5">
        <h4>Attention</h4>
        <p>
            According to the headers needs (Content-Type and Accept), this action can only be achieved by 
            using AJAX or CURL. Remember this when you are trying to use the service and feel for hitting your 
            own head with the Thor hammer. The easy way is using pure JS XHR Object or jQuery AJAX.
        </p>
        <x-code 
            class="mb-5"
            language="javascript"
            snippet="documentation.decode.ajax-request">
        </x-code>
    </div>

    <div class="mb-5">
        <h4>One more thing</h4>
        <p>
            As you can see, it is easy to use this API and we are working to make it even easier in the future.
            We encourage you to keep in touch with this documentation for future releases.
        </p>
    </div>

    


@endsection
