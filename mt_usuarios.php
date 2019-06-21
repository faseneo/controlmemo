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
		<script src="js/fn_mt_usuarios.js"></script>
    </head>
    <body>
	<?php include "barranav.php"; ?>
        <div class="container-fluid" style="margin-top:50px">
            <div class="row">
				<div class="col-md-12">  
					<h2 class="sub-header">Usuarios</h2>
					<div class="table-responsive">
						<!-- Añadimos un botón para el diálogo modal onclick="newServicio()"-->
						<button type="button" id="crea-usuario" class="btn btn-sm btn-primary"
								data-toggle="modal" data-target="#myModal" >NUEVO</button> 
						<table class="table table-striped">
							<thead>
								<tr>
									<th width="2%">Id</th>
									<th width="7%">Rut</th>
									<th width="13%">Email</th>
									<th width="13%">Nombre</th>
									<th width="13%">Rol Ususario</th>
									<th width="32%">Id - Departamento o Unidad</th>
									<th width="8%">Estado</th>
									<th width="12%">Acciones</th>
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
					<h4 class="modal-title-form" id="myModalLabel">Datos Usuario</h4>
				</div>
				<form role="form" name="formUsuario" id="formUsuario" method="post" action="">
					<input type="hidden" name="usuId" id="usuId" value="" />
					<input type="hidden" name="Accion" id="Accion" value="" />
					<div class="modal-body">
						<div class="row">
	                        <div class="col-md-4">
								<div class="form-group">
									<label for="usuRut">Rut</label>
									<input id="usuRut" class="form-control" type="text" name="usuRut" value="" title="Ingrese un rut" required />
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group">
									<label for="usuNombre">Nombre</label>
									<input id="usuNombre" name="usuNombre" type="text" class="form-control" rows="3"  title="Ingrese un nombre" />
								</div>
							</div>
						</div>
						<div class="row">
	                        <div class="col-md-8">
								<div class="form-group">
									<label for="usuEmail">E-mail</label>
									<input id="usuEmail" name="usuEmail" type="text" class="form-control" rows="3"  title="Ingrese Email" />
								</div>	                        
	                        </div>
	                        <div class="col-md-4">
								<div class="form-group">
									<label for="usuPass">Contraseña</label>
									<input id="usuPass" name="usuPass" type="password" class="form-control" rows="3"  title="Ingrese contraseña" />
								</div>
							</div>	                        
	                    </div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="usuRolId">Rol Usuario</label>
										<select name="usuRolId" id="usuRolId" class="form-control">
		                                </select>
								</div>
							</div>
	                        <div class="col-md-6">
								<div class="form-group">
									<label for="usuEstadoId">Estado</label>
										<select name="usuEstadoId" id="usuEstadoId" class="form-control">
											<option value="0">Creado</option>
											<option value="1">Activo</option>
											<option value="2">Inactivo</option>
		                                </select>
								</div>
	                        </div>							
						</div>
						<div class="row">
	                        <div class="col-md-12">
								<div class="form-group">
									<label for="usuDeptoId">Departamento o Unidad</label>
										<select name="usuDeptoId[]" id="usuDeptoId" multiple="multiple" class="form-control" size="5">
		                                </select>
		                            <span class="help-block"></span>
								</div>
	                        </div>						
	                    </div>
						<div class="row">
	                        <div class="col-md-12">
								<div class="alert alert-success" id="msgPerfil"></div>
	                        </div>
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
					<input type="hidden" name="id" id="id" value="" />
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
						<button id="cancelDel" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

   <!-- Modal PERFIL -->
	<div class="modal fade" id="myModalPerfil" tabindex="-1" role="dialog" aria-labelledby="myModalPerfilLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalPerfilLabel">Agregar Perfil a Usuario</h4>
				</div>
				<form role="form" name="formPerfil" id="formPerfil" method="post" action="">
					<input type="hidden" name="idUsu" id="idUsu" value="" />
					<div class="modal-body">
						<div class="row">
	                        <div class="col-md-4">
								<div class="form-group">
									<label for="rutUsu">Rut</label>
									<input id="rutUsu" name="rutUsu" class="form-control" type="text"  value="" readonly />
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group">
									<label for="nomUsu">Nombre</label>
									<input id="nomUsu" name="nomUsu" type="text" class="form-control" rows="3" readonly />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="rolUsu">Rol Usuario</label>
									<input id="rolUsu" name="rolUsu" type="text" class="form-control" rows="3" readonly />
								</div>
							</div>
						</div>
						<div class="row">
	                        <div class="col-md-8">
								<div class="form-group">
	                        		<label for="usuPerfiles">Seleccione Perfil(es)</label>
	                        			<p class="text-info"><small>Presione ctrl + click para seleccionar mas de un Perfil</small></p>
									<select id="usuPerfiles" name="usuPerfiles[]" multiple="multiple" class="form-control" size="4">
						            </select>
						            <span class="help-block"></span>
								</div>
	                        </div>
	                    </div>
					</div>
					<div class="modal-footer">
						<button id="editar-perfil" name="editar-perfil" type="button" class="btn btn-warning">Editar</button>
						<button id="actualizar-perfil" name="actualizar-perfil" type="button" class="btn btn-primary">Actualizar</button>
						<button id="guardar-perfil" name="guardar-perfil" type="button" class="btn btn-primary">Guardar</button>
						<button id="cancelPerfil" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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