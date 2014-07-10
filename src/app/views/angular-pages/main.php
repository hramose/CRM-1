<nav class="navbar navbar-default" role="navigation">

    <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav">

            <li class="navbar-form col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <div class="form-group">
                    <label for="">Куратор</label>
                    <select class="form-control"
                            ng-model="curator"
                            ng-options="sl.id as sl.name for sl in curators">
                            <option value="0">Все</option>
                    </select>
                </div>
            </li>

            <li class="navbar-form col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <div class="form-group">
                    <label for="">Статус</label>
                    <select class="form-control"
                            ng-model="status"
                            ng-options="sl.id as sl.name for sl in statuses">
                            <option value="0">Все</option>
                    </select>
                </div>
            </li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
            <li class="navbar-form">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Найти компанию">
                </div>
                <button type="submit" class="btn btn-info">
                    <span class="glyphicon glyphicon-search"></span> поиск
                </button>
            </li>
            <li>
                &nbsp;
            </li>
            <li class="navbar-form">
                <div class="form-group">
                    <button class="btn btn-success">Добавить</button>
                </div>
            </li>
            <li>
                &nbsp;
            </li>
        </ul>


    </div>
</nav>


<!--  -->
<ul class="pagination">
    <li ng-class="{active: pg==page}" ng-repeat="pg in pages"><a ng-click="rePage(pg, true)">{{ pg }}</a></li>
</ul>
<!--  -->


<table class="table table-striped table-hover table-bordered table-condensed">
    <tr>
        <th class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
           Название
        </th>
        <th class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            Адрес сайта
        </th>
        <th class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            Контакты
        </th>
    </tr>

    <tr ng-repeat="client in clients">
        <td>{{ client.name }}</td>
        <td>{{ client.url }}</td>
        <td>{{ client.contact }}</td>
    </tr>
</table>