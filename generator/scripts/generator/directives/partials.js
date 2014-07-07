'use strict';

app.directive('navCountries', function() {
      return{
        restrict: 'E',
        templateUrl: 'views/partial/nav.html',
        controller: 'GeneratorCtrl'
      };
  })
  .directive('settings', function() {
      return{
        restrict: 'E',
        templateUrl: 'views/partial/settings.html',
        controller: 'GeneratorCtrl'
      };
  });