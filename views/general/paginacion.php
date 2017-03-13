
<ul class="pagination">
  <li ng-class="classPage(p.page)" ng-repeat="p in pages" ng-click='load( ( p.page ) )'><a href="#">{{p.label}}</a></li>
</ul>