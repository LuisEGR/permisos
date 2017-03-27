
        <div class="col-sm-9 col-sm-offset-3 col-md-12 col-md-offset-0 main">
			<h1 class="page-header">Permisos</h1>

			<img src='/img/door-key.png' onclick="location.href='agregar'"  class='btnImg' style='float: right;padding: 10px;cursor:pointer;'><br><br>

			<input type="text" ng-change="load(1, nameSearch)" ng-model="nameSearch" class="form-control" placeholder="Buscar..."
			ng-model-options='{ debounce: 300 }'/>
			
			

			<div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Key</th>
				  <th>Grupo</th>
				  <th>P&aacute;gina </th>
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
				  <td>{{m.groupName}}
				  <td>
						<a href="#" editable-select="m.id_pagina" onshow="loadPags()" e-ng-options="p.id_pagina as p.pagina for p in pags" onaftersave="updatePagina(m)" >
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
	

	<div >
		<?php include_once 'views/permisos/modal_addPermiso.php'; ?>
	</div>
	
	<div >
		<?php //include_once 'views/permisos/modal_addGrupo.php'; ?>
	</div>
	
	<div >
		<?php include_once 'views/paginas_sistema/modal_addPage.php'; ?>
	</div>
	
