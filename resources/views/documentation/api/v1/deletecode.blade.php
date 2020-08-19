@extends('layouts.documentation')


@section('module')
    <x-card-header
        hint="documentation / api · v1"
        title="DELETE code">
    </x-card-header>

    <div class="mb-5">
        <h4>Introduction</h4>
        <p>
            This route is used to delete a QR code. This remove the code, the stats and everything
            related to that code.
        </p>
    </div>

    <div class="mb-5">
        <h4>Methods</h4>
        <p>
            <span class="badge badge-primary">DELETE</span>
        </p>
        <p>
            Requests have to be sent to <code>{{ secure_url('/') }}/api/v1/code</code>
        </p>
    </div>

    <div class="mb-5">
        <h4>Parameters</h4>
        <p>
            In order to make this easy for everyone, we accept a JSON structure as input or
            ordinary post parameters encoded as application/x-www-form-urlencoded
        </p>

        {{-- id --}}
        <p>
            <span class="font-weight-bolder">
                id 
                <code>(mandatory)</code>
            </span>
            <p>
                The id of the code you want to modify. This <code>id</code> is given by <code>GET /code</code>
                or during creation of the code with <code>POST /code</code>
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
                With the following code, you will remove a QR code.
            </p>
            <x-snippet 
                language="bash"
                snippet="documentation.api.v1.curl-deletecode">
            </x-snippet>
        </div>

        {{-- PHP curl --}}
        <div class="mb-5">
            <p>
                Using PHP? let's get the QR as content
            </p>
            <x-snippet 
                language="php"
                snippet="documentation.api.v1.php-deletecode">
            </x-snippet>
        </div>
    </div>

    <div class="mb-5">
        <h4>Response</h4>
        <p>
            The response for this route does NOT include more information
        </p>
        <x-snippet 
            language="json"
            snippet="documentation.api.v1.json-response-deletecode">
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
            snippet="documentation.api.v1.json-error-response">
        </x-snippet>
    </div>


@endsection
