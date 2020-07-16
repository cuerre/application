@php
echo htmlentities('


$url = "'.secure_url("/").'/api/v1/codes";
$data = array(
    "apikey"  => "{API KEY}", 
    "page"    => {PAGE NUMBER}
);

// use key "http" even if you send the request to https://...
$options = array(
    "http" => array(
        "method"  => "GET",
        "content" => http_build_query($data),
    ),
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

var_dump($result);


')
@endphp