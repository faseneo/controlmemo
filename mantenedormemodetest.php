<html>
    <head>
	<?php include "header.php"; ?>
	<script src="js/funcionesmemodetest.js"></script>
    </head>
    <body>
 
<?php include "barranav.php"; ?>

        <div class="container" style="margin-top:50px">
            <div class="row">
				<div class="col-md-12">
					<h2 class="sub-header">Memo Detalle Estado</h2>
					<div class="table-responsive">
						<!-- Añadimos un botón para el diálogo modal onclick="newServicio()"-->
						<button type="button" id="crea-memodetest" class="btn btn-sm btn-primary"
								data-toggle="modal" data-target="#myModal" >NUEVO</button> 
						<table class="table table-striped">
							<thead>
								<tr>
									<th width="30%">Tipo</th>
									<th width="30%">Prioridad</th>
									<th width="30%">Acciones</th>
								</tr>
							</thead>
							<tbody id="listamemodetest">
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
					<h4 class="modal-title-form" id="myModalLabel">Memo Detalle Estado</h4>
				</div>
				<form role="form" name="formMemoDetEst" id="formMemoDetEst" method="post" action="">
					<input type="hidden" name="memodetestId" id="memodetestId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="form-group">
							<label for="memodetestTipo">Tipo</label>
							<input id="memodetestTipo" class="form-control" type="text" name="memodetestTipo" value="" title="Ingrese un tipo" required />
						</div>
						<div class="form-group">
							<label for="memodetPriori">Prioridad</label>
							<input id="memodetPriori" class="form-control" type="text" name="memodetPriori" value="" title="Ingrese una prioridad" required />
						</div>
					</div>
					<div class="modal-footer">
						<button id="editar-memodetest" name="editar-memodetest" type="button" class="btn btn-warning">Editar</button>
						<button id="actualizar-memodetest" name="actualizar-memodetest" type="button" class="btn btn-primary">Actualizar</button>
						<button id="guardar-memodetest" name="guardar-memodetest" type="button" class="btn btn-primary">Guardar</button>
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
				<form role="form" name="formDeleteMemoDetEst" id="formDeleteMemoDetEst" method="post" action="">
					<input type="hidden" name="memodetestId" id="memodetestId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="input-group">
							<label for="pregunta">¿Está Seguro de eliminar Memo Detalle Estado seleccionado?</label>
						</div>       
						<div class="input-group">
							<label for="nameMemoDetEst">Memo Detalle Estado</label>
							<input type="text" class="form-control" id="nameMemoDetEst" name="nameMemoDetEst" placeholder="" readonly>
						</div>
					</div>
					<div class="modal-footer">
						<button id="eliminar-memodetest" name="eliminar-memodetest" type="button" class="btn btn-primary">Aceptar</button>
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