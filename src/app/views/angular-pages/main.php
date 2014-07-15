<nav class="navbar navbar-default" role="navigation">

    <div class=" navbar-collapse">
        <ul class="nav navbar-nav">

            <!-- Куратор -->
            <li class="navbar-form">
                <div class="form-group">
                    <label for="">Куратор</label>
                    <select class="form-control"
                            ng-model="curator"
                            ng-change="show()"
                            ng-options="sl.id as sl.name for sl in curators">
                            <option value="0">Все</option>
                    </select>
                </div>
            </li>

            <!-- Статус -->
            <li class="navbar-form">
                <div class="form-group">
                    <label for="">Статус</label>
                    <select class="form-control"
                            ng-model="status"
                            ng-change="show()"
                            ng-options="sl.id as sl.name for sl in statuses">
                            <option value="0">Все</option>
                    </select>
                </div>
            </li>
        </ul>

        <!-- Поиск -->
        <ul class="nav navbar-nav navbar-right">
            <li class="navbar-form">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Поиск" ng-model="query" ng-change="search()">
                    <button class="btn btn-default" ng-click="query=''; show(1);">
                        <span class="glyphicon glyphicon-remove"></span>
                    </button>
                </div>
            </li>
            <li>
                &nbsp;
            </li>
            <li class="navbar-form navbar-right">
                <div class="form-group">
                    <button class="btn btn-success" ng-click="showForm=true; client_id=0; BodyOver(true)">Добавить компанию</button>
                </div>
            </li>
            <li>
                &nbsp;
            </li>
        </ul>


    </div>
</nav>

<!--  -->

<ul class="pagination pagination-sm pull-left">
    <li ng-class="{active: p==page}" ng-repeat="p in pages"><a ng-click="show(p)"> {{p}} </a></li>

<!-- AJAX animation -->
    <li ng-class="{hidden : animate!=true}" class="animation pull-left col-xs-offset-1 col-xs-1 col-sm-offset-1 col-sm-1 col-md-offset-1 col-md-1 col-lg-offset-1 col-lg-1">
        <img src="/content/img/ajax-loader.gif" alt="">
    </li>
</ul>

<!--  -->

<table class="table table-striped table-hover table-bordered table-condensed">
    <tr>
        <th class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
           Название
        </th>
        <th class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            Адрес сайта
        </th>
        <th class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            Контакты
        </th>
    </tr>

    <tr ng-repeat="client in clients">
        <td>
            <span class="created_at">{{ client.created_at }}</span>
            <button type="button" class="btn btn-default btn-xs" ng-click="editClient(client.id)" ng-show="client.edit">
                <span class="glyphicon glyphicon-pencil"></span>
            </button>
            <a href="" ng-click="seeClient(client.id);">{{ client.name }}</a>
        </td>

        <td> <a href="{{ url }}" target="_blank" ng-repeat="url in client.url">{{ url }}<br></a></td>

        <td>
            <div class="well" ng-repeat="cont in client.contact">
                <i>Имя:</i>       {{ cont.name }}<br>
                <i>e-mail:</i>    {{ cont.mail }}<br>
                <i>Тел.</i>:      {{ cont.phone }}<br>
                <i>Должность:</i> {{ cont.position }}<br>
                <i>Адрес:</i> <br>
                {{ cont.address }}<br>
            </div>
        </td>
    </tr>
</table>



<!-- Form -->

