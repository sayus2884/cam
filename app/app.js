'use strict';

angular.module('myApp', ['ngRoute', 'myApp.home']).config(['$routeProvider', function($routeProvider) {

    $routeProvider.when('/home', {
        controller: 'SampleController',
        templateUrl: 'app/modules/home/views/home.html'
    });

    $routeProvider.otherwise({
        redirectTo: '/home'
    });
    
}]);