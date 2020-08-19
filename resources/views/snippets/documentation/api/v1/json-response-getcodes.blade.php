@php
echo htmlentities('

{
    "status": "success",
    "message": "provided",
    "data": {
        "total": 5,
        "perPage": 25,
        "currentPage": 1,
        "lastPage": 1,
        "currency": "eur",
        "itemPrice": 0.1,
        "totalCost": 0.5,
        "codes": [
            {
                "id": 4,
                "name": "Campaign 1",
                "active": 0,
                "created": "2020-07-12 01:49:49"
            },
            {
                "id": 5,
                "name": "Campaign 2",
                "active": 0,
                "created": "2020-07-12 04:21:29"
            },
            {
                "id": 6,
                "name": "Campaign 3",
                "active": 0,
                "created": "2020-07-12 04:22:13"
            },
            {
                "id": 7,
                "name": "Campaign 4",
                "active": 0,
                "created": "2020-07-12 04:22:28"
            },
            {
                "id": 8,
                "name": "Campaign 5",
                "active": 0,
                "created": "2020-07-12 04:22:30"
            },
        ]
    }
}

');
@endphp