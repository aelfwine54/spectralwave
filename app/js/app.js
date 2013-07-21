'use strict';


// Declare app level module which depends on filters, and services
angular.module('myApp', ['myApp.filters', 'myApp.services', 'myApp.directives']).
  config(['$routeProvider', function($routeProvider) {
    $routeProvider.when('/index', {templateUrl: 'partials/spectralwave.html', controller: SpectralWaveCtrl});
    $routeProvider.when('/telechargements', {templateUrl: 'partials/telechargements.html', controller: TelechargementCtrl});
    $routeProvider.when('/viewers', {templateUrl: 'partials/viewers.html', controller: SpectralWaveCtrl});
    $routeProvider.when('/regles', {templateUrl: 'partials/regles.html', controller: SpectralWaveCtrl});
    $routeProvider.when('/version', {templateUrl: 'partials/version.html', controller: SpectralWaveCtrl});
    $routeProvider.when('/serveurs', {templateUrl: 'partials/serveurs.html', controller: SpectralWaveCtrl});
    $routeProvider.when('/bbcode', {templateUrl: 'partials/bbcodeHelp.html', controller: SpectralWaveCtrl});

    $routeProvider.when('/events', {templateUrl: 'partials/allEvents.html', controller: AllEventsCtrl});
    $routeProvider.when('/news', {templateUrl: 'partials/allNews.html', controller: AllNewsCtrl});

    $routeProvider.when('/events/:eventId', {templateUrl: 'partials/detailledEvent.html', controller: DetailledEventCtrl});
    $routeProvider.when('/news/:newsId', {templateUrl: 'partials/detailledNews.html', controller: DetailledNewsCtrl});

    $routeProvider.otherwise({redirectTo: '/index'});
  }]);
