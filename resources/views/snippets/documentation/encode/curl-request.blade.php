@php
echo htmlentities('


curl '.secure_url("/").'/api/v1/encode?data={your data} -o {your file}
    -H "Accept: application/json"
    -H "Authorization: Bearer {API KEY}"


');
@endphp