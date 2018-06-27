<!DOCTYPE html>
<html lang="es">
<head>
	<?php include "header.php"; ?>
	<script src="js/funcionesmemodetarch.js"></script>
</head>
<body>
	<?php include "barranav.php"; ?>
	<div class="container" style="margin-top:50px">
		<div class="row">
			<div class="col-md-9">  
				<h2 class="sub-header">Memo Detalle Archivo</h2>
				<div class="table-responsive">
					<button type="button" id="crea-memodetarch" class="btn btn-sm btn-primary"
					data-toggle="modal" data-target="#myModal" >NUEVO</button> 
					<table class="table table-striped">
						<thead>
							<tr>
								<th width="50%">URL</th>
								<th width="50%">Acciones</th>
							</tr>
						</thead>
						<tbody id="listamemodetarch">
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
					<h4 class="modal-title-form" id="myModalLabel">Memo Detalle Archivo</h4>
				</div>
				<form role="form" name="formMemoDetArch" id="formMemoDetArch" method="post" action="">
					<input type="hidden" name="memodetarchId" id="memodetarchId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="form-group">
							<label for="memodetarchUrl">URL</label>
							<input id="memodetarchUrl" class="form-control" type="text" name="memodetarchUrl" value="" title="Ingrese un URL" required />
						</div>
					</div>
					<div class="modal-footer">
						<button id="editar-memodetarch" name="editar-memodetarch" type="button" class="btn btn-warning">Editar</button>
						<button id="actualizar-memodetarch" name="actualizar-memodetarch" type="button" class="btn btn-primary">Actualizar</button>
						<button id="guardar-memodetarch" name="guardar-memodetarch" type="button" class="btn btn-primary">Guardar</button>
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
					<h4 class="modal-title" id="myModalDeleteLabel">Eliminación de Memo Detalle Archivo</h4>
				</div>
				<form role="form" name="formDeleteMemoDetArch" id="formDeleteMemoDetArch" method="post" action="">
					<input type="hidden" name="memodetarchId" id="memodetarchId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="input-group">
							<label for="pregunta">¿Está seguro de eliminar el Memo Detalle Archivo seleccionado?</label>
						</div>       
						<div class="input-group">
							<label for="namememodetarch">Nombre Memo Detalle Archivo</label>
							<input type="text" class="form-control" id="namememodetarch" name="namememodetarch" placeholder="" readonly>
						</div>
					</div>
					<div class="modal-footer">
						<button id="eliminar-memodetarch" name="eliminar-memodetarch" type="button" class="btn btn-primary">Aceptar</button>
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