'use strict';

/* Controllers */

function MainCtrl($scope,$http, eventService){
	$scope.connect = Boolean(getCookie('connexion'));
	$scope.user = {};
	$scope.newUser = {};
	$scope.pseudo = getCookie('pseudo');
	
	$scope.switchMenuActif = function(mainMenu, subMenu){
		$($scope.menuActif).removeClass('active');
		$(mainMenu).addClass('active');
		$scope.menuActif = mainMenu;

		$($scope.subMeneActif).removeClass('active');
		$(subMenu).addClass('active');
		$scope.subMeneActif = subMenu;
	}

	$scope.connexion = function(){

		$scope.user.credentials = $.base64.encode($scope.user.pseudo+'12'+$scope.user.password);
		$http.post('./api/connect', $scope.user).
			success(function(data){
				document.cookie = 'connexion=true';
				document.cookie = 'pseudo=' + $scope.user.pseudo;
				$scope.connect=true;
				$('#connexionDropDown').hide();
				$('#connexionDropDown').removeClass('open');
				$scope.setGrade(getCookie('grade'));
				$scope.pseudo = getCookie('pseudo');
			}).
			error(function(data){
				$scope.errorMessage = data[0];
			});
	}

	$scope.logout = function(){
		$http.post('./api/logout').
			success(function(data){
				deleteCookie('admin');
				deleteCookie('connexion');
				$scope.connect = false;
				eventService.emit('adminDisconnect');
			});
	}

	$scope.setGrade = function(grade){
		switch(Number(grade)){
			case 1:
				//superuser
				break;
			case 2:
				//admin
				eventService.emit('adminConnect');
				document.cookie = "admin=" + $scope.connect;
				break;
			case 3:
				//moderateur
				break;
			case 4:
				//maire
				break;
			case 5:
				//joueur
				break;
			case 6:
				//visiteur
				break;
		}
	}

	$scope.inscription = function(){
		$http.post('./api/joueurs', $scope.newUser).
		success(function(data){
				$scope.confirmMessage = "Inscription reussie. Veuillez-vous connecter";
			}).
			error(function(data){
				$scope.errorMessage = data;
			});
	}


}
MainCtrl.$inject = ['$scope','$http', 'eventService'];

function TelechargementCtrl($scope,$route, $routeParams) {
	$scope.$route = $route;
	$scope.$routeProvider = $routeParams;

}
TelechargementCtrl.$inject = ['$route'];