@php
echo htmlentities('

{
    "status"  : "success",
    "message" : "A wonderful hint",
    "data"    : {
        "code" : "{YOUR CODE ID}",
        "name" : "{YOUR CODE NAME}",
        "targets" : {
            "any" : "http://target.com",
            "ios" : "http://another-target.com"
        },
        "active" : true|false
    }
}

');
@endphp