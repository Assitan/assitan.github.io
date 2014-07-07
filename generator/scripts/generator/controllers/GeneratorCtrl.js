'use strict';

app.controller('GeneratorCtrl', ['$scope','$localStorage', 'TrackingsBeginFactory', 'TrackingsEndFactory', 'ColorFactory', 'TitleFactory', 
                        function ($scope, $localStorage, TrackingsBeginFactory, TrackingsEndFactory, ColorFactory, TitleFactory) {

    // NAVIGATION
    $scope.main_countries = ['FR_fr','DE_de','ES_es','IT_it','UK_en'];//TODO: Check kits for BE_fr
    $scope.all_countries = ['AT_de','CH_de','BE_fr','CH_fr','LU_fr','NL_nl','BE_nl','CH_it'];

    for (var i = 0; i < $scope.main_countries.length; i++) {
        for (var j = 0; j < $scope.all_countries.length; j++) {
            $scope.all_countries.push($scope.main_countries[i]);
            break;
        }
    }

    $scope.simpleCountries = {};
    for (var i = 0; i < $scope.main_countries.length; i++) {
        key = $scope.main_countries[i];
        $scope.simpleCountries[key] = {
            big:$scope.main_countries[i].split('_').splice(0,1),
            small:'template_' + $scope.main_countries[i].split('_').splice(1,2)
        }
    }

   /* $scope.isActive = function(route) {
        return route === $location.path();
        console.log($location.path());
    };*/

    //TRACKINGS IN SETTINGS PANEL
    $scope.collapses = {};
    for (var i = 0; i < $scope.all_countries.length; i++) {
        var key = $scope.all_countries[i];
        $scope.collapses[key] = {
            id: i,
            country: $scope.all_countries[i]
        };
    }

    $scope.track_begin = TrackingsBeginFactory;
    $scope.track_end = TrackingsEndFactory;
    $scope.setColor = ColorFactory;
    $scope.title = TitleFactory;

    $scope.reset = function(){
        $localStorage.$reset();
    }

    $scope.year = new Date();


    //GET FILE : TODO
    /*function readFile(evt) {

        var file = evt.target.files[0]; 
        var targetFile = document.getElementById('targetFile');

        if (file && file.type.match('text/html.*')) {
            var filereader = new FileReader();
            filereader.onload = function(e) { 
                var contents = e.target.result;
                targetFile.value = contents;
            }
                filereader.readAsText(file);
        } else { 
            alert("fichier non chargé");
        }
    }

   $('#fileinput').on('change', readFile);
*/

  }]);