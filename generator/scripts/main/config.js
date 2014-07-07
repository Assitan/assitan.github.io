'use strict';

app
 .config(['$stateProvider','$urlRouterProvider','$locationProvider', 
    function ($stateProvider, $urlRouterProvider, $locationProvider) {

    var mainCountries = ['FR_fr','DE_de','ES_es','IT_it','BE_fr'],
        allCountries = ['FR_fr','DE_de','ES_es','IT_it','UK_en','BE_fr','CH_fr','LU_fr','AT_de','CH_de','CH_it','NL_nl','BE_nl'],
        i = 0,
        j = 0;

        //console.log(MainCountriesFactory);

    for (; i < mainCountries.length; i++) {
        state_kit(mainCountries[i]);
        state_kit700(mainCountries[i]);
    }

    for (; j < allCountries.length; j++) {
        state_news(allCountries[j]);
        state_news700(allCountries[j]);
    }



    $urlRouterProvider.otherwise('/');

    $stateProvider
        .state('newsCP', {
            //url: 'generate',
            url: '/',
            templateUrl: 'views/templates/newsletters/news/news-FR_fr_CP.html'
        })
        .state('news700CP', {
            //url: 'generate',
            url: '/',
            templateUrl: 'views/templates/newsletters/news700/news700-FR_fr_CP.html'
        });

    function state_kit(country){
        $stateProvider.state('kit_' + country, {
            //url: '/kit/' + country,
            url: '/',
            templateUrl: 'views/templates/newsletters/kit/kit-' + country + '.html',
        });
    }

    function state_kit700(country){
        $stateProvider.state('kit700_' + country, {
            //url: '/kit700/' + country,
            url: '/',
            templateUrl: 'views/templates/newsletters/kit700/kit700-' + country + '.html'
        });
    }

    function state_news(country){
        $stateProvider.state('news_' + country, {
            //url: '/news/' + country,
            url: '/',
            templateUrl: 'views/templates/newsletters/news/news-' + country + '.html'
        });
    }

    function state_news700(country){
        $stateProvider.state('news700_'+ country, {
            //url: '/news700/' + country,
            url: '/',
            templateUrl: 'views/templates/newsletters/news700/news700-' + country + '.html'
        });
    }

    $locationProvider.html5Mode(true);
  }]);