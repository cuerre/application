@php
echo htmlentities('


$url = "'.secure_url("/").'/api/v1/code";
$data = array(
    "apikey"  => "{API KEY}", 
    "name"    => "{YOUR CODE NAME}", 
    "targets" => [
        "any" => "http://target.com",
        "ios" => "http://another-target.com"
    ]
);

// use key "http" even if you send the request to https://...
$options = array(
    "http" => array(
        "method"  => "POST",
        "header"  => "Content-Type: application/x-www-form-urlencoded",
        "content" => http_build_query($data),
    ),
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

var_dump($result);


')
@endphp