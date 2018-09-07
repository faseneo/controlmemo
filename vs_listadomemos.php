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
                        <div class="col-md-4">
                            <div class="form-group">  
                               <label for="usuario">Usuario</label>
                                <select name="usuario" id="usuario" class="form-control" onchange="rolusu();">
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">  
                               <label for="rolUsuario">Rol</label>
                                <input type="text" name="rolUsuario" id="rolUsuario" class="form-control" readonly />
                                
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                             <div class="form-group">
                                <label for="memoEstado">Estado</label>  
                                <select name="memoEstado" id="memoEstado" class="form-control">
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-1">
                             <div class="form-group"> <label for="memoEstado">algo.</label>  
                                <button id="ver-memo" type="button" class="btn btn-xs btn-success" >Buscar</button>
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
                            <ul id="paginador" class="pagination pagination-sm">
                            </ul>
                        </div>
                    </div>
                  
                
            </div><!-- /.8 -->
        </div> <!-- /.row-->
    </div> <!-- /.container-->
    <div class="modal fade" id="ModalCargando" tabindex="-1" role="dialog" aria-labelledby="ModalCargandoLabel">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
            <div class="loader"></div>
            <p id="msg" class="msg">Gargando Listado de Memos</p>
          </div>
          <div class="modal-footer">
           <!--  <button type="button" id="cerrarModalCargando" class="btn btn-default" data-dismiss="modal">Cerrar</button> -->
          </div>
        </div>
      </div>
    </div>
</body>
</html>