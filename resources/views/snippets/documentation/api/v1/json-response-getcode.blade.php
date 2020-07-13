@php
echo htmlentities('

{
    "status": "success",
    "message": "provided",
    "data": {
        "id": 9,
        "name": "Covid-19",
        "targets": {
            "any": "http://target.es",
            "ios": "http://another-target.com"
        },
        "stats": {
            "sample": 100,
            "platforms": {
                "Win10": 4
            },
            "browsers": {
                "Chrome": 4
            },
            "deviceTypes": {
                "Desktop": 4
            },
            "browserTypes": {
                "Browser": 4
            },
            "lastWeek": {
                "Monday": 4
            },
            "lastMonth": {
                "13": 4
            },
            "lastYear": {
                "July": 4
            }
        }
    }
}

');
@endphp