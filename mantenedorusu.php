<html>
    <head>
	<?php include "header.php"; ?>
	<script src="js/funcionesusu.js"></script>
    </head>
    <body>

<?php include "barranav.php"; ?>

        <div class="container" style="margin-top:50px">
            <div class="row">
				<div class="col-md-9">  
					<h2 class="sub-header">Usuarios</h2>
					<div class="table-responsive">
						<!-- Añadimos un botón para el diálogo modal onclick="newServicio()"-->
						<button type="button" id="crea-usuario" class="btn btn-sm btn-primary"
								data-toggle="modal" data-target="#myModal" >NUEVO</button> 
						<table class="table table-striped">
							<thead>
								<tr>
									<th width="25%">Rut</th>
									<th width="25%">Nombre</th>
									<th width="25%">Perfil</th>
									<th width="25%">Acciones</th>
								</tr>
							</thead>
							<tbody id="listausuario">
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
					<h4 class="modal-title-form" id="myModalLabel">Usuarios</h4>
				</div>
				<form role="form" name="formUsuario" id="formUsuario" method="post" action="">
					<input type="hidden" name="usuId" id="usuId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="form-group">
							<label for="usuRut">Rut</label>
							<input id="usuRut" class="form-control" type="text" name="usuRut" value="" title="Ingrese un rut" required />
						</div>
						<div class="form-group">
							<label for="usuNombre">Nombre</label>
							<input id="usuNombre" name="usuNombre" class="form-control" rows="3"  title="Ingrese un nombre" />
						</div>
						<div class="form-group">
							<label for="usuPass">Contraseña</label>
							<input id="usuPass" name="usuPass" class="form-control" rows="3"  title="Ingrese contraseña" />
						</div>
						<div class="form-group">
							<label for="usuPerfilId">Perfil</label>
                                        <select name="usuPerfilId" id="usuPerfilId" class="form-control">
                                        </select>
						</div>
					</div>
					<div class="modal-footer">
						<button id="editar-usuario" name="editar-usuario" type="button" class="btn btn-warning">Editar</button>
						<button id="actualizar-usuario" name="actualizar-usuario" type="button" class="btn btn-primary">Actualizar</button>
						<button id="guardar-usuario" name="guardar-usuario" type="button" class="btn btn-primary">Guardar</button>
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
					<h4 class="modal-title" id="myModalDeleteLabel">Eliminación de Usuario</h4>
				</div>
				<form role="form" name="formDeleteUsuario" id="formDeleteUsuario" method="post" action="">
					<input type="hidden" name="usuId" id="usuId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="input-group">
							<label for="pregunta">¿Está seguro de eliminar el Usuario seleccionado?</label>
						</div>       
						<div class="input-group">
							<label for="nameUsu">Nombre Usuario</label>
							<input type="text" class="form-control" id="nameUsu" name="nameUsu" placeholder="" readonly>
						</div>
					</div>
					<div class="modal-footer">
						<button id="eliminar-usuario" name="eliminar-usuario" type="button" class="btn btn-primary">Aceptar</button>
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



    </body>
</html>
