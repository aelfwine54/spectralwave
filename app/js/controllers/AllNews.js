function AllNewsCtrl($scope, $http, eventService){

	$scope.admin = getCookie("admin");

	$scope.fetchNews = function(){
		$http.get('./api/news').
			success(function(data){
				var e;
				for (e in data){
					data[e].description = XBBCODE.process({
		            		text: data[e].description,
		            		removeMisalignedTags: true,
		            		addInLineBreaks: true
	        			}).html;
				}
				$scope.news = data.reverse();
			})
	}

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
			$scope.deleteNews($(this).closest('tr').attr('newsId'));
		}
	});

	$scope.$on('getNews', function(){
		$scope.fetchNews();
	});

	$scope.fetchNews();
}
AllNewsCtrl.$inject = ['$scope','$http','eventService'];