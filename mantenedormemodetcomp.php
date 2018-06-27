<!DOCTYPE html>
<html lang="es">
<head>
	<?php include "header.php"; ?>
	<script src="js/funcionesmemodetcomp.js"></script>
</head>
<body>
	<?php include "barranav.php"; ?>
	<div class="container" style="margin-top:50px">
		<div class="row">
			<div class="col-md-9">  
				<h2 class="sub-header">Detalle Compra</h2>
				<div class="table-responsive">
					<button type="button" id="crea-memodetcomp" class="btn btn-sm btn-primary"
					data-toggle="modal" data-target="#myModal" >NUEVO</button> 
					<table class="table table-striped">
						<thead>
							<tr>
								<th width="20%">Producto</th>
								<th width="20%">Cantidad</th>
								<th width="20%">Valor</th>
								<th width="20%">Total</th>
								<th width="20%">Acciones</th>
							</tr>
						</thead>
						<tbody id="listamemodetcomp">
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
					<h4 class="modal-title-form" id="myModalLabel">Detalle Compra</h4>
				</div>
				<form role="form" name="formMemoDetComp" id="formMemoDetComp" method="post" action="">
					<input type="hidden" name="detcompId" id="detcompId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="form-group">
							<label for="detcompNombre">Producto</label>
							<input id="detcompNombre" class="form-control" type="text" name="detcompNombre" value="" title="Ingrese un nombre" required />
						</div>
						<div class="form-group">
							<label for="detcompCant">Cantidad</label>
							<input id="detcompCant" name="detcompCant" class="form-control" value=""  title="Ingrese una cantidad" />
						</div>
						<div class="form-group">
							<label for="detcompValor">Valor</label>
							<input id="detcompValor" name="detcompValor" class="form-control" value=""  title="Ingrese un valor" />
						</div>
						<div class="form-group">
							<label for="detcompTotal">Total</label>
							<input id="detcompTotal" name="detcompTotal" class="form-control" value=""  title="Ingrese un total" />
						</div>

					</div>
					<div class="modal-footer">
						<button id="editar-memodetcomp" name="editar-memodetcomp" type="button" class="btn btn-warning">Editar</button>
						<button id="actualizar-memodetcomp" name="actualizar-memodetcomp" type="button" class="btn btn-primary">Actualizar</button>
						<button id="guardar-memodetcomp" name="guardar-memodetcomp" type="button" class="btn btn-primary">Guardar</button>
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
					<h4 class="modal-title" id="myModalDeleteLabel">Eliminación de Detalle Compra</h4>
				</div>
				<form role="form" name="formDeleteMemoDetComp" id="formDeleteMemoDetComp" method="post" action="">
					<input type="hidden" name="detcompId" id="detcompId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="input-group">
							<label for="pregunta">¿Está seguro de eliminar el Detalle Compra seleccionado?</label>
						</div>       
						<div class="input-group">
							<label for="namememodetcomp">Detalle Compra</label>
							<input type="text" class="form-control" id="namememodetcomp" name="namememodetcomp" placeholder="" readonly>
						</div>
					</div>
					<div class="modal-footer">
						<button id="eliminar-memodetcomp" name="eliminar-memodetcomp" type="button" class="btn btn-primary">Aceptar</button>
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
