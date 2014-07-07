'use strict';

app.directive('mdmAddactiveclass', function() {
      return function (scope, element, attrs) {
        element.click(function(){
            element.parent().parent().siblings().removeClass('active');
            element.siblings().removeClass('active');
            $(this).parent().parent().addClass('active')
            $(this).addClass('active');
        });
      };
    })
  .directive('copyCode', [function () {
    var copyBtn = angular.element('<button class="btn btn-primary btn-xs">copier dans le code HTML</button>');
    
    var link = function (scope, el) {
      copyBtn.click(function() {

        var generate = angular.element('.generate_zone_container');
        var newsletter =  angular.element('.newsletter').html();
        var replaced_newsletter  = newsletter.replace(/(class="ng-scope ng-binding")|(ng-binding)|(ng-model=".+")/g, "");

        generate
          .children()
          .remove()
          .end()
          .append('<textarea class="generate_zone">'+
          '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">'+
            replaced_newsletter + '</textarea>');
      });
    }

    return {
      restrict: 'E',
      compile: function (tElem) {
        tElem.append(copyBtn);
        return link;
      }
    };
  }])
   .directive('tabgroup', function () {
    return {
        restrict: 'E',
        transclude: true,
        template:'<a class="btn btn-info" href="#" ng-repeat="tab in tabs" ng-click="select(tab)" ng-class={active:tab.selected}>{{tab.title}}</a><div ng-transclude></div>',
        controller: function($scope){
            $scope.tabs = [];
            this.addTab = function(tab){
                if($scope.tabs.length === 0){
                    tab.selected = true;
                }
                $scope.tabs.push(tab);
            };
            
            $scope.select = function(tab){
                angular.forEach($scope.tabs, function(eachTab){
                    eachTab.selected = angular.equals(tab, eachTab);
                });
            };
        }
    }
})
.directive('tab', function () {
    return {
        restrict: 'E',
        scope: {
            title: '@'
        },
        transclude: true,
        template: ' <p ng-show="selected" ng-transclude></p>',
        require:'^tabgroup',
        link: function (scope, element, attrs, controller) {
            controller.addTab(scope);//watching scope properties of tab
        }
    }
})

.directive('generate', function () {
    return {
        restrict: 'E',
        templateUrl: 'views/generate.html'
    }
});