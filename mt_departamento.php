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
	<script src="js/fn_mt_depto.js"></script>  
</head>
<body>
	<?php include "barranav.php"; ?>
        <div class="container" style="margin-top:50px">
        	<div class="row">
        		<div class="col-md-10">
					<h2 class="sub-header">Departamentos</h2>
        		</div>
        	</div>
            <div class="row">
				<div class="col-md-3">
					<div class="table-responsive">
						<!-- Añadimos un botón para el diálogo modal onclick="newServicio()"-->
						<button type="button" id="crea-depto" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal" >NUEVO</button> 
						
					</div>
				</div>
				<div class="col-md-4 col-md-offset-5">
					<div class="input-group search">
						<input type="text" id="busqueda" class="form-control texto-gris" placeholder="Buscar ..." >
					 	<span class="input-group-addon"><i class="fa fa-search"></i></span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<table class="table table-striped" id="listadodepto">
							<thead>
								<tr>
									<th width="62%">Nombre</th>
									<th width="15%">Nombre Corto</th>
									<th width="9%">Acción</th>
									<th width="6%">Estado</th>
									<th width="6%">Habilitado</th>
								</tr>
							</thead>
							<tbody id="listadepto">
							</tbody>
		 			</table>
				</div>				
			</div>

		</div>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title-form" id="myModalLabel">Departamentos</h4>
				</div>
				<form role="form" name="formDepto" id="formDepto" method="post" action="">
					<input type="hidden" name="deptoId" id="deptoId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="form-group">
							<label for="deptoNombre">Nombre</label>
							<input id="deptoNombre" class="form-control" type="text" name="deptoNombre" value="" title="Ingrese un nombre" required />
						</div>
						<div class="form-group">
							<label for="deptoNombreCorto">Nombre corto o abreviado</label>
							<input id="deptoNombreCorto" class="form-control" type="text" name="deptoNombreCorto" value="" title="Ingrese un nombre" required />
						</div>
						<div class="form-group">
							<label for="deptoEstado">Estado</label>
							<select id="deptoEstado" name="deptoEstado" class="form-control">
								<option value="1">Activo</option>
								<option value="0">Inactivo</option>
							</select>
						</div>
						<div class="form-group">
							<label for="deptoHabilitado">Habilitado como sección</label>
							<select id="deptoHabilitado" name="deptoHabilitado" class="form-control">
								<option value="1">Activo</option>
								<option value="0">Inactivo</option>
							</select>
						</div>						
					</div>
					<div class="modal-footer">
						<button id="editar-depto" name="editar-depto" type="button" class="btn btn-warning">Editar</button>
						<button id="actualizar-depto" name="actualizar-depto" type="button" class="btn btn-primary">Actualizar</button>
						<button id="guardar-depto" name="guardar-depto" type="button" class="btn btn-primary">Guardar</button>
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
				<form role="form" name="formDeleteDepto" id="formDeleteDepto" method="post" action="">
					<input type="hidden" name="deptoId" id="deptoId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="input-group">
							<label for="pregunta">¿Está Seguro de eliminar el Departamento seleccionado?</label>
						</div>       
						<div class="input-group">
							<label for="nameDepto">Nombre Departamento</label>
							<input type="text" class="form-control" id="nameDepto" name="nameDepto" placeholder="" readonly>
						</div>
					</div>
					<div class="modal-footer">
						<button id="eliminar-depto" name="eliminar-depto" type="button" class="btn btn-primary">Aceptar</button>
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