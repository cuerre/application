@php
echo htmlentities('

curl -d \'{"name":"YOUR NAME", "targets": { "any" : "http://target.com"} }\' 
     -H "Content-Type: application/json" 
     -X POST '.secure_url("/").'/api/v1/code?apikey={API KEY}

');
@endphp