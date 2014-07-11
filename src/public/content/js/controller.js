CRM.controller('MainCtrl', ['$scope', '$http',
    function($scope, $http) {

        $scope.showForm = false;
        $scope.client_id = 0;

        $scope.clients = [];

        $scope.page = 1;
        $scope.pages = [];

        $scope.status = 0;
        $scope.statuses = [];

        $scope.curator = 0;
        $scope.curators = [];

        $scope.form_statuses = [];
        $scope.form_curators = [];


        // ### Search ###
        $scope.search = function(item) {
            if($scope.query===undefined || $scope.query===''){
                return true;
            }

            if (item.name.indexOf($scope.query) != -1) {
                return true;
            }

            for (var i = 0; i < item.contact.length; i++) {
                if(item.contact[i].name.indexOf($scope.query) != -1){
                    return true;
                }
            }

            return false;
        };

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
                            $scope['form_' + Sname].push({
                                id: data.items[i].id,
                                name: (data.items[i].username || data.items[i].name)
                            });

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



        // ######## add/edit #########
        $scope.BodyOver = function(over) {
            var d = document.getElementById("body");

            d.className = (over) ? 'ov-h' : '';
        };



        $scope.saveClient = function() {

            var url = '/api/save',
                data = {
                    name: $scope.name,
                    company_name: $scope.company_name,
                    url: $scope.url,
                    about: $scope.about,
                    status_id: $scope.form_status,
                    user_id: $scope.form_curator,
                    client_id: $scope.client_id,
                    see_all: $scope.see_all
                };

            if ((!data.user_id) || (!data.status_id)) {
                alert('Статус и Куратор обязательно должны быть заполнены');
                return false;
            }



            $http.post(url, data)
                .success(function(data, status) {

                    if (data && data.message) {
                        alert(data.message);
                    }

                    if (data && data.status) {
                        $scope.closeForm();
                        $scope.show();
                    }
                })
                .error(function(data, status) {
                    alert('Возникли проблемы...');
                    console.log(status, data);
                });
        };



        $scope.editClient = function(id) {
            var data = {
                id: id
            };

            $scope.BodyOver(true);

            $http.post('/api/getclient', data)
                .success(function(data, status) {

                    if (data && data.item) {
                        for (var cl in data.item) {
                            $scope[cl] = data.item[cl];
                        }
                    }

                    $scope.showForm = true;
                })
                .error(function(data, status) {
                    alert('Возникли проблемы...');
                    console.log(status, data);
                });
        };



        $scope.closeForm = function() {
            $scope.showForm = false;
            $scope.BodyOver();

            $scope.name = '';
            $scope.company_name = '';
            $scope.url = '';
            $scope.about = '';

            // debugger;

        };

    }

]);