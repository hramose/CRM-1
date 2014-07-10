CRM.controller('MainCtrl', ['$scope', '$http',
    function($scope, $http) {

        $scope.clients = [];

        $scope.page = 1;
        $scope.pages = [];

        $scope.status = 0;
        $scope.statuses = [];

        $scope.curator = 0;
        $scope.curators = [];

        // получаем список кураторов
        var getSelect = function(Sname) {

            $http.post('/api/' + Sname)
                .success(function(data, status) {
                    $scope[Sname] = [];

                    $scope[Sname].push({
                        id: 0,
                        name: 'Все'
                    });

                    if (data.items) {
                        if (typeof data.items === 'string') {
                            data.items = JSON.parse(data.items);
                        }

                        for (var i = 0; i < data.items.length; i++) {
                            $scope[Sname].push({
                                id: data.items[i].id,
                                name: (data.items[i].username || data.items[i].name)
                            });
                        }
                    }
                });
        };

        getSelect('curators');
        getSelect('statuses');



        $scope.show = function() {

            // собираем даныне фильтра и номер страницы
            var data = {
                page: $scope.page,
                curator: $scope.curator,
                status: $scope.status
            };

            $http.post('/api/show', data)
                .success(function(data, status) {
                    $scope.clients = [];

                    if (data.items) {
                        if (typeof data.items === 'string') {
                            data.items = JSON.parse(data.items);
                        }

                        for (var i = 0; i < data.items.length; i++) {
                            $scope.clients.push({
                                id: data.items[i].id,
                                name: data.items[i].name,
                                url: data.items[i].url,
                                contact: data.items[i].contact,
                                created_at: data.items[i].created_at
                            });
                        }
                    }
                })
                .error(function(data, status) {
                    alert('Возникли проблемы...');
                    console.log(status, data);
                });
        };


        $scope.show();
    }

]);