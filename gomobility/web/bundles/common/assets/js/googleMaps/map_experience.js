'use strict';

var experiencesMap = (function(){

  var directionsDisplay,
    directionsService = new google.maps.DirectionsService(),
    map,
    $start = $('.start').text(),
    $arrival = $('.arrival').text();

  function initialize() {
    directionsDisplay = new google.maps.DirectionsRenderer();
    var chicago = new google.maps.LatLng(48.85433450000001, 2.3713917000000038);
    var mapOptions = {
      zoom:7,
      center: chicago
    };
    map = new google.maps.Map(document.getElementById('experience_maps'), mapOptions);
    directionsDisplay.setMap(map);
    
    calcRoute();
  }

  function calcRoute() {
    var start = $start;
    var end =  $arrival;
    var request = {
        origin:start,
        destination:end,
        travelMode: google.maps.TravelMode.DRIVING
    };
    directionsService.route(request, function(response, status) {
      if (status == google.maps.DirectionsStatus.OK) {
        directionsDisplay.setDirections(response);
      }
    });
  }

  google.maps.event.addDomListener(window, 'load', initialize);

 return initialize;
 
})();

