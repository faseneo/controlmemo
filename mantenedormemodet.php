<!DOCTYPE html>
<html lang="es">
<head>
	<?php include "header.php"; ?>
	<script src="js/funcionesmemodet.js"></script>
</head>
<body>
	<?php include "barranav.php"; ?>
	<div class="container" style="margin-top:50px">
		<div class="row">
			<div class="col-md-9">  
				<h2 class="sub-header">Memo Detalle</h2>
				<div class="table-responsive">
					<button type="button" id="crea-memodet" class="btn btn-sm btn-primary"
					data-toggle="modal" data-target="#myModal" >NUEVO</button> 
					<table class="table table-striped">
						<thead>
							<tr>
								<th width="10%">Descripción</th>
								<th width="10%">Número OC CHC</th>
								<th width="10%">Fecha CDP</th>
								<th width="10%">Número OC Manager</th>
								<th width="10%">Número Factura</th>
								<th width="10%">Fecha Factura</th>
								<th width="10%">Monto Total</th>
								<th width="20%">Observaciones</th>
								<th width="10%">Acciones</th>
							</tr>
						</thead>
						<tbody id="listamemodet">
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
					<h4 class="modal-title-form" id="myModalLabel">Memo Detalle</h4>
				</div>
				<form role="form" name="formMemoDet" id="formMemoDet" method="post" action="">
					<input type="hidden" name="memodetId" id="memodetId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="form-group">
							<label for="memodetDesc">Descripción</label>
							<input id="memodetDesc" class="form-control" type="text" name="memodetDesc" value="" title="Ingrese una descripción" required />
						</div>
						<div class="form-group">
							<label for="memodetNumOcChc">Número OC CHC</label>
							<input id="memodetNumOcChc" name="memodetNumOcChc" class="form-control" value=""  title="Ingrese un Número" />
						</div>
						<div class="form-group">
							<label for="memodetCdp">Fecha CDP</label>
							<input id="memodetCdp" class="form-control" type="text" name="memodetCdp" value="" title="Ingrese una fecha" required />
						</div>
						<div class="form-group">
							<label for="memodetNumOcMan">Número OC Manager</label>
							<input id="memodetNumOcMan" class="form-control" type="text" name="memodetNumOcMan" value="" title="Ingrese un número" required />
						</div>
						<div class="form-group">
							<label for="memodetNumFact">Número Factura</label>
							<input id="memodetNumFact" class="form-control" type="text" name="memodetNumFact" value="" title="Ingrese un número" required />
						</div>
						<div class="form-group">
							<label for="memodetFechFact">Fecha Factura</label>
							<input id="memodetFechFact" class="form-control" type="text" name="memodetFechFact" value="" title="Ingrese una fecha" required />
						</div>
						<div class="form-group">
							<label for="memodetMonTotal">Monto Total</label>
							<input id="memodetMonTotal" class="form-control" type="text" name="memodetMonTotal" value="" title="Ingrese un monto" required />
						</div>
						<div class="form-group">
							<label for="memodetObs">Observaciones</label>
							<input id="memodetObs" class="form-control" type="text" name="memodetObs" value="" title="Ingrese una observación" required />
						</div>

					</div>
					<div class="modal-footer">
						<button id="editar-memodet" name="editar-memodet" type="button" class="btn btn-warning">Editar</button>
						<button id="actualizar-memodet" name="actualizar-memodet" type="button" class="btn btn-primary">Actualizar</button>
						<button id="guardar-memodet" name="guardar-memodet" type="button" class="btn btn-primary">Guardar</button>
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
					<h4 class="modal-title" id="myModalDeleteLabel">Eliminación de Memo Detalle</h4>
				</div>
				<form role="form" name="formDeleteMemoDet" id="formDeleteMemoDet" method="post" action="">
					<input type="hidden" name="memodetId" id="memodetId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="input-group">
							<label for="pregunta">¿Está seguro de eliminar el Memo Detalle seleccionado?</label>
						</div>       
						<div class="input-group">
							<label for="namememodet">Nombre Memo Detalle</label>
							<input type="text" class="form-control" id="namememodet" name="namememodet" placeholder="" readonly>
						</div>
					</div>
					<div class="modal-footer">
						<button id="eliminar-memodet" name="eliminar-memodet" type="button" class="btn btn-primary">Aceptar</button>
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