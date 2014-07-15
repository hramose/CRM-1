CRM.controller('MainCtrl', ['$scope', '$http',
    function($scope, $http) {

        $scope.animate = false;
        $scope.showForm = false;
        $scope.showClientBlock = false;
        $scope.edit_Contact = false;

        $scope.client_id = 0;
        $scope.contact_id = 0;

        $scope.block_history = false;
        $scope.block_contact = true;

        $scope.clients = [];
        $scope.form_contacts = [];

        $scope.page = 1;
        $scope.pages = [];

        $scope.status = 0;
        $scope.statuses = [];

        $scope.curator = 0;
        $scope.curators = [];

        $scope.form_statuses = [];
        $scope.form_curators = [];



        // ### Search ###
        $scope.search = function() {
            if ($scope.query.length < 2)
                return false;

            $scope.show();
        };


        // pagination
        var pagination = function(current, count) {
            $scope.page = current;
            $scope.pages = [];

            for (var i = 1; i <= count; i++) {
                $scope.pages.push(i);
            }
        };

        var sendPost = function(url, data, callback) {
            $scope.animate = true;

            $http.post(url, data)
                .success(function(data) {
                    $scope.animate = false;
                    callback(data);
                })
                .error(function(data, status) {
                    alert('Возникли проблемы...');
                    console.log(status, data);
                });
        };



        // получаем список кураторов
        var getSelect = function(Sname) {

            sendPost('/api/' + Sname, {}, function(data) {
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

                    if (data.current && data.count) {
                        pagination(data.current, data.count);
                    }
                }
            });
        };

        getSelect('curators');
        getSelect('statuses');



        $scope.show = function(page) {

            if (page !== undefined)
                $scope.page = page;

            // собираем даныне фильтра и номер страницы
            var data = {
                page: $scope.page,
                curator: $scope.curator,
                status: $scope.status,
                search: ($scope.query && $scope.query.length > 2) ? $scope.query : ''
            };

            sendPost('/api/show', data, function(data) {
                $scope.clients = [];

                if (data.items!==undefined) {
                    if (typeof data.items === 'string') {
                        data.items = JSON.parse(data.items);
                    }

                    for (var i = 0; i < data.items.length; i++) {
                        $scope.clients.push({
                            edit: data.items[i].edit,
                            id: data.items[i].id,
                            name: data.items[i].name,
                            url: data.items[i].url,
                            contact: data.items[i].contact,
                            created_at: data.items[i].created_at
                        });
                    }
                }

                if (data.page !== undefined && data.count !== undefined)
                    pagination(data.page, data.count);

                if (data.sql)
                    console.log(data.sql);

            });
        };
        $scope.show();



        // ######## add/edit #########
        $scope.BodyOver = function(over) {
            var d = document.getElementById("body");

            d.className = (over) ? 'ov-h' : '';
        };



        $scope.saveClient = function() {
            var data = {
                name: $scope.name,
                company_name: $scope.company_name,
                url: $scope.url,
                about: $scope.about,
                status_id: $scope.form_status,
                user_id: $scope.form_curator,
                client_id: $scope.client_id,
                see_all: $scope.see_all,
                contact: {
                    contact_id: $scope.contact_id,
                    contact_name: $scope.contact_name,
                    contact_mail: $scope.contact_mail,
                    contact_phone: $scope.contact_phone,
                    contact_position: $scope.contact_position,
                    contact_address: $scope.contact_address
                }
            };

            if ((!data.user_id) || (!data.status_id)) {
                alert('Статус и Куратор обязательно должны быть заполнены');
                return false;
            }

            sendPost('/api/save', data, function(data) {

                if (data && data.message) {
                    alert(data.message);
                }

                // $scope.client_id = data.client_id;

                if (data && data.status) {
                    $scope.closeForm();
                    $scope.show(1);
                }
            });
        };



        $scope.editClient = function(id) {
            var data = {
                id: id
            };

            $scope.BodyOver(true);

            sendPost('/api/getclient', data, function(data) {

                if (data && data.item) {
                    for (var cl in data.item) {
                        $scope[cl] = data.item[cl];
                    }
                }

                $scope.showForm = true;
            });
        };

        $scope.seeClient = function(id) {
            var data = {
                id: id
            };

            $scope.BodyOver(true);

            sendPost('/api/getclient', data, function(data) {

                if (data && data.item) {
                    for (var cl in data.item) {
                        $scope[cl] = data.item[cl];

                    }

                    for (var i = 0; i < $scope.curators.length; i++) {
                        if($scope.curators[i].id === $scope.form_curator)
                            $scope.form_curator_name = $scope.curators[i].name;
                    }

                    for (var i = 0; i < $scope.statuses.length; i++) {
                        if($scope.statuses[i].id === $scope.form_status)
                            $scope.form_status_name = $scope.statuses[i].name;
                    }
                }

                $scope.showClientBlock = true;
            });
        };


        $scope.closeForm = function() {
            $scope.showForm = false;
            $scope.BodyOver();

            $scope.name = '';
            $scope.company_name = '';
            $scope.url = '';
            $scope.about = '';

            $scope.edit_Contact = false;
            $scope.contact_id = 0;
            $scope.contact_name = '';
            $scope.contact_mail = '';
            $scope.contact_phone = '';
            $scope.contact_position = '';
            $scope.contact_address = '';
        };



        $scope.deleteContact = function(contact) {

            if (!confirm('Вы уверены что хотите удалить "' + contact.name + '"?')) {
                return false;
            }

            var data = {
                contact_id: contact.id,
            };

            sendPost('/api/deletecontact', data, function(data) {
                if (data.status) {
                    var i = $scope.form_contacts.indexOf(contact);
                    $scope.form_contacts.splice(i, 1);
                }

                if (data.message)
                    alert(data.message);
            });
        };


        $scope.deleteClient = function(client_id) {

            if (!confirm('Вы уверены что хотите удалить эту компанию?')) {
                return false;
            }

            var data = {
                client_id: client_id
            };

            sendPost('/api/deleteclient', data, function(data) {
                if (data.status) {
                    $scope.closeForm();
                    $scope.show();
                }

                if (data.message)
                    alert(data.message);
            });
        };


        $scope.editThisContact = function(contact) {
            $scope.contact_id = contact.id;
            $scope.contact_name = contact.name;
            $scope.contact_mail = contact.mail;
            $scope.contact_phone = contact.phone;
            $scope.contact_position = contact.position;
            $scope.contact_address = contact.address;

            $scope.edit_Contact = true;
        };

    }
]);