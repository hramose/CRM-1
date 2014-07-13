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


CRM.directive('addContact', [function () {
    return {
        restrict: 'E',
        templateUrl: '/template/add-contact',
        controller: function () {
            //
        },
        controllerAs: 'contact'
    };
}]);

