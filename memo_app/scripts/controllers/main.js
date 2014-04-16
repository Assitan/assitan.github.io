'use strict';

app.config(['$routeProvider', function($routeProvider) {
  $routeProvider
    .when('/memo_save', {
      templateUrl: 'scripts/controllers/memo.json', 
      controller: 'MainCtrl'
    })
    .otherwise({redirectTo: '/'});

}]).controller('MainCtrl', function($scope,$http) {//récup du $scope
 
  	var memos = [];//ensemble des mémos  
    var memoContent = '';
    var year = new Date();

    $scope.memoContent = memoContent; 
    $scope.year = year;
    $scope.bgdColors = {
      defaults : '#F6F761',
      pink     : '#ffb8ce',
      blue     : '#74cbf7',
      white    : '#fff',
      green    : '#a7e4a4'
    };

    $scope.hoverBgdColor = function(){
      var memoBgd = angular.element(document.querySelector( 'textarea' ));
      memoBgd.css('background-color',$scope.bgdColors)
      console.log('hello');
    }

    $scope.addMemo = function(){
      var self = this;
      $scope.memos = memos;//rattachement à la vue
    	var value = $scope.memo;
      memos.push({title:value});

      var publication = {};
      self.publication = new Date()
      $scope.publication = self.publication;
      console.log($scope.publication);
      //$scope.publication = self.date;     
  	};

  	//Suppr. d'un mémo
  	$scope.removeMemo = function(index){		
  		memos.splice(index,1);
  	};

    //Sauvegarde du content
    /*$scope.save = function() {
      var self = this;
      $http.post('/scripts/controllers/memo.json', self.memoContent).then(function(data) {
        $scope.msg = 'Data saved';
      });
      self.msg = 'memo n° ' + (self.$index+1) + ' : ' + JSON.stringify(self.memoContent);
    };*/

 });
