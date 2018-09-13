﻿<!DOCTYPE html>
<html lang="es">
<head>
    <?php include "header.php"; ?>
    <title>Ingreso memo</title>
    <script src="js/fn_memo.js"></script>
    <script src="js/globalfn.js"></script>
    <style type="text/css">
        .alert {
            margin:5px;
            padding: 5px;
            height: 30px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="popover"]').popover();   
        });
    </script>    
</head>
<body> 
    <?php include "barranav.php"; ?>
    <div class="container" style="margin-top:50px">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <h2 class="text-center">Ingreso memo </h2>
                <form id="formIngresoMemo" name="formIngresoMemo" method="POST"  enctype="multipart/form-data" accept-charset="utf-8" role="form" data-toggle="validator" >
                    <input type="hidden" name="memoId" id="memoId" value="" />
                    <input type="hidden" name="Accionmem" id="Accionmem" value="registrar" />
                    <div class="messages"></div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="memoFecha">Fecha memo</label>
                                <input name="memoFecha" id="memoFecha" type="date" class="form-control" onchange="aniomemo();" required >
                                <!-- <span class="glyphicon form-control-feedback" aria-hidden="true"></span> -->
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="memoNum">Número Memo</label>
                                <input name="memoNum" id="memoNum" type="text"  class="form-control" maxlength="5" required>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label class="control-label" for="memoAnio">Año</label>
                                <input name="memoAnio" id="memoAnio" type="text"  class="form-control textocol1" maxlength="5"  readonly="">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="memoFechaRecep">Fecha recepción memo</label>
                                <input name="memoFechaRecep" id="memoFechaRecep" type="date" class="form-control" required>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="memoMateria">Asunto o Materia</label>
                                <textarea name="memoMateria" id="memoMateria" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="memoNombreSol">Nombre Solicitante</label>
                                <input name="memoNombreSol" id="memoNombreSol" type="text"  class="form-control">
                                <span class="help-block"></span>
                            </div>
                        </div>                        

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="memoDeptoSol">Departamento o Unidad Solicitante</label>
                                <select name="memoDeptoSol" id="memoDeptoSol" class="form-control" required>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="memoNombreDest">Nombre Destinatario</label>
                                <input name="memoNombreDest" id="memoNombreDest" type="text"  class="form-control" value="Leonel Durán" >
                                <span class="help-block"></span>
                            </div>
                        </div>                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="memoDeptoDest">Departamento o Unidad Destinatario</label>
                                <select name="memoDeptoDest" id="memoDeptoDest" class="form-control" required>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel-group" id="accordion">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a id="accord" data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                                Agregar Archivos</a>
                                                <a href="#" data-toggle="tooltip" title="pdf, jpg, png, doc, dox, xls, xlsx" data-content="pdf, jpg, png, doc, dox, xls, xlsx"><span class="glyphicon glyphicon-info-sign"></span></a>
                                            </h4>
                                        </div>
                                        <div id="collapse1" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <label class="btn btn-success btn-sm" for="memoFile">
                                                            <input id="memoFile" name="memoFile" type="file" accept=".jpg, .jpeg, .png, .pdf, .doc, .docx, .xls, .xlsx" multiple style="display:none">Agregar archivo memo escaneado
                                                        </label>
                                                        <span class='label label-info' id="memoFileInfo"></span> &nbsp; &nbsp;
                                                        <button id="limpiar-archivo-memo" type="button" class="btn btn-sm btn-default" data-dismiss="modal">Quita Archivo Memo</button>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="btn btn-primary btn-sm" for="memoFileList">
                                                            <input id="memoFileList" name="memoFileList[]" type="file" accept=".jpg, .jpeg, .png, .pdf, .doc, .docx, .xls, .xlsx" multiple style="display:none">Agregar otros archivos Anexos
                                                        </label><span class='label label-info' id="memoFileListInfo"></span> &nbsp; &nbsp;
                                                        <button id="limpiar-archivo" type="button" class="btn btn-sm btn-default" data-dismiss="modal">Quitar Archivos</button>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                     <div class="table-responsive">
                                                         <table class="table table-striped">
                                                             <thead>
                                                                 <tr>
                                                                     <th width="80%">Nombre Archivo</th>
                                                                     <th width="10%">Tamaño</th>
                                                                 </tr>
                                                             </thead>
                                                             <tbody id="archivoMemo">
                                                             </tbody>
                                                         </table>
                                                     </div>
                                                 </div>

                                                 <div class="col-lg-6">
                                                     <div class="table-responsive">
                                                         <table class="table table-striped">
                                                             <thead>
                                                                 <tr>
                                                                     <th width="80%">Nombre Archivo</th>
                                                                     <th width="10%">Tamaño</th>
                                                                 </tr>
                                                             </thead>
                                                             <tbody id="listaArchivosMemo">
                                                             </tbody>
                                                         </table>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>                    
                     <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="memoEstado">Estado</label>
                                <select name="memoEstado" id="memoEstado" class="form-control">
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="col-md-4 col-md-offset-4">
                            <button id="editar-memo" name="editar-memo" type="button" class="btn btn-warning">Editar</button>
                            <button id="actualizar-memo" name="actualizar-memo" type="button" class="btn btn-primary">Actualizar</button>
                            <button id="grabar-memo" name="grabar-memo" type="button" class="btn btn-primary">Grabar</button>
                            <button id="limpiar-memo" type="button" class="btn btn-default" data-dismiss="modal">Limpiar</button>
                            <button id="cancelar-memo" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </form>    
            </div><!-- /.10 -->
        </div> <!-- /.row-->
    </div> <!-- /.container-->

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
    <div class="modal fade" id="ModalCargando" tabindex="-1" role="dialog" aria-labelledby="ModalCargandoLabel">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="loader"></div>
                    <p id="msg" class="msg">Guardando Memo</p>
                </div>
                <div class="modal-footer">
                    <!--  <button type="button" id="cerrarModalCargando" class="btn btn-default" data-dismiss="modal">Cerrar</button> -->
                </div>
            </div>
        </div>
    </div>    
</body>
</html> 