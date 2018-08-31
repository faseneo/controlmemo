<!DOCTYPE html>
<html lang="es">
<head>
    <?php include "header.php"; ?>
    <title>Listado Memos</title>
    <script src="js/globalfn.js"></script>    
    <script src="js/fn_listadomemos.js"></script>
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
                    </div>
                </form>    

                    <br>
                    <div class="row">     
                        <div class="col-md-12">      
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="7%" >Número</th>
                                        <th width="8%">Fecha</th>
                                        <th width="35%">Materia</th>
                                        <th width="10%">Orden compra manager</th>
                                        <th width="10%">Número resolución</th>
                                        <th width="10%">Orden compra Chilecompra</th>
                                        <th width="20%">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="listamemos">
                                </tbody>
                            </table>
                        </div>
                    </div>
                  
                
            </div><!-- /.8 -->
        </div> <!-- /.row-->
    </div> <!-- /.container-->
</body>
</html>