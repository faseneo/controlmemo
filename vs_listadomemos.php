<!DOCTYPE html>
<html lang="es">
<head>
    <?php include "header.php"; ?>
    <title>Listado Memos</title>
    <script src="js/globalfn.js"></script>    
    <script src="js/fn_listadomemos.js"></script>
    <style type="text/css">
        .orden{
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .sorting {
            color: #337AB7;
        }

        .asc:after {
            content: ' ↑';
        }

        .desc:after {
            content: " ↓";
        }
    </style>
</head>
<body>
    <?php include "barranav.php"; ?>
    <div class="container" style="margin-top:50px"> 
        <div class="row"> 
            <div class="col-md-12 ">
                <center><h2>Listado Memos <span class="badge" id="totalmemos"></span></h2><span class="badge" id="totalmemos"></span></center><br><br>
                <form id="contact-form" method="post" action="#" role="form">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">  
                               <label for="usuario">Usuario</label>
                                <select name="usuario" id="usuario" class="form-control" >
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">  
                               <label for="rolUsuario">Rol</label>
                                <input type="text" name="rolUsuario" id="rolUsuario" class="form-control" readonly />
                                
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="col-md-5">
                             <div class="form-group">
                                <label for="memoEstado">Estado</label>  
                                <select name="memoEstado" id="memoEstado" class="form-control">
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
<!--                         <div class="col-md-1">
                            <div class="form-group"> <label for="memoEstado">algo.</label>  
                               <button id="ver-memo" type="button" class="btn btn-xs btn-success" >Buscar</button>
                           </div>
                       </div>  -->                       
                    </div>
                </form>    

                    <br>
                    <div class="row">     
                        <div class="col-md-12">      
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="7%" class="orden">Año / Número</th>
                                        <th width="8%" class="orden">Fecha Memo</th>
                                        <th width="35%" class="orden">Materia o Asunto</th>
                                        <th width="7%" class="orden">OC Manager</th>
                                        <th width="10%" class="orden">Número Resolución</th>
                                        <th width="8%" class="orden">OC Chilecompra</th>
                                        <th width="12%" class="orden">Estado</th>
                                        <th width="13%">Acciones</th>
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