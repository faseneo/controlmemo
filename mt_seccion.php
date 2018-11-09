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
	<script src="js/fn_mt_seccion.js"></script>
    </head>
    <body>
 
<?php include "barranav.php"; ?>

        <div class="container" style="margin-top:50px">
            <div class="row">
				<div class="col-md-8 col-md-offset-2">
					<h2 class="sub-header">Secciones</h2>
					<div class="table-responsive">
						<button type="button" id="crea-seccion" class="btn btn-sm btn-primary"
								data-toggle="modal" data-target="#myModal" >NUEVO</button> 
						<table class="table table-striped">
							<thead>
								<tr>
									<th width="70%">Nombre sección</th>
									<th width="30%">Acciones</th>
								</tr>
							</thead>
							<tbody id="listadoseccion"> 
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
					<h4 class="modal-title-form" id="myModalLabel">Seccion</h4>
				</div>
				<form role="form" name="formSeccion" id="formSeccion" method="post" action="">
					<input type="hidden" name="secId" id="secId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="form-group">
							<label for="secNombre">Tipo</label>
							<input id="secNombre" class="form-control" type="text" name="secNombre" value="" title="Ingrese un tipo" required />
						</div>
					</div>
					<div class="modal-footer">
						<button id="editar-seccion" name="editar-seccion" type="button" class="btn btn-warning">Editar</button>
						<button id="actualizar-seccion" name="actualizar-seccion" type="button" class="btn btn-primary">Actualizar</button>
						<button id="guardar-seccion" name="guardar-seccion" type="button" class="btn btn-primary">Guardar</button>
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
					<h4 class="modal-title" id="myModalDeleteLabel">Eliminación de Seccion</h4>
				</div>
				<form role="form" name="formDeleteSeccion" id="formDeleteSeccion" method="post" action="">
					<input type="hidden" name="secId" id="secId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="input-group">
							<label for="pregunta">¿Está seguro de eliminar la Seccion?</label>
						</div>       
						<div class="input-group">
							<label for="nameSeccion">Nombre Seccion</label>
							<input type="text" class="form-control" id="nameSeccion" name="nameSeccion" placeholder="" readonly>
						</div>
					</div>
					<div class="modal-footer">
						<button id="eliminar-seccion" name="eliminar-seccion" type="button" class="btn btn-primary">Aceptar</button>
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
