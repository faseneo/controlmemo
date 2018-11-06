<html>
    <head>
	<?php include "header.php"; ?>
	<script src="js/fn_mt_estadooc.js"></script>
    </head>
    <body>
 
<?php include "barranav.php"; ?>

        <div class="container" style="margin-top:50px">
            <div class="row">
				<div class="col-md-8 col-md-offset-2">
					<h2 class="sub-header">Estado Orden de Compra</h2>
					<div class="table-responsive">
						<!-- Añadimos un botón para el diálogo modal onclick="newServicio()"-->
						<button type="button" id="crea-estadoOC" class="btn btn-sm btn-primary"
								data-toggle="modal" data-target="#myModal" >NUEVO</button> 
						<table class="table table-striped">
							<thead>
								<tr>
									<th width="50%">Nombre Estado</th>
									<th width="15%">Prioridad</th>
									<th width="15%">Activo</th>
									<th width="20%">Acciones</th>
								</tr>
							</thead>
							<tbody id="listaestadoOC">
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
					<h4 class="modal-title-form" id="myModalLabel">Estado Orden de Compra</h4>
				</div>
				<form role="form" name="formestadoOC" id="formestadoOC" method="post" action="">
					<input type="hidden" name="estadoOCId" id="estadoOCId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="form-group">
							<label for="estadoOCTipo">Nombre Estado</label>
							<input id="estadoOCTipo" class="form-control" type="text" name="estadoOCTipo" value="" title="Ingrese un tipo" required />
						</div>
						<div class="form-group">
							<label for="estadoOCPriori">Prioridad</label>
							<input id="estadoOCPriori" class="form-control" type="text" name="estadoOCPriori" value="" title="Ingrese una prioridad" required />
						</div>
						<div class="form-group">
							<label for="estadoOCActivo">Activo</label>
							<select name="estadoOCActivo" id="estadoOCActivo" class="form-control">
								<option value="0">NO</option>
								<option value="1" selected>SI</option>
							</select>
						</div>						
					</div>
					<div class="modal-footer">
						<button id="editar-estadoOC" name="editar-estadoOC" type="button" class="btn btn-warning">Editar</button>
						<button id="actualizar-estadoOC" name="actualizar-estadoOC" type="button" class="btn btn-primary">Actualizar</button>
						<button id="guardar-estadoOC" name="guardar-estadoOC" type="button" class="btn btn-primary">Guardar</button>
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
				<form role="form" name="formDeleteestadoOC" id="formDeleteestadoOC" method="post" action="">
					<input type="hidden" name="estadoOCId" id="estadoOCId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="input-group">
							<label for="pregunta">¿Está Seguro de eliminar Memo Detalle Estado seleccionado?</label>
						</div>       
						<div class="input-group">
							<label for="nameestadoOC">Memo Detalle Estado</label>
							<input type="text" class="form-control" id="nameestadoOC" name="nameestadoOC" placeholder="" readonly>
						</div>
					</div>
					<div class="modal-footer">
						<button id="eliminar-estadoOC" name="eliminar-estadoOC" type="button" class="btn btn-primary">Aceptar</button>
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