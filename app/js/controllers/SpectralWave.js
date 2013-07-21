function SpectralWaveCtrl($scope, $http, eventService) {

	$scope.admin = getCookie("admin");

	$scope.fetchNews = function(){
		$http.get('./api/news').
			success(function(data){
				var e;
				for (e in data){
					data[e].description = XBBCODE.process({
		            		text: data[e].description,
		            		removeMisalignedTags: false,
		            		addInLineBreaks: true
	        			}).html;
				}
				$scope.news = data.reverse();
			})
	}

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
			$scope.deleteEvent($(this).closest('article').attr('eventId'));
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

	$scope.deleteNews = function(id){
			$http.delete('./api/news/'+id).
				success(function(){
					$scope.fetchNews();
					alertSuccess('#deleteNewsSuccess');
				}).
				error(function(){
					$scope.fetchNews();
					alertError('#deleteNewsError');
				});
	}

	$('body').on('click', '.delNews',function(){
		if(confirm('Etes-vous sur de vouloir effacer cette news?')){
			$scope.deleteNews($(this).closest('article').attr('newsId'));
		}
	});

	$scope.$on('getNews', function(){
		$scope.fetchNews();
	});

	$scope.fetchNews();
	$scope.fetchEvents()
}
SpectralWaveCtrl.$inject = ['$scope','$http'];