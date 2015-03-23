'use strict'

var directives = angular.module('home.directives',[]);

directives.directive('description', function(){
    return{
        restrict: 'E',
        templateUrl: 'app/modules/home/views/description.html'
    };
});