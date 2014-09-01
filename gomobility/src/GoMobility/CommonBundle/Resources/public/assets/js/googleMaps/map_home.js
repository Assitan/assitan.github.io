'use strict';

var homepageMap = (function(){

  var map;

  function initialize() {

    var mapOptions = {
      zoom: 2,
      center: new google.maps.LatLng(48.8535243, 2.33949860000007),
      mapTypeId : google.maps.MapTypeId.TERRAIN
    };
    map = new google.maps.Map(document.getElementById('main_maps'),mapOptions);
    setMarkers(map);
  };

  function setMarkers(map) {

    $('.hidden_home').each(function(){
      var contentMap = [
        {id : $(this).find('.id_home').text()},
        {type : $(this).find('.type_home').text()},
        {description : $(this).find('.description_home').text()},
        {marker : $(this).find('.marker_home').text()},
        {link : $(this).find('.link_home').text()},
        {latitude : $(this).find('.lat_home').text()},
        {longitude : $(this).find('.long_home').text()}
      ];

      var myLatLng = new google.maps.LatLng(contentMap[5].latitude, contentMap[6].longitude);
      var marker = new google.maps.Marker({
         position: myLatLng,
         map: map,
         icon: contentMap[3].marker
       });

      var contentString = '<div id="content">'+
        '<h3>Expérience n° ' + contentMap[0].id + ' </h3>'+
        '<h5>mode : ' + contentMap[1].type + ' </h5>'+
        '<p>' + contentMap[2].description +'</p>'+
        ' <a href="'+ contentMap[4].link + '">En savoir plus</a> '+
        '</div>';

      var infowindow = new google.maps.InfoWindow;

      bindInfoW(marker, contentString, infowindow);
    });

  }  

  function bindInfoW(marker, contentString, infowindow){
    google.maps.event.addListener(marker, 'click', function() {
      infowindow.setContent(contentString);
      infowindow.open(map, marker);
    });
  }

  google.maps.event.addDomListener(window, 'load', initialize);

  return initialize;
})();

