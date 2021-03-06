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
	<script src="js/fn_mt_centrocosto.js"></script>
</head>
<body>
	<?php include "barranav.php"; ?>
	<div class="container" style="margin-top:50px">
		<div class="row">
			<div class="col-md-12">  
			<div class="box">
	            <div class="box-header">
					<h3 class="box-title-mt">Centro de Costos</h3>
					<!-- <h3 class="sub-header">Centro de Costos</h3> -->
					<div class="box-tools">
						<ul class="pagination pagination-sm no-margin pull-right">
							<li><a href="#">&laquo;</a></li>
							<li><a href="#">1</a></li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">&raquo;</a></li>
						</ul>
					</div>
	            </div>
				<div class="box-body no-padding">
					<div class="table-responsive">
						<button type="button" id="crea-cecosto" class="btn btn-sm btn-primary"
						data-toggle="modal" data-target="#myModal" >NUEVO</button> 
						<table class="table table-striped">
							<thead>
								<tr>
									<th width="8%">Código</th>
									<th width="45%">Nombre Centro de Costos</th>
									<th width="10%">Tipo</th>
									<th width="23%">Unidad de dependencia</th>
									<th width="8%">Acción</th>
									<th width="6%">Estado</th>
								</tr>
							</thead>
							<tbody id="listacecostos">
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title-form" id="myModalLabel">Centro de Costos</h4>
				</div>
				<form role="form" name="formCecosto" id="formCecosto" method="post" action="">
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="form-group">
							<label for="ccCodigo">Código</label>
							<input id="ccCodigo" name="ccCodigo" class="form-control" rows="3"  title="Ingrese una Codigo" />
						</div>
						<div class="form-group">
							<label for="ccNombre">Nombre Centro de Costos</label>
							<input id="ccNombre" class="form-control" type="text" name="ccNombre" value="" title="Ingrese un nombre" required />
						</div>
						<div class="form-group">
							<label for="ccTipo">Tipo Centro de Costos</label>
							<select id="ccTipo" name="ccTipo" class="form-control">
								<option value="PROPIO">Propio</option>
								<option value="PROYECTO">Proyecto</option>
							</select>
						</div>
						<div class="form-group">
							<label for="ccDependencia">Unidad de dependencia</label>
                            <select name="ccDependencia" id="ccDependencia" class="form-control"></select>
						</div>
						<div class="form-group">
							<label for="ccEstado">Estado Centro de Costos</label>
							<select id="ccEstado" name="ccEstado" class="form-control">
								<option value="1">Activo</option>
								<option value="0">Inactivo</option>
							</select>
						</div>						
					</div>
					<div class="modal-footer">
						<button id="editar-cecosto" name="editar-cecosto" type="button" class="btn btn-warning">Editar</button>
						<button id="actualizar-cecosto" name="actualizar-cecosto" type="button" class="btn btn-primary">Actualizar</button>
						<button id="guardar-cecosto" name="guardar-cecosto" type="button" class="btn btn-primary">Guardar</button>
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
					<h4 class="modal-title" id="myModalDeleteLabel">Eliminación de Centro de Costos</h4>
				</div>
				<form role="form" name="formDeleteCecosto" id="formDeleteCecosto" method="post" action="">
					<input type="hidden" name="ccCodigo" id="ccCodigo" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="input-group">
							<label for="pregunta">¿Está seguro de eliminar el Centro de Costo seleccionado?</label>
						</div>       
						<div class="input-group">
							<label for="namececosto">Nombre Centro de Costos</label>
							<input type="text" class="form-control" id="namececosto" name="namececosto" placeholder="" readonly>
						</div>
					</div>
					<div class="modal-footer">
						<button id="eliminar-cecosto" name="eliminar-cecosto" type="button" class="btn btn-primary">Aceptar</button>
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
