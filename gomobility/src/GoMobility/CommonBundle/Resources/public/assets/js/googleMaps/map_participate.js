'use strict';

var formMap = (function(){
  var geocoder;
  var map;
  var directionsDisplay;
  var directionsService;
  var stepDisplay;
  var markerArray = [];

  var start_address = $('.start_address');
  var start_lat = $('.start_lat');
  var start_long = $('.start_long');

  var arrival_address = $('.arrival_address');
  var end_lat = $('.end_lat');
  var end_long = $('.end_long');

  var ges = $('.ges');

  var initialize = function() {
    directionsService = new google.maps.DirectionsService();
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(48.85433450000001, 2.3713917000000038);
    var mapOptions = {
      zoom: 5,
      center: latlng
    }
    map = new google.maps.Map(document.getElementById('form_map'), mapOptions);
     var rendererOptions = {
      map: map
    }

    directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions)
    google.maps.event.addListener(directionsDisplay, 'directions_changed', function() {
      computeTotalDistance(directionsDisplay.getDirections());
    });
    
    var inputD = document.getElementById('gomobility_publicbundle_ecoactors_start');
    var autocompleteDepart = new google.maps.places.Autocomplete(inputD);
    var inputA = document.getElementById('gomobility_publicbundle_ecoactors_arrival');
    var autocompleteArrivee = new google.maps.places.Autocomplete(inputA);
  }

  $('.submit_start').click(function(){
    codeAddress(start_address, start_lat, start_long);
  });

  $('.submit_arrival').click(function(){
    codeAddress(arrival_address, end_lat, end_long);    
    if($('#gomobility_publicbundle_ecoactors_type').val() === ''){
      $('.transport_error').css('display','block');
    }
    
    calcRoute();
    ges.removeAttr('disabled');
  });

  function calculGes(total){
    var select_travelMode =  $('#gomobility_publicbundle_ecoactors_type').val();
    var walking = 1;
    var bicycling = 1;
    var transit = 2;
    var driving = 3;

    if (select_travelMode === 'marche') ges.val(total * walking);
    if (select_travelMode === 'vélo') ges.val(total * bicycling);
    if (select_travelMode === 'transports en commun') ges.val(total * transit);
    if (select_travelMode === 'co-voiturage') ges.val(total * driving);
  }

  function codeAddress(element, lat, long) {
    var address = element.val();
    geocoder.geocode( { 'address': address}, function(results, status) {

      if (status === google.maps.GeocoderStatus.OK) {
        lat.val(results[0].geometry.location.k);
        long.val(results[0].geometry.location.B);

        map.setCenter(results[0].geometry.location);

        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });

        var infowindow = new google.maps.InfoWindow();
        google.maps.event.addListener(marker, 'click', function() {
          infowindow.setContent(results[0].formatted_address);
          infowindow.open(map, this);
        });

      } else {
        alert('Erreur: pas de résultats');
      }
    });
  }

  function calcRoute() {
    for (var i = 0; i < markerArray.length; i++) {
      markerArray[i].setMap(null);
    }

    markerArray = [];

    var start = start_address.val();
    var end = arrival_address.val();
    var request = {
        origin: start,
        destination: end,
        travelMode: google.maps.TravelMode.WALKING
    };

    directionsService.route(request, function(response, status) {
      if (status == google.maps.DirectionsStatus.OK) {
        directionsDisplay.setDirections(response);
      }

    });

  }

  function computeTotalDistance(result) {
    var total = 0;
    var myroute = result.routes[0];
    for (var i = 0; i < myroute.legs.length; i++) {
      total += myroute.legs[i].distance.value;
    }
    total = total / 1000.0;

    calculGes(total);

    document.getElementById('total').innerHTML = total + ' km';
  }

  google.maps.event.addDomListener(window, 'load', initialize);

  return initialize;
})();
