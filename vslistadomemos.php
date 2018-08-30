<!DOCTYPE html>
<html lang="es">
<head>
    <?php include "header.php"; ?>
    <title>Listado Memos</title>
    <script src="js/globalfn.js"></script>    
    <script src="js/fnmemo.js"></script>
    <script src="js/funcioneslistado.js"></script>
    <!-- <style type="text/css">
        .alert {
            margin:5px;
            padding: 5px;
            height: 30px;
        }
    </style> -->
</head>
<body>
    <?php include "barranav.php"; ?>
    <div class="container" style="margin-top:50px"> 
        <div class="row"> 
            <div class="col-md-12 ">
                <center><h1>Listado</h1></center><br><br>
                <form id="contact-form" method="post" action="#" role="form">
                    <div class="messages"></div>
                    <div class="controls"> 

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">  
                                <label for="usuario">Usuario</label>
                                <select name="usuario" id="usuario" class="form-control">
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>                                
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="memoEstado">Estado</label>  
                                <select name="memoEstado" id="memoEstado" class="form-control">
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div><br>

                    <div class="row">     
                        <div class="col-md-12">      
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Número</th>
                                        <th>Fecha</th>
                                        <th>Orden compra manager</th>
                                        <th>Número resolución</th>
                                        <th>Orden compra Chilecompra</th>
                                        <th>Ver</th>
                                        <th>Anular</th>
                                        <th>Asignar</th>
                                    </tr>
                                </thead>
                                <tbody id="listamemos">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </div>
                </form>
            </div><!-- /.8 -->
        </div> <!-- /.row-->
    </div> <!-- /.container-->
</body>
</html>