function LiteralPopUpCtrl($scope, $http, eventService){

	$scope.literal ={};
	$scope.title = "Ajouter un literal";
	$scope.submitText = "Ajouter";

	$scope.createLiteral = function(){
		if($scope.oldname){
			$scope.saveLiteral();
		}
		else{
			$http.post('./api/literals',$scope.literal).
				success(function(data){
					$('#literalPopUp').modal('hide');
					$('#literalPopUp').on('hidden', function(){
						alertSuccess('#createLiteralSuccess');
						$('#literalPopUp').off('hidden');
					})
				}).
				error(function(data){
					alertError('#createliteralError');
				})
		}
	}
	$scope.editLiteral = function(name){
		$http.get('./api/literals/'+name).
			success(function(data){
				$scope.literal = data[0];
				$scope.oldname = name;
				$scope.title = 'Modifier un literal';
				$scope.submitText = "Modifier";
				$('#literalPopUp').modal('show');
			});
	};

	$scope.saveLiteral = function(){
		$http.put('./api/literals/'+ $scope.literal.name , $scope.literal).
			success(function(data){
				$('#literalPopUp').modal('hide');
				$('#literalPopUp').on('hidden', function(){
					alertSuccess('#editLiteralSuccess');
					eventService.emit('getLiterals');
					$('#literalPopUp').off('hidden');
				})
			}).
			error(function(data){
				alertError('#editLiteralError');
			})
	}

	$('body').on('click', '.editLiteral',function(){
		$scope.editLiteral($(this).attr('literal'));	}
	);

}
LiteralPopUpCtrl.$inject = ['$scope','$http','eventService'];