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
    <title>Detalle Memo</title>
    <script src="js/fn_vs_memodetalle.js"></script>
    <script src="js/globalfn.js"></script>    
</head>
<body>
    <?php include "barranav.php"; ?>
    <div class="container" style="margin-top:50px">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <center><h1>Ingreso Detalle Memo</h1></center><br><br>
                <form id="contact-form" method="post" action="#" role="form">
                    <div class="messages"></div>
                    <div class="controls">
                        
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label >Ingrese N° Memo</label>
                                    <input id="" type="text" name="" class="form-control" placeholder="Ej: 2018-123">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label >Centro Costo</label>
                                    <input id="" type="text" name="" class="form-control" value="">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Nombre Solicitante</label>
                                    <input id="" type="text" name="" class="form-control" value="">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label >Departamento Solicitante</label>
                                    <input id="" type="text" name="" class="form-control" value="">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>                            
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label >Descripción o detalle </label>
                                    <textarea name="" class="form-control"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label >Procedimiento de compra</label>
                                    <select name="select" class="form-control">
                                        <option value="value2" >Caja Chica</option>
                                        <option value="value3">Convenio Marco (CM)</option>
                                        <option value="value3">Compra directa</option>
                                        <option value="value3">Gran compra</option>
                                        <option value="value3">Licitacion Publica / Privada</option>
                                        <option value="value3">Trato directo</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >Proveedor</label><br>
                                    <select name="select" class="form-control">
                                        <option value="value1">EDENRED CHILE SOCIEDAD ANONIMA</option> 
                                        <option value="value2">WEI CHILE S.A.</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label >Rut proveedor</label>
                                    <input id="" type="text" name="" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label >Número orden de compra Sistema Interno</label>
                                    <input id="" type="text" name="" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>                        
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label >Número orden compra Chilecompra</label>
                                    <input id="" type="text" name="" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label >Monto total</label>
                                    <input id="" type="text" name="" class="form-control">
                                    <div class="help-block with-errors"></div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                            <!--                                 <div class="form-group"><br>
                                <input type="submit" class="btn btn-success btn-send" value="Agregar detalle">
                                <input type="submit" class="btn btn-success btn-send" value="Agregar archivo">
                                <div class="help-block with-errors"></div>
                            </div> -->
                            <div class="panel-group" id="accordion">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a id="accord" data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                                Agregar Archivos</a>
                                                <a href="#" data-toggle="tooltip" title="Archivos que puede subir: pdf, jpg, png, doc, docx, xls, xlsx" data-content="pdf, jpg, png, doc, docx, xls, xlsx"><span class="glyphicon glyphicon-info-sign"></span></a>
                                            </h4>
                                        </div>
                                        <div id="collapse1" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="row">
                                                    
                                                    <div class="col-lg-12">
                                                        <label class="btn btn-primary btn-sm" for="memoFileList">
                                                            <input id="memoFileList" name="memoFileList[]" type="file" accept=".jpg, .jpeg, .png, .pdf, .doc, .docx, .xls, .xlsx" multiple style="display:none">Agregar archivos Anexos
                                                        </label><span class='label label-info' id="memoFileListInfo"></span> &nbsp; &nbsp;
                                                        <button id="limpiar-archivo" type="button" class="btn btn-sm btn-default" data-dismiss="modal">Quitar Archivos</button>
                                                    </div>
                                                </div>
                                                <br>
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
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>                            
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label >Estado</label>
                                    <select name="select" class="form-control">
                                        <option value="1">En Espera de Antecedentes</option> 
                                        <option value="2">Compra Parcial</option>
                                        <option value="3">Compra Realizada</option>
                                        <option value="4">Orden de Compra Nula</option>
                                        <option value="4">Orden de Compra Cancelada</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label >Observaciones</label>
                                    <textarea name="" class="form-control"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>                            
                        </div>
                        <br><br><br>
                        <div class="row">
                           <div class="col-md-4 col-md-offset-8">
                            <button id="editar-memo" name="editar-memo" type="button" class="btn btn-warning">Editar</button>
                            <button id="actualizar-memo" name="actualizar-memo" type="button" class="btn btn-primary">Actualizar</button>
                            <button id="grabar-memo" name="grabar-memo" type="button" class="btn btn-primary">Grabar</button>
                            <button id="limpiar-memo" type="button" class="btn btn-default" data-dismiss="modal">Limpiar</button>
                            <button id="cancelar-memo" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <div class="help-block with-errors"></div>
                        </div>
                        </div>
                    </div>
                </form>
            </div><!-- /.8 -->
        </div> <!-- /.row-->
    </div> <!-- /.container-->
</body>
</html>