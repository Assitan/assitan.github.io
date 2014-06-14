'use strict';

app.controller('MainCtrl', function($scope) {
 
  	 $scope.memos = []; 

    $scope.year = new Date();

    //ajout des mémos
    $scope.addMemo = function(){
      $scope.memo = {};
      $scope.memo.publication = Date.now();
      $scope.memos.push($scope.memo);
    };

    //Suppression d'un mémo
    $scope.removeMemo = function(index){    
      $scope.memos.splice(index,1);
    };

 })
  .directive('memoContent', function () {
    return {
      restrict: 'E',
      templateUrl: 'views/main.html',
      controller: 'MainCtrl'
    };
  });
