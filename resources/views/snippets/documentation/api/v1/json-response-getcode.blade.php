@php
echo htmlentities('

{
    "status": "success",
    "message": "provided",
    "data": {
        "id": 9,
        "name": "Coronavirus 2020",
        "targets": {
            "any": "http://target.es",
            "ios": "http://another-target.com"
        },
        "stats": {
            "sample": 100,
            "platforms": [],
            "browsers": [],
            "deviceTypes": [],
            "browserTypes": [],
            "lastWeek": [],
            "lastMonth": [],
            "lastYear": []
        }
    }
}

');
@endphp