<?php 
 $val = $_SESSION["autentica"];
 $rut = $_SESSION["rut"];
 $rol = $_SESSION["rol"];
 $nombre = $_SESSION["nombre"];
 // 1_admin, 2_super, 3_analisa, 4_secre, 5_gestion
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="/controlmemo/" class="navbar-brand"><img src="img/logo.png" style="height: 30px;"></a>			
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav">
				<li class="active"><a href="/controlmemo/">Inicio</a></li>
				<?php 
					if($rol==1 || $rol==2 || $rol==3 || $rol==4){
				?>
					<li><a href="principal.php">Buscador</a></li>
					<li><a href="vs_ingresomemo.php">Ingreso Memo</a></li>
					<li><a href="vs_listadomemos.php">Listado</a></li>
				<?php 
					}
				?>
				<?php 
					if($rol==1 || $rol==2){
				?>
					<li><a href="vistaresumenpend2.php">Resumen pendientes</a></li>
				<?php 
					}
				?>
				<?php 
					if($rol==1){
				?>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">Mantendor<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="mt_centrocosto.php">Centro de Costos</a></li>
						<li><a href="mt_departamento.php">Departamentos</a></li>
						<li><a href="mt_dependencia.php">Dependencias</a></li>
						<li><a href="mt_procedimientos.php">Procedimiento Compra</a></li>
						<li><a href="mt_proveedores.php">Proveedores</a></li>
						<li><a href="mt_usuarios.php">Usuarios</a></li>
						<li><a href="mt_usuariorol.php">Usuario Rol</a></li>
						<li><a href="mt_seccion.php">Sección</a></li>
						<li><a href="mt_estadodetmemo.php">Estado Detalle Memo</a></li>
						<li><a href="mt_memoestado.php">Estado Memos</a></li>
						<li><a href="mt_estadoasignacion.php">Estado Asignacion Memos</a></li>
						<li><a href="mt_asignadificultad.php">Dificultad Asignacion</a></li>
						<li><a href="mt_asignaprioridad.php">Prioridad Asignacion</a></li>
					</ul>
				</li>
				<?php 
					}
				?>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#">Bienvend@ <?php echo $nombre; ?></a></li>
				<li><a href="vistacambiocontr.php">Cambiar contraseña</a></li>
				<li><a href="salir.php">Logout</a></li>
				<!-- <li><a href="#"><span class="glyphicon glyphicon-user"></span>Registrarse</a></li> -->
				<!-- <li><a href="#"><span class="glyphicon glyphicon-log-in"></span>Login</a></li> -->
			</ul>
		</div>
	</div>
</nav>