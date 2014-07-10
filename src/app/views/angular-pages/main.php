<nav class="navbar navbar-default" role="navigation">

    <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav  col-xs-6 col-sm-6 col-md-6 col-lg-6">

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
        <ul class="nav navbar-nav navbar-right  col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <li class="navbar-form">
                <div class="form-group">
                    <input type="text" class="form-control search-model" placeholder="Отфильтровать по названию" ng-model="search.name">
                </div>
            </li>
            <li>
                &nbsp;
            </li>
            <li class="navbar-form navbar-right">
                <div class="form-group">
                    <button class="btn btn-success">Добавить компанию</button>
                </div>
            </li>
            <li>
                &nbsp;
            </li>
        </ul>


    </div>
</nav>

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

    <tr ng-repeat="client in clients | filter:search | orderBy:created_at:true">
        <td>
            <span class="created_at">{{ client.created_at }}</span>  {{ client.name }}
        </td>

        <td> <a href="{{ url }}" target="_blank" ng-repeat="url in client.url">{{ url }}<br></a></td>

        <td>
            <div class="well" ng-repeat="cont in client.contact">
                <b>Имя:</b>       {{ cont.name }}<br>
                <b>e-mail:</b>    {{ cont.mail }}<br>
                <b>Тел.</b>:      {{ cont.phone }}<br>
                <b>Должность:</b> {{ cont.position }}<br>
                <b>Адрес:</b> <br>
                {{ cont.address }}<br>
            </div>
        </td>
    </tr>
</table>
















