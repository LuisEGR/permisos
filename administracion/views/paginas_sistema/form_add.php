	<form name="savePagina" class="css-form" novalidate>

	
	<div class="form-group">
	  <label for="id_grupo">Grupo:</label>
	  <select class="form-control" id="id_grupo" name="id_grupo"  ng-change="update()" ng-model="formData.id_grupo" ng-options="p.id_grupo as p.grupo for p in catGrupos track by p.id_grupo" required="" >
		  <option value="" >Selecciona una opci&oacute;n</option>
	  </select>
	  	<div ng-show="savePagina.$submitted || savePagina.id_grupo.$touched">
		  <div ng-show="savePagina.id_grupo.$error.required">Este es un campo requerido.</div>
		</div>
	</div>
	
	<div class="form-group">
		<label for="observaciones">Pagina</label>
		  <input type="text" ng-model="formData.pagina" name="pagina" class="form-control" placeholder="Pagina"  required=""/>
		<div ng-show="savePagina.$submitted || savePagina.pagina.$touched">
		  <div ng-show="savePagina.pagina.$error.required">Este es un campo requerido.</div>
		</div>
	</div>

	<div class="panel panel-default">
	<div class="table-responsive">
		<table class="table table-striped">
		  <thead>
			<tr>
			  <th>ID</th>
			  <th>Posición</th>
			  <th>Clave</th>
			  <th>Nombre</th>
			</tr>
		  </thead>
		  <tbody>
			<tr>
			  <td class="ng-binding">32</td>
			  <td class="ng-binding">Asistente de Biomédica</td>
			  <td class="ng-binding">NOC-BM</td>
			  <td class="ng-binding">Leonel  González </td>
			  
			</tr>

		  </tbody>
		</table>
	</div>
</div>
	
	<button type="button" style='display:none' class="btn btn-default" onclick=""  >Cancelar</button>
	<button type="submit" class="btn btn-default" ng-click='submitForm(savePagina.$valid); ' id='btnSubmit' >Guardar</button>

  </form>