<div class="litbox-form" ng-class="{hidden: showForm!=true}">

    <div class="jumbotron form-block col-xs-12 col-sm-12 col-md-10 col-lg-8">

        <a ng-click="closeForm(); editContact=false;" class="close">X</a>

        <h3>Добавить организацию</h3>
        <hr>
        <div class="form-group pull-right">
            <button class="btn btn-success" ng-click="saveClient(); editContact=false;">Сохранить</button>
            <button class="btn btn-danger" ng-click="deleteClient(client_id); editContact=false;">Удалить</button>
        </div>

        <input type="hidden" ng-model="client_id">


        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox"
                            ng-model="see_all"
                            ng-true-value="1"
                            ng-false-value="0"> Могут видеть члены других групп
                </label>
            </div>
        </div>

        <div class="form-group">
            <label for="name">Название</label>
            <input type="text" class="form-control" id="name" ng-model="name">
        </div>

        <div class="form-group">
            <label for="company_name">Полное название</label>
            <input type="text" class="form-control" id="company_name" ng-model="company_name">
        </div>


        <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <label for="">Статус</label>
            <select class="form-control"
                    ng-model="form_status"
                    ng-options="sl.id as sl.name for sl in statuses | filter:{id: '!0'}">
            </select>


            <label for="">Куратор</label>
            <select class="form-control"
                    ng-model="form_curator"
                    ng-options="sl.id as sl.name for sl in curators | filter:{id: '!0'}">
                    <option value="0">Все</option>
            </select>
        </div>


        <div class="form-group">
            <label for="url">Адрес сайта (если несколько разделять пробелом)</label>
            <input type="text" class="form-control" id="url" ng-model="url">
        </div>

        <div class="form-group">
            <label for="about">О компании</label>
            <textarea class="form-control" rows="3" id="about" ng-model="about"></textarea>
        </div>

    <!--  -->
        <ul class="nav nav-tabs" role="tablist">
            <li ng-class="{active: block_contact==true}">
                <a href="" ng-click="block_contact=true; block_history=false;">Контакты</a>
            </li>
            <li ng-class="{active: block_history==true}">
                <a href="" ng-click="block_contact=false; block_history=true;">История</a>
            </li>
        </ul>

        <div class="block" ng-class="{hidden: block_history==true}">

    <!--  -->
            <button type="button"
                    class="btn btn-primary"
                    ng-click="edit_Contact=true"
                    ng-class="{hidden: edit_Contact==true}">Добавить контакт</button>
            <br>
            <br>
            <div class="alert alert-info" ng-class="{hidden: edit_Contact!=true}">

                <button class="btn btn-danger pull-right" ng-click="edit_Contact=false; contact_id=0; contact_name=''; contact_mail=''; contact_phone=''; contact_position=''; contact_address='';">
                    <span class="glyphicon glyphicon-remove"></span>
                </button>

                <input type="hidden" ng-model="contact_id" value="0">

                <br>
                <div class="form-group">
                    <label for="contact_name">Имя</label>
                    <input type="text" class="form-control" id="contact_name" ng-model="contact_name">
                </div>

                <div class="form-group">
                    <label for="contact_mail">email</label>
                    <input type="text" class="form-control" id="contact_mail" ng-model="contact_mail">
                </div>

                <div class="form-group">
                    <label for="contact_phone">Телефон</label>
                    <input type="text" class="form-control" id="contact_phone" ng-model="contact_phone">
                </div>

                <div class="form-group">
                    <label for="contact_position">Должность</label>
                    <input type="text" class="form-control" id="contact_position" ng-model="contact_position">
                </div>

                <div class="form-group">
                    <label for="client_address">Адрес</label>
                    <textarea class="form-control" rows="3" id="contact_address" ng-model="contact_address"></textarea>
                </div>
            </div>

            <hr>

            <div class="well" ng-repeat="cont in form_contacts">
                <a class="btn btn-danger pull-right" ng-click="deleteContact(cont)">
                    <span class="glyphicon glyphicon-remove"></span>
                </a>

                <a class="btn btn-info pull-right" ng-click="editThisContact(cont)">
                    <span class="glyphicon glyphicon-pencil"></span>
                </a>

                <i>Имя:</i>       {{ cont.name }}<br>
                <i>e-mail:</i>    {{ cont.mail }}<br>
                <i>Тел.</i>:      {{ cont.phone }}<br>
                <i>Должность:</i> {{ cont.position }}<br>
                <i>Адрес:</i> <br>
                {{ cont.address }}<br>
            </div>
        </div>


        <div class="block" ng-class="{hidden: block_contact==true}">
            <div class="list-group">
               <span class="list-group-item" ng-repeat="hist in history">
                    <span class="created_at">{{hist.created_at}}</span>
                   {{hist.event}}
               </span>
           </div>
       </div>

    </div>
</div>

<!-- @Form -->


<!-- SeeForm -->
<div class="litbox-form" ng-class="{hidden: showClientBlock!=true}">

    <div class="jumbotron form-block col-xs-12 col-sm-12 col-md-10 col-lg-8">
        <a ng-click="closeForm(); showClientBlock=false;" class="close">X</a>

        <button type="button" class="btn btn-default btn-xs"
                ng-click="showClientBlock=false; editClient(client_id)"
                ng-show="client_edit">
            <span class="glyphicon glyphicon-pencil"></span>
        </button>

        <h2>{{name}}</h2>

        <table class="table table-striped table-hover table-bordered table-condensed">
            <tr>
                <td class="col-xs-5 col-sm-5 col-md-5 col-lg-5">Полное название</td>
                <td>{{company_name}}</td>
            </tr>
            <tr>
                <td>Куратор</td>
                <td>{{form_curator_name}}</td>
            </tr>
            <tr>
                <td>Статус</td>
                <td>{{form_status_name}}</td>
            </tr>
            <tr>
                <td>Могут видеть члены других групп</td>
                <td>{{ (see_all==1)? '&#10004;' : '&#10006;' }}</td>
            </tr>
            <tr>
                <td>Адрес сайта</td>
                <td>{{url}}</td>
            </tr>
            <tr>
                <td>О компании</td>
                <td>{{about}}</td>
            </tr>
        </table>

        <ul class="nav nav-tabs" role="tablist">
            <li ng-class="{active: block_contact==true}">
                <a href="" ng-click="block_contact=true; block_history=false;">Контакты</a>
            </li>
            <li ng-class="{active: block_history==true}">
                <a href="" ng-click="block_contact=false; block_history=true;">История</a>
            </li>
        </ul>

        <div class="block" ng-class="{hidden: block_history==true}">
            <div class="well" ng-repeat="cont in form_contacts">
                <i>Имя:</i>       {{ cont.name }}<br>
                <i>e-mail:</i>    {{ cont.mail }}<br>
                <i>Тел.</i>:      {{ cont.phone }}<br>
                <i>Должность:</i> {{ cont.position }}<br>
                <i>Адрес:</i> <br>
                {{ cont.address }}<br>
            </div>
        </div>

        <div class="block" ng-class="{hidden: block_contact==true}">
            <div class="list-group">
               <span class="list-group-item" ng-repeat="hist in history">
                    <span class="created_at">{{hist.created_at}}</span>
                   {{hist.event}}
               </span>
           </div>
       </div>

    </div>
</div>

<!-- @SeeForm -->












