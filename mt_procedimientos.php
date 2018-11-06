<!DOCTYPE html>
<html lang="es">
<head>
	<?php include "header.php"; ?>
	<script src="js/fn_mt_procedimientos.js"></script>
</head>
<body>
	<?php include "barranav.php"; ?>
	<div class="container" style="margin-top:50px">
		<div class="row">
			<div class="col-md-10">  
				<h2 class="sub-header">Procedimiento de Compras</h2>
				<div class="table-responsive">
					<button type="button" id="crea-proccomp" class="btn btn-sm btn-primary"
					data-toggle="modal" data-target="#myModal" >NUEVO</button> 
					<table class="table table-striped">
						<thead>
							<tr>
								<th width="30%">Nombre Procedimiento</th>
								<th width="30%">Descripcion</th>
								<th width="10%">Orden</th>
								<th width="10%">Activo</th>
								<th width="20%">Acciones</th> 
							</tr>
						</thead>
						<tbody id="listaproccomp">
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
					<h4 class="modal-title-form" id="myModalLabel">Procedimiento de Compras</h4>
				</div>
				<form role="form" name="formProcComp" id="formProcComp" method="post" action="">
					<input type="hidden" name="proccompId" id="proccompId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="form-group">
							<label for="proccompTipo">Nombre Procedimiento</label>
							<input id="proccompTipo" class="form-control" type="text" name="proccompTipo" value="" title="Ingrese un Tipo" required />
						</div>
						<div class="form-group">
							<label for="proccompDescrip">Descripción</label>
							<input id="proccompDescrip" class="form-control" type="text" name="proccompDescrip" value="" title="Ingrese un Tipo" required />
						</div>						
						<div class="form-group">
							<label for="proccompOrden">Orden</label>
							<input id="proccompOrden" class="form-control" type="number" name="proccompOrden" value="" title="Ingrese prioridad" required />
						</div>						
						<div class="form-group">
							<label for="proccompActivo">Activo</label>
							<select name="proccompActivo" id="proccompActivo" class="form-control">
								<option value="0">NO</option>
								<option value="1" selected>SI</option>
							</select>
						</div>						
					</div>
					<div class="modal-footer">
						<button id="editar-proccomp" name="editar-proccomp" type="button" class="btn btn-warning">Editar</button>
						<button id="actualizar-proccomp" name="actualizar-proccomp" type="button" class="btn btn-primary">Actualizar</button>
						<button id="guardar-proccomp" name="guardar-proccomp" type="button" class="btn btn-primary">Guardar</button>
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
					<h4 class="modal-title" id="myModalDeleteLabel">Eliminación de Procedimiento de Compras</h4>
				</div>
				<form role="form" name="formDeleteProcComp" id="formDeleteProcComp" method="post" action="">
					<input type="hidden" name="proccompId" id="proccompId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="input-group">
							<label for="pregunta">¿Está seguro de eliminar el Procedimiento de Compra seleccionado?</label>
						</div>       
						<div class="input-group">
							<label for="nameproccomp">Nombre Procedimiento de Compra</label>
							<input type="text" class="form-control" id="nameproccomp" name="nameproccomp" placeholder="" readonly>
						</div>
					</div>
					<div class="modal-footer">
						<button id="eliminar-proccomp" name="eliminar-proccomp" type="button" class="btn btn-primary">Aceptar</button>
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