function AllEventsCtrl($scope, $http, eventService){

	$scope.admin = getCookie("admin");

	$scope.fetchEvents = function(){
		$http.get('./api/events').
			success(function(data){
				var e;
				for (e in data){
					data[e].description = XBBCODE.process({
		            		text: data[e].description,
		            		removeMisalignedTags: true,
		            		addInLineBreaks: true
	        			}).html;
				}
				$scope.events = data;
			})
	}

	$scope.deleteEvent = function(id){
			$http.delete('./api/events/'+id).
				success(function(){
					$scope.fetchEvents();
					alertSuccess('#deleteEventSuccess');
				}).
				error(function(){
					$scope.fetchEvents();
					alertError('#deleteEventError');
				});
	}

	$('body').on('click', '.delEvent',function(){
		if(confirm('Etes-vous sur de vouloir effacer cet event?')){
			$scope.deleteEvent($(this).closest('tr').attr('eventid'));
		}
	});

	$scope.$on('getEvents', function(){
		$scope.fetchEvents();
	});

	$scope.$on('adminConnect', function(){
		$scope.admin=true;
	});

	$scope.$on('adminDisconnect', function(){
		$scope.admin=false;
	});

	$scope.fetchEvents();

}
AllEventsCtrl.$inject = ['$scope','$http','eventService'];