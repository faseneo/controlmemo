<?php
session_start();
if($_SESSION["autentica"] != "SIP"){
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include "header.php"; ?>    
    <title>Cambio contraseña</title>
    <script src="js/fn_cambiopass.js"></script>
</head>
<body>
    <?php include "barranav.php"; ?>
    <div class="container" style="margin-top:50px">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <center><h1>Cambio contraseña</h1></center><br><br>
                <form id="formCambioPass" name="formCambioPass" method="post" action="#" role="form">
                    <input name="accion" type="hidden" value="cambiapass">
                    <div class="messages"></div>
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="form-group">
                                    <label class="text-success">Contraseña actual</label>
                                    <input id="" type="text" name="" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="form-group">
                                    <label class="text-danger" >Contraseña nueva</label>
                                    <input id="" type="text" name="" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="form-group">
                                    <label class="text-danger">Confirmar contraseña nueva</label>
                                    <input id="" type="text" name="" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <center><br>
                            <div class="row">
                                <div class="col-md-12">
                                    <input id="cambiar" name="cambiar" type="submit" class="btn btn-success btn-send" value="Cambiar">
                                    <input type="reset" class="btn btn-default btn-send" value="Limpiar">
                                </div>
                            </div><br>
                        </center>
                    </div>
                </form>
            </div><!-- /.8 -->
        </div> <!-- /.row-->
    </div> <!-- /.container-->
</body>
</html>
