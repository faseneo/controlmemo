<!DOCTYPE html>
<html lang="es">
<head>
    <?php include "header.php"; ?>
    <title>Listado Memos</title>
    <!-- <script src="js/fn_valida.js"></script> -->
</head>
<body>
  <div class="container">
    <!-- <div class="row">
      <div class="col-sm-12">
        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                        
              </button>
              <a class="navbar-brand" href="http://www.umce.cl">UMCE</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
              <ul class="nav navbar-nav navbar-right">
                <li><a href="http://www.umce.cl">Universidad Metropolitana de Ciencias de la Educación</a></li>
              </ul>
            </div>
          </div>
        </nav>
      </div>
    </div> -->
    <br><br><br><br>
    <div class="row">
      <div class="col-sm-4 col-sm-offset-4">
        <div >
          <h3>Sistema Control Adquisiciones</h3>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-3 col-sm-offset-4">
        <br><h3 class="form-signin-heading">Ingrese sus datos</h3><br><br>
      </div>
    </div>
    <form class="form-signin" method="post" action="controllers/controllerusuario.php">
      <input type="hidden" id="Accion" name="Accion" value="valida">
      <div class="row">
        <div class="col-sm-3 col-sm-offset-4" >
            <div class="form-group">
              <label for="formRut">Rut</label>
              <input type="text" class="form-control" name="formRut" id="formRut" placeholder="">
            </div>
            <div class="form-group">
              <label for="formPass">Contraseña</label>
              <input type="password" class="form-control" id="formPass" name="formPass"  placeholder="">
            </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3 col-sm-offset-4" style="text-align:center">
          <button class="btn btn-small btn-primary" type="submit">Entrar al sistema</button>
        </div>
      </div>      
    </form>
    <br>
     <div class="row">
        <div class="col-sm-3 col-sm-offset-4" style="text-align:center">
          <h6>
            <p>Escriba los datos como en el siguiente ejemplo:</p>
            <p>Rut: 12345678-9 / Fecha nac.: 1-1-1901</p>
          </h6>
        </div>
      </div> 
      <hr>
  </div>    
  <footer>
       <p><center><h5>Si tiene alg&uacute;n problema para ingresar debe acercarse a su asistente social</h5></center></p>
  </footer>
 </body>
 </html>
