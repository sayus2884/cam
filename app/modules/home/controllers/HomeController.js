'use strict'

var controllers = angular.module('home.controllers',[]);

controllers.controller('SampleController', ['$scope','$http', function($scope,$http){
    $scope.name = "Jo";
    $scope.author = "";
    
    $scope.contacts = {
        info: [
            {
                contactInfo: 'jonacius.codeitat@gmail.com',
                image: 'app/modules/home/images/gmail.png'
            },
            {
                contactInfo: 'ph.linkedin.com/in/JonaciusCodeitat',
                image: 'app/modules/home/images/linkedin.png'
            },
            {
                contactInfo: 'https://www.facebook.com/sayus2884',
                image: 'app/modules/home/images/fb.png'
            },
            {
                contactInfo: '+63 926 348 7129',
                image: 'app/modules/home/images/mobile.png'
            }
        ]
    };
    
    $http.post('server/index.php/SampleController/getDescription').success(function(data) {
        $scope.author = data;
    });  
}]);