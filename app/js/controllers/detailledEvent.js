function DetailledEventCtrl($scope, $http, eventService, $routeParams){

	$scope.admin = getCookie("admin");
	
	$scope.newComm={};

	$scope.fetchEvent = function(){
		$http.get('./api/events/'+ $routeParams.eventId).
			success(function(data){
				data[0].description = XBBCODE.process({
		            text: data[0].description,
		            removeMisalignedTags: true,
		            addInLineBreaks: true
	        	}).html;
				$scope.event = data[0];
				$scope.fetchComments();
			})
	}

	$scope.fetchComments = function(){
		$http.get('./api/events/'+ $routeParams.eventId +'/commentaires').
			success(function(data){
				$scope.comments = data;
			})
	}

	$scope.addComment = function(){
		$scope.newComm.date = new Date();
		$scope.newComm.eventId = $routeParams.eventId;
		$scope.newComm.contenu = XBBCODE.process({
            text: $scope.newComm.contenu,
            removeMisalignedTags: true,
            addInLineBreaks: true
        }).html;
		$http.post('./api/events/'+ $routeParams.eventId +'/commentaires', $scope.newComm).
			success(function(data){
				$scope.fetchComments();
				$('#commentReset').click();
				alertSuccess('#addCommentSuccess');
			}).
			error(function(data){
				alertError('#addCommentError');
			})
	}

	$scope.$on('adminConnect', function(){
		$scope.admin=true;
	});

	$scope.$on('adminDisconnect', function(){
		$scope.admin=false;
	});

	$scope.$on('getEvents', function(){
		$scope.fetchEvent();
	});

	$scope.delComment = function(id){
			$http.delete('./api/events/'+ $routeParams.eventId +'/commentaires/'+id).
				success(function(){
					$scope.fetchComments();
					alertSuccess('#deleteCommentSuccess');
				}).
				error(function(){
					$scope.fetchComments();
					alertError('#deleteCommentError');
				});
	}

	$('body').on('click', '.delComment',function(){
		if(confirm('Etes-vous sur de vouloir effacer ce commentaire?')){
			$scope.delComment($(this).closest('article').attr('commentId'));
		}
	});

	$scope.deleteEvent = function(id){
		$http.delete('./api/events/'+ id).
			success(function(){
				$scope.fetchEvent();
				window.location='#/index';
			}).
			error(function(){
				$scope.fetchEvent();
				alertError('#deleteEventError');
			});
	}

	$('body').on('click', '.delEvent',function(){
		if(confirm('Etes-vous sur de vouloir effacer cet event?')){
			$scope.deleteEvent($(this).closest('article').attr('eventId'));
		}
	});

	$scope.fetchEvent();
}
DetailledEventCtrl.$inject = ['$scope','$http','eventService', '$routeParams'];