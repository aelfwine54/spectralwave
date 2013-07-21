'use strict';

/* Services */


// Demonstrate how to register services
// In this case it is a simple value service.
var service=angular.module('myApp.services', []).
	value('version', '0.1');

service.factory('eventService', function($rootScope, $http){
	var eventService = {};

	eventService.emit = function(){
		$rootScope.$broadcast.apply($rootScope, arguments); 
	};
return eventService;
});
