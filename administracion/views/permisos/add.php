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
		  <option ng-repeat = "p in catPags"value="{{p.id_pagina}}" >{{p.grupo}} - {{p.pagina}}</option>
		  </optgroup>
		  <option value="-1" >Otra ...</option>		  
	  </select>
	  	<div ng-show="savePermiso.$submitted || savePermiso.id_pagina.$touched">
		  <div ng-show="savePermiso.id_pagina.$error.required">Este es un campo requerido.</div>
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

  
  
  
  <br><br>
  
  	<div ng-show='formData.id_pagina==-1' >
	
	<div class="panel panel-default">

				<div class="panel-heading">Agregar Pagina</div>
			<div class="panel-body">

	<form name="savePagina" class="css-form" novalidate>

	
	<div class="form-group">
	  <label for="id_grupo">Grupo:</label>
	  <select class="form-control" id="id_grupo" name="id_grupo"  ng-change="getPagesGroup( formData.id_grupo )" ng-model="formData.id_grupo" required="" >
		  <option value="" >Selecciona una opci&oacute;n</option>
		  <optgroup label="Grupos">
		  <option ng-repeat = "p in catGrupos"value="{{p.id_grupo}}" >{{p.grupo}}</option>
		  </optgroup>
		  <option value="-1" >Otro ...</option>		
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

	<div class="panel panel-default" >
	<div class="table-responsive">
		<table class="table table-striped">
		  <thead>
			<tr>
			  <th>ID</th>
			  <th>P&aacute;gina</th>
			</tr>
		  </thead>
		  <tbody>
			<tr ng-repeat='c in catPags2'>
			  <td class="ng-binding">{{c.id_pagina}}</td>
			  <td class="ng-binding">{{c.pagina}}</td>			  
			</tr>

		  </tbody>
		</table>
	</div>
</div>
	
	<button type="button" style='display:none' class="btn btn-default" onclick=""  >Cancelar</button>
	<button type="submit" class="btn btn-default" ng-click='submitAddPagina(savePagina.$valid); ' id='btnSubmitPagina' >Guardar</button>

  </form>
</div>
</div>
	
		
			
	</div>
	
	
	
	
	<div ng-show='formData.id_grupo==-1' >
	
	
	<div class="panel panel-default">
			<div class="panel-heading">Agregar Grupo</div>
			<div class="panel-body">			
				<form name="saveGrupo" class="css-form" novalidate>

				<div class="form-group">
					<label for="grupo">Grupo</label>
					  <input type="text" ng-model="formData.grupo" name="grupo" class="form-control" placeholder="Grupo"  required=""/>
					<div ng-show="saveGrupo.$submitted || saveGrupo.grupo.$touched">
					  <div ng-show="saveGrupo.grupo.$error.required">Este es un campo requerido.</div>
					</div>
				</div>

				<button type="submit" class="btn btn-default" ng-click='submitFormGrupo(saveGrupo.$valid); ' id='btnSubmit2' >Guardar</button>
				</form>
							
			</div>
		</div>
	
	</div>