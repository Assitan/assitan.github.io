'use strict';

app.controller('MainCtrl', function ($scope) {
 
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

    $scope.setMemoContent = function(){
      localStorage.setItem('Memos', JSON.stringify(angular.copy($scope.memos)));
      alert('Enregistré');
    };

    $scope.getMemoContent = function(){
      $scope.storage = localStorage.getItem('Memos');
      $scope.storage = JSON.parse($scope.storage);

      $scope.storage.forEach(function (element){
        $scope.storage[element] = element;
        console.log(element);
      });
      
    }; 

 })
  .directive('memoContent', function () {
    return {
      restrict: 'E',
      templateUrl: 'views/main.html',
      controller: 'MainCtrl'
    };
  });
