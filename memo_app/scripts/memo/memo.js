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

    var fb_url = new Firebase('https://memo-app.firebaseio.com');
    var memoColors = new Firebase(fb_url + '/colors');
    var content = new Firebase(fb_url + '/content');

    $scope.setMemoColors = function(){
      memoColors.update($scope.setColor);
    };

    memoColors.on('value', function(snap) {
      $scope.getColor = snap.val();
    });

    /*$scope.setMemoContent = function(index){
      content.update($scope.setContent + index);
    };

    content.on('value', function(snap) {
      $scope.getContent = snap.val();
    });*/

    //rattachement à la vue
    $scope.addMemo = function(){
      var self = this;
      $scope.memos = memos;
    	var value = $scope.memo;
      memos.push({title:value});

      /*var publication = {};
      self.publication = new Date()
      $scope.publication = self.publication;
      console.log($scope.publication);*/
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
