var CRM = angular.module('CRM', ['ngRoute']);

CRM.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider
            .when('/group', {
                templateUrl: '/template/admin-group',
                controller: 'MainAdminCtrl'
            })
            .otherwise({
                redirectTo: '/group'
            });

    }
]);


CRM.factory('API', ['$http',
    function($http) {

        return {
            sendPost: function(url, data, callback) {
                $http.post(url, data)
                    .success(callback)
                    .error(function(data, status) {
                        console.log(data, status);
                    });
            }
        };
    }
]);

/**
   __________  _   ____________  ____  __    __    __________
  / ____/ __ \/ | / /_  __/ __ \/ __ \/ /   / /   / ____/ __ \
 / /   / / / /  |/ / / / / /_/ / / / / /   / /   / __/ / /_/ /
/ /___/ /_/ / /|  / / / / _, _/ /_/ / /___/ /___/ /___/ _, _/
\____/\____/_/ |_/ /_/ /_/ |_|\____/_____/_____/_____/_/ |_|

*/

CRM.controller('MainAdminCtrl', ['$scope', 'API',
    function($scope, API) {

        $scope.not_group = [{
            id: 2,
            username: 'Test'
        }, {
            id: 3,
            username: 'The test'
        }];

        $scope.group = [{
            id: 2,
            username: 'Test'
        }, {
            id: 3,
            username: 'The test'
        }];


        var Group = function(data) {
            if (data.group)
                $scope.group = data.group;

            if (data.not_group)
                $scope.not_group = data.not_group;
        };


        API.sendPost('/api-admin/getgroup', {}, Group);


        $scope.addToGroup = function(id) {
            API.sendPost('/api-admin/add', {
                id: id
            }, Group);
        };


        $scope.removeFromGroup = function(id) {
            API.sendPost('/api-admin/remove', {
                id: id
            }, Group);
        };


    }
]);