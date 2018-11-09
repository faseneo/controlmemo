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
	<script src="js/funcionesdep.js"></script>
</head>
<body>
	<?php include "barranav.php"; ?>
	<div class="container" style="margin-top:50px">
		<div class="row">
			<div class="col-md-9">  
				<h2 class="sub-header">Unidades de dependencias</h2>
				<div class="table-responsive">
					<button type="button" id="crea-dependencia" class="btn btn-sm btn-primary"
					data-toggle="modal" data-target="#myModal" >NUEVO</button> 
					<table class="table table-striped">
						<thead>
							<tr>
								<th width="60%">Nombre</th>
								<th width="15%">Código</th>
								<th width="25%">Acciones</th>
							</tr>
						</thead>
						<tbody id="listadependencia">
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
					<h4 class="modal-title-form" id="myModalLabel">Dependencia</h4>
				</div>
				<form role="form" name="formDependencia" id="formDependencia" method="post" action="">
					
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="form-group">
							<label for="depCodigo">Código</label>
							<input id="depCodigo" name="depCodigo" class="form-control" rows="3"  title="Ingrese una Codigo" />
						</div>
						<div class="form-group">
							<label for="depNombre">Nombre</label>
							<input id="depNombre" class="form-control" type="text" name="depNombre" value="" title="Ingrese un nombre" required />
						</div>
					</div>
					<div class="modal-footer">
						<button id="editar-dependencia" name="editar-dependencia" type="button" class="btn btn-warning">Editar</button>
						<button id="actualizar-dependencia" name="actualizar-dependencia" type="button" class="btn btn-primary">Actualizar</button>
						<button id="guardar-dependencia" name="guardar-dependencia" type="button" class="btn btn-primary">Guardar</button>
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
					<h4 class="modal-title" id="myModalDeleteLabel">Eliminación de Dependencia</h4>
				</div>
				<form role="form" name="formDeleteDependencia" id="formDeleteDependencia" method="post" action="">
					<input type="hidden" name="depCodigo" id="depCodigo" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="input-group">
							<label for="pregunta">¿Está seguro de eliminar la dependencia seleccionada?</label>
						</div>       
						<div class="input-group">
							<label for="namedep">Nombre Dependencia</label>
							<input type="text" class="form-control" id="namedep" name="namedep" placeholder="" readonly>
						</div>
					</div>
					<div class="modal-footer">
						<button id="eliminar-dependencia" name="eliminar-dependencia" type="button" class="btn btn-primary">Aceptar</button>
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
