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
                <center><h2>Listado Memos <span class="badge" id="totalmemos"></span></h2></center><br><br>
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

                        <div class="col-md-2">
                            <div class="form-group">  
                               <label for="rolUsuario">Rol</label>
                                <input type="text" name="rolUsuario" id="rolUsuario" class="form-control" readonly />
                                
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="col-md-3">
                             <div class="form-group">
                                <label for="memoSeccion">Sección</label>  
                                <select name="memoSeccion" id="memoSeccion" class="form-control">
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                             <div class="form-group">
                                <label for="memoEstado">Estado</label>  
                                <select name="memoEstado" id="memoEstado" class="form-control">
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>                        
                        <!--<div class="col-md-1">
                            <div class="form-group"> <label for="memoEstado">algo.</label>  
                               <button id="ver-memo" type="button" class="btn btn-xs btn-success" >Buscar</button>
                           </div>
                       </div>  -->                       
                    </div>
                </form>    
                    <div class="row">
                        <div class="col-md-12">
                            <h4 id="titulolistado">Listado memos de : <span id="nombreusu"></span> <!-- - Estado <span id="estadousu"></span> --></h4>
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-condensed  table-hover">
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
    <!-- Modal para asignar usuarios -->
    <div class="modal fade" id="myModalAsiganUsu" tabindex="-1" role="dialog" aria-labelledby="myModalAsiganUsuLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title-form" id="myModalAsiganUsuLabel">Asigna Usuario</h4>
                </div>
                <div class="modal-body">
                    <form role="form" name="formAsignaMem" id="formAsignaMem" method="POST" action="">
                        <input type="hidden" name="Accion" id="Accion" value="asignamemo" />
                        <input type="hidden" name="memoId" id="memoId" value="" />
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="asignadatos">Datos Memo</label>
                                    <p id="memonum"></p>
                                    <p id="memomat"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="asignausu">Seleccione Analista</label>
                                    <select name="asignausu" id="asignausu" class="form-control" >
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="asignadif">Seleccione Dificultad</label>
                                    <select name="asignadif" id="asignadif" class="form-control" >
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="asignaprio">Seleccione Prioridad</label>
                                    <select name="asignaprio" id="asignaprio" class="form-control" >
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="asignaobs">Observacion</label>
                                    <textarea class="form-control" rows="2" id="asignaobs" name="asignaobs" ></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="asigna" name="asignas" type="button" class="btn btn-primary">Asignar</button>
                    <button id="cancel" name="cancel" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- Modal mensajes cortos-->
    <div class="modal fade" id="myModalLittle" tabindex="-1" role="dialog" aria-labelledby="myModalLittleLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Mensaje</h4>
                </div>
                <div class="modal-body">
                    <p id="msg" class="msg"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="cerrarModalLittle" class="btn btn-default" data-dismiss="modal">Continuar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->     
</body>
</html>