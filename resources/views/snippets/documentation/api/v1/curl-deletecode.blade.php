@php
echo htmlentities('

curl -d \'{ "id":9 }\' 
     -H "Content-Type: application/json" 
     -X DELETE '.secure_url("/").'/api/v1/code?apikey={API KEY}

');
@endphp