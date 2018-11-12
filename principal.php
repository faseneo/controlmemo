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
    <title>Buscador</title>
    <script src="js/fn_buscador.js"></script>
</head>
<body>
    <?php include "barranav.php"; ?>
    <div class="container" style="margin-top:50px">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <center><h1>Buscador</h1></center><br><br>
                <form id="contact-form" method="post" action="#" role="form">
                    <div class="messages"></div>
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >Número Memo</label>
                                    <input id="" type="text" name="" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >Orden de compra SAC</label>
                                    <input id="" type="text" name="" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >Orden de compra Chilecompra</label>
                                    <input id="" type="text" name="" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >Número de resolución</label>
                                    <input id="" type="text" name="" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <center>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-success btn-send" value="Buscar">
                                </div>
                            </div><br>
                            <a href="vistabuscadorav.php">Búsqueda avanzada</a>
                        </center>
                    </div>
                </form>
            </div><!-- /.8 -->
        </div> <!-- /.row-->
            <div class="row">
                <div class="col-md-12">
                    <h4 id="titulolistado">Listado memos de : <span id="nombreusu"></span> <!-- - Estado <span id="estadousu"></span> --></h4>
                </div>
            </div>                    
            <div class="row">
                <div class="col-md-12">
                    <table class="table" id="resultadomemo">
                        <thead>
                            <tr>
                                <th width="8%" class="orden">Año / Número</th>
                                <th width="8%" class="orden">Fecha Memo</th>
                                <th width="34%" class="orden">Materia o Asunto</th>
                                <th width="25%" class="orden">Departamento Solicitante</th>
                                <th width="12%" class="orden">Estado</th>
                                <th width="13%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="listamemos">
                        </tbody>
                    </table>
                    <div class="alert alert-warning " id="resultadofiltro">
                        <!-- <button type="button" class="close" data-dismiss="alert">&times;</button> -->
                        <span id="resultadofiltromsg"></span>
                    </div>
                    <ul id="paginador" class="pagination pagination-sm">
                    </ul>
                </div>
            </div>
    </div> <!-- /.container-->
</body>
</html>
