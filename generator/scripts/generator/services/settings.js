app
  .factory('TrackingsBeginFactory', ['$sessionStorage', function ($sessionStorage) {
    
    var track_begin = $sessionStorage;

    return track_begin;

  }])
    .factory('TrackingsEndFactory', ['$localStorage', function ($localStorage) {
    
    var track_end = $localStorage;

    return track_end;

  }])
    .factory('ColorFactory', ['$localStorage', function ($localStorage) {
    
    var setColor = $localStorage;

    return setColor;

  }])
    .factory('TitleFactory', ['$localStorage', function ($localStorage) {

    var title = $localStorage;

    return title;

  }]);