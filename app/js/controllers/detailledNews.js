function DetailledNewsCtrl($scope, $http, eventService, $routeParams){

	$scope.admin = getCookie("admin");

	$scope.newComm={};

	$scope.fetchNews = function(){
		$http.get('./api/news/'+ $routeParams.newsId).
			success(function(data){
				data[0].description = XBBCODE.process({
		            text: data[0].description,
		            removeMisalignedTags: true,
		            addInLineBreaks: true
	        	}).html;
				$scope.news = data[0];
				$scope.fetchComments();
			})
	}

	$scope.fetchComments = function(){
		$http.get('./api/news/'+ $routeParams.newsId +'/commentaires').
			success(function(data){
				$scope.comments = data;
			})
	}

	$scope.addComment = function(){
		$scope.newComm.date = new Date();
		$scope.newComm.eventId = $routeParams.newsId;
		$scope.newComm.contenu = XBBCODE.process({
            text: $scope.newComm.contenu,
            removeMisalignedTags: true,
            addInLineBreaks: true
        }).html;
		$http.post('./api/news/'+ $routeParams.newsId +'/commentaires', $scope.newComm).
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

	$scope.$on('getNews', function(){
		$scope.fetchNews();
	});

	$scope.delComment = function(id){
			$http.delete('./api/news/'+ $routeParams.newsId +'/commentaires/'+id).
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

	$scope.deleteNews = function(id){
		$http.delete('./api/news/'+ id).
			success(function(){
				$scope.fetchNews();
				window.location='#/index';
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

	$scope.fetchNews();
}
DetailledNewsCtrl.$inject = ['$scope','$http','eventService', '$routeParams'];