        <div class="col-sm-9 col-sm-offset-2 col-md-10 col-md-offset-1 main">
          <h1 class="page-header">Agregar Pagina</h1>





	<form name="savePagina" class="css-form" novalidate>

	
	<div class="form-group">
	  <label for="id_grupo">Grupo:</label>
	  <select class="form-control" id="id_grupo" name="id_grupo" ng-model="formData.id_grupo" ng-options="p.id_grupo as p.grupo for p in catGrupos track by p.id_grupo" required="" >
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

	<button type="button" class="btn btn-default" onclick="location.href='../'"  >Regresar</button>
	<button type="submit" class="btn btn-default" ng-click='submitForm(savePagina.$valid); ' id='btnSubmit' >Guardar</button>

  </form>
