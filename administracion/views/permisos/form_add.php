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
		Otro
	</div>

	<div class="form-group">
		<label for="item">Item</label>
		  <input type="text" ng-model="formData.item" name="item" class="form-control" placeholder="Item" required="" />
		<div ng-show="savePermiso.$submitted || savePermiso.item.$touched">
		  <div ng-show="savePermiso.item.$error.required">Este es un campo requerido.</div>
		</div>
	</div>


	<button type="button" class="btn btn-default" onclick="location.href='../'"  >Regresar</button>
	<button type="submit" class="btn btn-default" ng-click='submitAddPermiso(savePermiso.$valid); ' id='btnSubmitAddPermiso' >Guardar</button>

  </form>
