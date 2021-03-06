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
	<script src="js/funcionesbuscadorav.js"></script>
    <title>Buscador</title><br>
</head>
<body>
    <?php include "barranav.php"; ?>
    <div class="container" style="margin-top:50px">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <center><h1>Búsqueda Avanzada</h1></center><br><br>
                <form id="contact-form" method="post" action="#" role="form">
                    <div class="messages"></div>
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                <label for="memoFecha">Fecha memo</label>
                                <input name="memoFecha" id="memoFecha" type="date" class="form-control">
                                <span class="help-block"></span>
                            </div>                            
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="memoDepto" >Departamento</label>
                                    <select name="memoDepto" id="memoDepto" class="form-control">
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="memoFechaRecepcion">Fecha recepción analista</label>
                                    <input name="memoFechaRecepcion" id="memoFechaRecepcion" type="date" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="memoCcosto" >Centro de costos</label>
                                    <select name="memoCcosto" id="memoCcosto" class="form-control">
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="memoDetPcompra" >Procedimiento de compra</label>
                                    <select name="memoDetPcompra" id="memoDetPcompra" class="form-control">
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>                                
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="memoDetProveedor" >Proveedor</label>
                                    <select name="memoDetProveedor" id="memoDetProveedor" class="form-control">
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="memoFechaFactura">Fecha factura</label>
                                    <input name="memoFechaFactura" id="memoFechaFactura" type="date" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >Rut proveedor</label>
                                    <input id="" type="text" name="" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >Certificado disponibilidad presupuestaria</label>
                                    <input id="" type="text" name="" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >Número factura</label>
                                    <input id="" type="text" name="" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="memoEstado" >Estado</label>
                                    <select name="memoEstado" id="memoEstado" class="form-control">
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="usuario" >Usuario</label>
                                    <select name="usuario" id="usuario" class="form-control">
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>

                        <center>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-success btn-send" value="Buscar">
                                </div>
                            </div>
                        </center>
                    </div>
                </form>
            </div><!-- /.8 -->
        </div> <!-- /.row-->
    </div> <!-- /.container-->
</body>
</html>