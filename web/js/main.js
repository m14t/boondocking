function initialize(position) {
    var mapOptions = {
        center: new google.maps.LatLng(
            position.coords.latitude,
            position.coords.longitude
        ),
        zoom: 8
    };
    var map = new google.maps.Map(
        document.getElementById("map-canvas"),
        mapOptions
    );
    requestDataPoints(map);
}

function requestLocation() {
    navigator.geolocation.getCurrentPosition(initialize);
}

function requestDataPoints(map) {
    $.ajax(
        '/api/locations',
        {
            dataType: 'json'
        }
    ).done(function(data) {
        data = JSON.parse(data);

        $.each(data, function(i, location) {
            var latLng = new google.maps.LatLng(
                location.Latitude,
                location.Longitude
            );

            // To add the marker to the map, use the 'map' property
            var marker = new google.maps.Marker({
                position: latLng,
                map: map,
                title: location.Description
            });
        });
    })
}

google.maps.event.addDomListener(window, 'load', requestLocation);
