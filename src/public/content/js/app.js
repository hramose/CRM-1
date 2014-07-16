var CRM = angular.module('CRM', ['ngRoute']);

CRM.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider
            .when('/main', {
                templateUrl: '/template/main',
                controller: 'MainCtrl'
            })
            .otherwise({
                redirectTo: '/main'
            });

    }
]);



