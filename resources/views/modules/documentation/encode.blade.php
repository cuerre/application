@extends('layouts.documentation')


@section('module')
    <x-card-header
        title="Encode QR"
        hint="documentation / api">
    </x-card-header>

    <div class="mb-5">
        <h4>Methods</h4>
        <p>
            For convenience, to get a QR code, our service admits just <code>GET</code> method 
            that can be used with cURL, Python, PHP and many other languages.
            In the following sections you can see how to make a request.
        </p>
        <p>
            By the moment, you should know that all requests have to be sent to <code>api.cuerre.com/encode</code>
        </p>
    </div>

    <div class="mb-5">
        <h4>Parameters</h4>
        <p>
            There are several parameters you can use to modify the result of a request and get 
            more accurate results. All parameters different to <code>data</code> can be omited.
            Doing this will cause the output to follow out fair use recommendations so
            we encourage to let them blank unless you need another configuration. 
        </p>

        {{-- Data --}}
        <p>
            <span class="font-weight-bolder">
                data 
                <code>(mandatory)</code>
            </span>
            <p>
                A string to encode. This can be a URL, a simple text, a VCARD, etc. The requirement is that must 
                be a valid string to pass into URL params.
            </p>
        </p>
        
        {{-- Dotsize--}}
        <p>
            <span class="font-weight-bolder">
                dotsize 
                {{--<code>(mandatory)</code>--}}
            </span>
            <p>
                The size of each QR dot. The value is just a number between 1 and 5. 
                The maximum value may change in the future.
            </p>
        </p>

        {{-- ECC --}}
        <p>
            <span class="font-weight-bolder">
                ecc
                {{--<code>(mandatory)</code>--}}
            </span>
            <p>
                Defines the error correction code (ECC) which determines the degree of data
                redundancy. The more data redundancy exists, the more data can be restored if
                a QR code is damaged. Use upper case for this parameter
            </p>
            <p>
                Possible values:
                <ul>
                    <li><b class="mr-3">L</b> (low, ~7% destroyed data may be corrected)</li>
                    <li><b class="mr-3">M</b> (middle, ~15% destroyed data may be corrected)</li>
                    <li><b class="mr-3">Q</b> (quality, ~25% destroyed data may be corrected)</li>
                    <li><b class="mr-3">H</b> (high, ~30% destroyed data may be corrected)</li>
                </ul>
            </p>
            <p class="small">
                <code>Default:</code>
                (will be used if no or invalid value is set): L
            </p>
            <p class="small">
                <code>Best practise:</code>
                L. A higher ECC results in more data to save and thus leads to a QR code with
                more data pixels and a larger data matrix. Because many cell phone readers
                have problems with QR codes > Version 4 (matrix of 33×33 modules), the lowest
                ECC is the best choice for common purpose – legacy QR code readers are a more
                common problem than destroyed QR codes.
            </p>
        </p>

        {{-- marginsize --}}
        <p>
            <span class="font-weight-bolder">
                marginsize 
            </span>
            <p>
                Thickness of the margin. Just a number between 1 and 5. This parameter will
                be ignored if svg or eps is used as QR code format (=if the QR code output
                is a vector graphic).
            </p>
        </p>

        {{-- dpi --}}
        <p>
            <span class="font-weight-bolder">
                dpi 
            </span>
            <p>
                A number between 50 and 100 indicating how many dots are displayed into the
                same space.  
                <p class="small">
                    <code>Default</code> (will be used if no or invalid value is set): 72
                </p>
                <p class="small">
                    <code>Best practise:</code> Let it blank because higher values means better codes but slower.
                </p>
            </p>
        </p>

        {{-- output --}}
        <p>
            <span class="font-weight-bolder">
                output 
            </span>
            <p>
                Format of the resulting image. You can select between <code>PNG</code>, <code>SVG</code> and <code>EPS</code>. By default,
                this setting is set to PNG. Use vector choice just when needed for graphical design
                environments.
                <p class="small">
                    <code>Default</code> (will be used if no or invalid value is set): PNG
                </p>
                <p class="small">
                    <code>Mandatory:</code> Use upper case for this parameter.
                </p>
            </p>
        </p>

        {{-- download --}}
        <p>
            <span class="font-weight-bolder">
                download 
            </span>
            <p>
                Force the generated file to be downloaded.
                <p class="small">
                    <code>Best practise:</code> Download one time and cache the image to use it as local.
                </p>
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
                With the following code, you will generate a new QR code and will store it into a file.
            </p>
            <x-code 
                language="bash"
                snippet="documentation.encode.curl-request">
            </x-code>
        </div>

        {{-- HTML request --}}
        <div class="mb-5">
            <p>
                Let's include a code into a website using pure HTML code.
            </p>
            <x-code language="html">
                <img src="https://api.cuerre.com/encode?data={your data}" />
            </x-code>
        </div>

        {{-- HTML request --}}
        <div class="mb-5">
            <p>
                Do you need a bigger QR embeded in your website?
            </p>
            <x-code language="html">
                <img src="https://api.cuerre.com/encode?data={your data}&dotsize=5" />
            </x-code>
        </div>

        {{-- HTML request --}}
        <div class="mb-5">
            <p>
                Your users need to download the generated QR code, lets put a link
            </p>
            <x-code language="html">
                <a href="https://api.cuerre.com/encode?data={your data}&download">Link</a>
            </x-code>
        </div>

        {{-- PHP curl --}}
        <div class="mb-5">
            <p>
                Using PHP? let's get the QR as content
            </p>
            <x-code 
                language="php"
                snippet="documentation.encode.php-request">
            </x-code>
        </div>




    </div>

    <div class="mb-5">
        <h4>One more thing</h4>
        <p>
            It is easy to deal with several parameters at the same time because all 
            you have to do is to join them step by step. For example, copy the next URL 
            and open it with your favourite browser.
        </p>
        <x-code 
            language="none">
            https://api.cuerre.com/encode?data=Hola&dotsize=5&output=PNG&marginsize=5&ecc=L
        </x-code>

    </div>


@endsection
