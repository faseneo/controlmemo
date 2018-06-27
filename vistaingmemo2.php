<!DOCTYPE html>
<html lang="es">
<head>
    <?php include "header.php"; ?>
    <title>Ingreso memo</title>
    <script src="js/funcionesmemo.js"></script>
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
                <center><h1>Ingreso memo</h1></center>
                <form id="formIngresoMemo" name="formIngresoMemo" method="POST" action="" role="form">
                    <input type="hidden" name="memoId" id="memoId" value="" />
                    <input type="hidden" name="AccionMemo" id="AccionMemo" value="registrar" />
                    <div class="messages"></div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="memoNum">Número Memo</label>
                                <input name="memoNum" id="memoNum" type="text"  class="form-control" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                            <label >Número Resolución</label><br>
                                <!-- <button type="button" class="btn btn-primary">Buscar número</button> -->
                                <button type="button" id="busca-resolucion" class="btn btn-primary"
                                    data-toggle="modal" data-target="#myModalBuscaRes" >Buscar Resolución</button>
                                    <br>
                                <input name="memoUrlRes" id="memoUrlRes" type="hidden"/>
                                <a href="#" id="linkres" target="_blank"></a>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="memoMateria">Materia</label>
                                <textarea name="memoMateria" id="memoMateria" class="form-control"></textarea>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="memoFecha">Fecha memo</label>
                                <input name="memoFecha" id="memoFecha" type="date" class="form-control" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="memoFechaRecep">Fecha recepción memo</label>
                                <input name="memoFechaRecep" id="memoFechaRecep" type="date" class="form-control" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
<!--                         <div class="col-md-6">
    <div class="form-group">
        <label for="memoFechaAnalista" >Fecha entrega analista</label>
        <input name="memoFechaAnalista" id="memoFechaAnalista" type="date" class="form-control">
        <div class="help-block with-errors"></div>
    </div>
