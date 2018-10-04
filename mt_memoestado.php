<html>
    <head>
	<?php include "header.php"; ?>
	<script src="js/fn_mt_memoestado.js"></script>
    </head>
    <body>
 
<?php include "barranav.php"; ?>

        <div class="container" style="margin-top:50px">
            <div class="row">
				<div class="col-md-12">
					<h2 class="sub-header">Memo Estado</h2>
					<div class="table-responsive">
						<!-- Añadimos un botón para el diálogo modal onclick="newServicio()"-->
						<button type="button" id="crea-memoest" class="btn btn-sm btn-primary"
								data-toggle="modal" data-target="#myModal" >NUEVO</button> 
						<table class="table table-striped" id="listadoestados">
							<thead>
								<tr>
									<th width="30%">Nombre estado</th>
									<th width="20%">Seccion</th>
									<th width="15%">Prioridad</th>
									<th width="15%">Activo</th>
									<th width="20%">Acciones</th>
								</tr>
							</thead>
							<tbody id="listamemoestado"> 
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
					<h4 class="modal-title-form" id="myModalLabel">Memo Estado</h4>
				</div>
				<form role="form" name="formMemoEst" id="formMemoEst" method="post" action="">
					<input type="hidden" name="memoestId" id="memoestId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="form-group">
							<label for="memoestTipo">Nombre Estado</label>
							<input id="memoestTipo" class="form-control" type="text" name="memoestTipo" value="" title="Ingrese un tipo" required />
						</div>
						<div class="form-group">
							<label for="memoestPrioridad">Prioridad</label>
							<input id="memoestPrioridad" class="form-control" type="text" name="memoestPrioridad" value="" title="Ingrese prioridad" required />
						</div>
						<div class="form-group">
							<label for="memoestActivo">Activo</label>
							<select name="memoestActivo" id="memoestActivo" class="form-control">
								<option value="0">NO</option>
								<option value="1" selected>SI</option>
							</select>
						</div>
						<div class="form-group">
							<label for="memoestSeccionId">Seccion</label>
							<select name="memoestSeccionId" id="memoestSeccionId" class="form-control">
							</select>							
						</div>						
					</div>
					<div class="modal-footer">
						<button id="editar-memoest" name="editar-memoest" type="button" class="btn btn-warning">Editar</button>
						<button id="actualizar-memoest" name="actualizar-memoest" type="button" class="btn btn-primary">Actualizar</button>
						<button id="guardar-memoest" name="guardar-memoest" type="button" class="btn btn-primary">Guardar</button>
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
					<h4 class="modal-title" id="myModalDeleteLabel">Eliminación de Memo Estado</h4>
				</div>
				<form role="form" name="formDeleteMemoEst" id="formDeleteMemoEst" method="post" action="">
					<input type="hidden" name="memoestId" id="memoestId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="input-group">
							<label for="pregunta">¿Está seguro de eliminar el Memo Estado seleccionado?</label>
						</div>       
						<div class="input-group">
							<label for="nameMemoest">Nombre Memo Estado</label>
							<input type="text" class="form-control" id="nameMemoest" name="nameMemoest" placeholder="" readonly>
						</div>
					</div>
					<div class="modal-footer">
						<button id="eliminar-memoest" name="eliminar-memoest" type="button" class="btn btn-primary">Aceptar</button>
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
