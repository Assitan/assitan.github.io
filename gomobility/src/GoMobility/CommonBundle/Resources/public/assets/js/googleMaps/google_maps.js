'use strict';

function homepageMap(){

  var initialize = function() {

    var myLatlng = new google.maps.LatLng(-25.363882,131.044922);
    var mapOptions = {
     zoom: 4,
     center: myLatlng
   }

   var map = new google.maps.Map(document.getElementById('main_maps'), mapOptions);

   var marker = new google.maps.Marker({
     position: myLatlng,
     map: map,
     title: 'Hello'
   });
 };

 google.maps.event.addDomListener(window, 'resize', initialize);
 google.maps.event.addDomListener(window, 'load', initialize);

 return initialize;
}