</div> -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="memoDepto">Departamento</label>
                                <select name="memoDepto" id="memoDepto" class="form-control" required>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="memoCcosto">Centro de costos</label>
                                <select name="memoCcosto" id="memoCcosto" class="form-control" required>
                                    <option value="0">Seleccionar</option> 
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="memoCodigoCcosto" >Código centro de costos</label>
                                <input name="memoCodigoCcosto" id="memoCodigoCcosto" type="text"  class="form-control" readonly>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group"> <!-- data-toggle="modal" data-target="#myModalDetalle" -->
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
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label class="btn btn-primary" for="my-file-selector">
                                <input id="my-file-selector" name="my-file-selector" type="file" accept=".jpg, .jpeg, .png, .pdf, .doc, .docx, .xls, .xlsx" multiple style="display:none">Agregar archivo
                            </label><button id="limpiar-archivo" type="button" class="btn btn-default" data-dismiss="modal">Quitar Archivos</button>
                            <span class='label label-info' id="upload-file-info"></span>
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
                            <button id="finalizar-memo" name="finalizar-memo" type="button" class="btn btn-primary">Finalizar</button>

                            <button id="limpiar-memo" type="button" class="btn btn-default" data-dismiss="modal">Limpiar</button>
                            <button id="cancelar-memo" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </form>    
            </div><!-- /.10 -->
        </div> <!-- /.row-->
    </div> <!-- /.container-->

    <div class="modal fade" id="myModalDetalle" tabindex="-1" role="dialog" aria-labelledby="myModalDetalleLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title-form" id="myModalDetalleLabel">Ingreso Detalle Memo</h4>
                </div>
                <div class="modal-body">
                    <form role="form" name="formDetalleMemo" id="formDetalleMemo" method="POST" action="">
                        <input type="hidden" name="memoDetId" id="memoDetId" value="" />
                        <input type="hidden" name="AccionMemoDet" id="AccionMemoDet" value="" />    
                         <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="memoDetPcompra">Procedimiento de compra</label>
                                    <select name="memoDetPcompra" id="memoDetPcompra" class="form-control">
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="memoDetNumOCCHC">Número OC Chilecompra</label>
                                    <input name="memoDetNumOCCHC" id="memoDetNumOCCHC" type="text"  class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="memoDetOCManager">Número OC Manager</label>
                                    <input name="memoDetOCManager" id="memoDetOCManager" type="text" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>                    
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="memoDetProveedor">Proveedor</label>
                                    <select name="memoDetProveedor" id="memoDetProveedor" class="form-control">
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>                
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="memoDetRutProv">Rut Proveedor</label>
                                    <input name="memoDetRutProv" id="memoDetRutProv" type="text"  class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="memoDetCDP" >Fecha CDP</label>
                                    <input name="memoDetCDP" id="memoDetCDP" type="date"  class="form-control">
                                    <span class="help-block">Certificado Disponibilidad Presupuestaria</span>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="memoDetFechaFact">Fecha factura</label>
                                    <input name="memoDetFechaFact" id="memoDetFechaFact" type="date" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="memoDetNumFact">Número factura</label>
                                    <input name="memoDetNumFact" id="memoDetNumFact" type="text" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="memoDetMontoFact">Monto Total</label>
                                    <input name="memoDetMontoFact"  id="memoDetMontoFact" type="text" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>                    
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="button" id="crea-detalle-compra" class="btn btn-primary"
                                    data-toggle="modal" data-target="#myModalDetalleCompra" >Agregar detalle Compra</button>
                                    <button type="button" id="carga-detalle-compra" class="btn btn-primary"
                                    data-toggle="modal" data-target="#myModalDetalleCompra" >Cargar xml Compra</button>
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
                                                <th width="50%">Producto</th>
                                                <th width="10%">Cantidad</th>
                                                <th width="10%">Valor</th>
                                                <th width="10%">Total</th>
                                                <th width="10%">Editar</th>
                                                <th width="10%">Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody id="listaDetalleCompra">
                                            <tr>
                                                <td>&nbsp;</td>
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
                        </div>                
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="button" id="agrega-archivo-detmemo" class="btn btn-primary"
                                    data-toggle="modal" data-target="#myModalDetArchivo">Agregar archivo</button>
                                    <!-- <input name="" type="submit" class="btn btn-success btn-send" value="Agregar archivo"> -->
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
                                            <th width="80%">Nombre Archivo</th>
                                            <th width="10%">Editar</th>
                                            <th width="10%">Eliminar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="listaArchivosDetMemo">
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>                         
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="memoDetobs">Observaciones</label>
                                    <textarea name="memoDetobs" id="memoDetobs" class="form-control"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="memoDetEstado">Estado</label>
                                    <select name="memoDetEstado" id="memoDetEstado" class="form-control">
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="editar-det-memo" name="editar-det-memo" type="button" class="btn btn-warning">Editar</button>
                    <button id="actualizar-det-memo" name="actualizar-det-memo" type="button" class="btn btn-primary">Actualizar</button>
                    <button id="agregar-det-memo" name="agregar-det-memo" type="button" class="btn btn-primary">Guardar</button>

                    <button id="limpiar-det-memo" type="button" class="btn btn-default">Limpiar</button>                    
                    <button id="cancel" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <div class="help-block with-errors"></div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->    

    <!-- Modal para agregar Detalle Compra -->
    <div class="modal fade" id="myModalDetalleCompra" tabindex="-1" role="dialog" aria-labelledby="myModalDetalleCompraLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title-form" id="myModalDetalleCompraLabel">Ingreso Detalle Compra</h4>
                </div>
                <div class="modal-body">
                    <form role="form" name="formDetalleCompra" id="formDetalleCompra" method="POST" action="">
                        <input type="hidden" name="detCompraId" id="detCompraId" value="" />
                        <input type="hidden" name="AccionDetCompra" id="AccionDetCompra" value="" />    
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="detCompraNombreProd">Nombre Producto</label>
                                    <textarea name="detCompraNombreProd" id="detCompraNombreProd" class="form-control"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="detCompraCantidad">Cantidad</label>
                                    <input name="detCompraCantidad"  id="detCompraCantidad" type="text" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="detCompraValor">Valor</label>
                                    <input name="detCompraValor"  id="detCompraValor" type="text" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>                
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="detCompraTotal">Total</label>
                                    <input name="detCompraTotal"  id="detCompraTotal" type="text" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>                       
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="editar-det-memo-compra" name="editar-det-memo-compra" type="button" class="btn btn-warning">Editar</button>
                    <button id="actualizar-det-memo-compra" name="actualizar-det-memo-compra" type="button" class="btn btn-primary">Actualizar</button>
                    <button id="agregar-det-memo-compra" name="agregar-det-memo-compra" type="button" class="btn btn-primary">Agregar</button>
                    <button id="limpiar-det-memo-compra" type="button" class="btn btn-default">Limpiar</button>
                    <button id="cancel" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Modal para buscar resoluciones -->
    <div class="modal fade" id="myModalBuscaRes" tabindex="-1" role="dialog" aria-labelledby="myModalBuscaResLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title-form" id="myModalBuscaResLabel">Busqueda Resolución</h4>
                </div>
                <div class="modal-body">
                    <form role="form" name="formBusquedaRes" id="formBusquedaRes" method="POST" action="">
                        <input type="hidden" name="Accion" id="Accion" value="buscar" />    
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="buscaNumRes">Numero Resolución </label>
                                    <span class="help-block">(año res - numero res)</span>
                                    <input name="buscaNumRes"  id="buscaNumRes" type="text" class="form-control" placeholder="Ej: 2017-999999">
                                    <div id="msgres">
                                    <!-- <div class="alert alert-danger hidden" id="msgres" role="alert" ></div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="buscar-res" name="buscar-res" type="button" class="btn btn-primary">Buscar</button>
                    <button id="limpiar-busca_res" type="button" class="btn btn-default">Limpiar</button>
                    <button id="cancel" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
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