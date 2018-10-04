<!DOCTYPE html>
<html lang="es">
<head>
	<?php include "header.php"; ?>
	<script src="js/funcionesprov.js"></script>
</head>
<body>
	<?php include "barranav.php"; ?>
	<div class="container" style="margin-top:50px">
		<div class="row">
			<div class="col-md-9">  
				<h2 class="sub-header">Proveedores</h2>
				<div class="table-responsive">
					<button type="button" id="crea-prov" class="btn btn-sm btn-primary"
					data-toggle="modal" data-target="#myModal" >NUEVO</button> 
					<table class="table table-striped">
						<thead>
							<tr>
								<th width="10%">Rut</th>
								<th width="50%">Nombre</th>
								<th width="25%">Nombre Contacto</th>
								<th width="15%">Acciones</th>
							</tr>
						</thead>
						<tbody id="listaprov">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title-form" id="myModalLabel">Proveedores</h4>
				</div>
				<form role="form" name="formProv" id="formProv" method="post" action="">
					<input type="hidden" name="provId" id="provId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="form-group">
							<label for="provRut">Rut</label>
							<input id="provRut" name="provRut" class="form-control" title="Ingrese un Rut" />
						</div>
						<div class="form-group">
							<label for="provNombre">Nombre</label>
							<input id="provNombre" class="form-control" type="text" name="provNombre" value="" title="Ingrese un nombre" required />
						</div>
						<div class="form-group">
							<label for="provFono">Telefono</label>
							<input id="provFono" class="form-control" type="text" name="provFono" value="" title="Ingrese un nombre" required />
						</div>						
						<div class="form-group">
							<label for="provDireccion">Dirección</label>
							<input id="provDireccion" class="form-control" type="text" name="provDireccion" value="" title="Ingrese un nombre" required />
						</div>
						<div class="form-group">
							<label for="provCiudad">Ciudad</label>
							<input id="provCiudad" class="form-control" type="text" name="provCiudad" value="" title="Ingrese un nombre" required />
						</div>
						<div class="form-group">
							<label for="provRegion">Región</label>
							<input id="provRegion" class="form-control" type="text" name="provRegion" value="" title="Ingrese un nombre" required />
						</div>
						<div class="form-group">
							<label for="provCuenta">Cuenta</label>
							<input id="provCuenta" class="form-control" type="text" name="provCuenta" value="" title="Ingrese un nombre" required />
						</div>
						<div class="form-group">
							<label for="provContNombre">Nombre Contacto</label>
							<input id="provContNombre" class="form-control" type="text" name="provContNombre" value="" title="Ingrese un nombre" required />
						</div>
						<div class="form-group">
							<label for="provContEmail">Email Contacto</label>
							<input id="provContEmail" class="form-control" type="text" name="provContEmail" value="" title="Ingrese un nombre" required />
						</div>
						<div class="form-group">
							<label for="provContFono">Telefono Contacto</label>
							<input id="provContFono" class="form-control" type="text" name="provContFono" value="" title="Ingrese un nombre" required />
						</div>
						<div class="form-group">
							<label for="provEstado">Estado</label>
							<input id="provEstado" class="form-control" type="text" name="provEstado" value="" title="Ingrese un nombre" required />
						</div>						
					</div>
					<div class="modal-footer">
						<button id="editar-prov" name="editar-prov" type="button" class="btn btn-warning">Editar</button>
					    <button id="actualizar-prov" name="actualizar-prov" type="button" class="btn btn-primary">Actualizar</button> 
						<button id="guardar-prov" name="guardar-prov" type="button" class="btn btn-primary">Guardar</button>
						<button id="cancel" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
   <!-- Modal DELETE -->
	<div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalDeleteLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalDeleteLabel">Eliminación de Proveedor</h4>
				</div>
				<form role="form" name="formDeleteProv" id="formDeleteProv" method="post" action="">
					<input type="hidden" name="provId" id="provId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="input-group">
							<label for="pregunta">¿Está seguro de eliminar el Proveedor seleccionado?</label>
						</div>       
						<div class="input-group">
							<label for="nameprov">Nombre Proveedor</label>
							<input type="text" class="form-control" id="nameprov" name="nameprov" placeholder="" readonly>
						</div>
					</div>
					<div class="modal-footer">
						<button id="eliminar-prov" name="eliminar-prov" type="button" class="btn btn-primary">Aceptar</button>
						<button id="cancel" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

    <!-- Modal mensajes cortos-->
	<div class="modal fade" id="myModalLittle" tabindex="-1" role="dialog" aria-labelledby="myModalLittleLabel">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Mensaje</h4>
				</div>
				<div class="modal-body">
					<p id="msg" class="msg"></p>
				</div>
				<div class="modal-footer">
					<button type="button" id="cerrarModalLittle" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
</body>
</html>