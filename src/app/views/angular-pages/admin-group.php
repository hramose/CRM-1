<div class="jumbotron-a">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 well">
        <span>Пользователи без группы</span>

        <div class="list-group">
           <span class="list-group-item" ng-repeat="usr in not_group">
                {{usr.username}}
                <span class="pull-right">
                    <a href="" ng-click="addToGroup(usr.id)">Добавить в группу</a>
                </span>
           </span>
       </div>
    </div>
    <!--  -->
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 well">
        <span>Члены моей группы</span>

        <div class="list-group">
           <span class="list-group-item" ng-repeat="usr in group">
                {{usr.username}}
                <span class="pull-right">
                    <a href="" ng-click="removeFromGroup(usr.id)">Удалить из группы</a>
                </span>
           </span>
       </div>
    </div>
     <div class="clearfix visible-xs-block"></div>
</div>