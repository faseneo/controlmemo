<?php 

 $val = $_SESSION["autentica"];
 $rol = $_SESSION["rol"];
 $nombre = $_SESSION["nombre"];
 $rolnom = $_SESSION["datos"]["usu_rol_nombre"];
 $fecha = $_SESSION["fecactual"];
 $data = $_SESSION["datos"];
 $perfil = $data['usu_perfiles'][0]['perf_id'];
 // ROLES: 1_admin, 2_JefaAdquisicion, 3_analisa, 4_secre, 5_Administrativo, 6_Director, 7_JefeDepto
 // Perfiles: 1_Admin, 2_JefeDepto, 3_Supervidor, 4_Analista, 5_Secretaria, 6_GestionPago, 7_Observador
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="/controlmemo/vs_listadomemos.php" class="navbar-brand"><img src="img/logo.png" style="height: 30px;"></a>			
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav">
				<?php 
					//if( $rol==1 ||  $rol==2){
					if($rol==2){
							echo '<li class="active"><a href="vs_listadomemoasigna.php">Inicio</a></li>';
                    }else if( $rol==3){
                            echo '<li class="active"><a href="vs_listadomemoadq.php">Inicio</a></li>';
                    }else{
                            echo '<li class="active"><a href="vs_listadomemos.php">Inicio</a></li>';
                    }
                    echo '<li><a href="principal.php">Buscador</a></li>';
					if($rol==1 || $rol==2 || $rol==3 || $rol==4){
						if($rol==4){
							echo '<li><a class="dropdown-toggle" data-toggle="dropdown" href="#">Memo<span class="caret"></span></a>';
								echo '<ul class="dropdown-menu">';
									echo '<li><a href="vs_ingresomemo.php">Ingreso Nuevo Memo</a></li>';
									echo '<li><a href="vs_recepcionmemo.php">Recepción Memo</a></li>';
								echo '</ul>';
							echo '</li>';
                        }else if( $rol==3){
                        	echo '<li><a class="dropdown-toggle" data-toggle="dropdown" href="#">Memo<span class="caret"></span></a>';
								echo '<ul class="dropdown-menu">';
                            		echo '<li><a href="vs_detallememo.php">Ingreso Detalle Memo</a></li>';
                            	echo '</ul>';
                            echo '</li>';
                    	}
                    }
                    if($rol<>1){
	                    echo '<li><a class="dropdown-toggle" data-toggle="dropdown" href="#">Listados<span class="caret"></span></a>';
	                }
                    echo '<ul class="dropdown-menu">';
                    	//if($rol==1 || $rol==2 || $perfil==3){
	                    if($rol==2 || $perfil==3){
	                    	echo '<li><a href="vs_listadomemoasigna.php">Listado Asignaciones</a></li>';
	                    }else if($rol==4){
	                    	echo '<li class="active"><a href="vs_listadomemos.php">Listado Memos</a></li>';
	                    }
	                    if($rol==2 || $rol==3){
	                    	echo '<li><a href="vs_listadomemoadq.php">Mis Asignaciones</a></li>';
	                    }
                    echo '</ul>';
					echo '</li>';
					//if($rol==1 || $rol==2){
					if($rol==2){
						//echo '<li><a href="#">Resumen pendientes</a></li>';
					}
				
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
							<li><a href="mt_perfil.php">Perfiles</a></li>
							<li><a href="mt_estadodetmemo.php">Estado Detalle Memo</a></li>
							<li><a href="mt_memoestado.php">Estado Memos</a></li>

							<li><a href="mt_menu.php">Menú</a></li>
							<li><a href="mt_menuitem.php">Menú Item</a></li>

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
				<li><a href="#">Bienvend@ <?php echo $nombre.' - '.$rolnom; ?></a></li>
				<li><a href="vs_cambiopass.php">Cambiar contraseña</a></li>
				<li><a href="salir.php">Salir</a></li>
				<li><p ><?php echo ' Fecha Actual : '.$fecha; ?></p></li>
				<!-- <li><a href="#"><span class="glyphicon glyphicon-user"></span>Registrarse</a></li> -->
				<!-- <li><a href="#"><span class="glyphicon glyphicon-log-in"></span>Login</a></li> -->
			</ul>
		</div>
	</div>
</nav>