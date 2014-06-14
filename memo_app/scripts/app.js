'use strict';

var app = angular.module('memoApp',[
	'ngRoute',
	'ngResource',
	'scrollto',
	'colorpicker.module'
	])
	.config(['$routeProvider', function($routeProvider) {
	  $routeProvider
	    .when('/memo_save', {
	      templateUrl: 'scripts/controllers/memo.json', 
	      controller: 'MainCtrl'
	    })
	    .otherwise({redirectTo: '/'});

	}]);
