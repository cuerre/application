@php
echo htmlentities('

curl -d \'{ "id":9, "name":"YOUR NAME", "targets": { "any":"http://target.com" }, "active":true }\' 
     -H "Content-Type: application/json" 
     -X PUT '.secure_url("/").'/api/v1/code?apikey={API KEY}

');
@endphp