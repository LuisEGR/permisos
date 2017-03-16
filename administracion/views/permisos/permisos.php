
        <div class="col-sm-9 col-sm-offset-3 col-md-12 col-md-offset-0 main">
			<h1 class="page-header">Permisos</h1>

			<button type="button" class="btn btn-default" onclick="location.href='add_permiso.php'" data-dismiss="modal">Agregar permiso</button><br><br>


			<input type="text" ng-change="load(1, nameSearch)" ng-model="nameSearch" class="form-control" placeholder="Buscar..."
			ng-model-options='{ debounce: 300 }'/>

			<div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Key</th>
				  <th>Grupo</th>
				  <th>Pagina</th>
				  <th>Detalles</th>
                  <th>Fecha Agregado</th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="m in miembros">
                  <td>{{m.permiso_id}}</td>
                  <td>
						{{ m.permiso_key || "Vacio" }}
				  </td>
				  <td>
						<a href="#" editable-select="m.group" onshow="loadGroups()" e-ng-options="g.id_grupo as g.grupo for g in groups" onaftersave="updateGroup(m)" >
							{{ m.groupName || 'not set' }}
						</a>
				  </td>
				  <td>
						<a href="#" editable-select="m.id_pagina" onshow="loadPags(m)" e-ng-options="p.id_pagina as p.pagina for p in pags | filter:{ id_grupo: m.id_grupo }: true" onaftersave="updatePagina(m)" >
							{{ m.pagina || 'not set' }}
						</a>
				  </td>
				  <td><a href="#" editable-text="m.permiso_detalles" onaftersave="updateDetalle(m)" >{{ m.permiso_detalles || "Vacio" }}</a></td>
                  <td>{{m.fecha_agregado}}</td>

                </tr>

              </tbody>
            </table>
          </div>

	<div style='float: right;'>
		<?php include_once 'views/general/paginacion.php'; ?>
	</div>
