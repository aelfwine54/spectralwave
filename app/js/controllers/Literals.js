function LiteralCtrl($scope, $http){

	$scope.value= '';
	

	$scope.init = function(name)
	{
	  //This function is sort of private constructor for controller
	  $scope.name = name;
	  $scope.fetchLiteral();
	};

	$scope.fetchLiteral = function(){
		$http.get('./api/literals/'+ $scope.name).
			success(function(data){
				$scope.value = data[0].value;
				$scope.literal = data[0];
			})
	}

	$scope.$on('getLiterals', function(){
		$scope.fetchLiteral();
	});

	
}
LiteralCtrl.$inject = ['$scope','$http'];