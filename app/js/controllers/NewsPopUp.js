function NewsPopUpCtrl($scope, $http, eventService){

	$scope.news ={};
	$scope.title = "Ajouter une news";
	$scope.submitText = "Ajouter";

	$scope.getJeux = function(){
		$http.get('./api/jeux').
			success(function(data){
				$scope.jeux =data;
			})
	};

	$scope.createNews = function(){
		if($scope.news.pubdate){
			$scope.saveNews();
		}
		else{
			$scope.news.pubdate = new Date();
			$scope.news.jeuId = $scope.news.jeuId.id;
			$http.post('./api/news',$scope.news).
				success(function(data){
					$('#newsPopUp').modal('hide');
					$('#newsPopUp').on('hidden', function(){
						eventService.emit('getNews');
						alertSuccess('#createNewsSuccess');
						$('#newsPopUp').off('hidden');
					})
				}).
				error(function(data){
					alertError('#createNewsError');
				})
		}
	}
	$scope.editNews = function(id){
		$http.get('./api/news/'+id).
			success(function(data){
				$scope.news = data[0];
				$scope.news.jeuId=findById($scope.jeux, data[0].jeuId);

				$scope.title = 'Modifier une news';
				$scope.submitText = "Modifier";
			});
	};

	$scope.saveNews = function(){
		$scope.news.jeuId = $scope.news.jeuId.id;
		$http.put('./api/news/'+ $scope.news.id , $scope.news).
			success(function(data){
				$('#newsPopUp').modal('hide');
				$('#newsPopUp').on('hidden', function(){
					eventService.emit('getNews');
					alertSuccess('#editNewsSuccess');
					$('#newsPopUp').off('hidden');
				})
			}).
			error(function(data){
				alertError('#editNewsError');
			})
	}

	$('body').on('click', '.editNews',function(){
		$scope.editNews($(this).closest('article').attr('newsId') || $(this).closest('tr').attr('newsId'));	}
	);

	$scope.getJeux();
}
NewsPopUpCtrl.$inject = ['$scope','$http','eventService'];