        <div class="col-sm-9 col-sm-offset-2 col-md-10 col-md-offset-1 main">
          <h1 class="page-header">Agregar Permiso</h1>





	<form name="savePermiso" class="css-form" novalidate>

	<div class="form-group">
	  <label for="id_pagina">Pagina:</label>
	  <select class="form-control" id="id_pagina" name="id_pagina"
	  ng-model="formData.id_pagina"

	  required="" >
		  <option value="" >Selecciona una opci&oacute;n</option>
		  <optgroup label="P&aacute;ginas">
		  <option ng-repeat = "p in catPags"value="{{p.id_pagina}}" >{{p.pagina}}</option>
		  </optgroup>
		  <option value="-1" >Otro ...</option>		  
	  </select>
	  	<div ng-show="savePermiso.$submitted || savePermiso.id_pagina.$touched">
		  <div ng-show="savePermiso.id_pagina.$error.required">Este es un campo requerido.</div>
		</div>
	</div>
	
	<div ng-show='formData.id_pagina==-1' >
		
		
		<div class="panel panel-default">
			<div class="panel-heading">Agregar Grupo</div>
			<div class="panel-body">			
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
				<a href='' ng-click='getGrupos()' data-toggle="modal" data-target="#modalAddPage" >Agregar p&aacute;gina</a>			
			</div>
		</div>
		
	</div>

	<div class="form-group">
		<label for="item">Item</label>
		  <input type="text" ng-model="formData.item" name="item" class="form-control" placeholder="Item" required="" />
		<div ng-show="savePermiso.$submitted || savePermiso.item.$touched">
		  <div ng-show="savePermiso.item.$error.required">Este es un campo requerido.</div>
		</div>
	</div>


	<button type="button" class="btn btn-default" onclick="location.href='../'"  >Regresar</button>
	<button type="submit" class="btn btn-default" ng-click='submitForm(savePermiso.$valid); ' id='btnSubmit' >Guardar</button>

  </form>
