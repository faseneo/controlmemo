<?php
session_start();
if($_SESSION["autentica"] != "SIP"){
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<?php include "header.php"; ?>
	<script src="js/fn_mt_asignadificultad.js"></script>  
</head>
<body>
	<?php include "barranav.php"; ?>
        <div class="container" style="margin-top:50px">
            <div class="row">
				<div class="col-md-8 col-md-offset-2">
					<h2 class="sub-header">Dificultad Asignación Memo</h2>
					<div class="table-responsive">
						<!-- Añadimos un botón para el diálogo modal onclick="newServicio()"-->
						<button type="button" id="crea-asignaDif" class="btn btn-sm btn-primary"
								data-toggle="modal" data-target="#myModal" >NUEVO</button> 
						<table class="table table-striped">
							<thead>
								<tr>
									<th width="80%">Texto</th>
									<th width="20%">Acciones</th>
								</tr>
							</thead>
							<tbody id="listaasignaDif">
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
					<h4 class="modal-title-form" id="myModalLabel">Estado Asignación</h4>
				</div>
				<form role="form" name="formasignaDif" id="formasignaDif" method="post" action="">
					<input type="hidden" name="asignaDifId" id="asignaDifId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="form-group">
							<label for="asignaDifTexto">Nombre</label>
							<input id="asignaDifTexto" class="form-control" type="text" name="asignaDifTexto" value="" title="Ingrese un nombre" required />
						</div>
					</div>
					<div class="modal-footer">
						<button id="editar-asignaDif" name="editar-asignaDif" type="button" class="btn btn-warning">Editar</button>
						<button id="actualizar-asignaDif" name="actualizar-asignaDif" type="button" class="btn btn-primary">Actualizar</button>
						<button id="guardar-asignaDif" name="guardar-asignaDif" type="button" class="btn btn-primary">Guardar</button>
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
					<h4 class="modal-title" id="myModalDeleteLabel">Eliminación de Departamento</h4>
				</div>
				<form role="form" name="formDeleteasignaDif" id="formDeleteasignaDif" method="post" action="">
					<input type="hidden" name="asignaDifId" id="asignaDifId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="input-group">
							<label for="pregunta">¿Está Seguro de eliminar el Departamento seleccionado?</label>
						</div>       
						<div class="input-group">
							<label for="nameasignaDif">Nombre Departamento</label>
							<input type="text" class="form-control" id="nameasignaDif" name="nameasignaDif" placeholder="" readonly>
						</div>
					</div>
					<div class="modal-footer">
						<button id="eliminar-asignaDif" name="eliminar-asignaDif" type="button" class="btn btn-primary">Aceptar</button>
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