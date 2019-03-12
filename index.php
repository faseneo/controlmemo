<!DOCTYPE html>
<html lang="es">
<head>
    <?php include "header.php"; ?>
    <title>Listado Memos</title>
    <script src="js/fn_valida.js"></script>
    <script type="text/javascript">
    	$(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
	<br>
	<header>
		<center>
			<img src="img/logo_umce_2018_290.jpg" class="img-rounded">
			<h2 class="form-signin-heading">Sistema Control Adquisiciones</h2>
		</center>
	</header>
	<main>
	<div class="container">
		<div class="row">
			<div class="col-sm-4 col-sm-offset-4">
				<br>
				<div class="well">
					<form id="formLogin" name="formLogin" class="form-signin" method="post" action="controllers/controllerusuario.php">
						<input type="hidden" id="Accion" name="Accion" value="valida">
						<div class="row">
							<div class="col-sm-10 col-sm-offset-1">
								<h3 class="form-signin-heading">Iniciar sesión</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-10 col-sm-offset-1">
								<div class="input-group">
									<span class="input-group-addon"  data-toggle="tooltip" data-placement="top" title="Correo Institucional"><i class="glyphicon glyphicon-user"></i></span>
									<input name="formUser" id="formUser" type="email" class="form-control" placeholder="E-mail">
								</div>
								<span class="help-block" id="spanuser"></span>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-10 col-sm-offset-1">
								<div class="input-group">
									<span class="input-group-addon" data-toggle="tooltip" data-placement="top" title="Contraseña Sistema"><i class="glyphicon glyphicon-lock"></i></span>
									<input name="formPass" id="formPass" type="password" class="form-control" placeholder="Contraseña">
								</div>
								<span class="help-block" id="spanpass"></span>
								<!-- <div class="col-md-12 text-right hidden-xs">
									<a id="linkRecupera" data-toggle="tooltip" data-placement="top" title="Recupera tu contraseña Aqui" href="#">
									¿Olvidaste tu contraseña?
									</a>
								</div> -->
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-10 col-sm-offset-1">
								<button id="validar" class="btn btn-small btn-primary" type="button">
									<span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>
									Entrar al sistema
								</button>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-10 col-sm-offset-1">
								
								<p class="text-danger" id="noexiste"></p>
							</div>
						</div>
						<br>
					</form>
				</div>
			</div>
		</div>
	</div>	
	</main>
	<footer>
		<hr>
		<center>
			<p>Departamento de informática UMCE 2018-2019</p>
		</center>	
	</footer>
</body>
</html>