<?php
session_start();

if(!isset($_SESSION["autentica"])){
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<?php include "header.php"; ?>
	<script src="js/fn_mt_estadodetmemo.js"></script>
</head>
<body>
 	<?php include "barranav.php"; ?>
        <div class="container" style="margin-top:50px">
            <div class="row">
				<div class="col-md-12">
					<h2 class="sub-header">Estado Detalle Memo</h2>
					<div class="table-responsive">
						<!-- Añadimos un botón para el diálogo modal onclick="newServicio()"-->
						<button type="button" id="crea-estadoDM" class="btn btn-sm btn-primary"
								data-toggle="modal" data-target="#myModal" >NUEVO</button> 
						<table class="table table-striped">
							<thead>
								<tr>
									<th width="25%">Nombre Estado</th>
									<th width="35%">Descripción</th>
									<th width="10%">Orden</th>
									<th width="10%">Activo</th>
									<th width="20%">Acciones</th>
								</tr>
							</thead>
							<tbody id="listaestadoDM">
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
					<h4 class="modal-title-form" id="myModalLabel">Estado Detalle Memo</h4>
				</div>
				<form role="form" name="formestadoDM" id="formestadoDM" method="post" action="">
					<input type="hidden" name="estadoDMId" id="estadoDMId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="form-group">
							<label for="estadoDMTipo">Nombre Estado</label>
							<input id="estadoDMTipo" class="form-control" type="text" name="estadoDMTipo" value="" title="Ingrese un tipo" required />
						</div>
						<div class="form-group">
							<label for="estadoDMDesc">Descripción</label>
							<input id="estadoDMDesc" class="form-control" type="text" name="estadoDMDesc" value="" title="Ingrese Decripción" required />
						</div>
						<div class="form-group">
							<label for="estadoDMOrden">Orden</label>
							<input id="estadoDMOrden" class="form-control" type="text" name="estadoDMOrden" value="" title="Ingrese numero orden" required />
						</div>
						<div class="form-group">
							<label for="estadoDMActivo">Activo</label>
							<select name="estadoDMActivo" id="estadoDMActivo" class="form-control">
								<option value="0">NO</option>
								<option value="1" selected>SI</option>
							</select>
						</div>						
					</div>
					<div class="modal-footer">
						<button id="editar-estadoDM" name="editar-estadoDM" type="button" class="btn btn-warning">Editar</button>
						<button id="actualizar-estadoDM" name="actualizar-estadoDM" type="button" class="btn btn-primary">Actualizar</button>
						<button id="guardar-estadoDM" name="guardar-estadoDM" type="button" class="btn btn-primary">Guardar</button>
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
					<h4 class="modal-title" id="myModalDeleteLabel">Eliminación de Memo Detalle Estado</h4>
				</div>
				<form role="form" name="formDeleteestadoDM" id="formDeleteestadoDM" method="post" action="">
					<input type="hidden" name="estadoDMId" id="estadoDMId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="input-group">
							<label for="pregunta">¿Está Seguro de eliminar Memo Detalle Estado seleccionado?</label>
						</div>       
						<div class="input-group">
							<label for="nameestadoDM">Memo Detalle Estado</label>
							<input type="text" class="form-control" id="nameestadoDM" name="nameestadoDM" placeholder="" readonly>
						</div>
					</div>
					<div class="modal-footer">
						<button id="eliminar-estadoDM" name="eliminar-estadoDM" type="button" class="btn btn-primary">Aceptar</button>
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