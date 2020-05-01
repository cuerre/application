@verbatim

$url = 'https://{version}.api.cuerre.io/encode';
$data = array('data' => '{your data}', 'download' => 'true');

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
    'method'  => 'GET',
    'content' => http_build_query($data),
    ),
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

var_dump($result);

@endverbatim