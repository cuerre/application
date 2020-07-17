@extends('layouts.documentation')


@section('module')
    <x-card-header
        title="GET code/image"
        hint="documentation / api · v1">
    </x-card-header>

    <div class="mb-5">
        <h4>Introduction</h4>
        <p>
            You can get the image of a code in several file formats always you want using this route.
        </p>
        <p>
            As a good practise, try to use this route as little as you can and store the image
            to use it always you want.
        </p>
    </div>

    <div class="mb-5">
        <h4>Methods</h4>
        <p>
            <span class="badge badge-primary">GET</span>
        </p>
        <p>
            Requests have to be sent to <code>{{ secure_url('/') }}/api/v1/code/image</code>
        </p>
    </div>

    <div class="mb-5">
        <h4>Parameters</h4>
        <p>
            You don't need to send a body with any parameter to this route but we accept it to make it easier
            for you if you make that mistake as developer (but that is horrible, don't do it)
        </p>

        {{-- id --}}
        <p>
            <span class="font-weight-bolder">
                id 
                <code>(mandatory)</code>
            </span>
            <p>
                The number that identify a code you own
            </p>
        </p>

        {{-- format --}}
        <p>
            <span class="font-weight-bolder">
                format 
                <code>(mandatory)</code>
            </span>
            <p>
                Output format you would like to get the image: 
                <code>png</code> 
                <code>eps</code> 
                <code>svg</code>
            </p>
        </p>
    </div>

    <div class="mb-5">
        <h4>How to use it</h4>
        <p>
            Almost every programming language has the skill to communicate with servers. 
            cURL is a client, a library that is ready out-of-the-box to make a request and get the response.
            The easiest way to test or use our service is using cURL and that is the reason we use it in our first example.
        </p>

        {{-- bash request --}}
        <div class="mb-5">
            <p>
                With the following code, you will get all information of a QR code 
                and will enjoy the most simple automation
            </p>
            <x-snippet 
                language="bash"
                snippet="documentation.api.v1.curl-getcodeimage">
            </x-snippet>
        </div>

        {{-- PHP curl --}}
        <div class="mb-5">
            <p>
                Using PHP? let's get the QR as content
            </p>
            <x-snippet 
                language="bash"
                snippet="documentation.api.v1.php-getcodeimage">
            </x-snippet>
        </div>
    </div>

    <div class="mb-5">
        <h4>One more thing</h4>
        <p>
            It is easy to deal with several parameters at the same time because all 
            you have to do is to join them step by step. For example, copy the next URL 
            and open it with your favourite browser.
        </p>
        <x-snippet 
            language="none">
            {{ secure_url('/') }}/api/v1/code/image?apikey={API KEY}&id=9&format=png
        </x-snippet>
    </div>

    <div class="mb-5">
        <h4>Response</h4>
        <p>
            The response for this route include the URL you should use
            to access the image and the format of the generated file
        </p>
        <x-snippet 
            language="json"
            snippet="documentation.api.v1.json-response-getcodeimage">
        </x-snippet>
    </div>

    <div class="mb-5">
        <h4>Errors</h4>
        <p>
            All developers need to test the tools to learn how to use them. It is a daily task 
            to fail. For those cases we answer with HTTP error codes like 4xx, 5xx... and 
            have an easy-to-understand response like the following.
        </p>
        <x-snippet 
            language="json"
            snippet="documentation.encode.json-response">
        </x-snippet>
    </div>


@endsection
