'use strict';

app.run(function(editableOptions) {
    editableOptions.theme = 'bs3';
  })
  .controller('EmailingCtrl', ['$scope','StraplineFactory', function ($scope, StraplineFactory){

    $scope.edit = StraplineFactory;

  }])
  .factory('StraplineFactory', ['$localStorage', function ($localStorage) {

    var edit = $localStorage;

    return edit;
        
  }]);