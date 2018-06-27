<!DOCTYPE html>
<html lang="es">
<head>
    <?php include "header.php"; ?>
    <title>Ingreso memo</title>
    <script src="js/fnmemo.js"></script>
    <style type="text/css">
        .alert {
            margin:5px;
            padding: 5px;
            height: 30px;
        }
    </style>
</head>
<body> 
    <?php include "barranav.php"; ?>
    <div class="container" style="margin-top:50px">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <h1 class="text-center">Ingreso memo </h1>
                <form id="formIngresoMemo" name="formIngresoMemo" method="POST" action="" role="form">
                    <input type="hidden" name="memoId" id="memoId" value="" />
                    <input type="hidden" name="AccionMemo" id="AccionMemo" value="registrar" />
                    <div class="messages"></div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="memoFecha">Fecha memo</label>
                                <input name="memoFecha" id="memoFecha" type="date" class="form-control" required onchange="aniomemo();">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="memoNum">Número Memo</label>
                                <input name="memoNum" id="memoNum" type="text"  class="form-control" maxlength="5" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label class="control-label" for="memoAnio">Año</label>
                                <input name="memoAnio" id="memoAnio" type="text"  class="form-control textocol1" maxlength="5"  readonly="">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="memoFechaRecep">Fecha recepción memo</label>
                                <input name="memoFechaRecep" id="memoFechaRecep" type="date" class="form-control" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="memoMateria">Asunto o Materia</label>
                                <textarea name="memoMateria" id="memoMateria" class="form-control"></textarea>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="memoNombreSolicitante">Nombre Solicitante</label>
                                <input name="memoNombreSolicitante" id="memoNombreSolicitante" type="text"  class="form-control" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>                        

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="memoDeptoSolicitante">Departamento o Unidad Solicitante</label>
                                <select name="memoDeptoSolicitante" id="memoDeptoSolicitante" class="form-control" required>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="memoNombreDestinatario">Nombre Destinatario</label>
                                <input name="memoNombreDestinatario" id="memoNombreDestinatario" type="text"  class="form-control" value="Leonel Durán" >
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>                        

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="memoDeptoDestinatario">Departamento o Unidad Destinatario</label>
                                <select name="memoDeptoDestinatario" id="memoDeptoDestinatario" class="form-control" required>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>                    
                    <!--<div class="row">
                         <div class="col-md-6">
                             <div class="form-group"> data-toggle="modal" data-target="#myModalDetalle"
                                 <button type="submit" id="crea-detalle-memo" class="btn btn-primary" >Agregar detalle</button>
                                 <div class="help-block with-errors"></div>
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-lg-12">
                             <div class="table-responsive">
                                 <table class="table table-striped">
                                     <thead>
                                         <tr>
                                             <th width="40%">Descripción</th>
                                             <th width="30%">Proveedor</th>
                                             <th width="10%">N° Factura</th>
                                             <th width="10%">Editar</th>
                                             <th width="10%">Eliminar</th>
                                         </tr>
                                     </thead>
                                     <tbody id="listaDetalleMemo">
                                         <tr>
                                             <td>&nbsp;</td>
                                             <td>&nbsp;</td>
                                             <td>&nbsp;</td>
                                             <td>&nbsp;</td>
                                             <td>&nbsp;</td>
                                         </tr>
                                     </tbody>
                                 </table>
                             </div>
                         </div>
                     </div>-->
                    <div class="row">
                        <div class="col-lg-3">
                            <label>PDF, JPG, PNG, DOC, DOCX, XLS, XLSX</label>
                            <label class="btn btn-success btn-sm" for="my-file-selector">
                                <input id="my-file-selector" name="my-file-selector" type="file" accept=".jpg, .jpeg, .png, .pdf, .doc, .docx, .xls, .xlsx" multiple style="display:none">Agregar archivo memo escaneado
                            </label>
                            <span class='label label-info' id="upload-file-info"></span>
                        </div>
                        <div class="col-lg-9">
                            <p id="archivoMemo"></p>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <label class="btn btn-primary btn-sm" for="my-filelist-selector">
                                <input id="my-filelist-selector" name="my-filelist-selector" type="file" accept=".jpg, .jpeg, .png, .pdf, .doc, .docx, .xls, .xlsx" multiple style="display:none">Agregar otros archivos Anexos
                             </label><span class='label label-info' id="upload-filelist-info"></span> &nbsp; &nbsp;
                             <button id="limpiar-archivo" type="button" class="btn btn-sm btn-default" data-dismiss="modal">Quitar Archivos</button>
                             
                        </div>                             
                     </div>
                     <div class="row">
                         <div class="col-lg-12">
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
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="memoEstado">Estado</label>
                                <select name="memoEstado" id="memoEstado" class="form-control">
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-md-offset-4">
                            <button id="editar-memo" name="editar-memo" type="button" class="btn btn-warning">Editar</button>
                            <button id="actualizar-memo" name="actualizar-memo" type="button" class="btn btn-primary">Actualizar</button>
                            <button id="grabar-memo" name="grabar-memo" type="button" class="btn btn-primary">Grabar</button>
                            <button id="limpiar-memo" type="button" class="btn btn-default" data-dismiss="modal">Limpiar</button>
                            <!-- <button id="cancelar-memo" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button> -->
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
</body>
</html> 