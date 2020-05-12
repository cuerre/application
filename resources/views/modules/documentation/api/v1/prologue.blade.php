@extends('layouts.documentation')


@section('module')
    <x-card-header
        title="Prologue"
        hint="documentation / api · v1">
    </x-card-header>

    <div class="mb-5">
        <h4>Methods</h4>
        <p>
            Due to the need to send information or files, 
            the available methods are <code>GET</code> and <code>POST</code>
        </p>
    </div>

    <div class="mb-5">
        <h4>Headers</h4>
        <p>
            Looking for ease, we work with only few headers like <code>Authorization</code>, 
            <code>Content-Type</code> or <code>Accept</code> and need no more of them. Let us to explain.
        </p>
        <p>
            This is an API for registered users and you need an <code>API KEY</code> 
            that must be sent on each request done. The way to send this key is setting 
            it on Authorization header as follows:
        </p>
        <x-snippet 
            class="mb-5"
            language="HTTP">
            Authorization: Bearer {API KEY}
        </x-snippet>
        <p>
            Another header you should know is <code>Content-Type</code>. This header is usually used 
            to say the server the information type you are going to send. We check all parameters you set 
            but not specially the Content-Type in all cases. This header must be set to 
            <code>application/x-www-form-urlencoded</code> for <code>POST</code> requests and to 
            <code>multipart/form-data</code> when you are trying to <code>POST</code> a picture to process.
        </p>
        <x-snippet 
            class="mb-5"
            language="HTTP">
            Content-Type: multipart/form-data
        </x-snippet>
        <p>
            In the same way we have <code>Accept</code> header. 
            This is used to tell the server what kind of information the client can process.
            You should be ready to recieve as Content-Type the following headers: 
            <code>application/json</code> on text responses,  
            <code>image/png</code> for PNG, 
            <code>image/svg+xml</code> for SVG and 
            <code>application/postscript</code> for EPS.
        </p>
        <x-snippet 
            class="mb-5"
            language="HTTP">
            Accept: application/json, image/png, image/svg+xml, application/postscript
        </x-snippet>
    </div>

    <div class="mb-5">
        <h4>One more thing</h4>
        <p>
            As you can see, it is easy to use this API and we are working to make it even easier in the future.
            We encourage you to keep in touch with this documentation for future releases.
        </p>
    </div>

    


@endsection
