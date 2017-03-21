        <div class="col-sm-9 col-sm-offset-2 col-md-10 col-md-offset-1 main">
          <h1 class="page-header">Agregar Grupo</h1>





	<form name="saveGrupo" class="css-form" novalidate>

	<div class="form-group">
		<label for="observaciones">Grupo</label>
		  <input type="text" ng-model="formData.grupo" name="grupo" class="form-control" placeholder="Grupo"  required=""/>
		<div ng-show="saveGrupo.$submitted || saveGrupo.permiso_key.$touched">
		  <div ng-show="saveGrupo.permiso_key.$error.required">Este es un campo requerido.</div>
		</div>
	</div>

	<button type="button" class="btn btn-default" onclick="location.href='../'"  >Regresar</button>
	<button type="submit" class="btn btn-default" ng-click='submitForm(saveGrupo.$valid); ' id='btnSubmit' >Guardar</button>

  </form>
