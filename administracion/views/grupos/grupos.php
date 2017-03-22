
        <div class="col-sm-9 col-sm-offset-3 col-md-12 col-md-offset-0 main">
			<h1 class="page-header">Grupos</h1>

			<button type="button" class="btn btn-default" onclick="location.href='agregar'" data-dismiss="modal">Agregar grupo</button><br><br>


			<input type="text" ng-change="load(1, nameSearch)" ng-model="nameSearch" class="form-control" placeholder="Buscar..."
			ng-model-options='{ debounce: 300 }'/>

			<div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Grupo</th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="m in miembros">
                  <td>{{m.id_grupo}}</td>
				  <td><a href="#" editable-text="m.grupo" onaftersave="updateGrupo(m)" >{{ m.grupo || "Vacio" }}</a></td>
                  <td>{{m.fecha_agregado}}</td>

                </tr>

              </tbody>
            </table>
          </div>

	<div style='float: right;'>
		<?php include_once '../views/general/paginacion.php'; ?>
	</div>
