function config($routeProvider) {
	$routeProvider
		.when('/', {
			templateUrl: 'views/home.html',
			controller: 'homeCtrl'
		})

		.when('/meals', {
			templateUrl: 'views/meals.html',
			controller: 'mealsCtrl'
		})

		.otherwise({
			redirectTo: '/'
		});
}

function run($rootScope, $location){
	var path = function() { return $location.path(); };
	$rootScope.$watch(path, function(newVal, oldVal){
		$rootScope.activetab = newVal;
	});
}

angular.module('app', ['ngRoute', 'app.components', 'ngFileUpload'])
    .config(config)
    .controller('navBarCtrl', navBarCtrl)
    .controller('homeCtrl', homeCtrl)
    .controller('mealsCtrl', mealsCtrl)

    /*.factory('', )*/
    .run(run);

