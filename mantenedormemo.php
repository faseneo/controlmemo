<!DOCTYPE html>
<html lang="es">
<head>
	<?php include "header.php"; ?>
	<script src="js/funcionesmemo.js"></script>
</head>
<body>
	<?php include "barranav.php"; ?>
	<div class="container" style="margin-top:50px">
		<div class="row">
			<div class="col-md-9">  
				<h2 class="sub-header">Memos</h2>
				<div class="table-responsive">
					<button type="button" id="crea-memo" class="btn btn-sm btn-primary"
					data-toggle="modal" data-target="#myModal" >NUEVO</button> 
					<table class="table table-striped">
						<thead>
							<tr>
								<th width="10%">N° Memo</th>
								<th width="20%">Fecha Recepción</th>
								<th width="10%">Fecha</th>
								<th width="15%">Fecha entrega</th>
								<th width="15%">Resolución</th>
								<th width="15%">URL Resolución</th>
								<th width="15%">Acciones</th>
							</tr>
						</thead>
						<tbody id="listamemo">
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
					<h4 class="modal-title-form" id="myModalLabel">Memos</h4>
				</div>
				<form role="form" name="formMemo" id="formMemo" method="post" action="">
					<input type="hidden" name="memoId" id="memoId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="form-group">
							<label for="memoNum">N° Memo</label>
							<input id="memoNum" class="form-control" type="text" name="memoNum" value="" title="Ingrese un número" required />
						</div>
						<div class="form-group">
							<label for="memoFechRec">Fecha Recepción</label>
							<input id="memoFechRec" name="memoFechRec" class="form-control" value=""  title="Ingrese una fecha" />
						</div>
						<div class="form-group">
							<label for="memoFecha">Fecha</label>
							<input id="memoFecha" class="form-control" type="text" name="memoFecha" value="" title="Ingrese una fecha" required />
						</div>
						<div class="form-group">
							<label for="memoFechEnt">Fecha Entrega</label>
							<input id="memoFechEnt" class="form-control" type="text" name="memoFechEnt" value="" title="Ingrese una fecha" required />
						</div>
						<div class="form-group">
							<label for="memoNumRes">Resolución</label>
							<input id="memoNumRes" class="form-control" type="text" name="memoNumRes" value="" title="Ingrese un número" required />
						</div>
						<div class="form-group">
							<label for="memoUrl">URL Resolución</label>
							<input id="memoUrl" class="form-control" type="text" name="memoUrl" value="" title="Ingrese un URL" required />
						</div>

					</div>
					<div class="modal-footer">
						<button id="editar-memo" name="editar-memo" type="button" class="btn btn-warning">Editar</button>
						<button id="actualizar-memo" name="actualizar-memo" type="button" class="btn btn-primary">Actualizar</button>
						<button id="guardar-memo" name="guardar-memo" type="button" class="btn btn-primary">Guardar</button>
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
					<h4 class="modal-title" id="myModalDeleteLabel">Eliminación de Memo</h4>
				</div>
				<form role="form" name="formDeleteMemo" id="formDeleteMemo" method="post" action="">
					<input type="hidden" name="memoId" id="memoId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="input-group">
							<label for="pregunta">¿Está seguro de eliminar el Memo seleccionado?</label>
						</div>       
						<div class="input-group">
							<label for="namememo">Número Memo</label>
							<input type="text" class="form-control" id="namememo" name="namememo" placeholder="" readonly>
						</div>
					</div>
					<div class="modal-footer">
						<button id="eliminar-memo" name="eliminar-memo" type="button" class="btn btn-primary">Aceptar</button>
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