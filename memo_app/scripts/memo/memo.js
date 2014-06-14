'use strict';

app.controller('MainCtrl', function($scope,$http) {
 
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

/*    var fb_url = new Firebase('https://memo-app.firebaseio.com');
    var memoColors = new Firebase(fb_url + '/colors');
    var content = new Firebase(fb_url + '/content');

    $scope.setMemoColors = function(){
      memoColors.update($scope.setColor);
      console.log($scope.setColor);
    };

    memoColors.on('value', function(snap) {
      $scope.getColor = snap.val();
    });

    $scope.setMemoContent = function(id){
      content.push(angular.copy($scope.memo));//enleve le $$HashKey 
    };

    content.on('value', function(snap) {
      $scope.getMemoContent = snap.val();
    });*/

 })
  .directive('memoContent', function () {
    return {
      restrict: 'E',
      templateUrl: 'views/main.html',
      controller: 'MainCtrl'
    };
  });
