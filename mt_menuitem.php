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
	<script src="js/fn_mt_menuitem.js"></script>
</head>
<body>
	<?php include "barranav.php"; ?>
    <div class="container" style="margin-top:50px">
		<div class="row">
			<div class="col-md-12">
				<h2 class="sub-header">Menú Item</h2>
				<div class="table-responsive">
					<button type="button" id="crea-menuitem" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal" >NUEVO</button> 
					<br><br>
					<table class="table table-striped">
						<thead>
							<tr>
								<th width="20%">Nombre Menú Item</th>
								<th width="35%">URL</th>
								<th width="15%">Menú</th>
								<th width="15%">Estado</th>								
								<th width="15%">Acciones</th>
							</tr>
						</thead>
						<tbody id="listadomenuitem"> 
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
					<h4 class="modal-title-form" id="myModalLabel">Menu Item</h4>
				</div>
				<form role="form" name="formMenu" id="formMenu" method="post" action="">
					<input type="hidden" name="menuitemId" id="menuitemId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="form-group">
							<label for="menuitemNombre">Nombre</label>
							<input id="menuitemNombre" class="form-control" type="text" name="menuitemNombre" value="" title="Ingrese un tipo" required />
						</div>
						<div class="form-group">
							<label for="menuitemUrl">URL</label>
							<input id="menuitemUrl" class="form-control" type="text" name="menuitemUrl" value="" title="Ingrese Url" required />
						</div>
						<div class="form-group">
							<label for="menuitemEstado">Estado</label>
							<select name="menuitemEstado" id="menuitemEstado" class="form-control">
								<option value="0">NO</option>
								<option value="1" selected>SI</option>
							</select>
						</div>
						<div class="form-group">
							<label for="menuitemMemid">Menú</label>
							<select name="menuitemMemid" id="menuitemMemid" class="form-control">
							</select>
						</div>						
					</div>
					<div class="modal-footer">
						<button id="editar-menuitem" name="editar-menuitem" type="button" class="btn btn-warning">Editar</button>
						<button id="actualizar-menuitem" name="actualizar-menuitem" type="button" class="btn btn-primary">Actualizar</button>
						<button id="guardar-menuitem" name="guardar-menuitem" type="button" class="btn btn-primary">Guardar</button>
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
					<h4 class="modal-title" id="myModalDeleteLabel">Eliminación de Menu Item</h4>
				</div>
				<form role="form" name="formDeleteMenu" id="formDeleteMenu" method="post" action="">
					<input type="hidden" name="menuitemId" id="menuitemId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="input-group">
							<label for="pregunta">¿Está seguro de eliminar el Menu?</label><br><br>
						</div>       
						<div class="input-group">
							<label for="nameMenu">Nombre Menú</label>
							<input type="text" class="form-control" id="nameMenu" name="nameMenu" placeholder="" readonly>
						</div>
					</div>
					<div class="modal-footer">
						<button id="eliminar-menuitem" name="eliminar-menuitem" type="button" class="btn btn-primary">Aceptar</button>
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
