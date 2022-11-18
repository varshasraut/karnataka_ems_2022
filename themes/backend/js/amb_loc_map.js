var markPin = base_url + "themes/backend/images/yellow_amb_pin.png";

var ambLocMap;


setTimeout(function () {

    mbLocMap = document.getElementById('INC_MAP');

    var ltlng = {lat: 18.51545, lng: 73.8696923};

    initMap(ltlng, ambLocMap);


}, 1000);


function locateAmb(lt, lg, title) {

    var markerLatLng = {lat: parseFloat(lt), lng: parseFloat(lg)};

    var marker = new google.maps.Marker({
        position: markerLatLng,
        map: map,
        icon: markPin,
        title: title,
    });


}
