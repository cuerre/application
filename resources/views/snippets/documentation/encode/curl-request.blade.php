@php
echo htmlentities('


curl '.secure_url("/").'/api/v1/encode?apikey={API KEY}&data={your data} -o {your file}
    -H "Accept: application/json"


');
@endphp