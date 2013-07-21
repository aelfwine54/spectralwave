function EventPopUpCtrl($scope, $http, eventService, $filter){

	$scope.events ={};
	$scope.submitText = 'Ajouter';

	$scope.getJeux = function(){
		$http.get('./api/jeux').
			success(function(data){
				$scope.jeux =data;
			})
	};

	$scope.createEvent = function(){
		if($scope.events.date!=null ){
			$scope.events.date = parseDate($scope.events.date);
		}
		if($scope.events.edit){
			$scope.saveEvent();
		}
		else{
			
			$scope.events.jeuId = $scope.events.jeuId.id;
			$http.post('./api/events',$scope.events).
				success(function(data){
					$('#eventPopUp').modal('hide');
					$('#eventPopUp').on('hidden', function(){
						eventService.emit('getEvents');
						alertSuccess('#createEventSuccess');
						$('#eventPopUp').off('hidden');
					})
				}).
				error(function(data){
					alertError('#createEventError');
				})
		}
	}

	$scope.editEvent = function(id){
		$http.get('./api/events/'+id).
			success(function(data){
				$scope.events = data[0];
				$scope.events.jeuId=findById($scope.jeux, data[0].jeuId);
				$scope.events.edit = true;
				$scope.events.date = $filter('date')(data[0].date, 'dd-MM-yyyy HH:mm');

				$scope.title = 'Modifier un event';
				$scope.submitText = "Modifier";
			});
	};

	$scope.saveEvent = function(){
		$scope.events.jeuId = $scope.events.jeuId.id;
		$http.put('./api/events/'+ $scope.events.id , $scope.events).
			success(function(data){
				$('#eventPopUp').modal('hide');
				$('#eventPopUp').on('hidden', function(){
					eventService.emit('getEvents');
					alertSuccess('#editEventSuccess');
					$('#eventPopUp').off('hidden');
				})
			}).
			error(function(data){
				alertError('#editEventError');
			})
	}

	$('body').on('click', '.editEvent',function(){
		$scope.editEvent($(this).closest('article').attr('eventId') || $(this).closest('tr').attr('eventId'));	}
	);

	$scope.getJeux();
}
EventPopUpCtrl.$inject = ['$scope','$http','eventService', '$filter'];