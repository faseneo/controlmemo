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
    <title>Ingreso memo</title>
    <link rel="stylesheet" href="bootstrap/select/css/bootstrap-select.min_1.11.2.css">
    <script src="bootstrap/select/js/bootstrap-select.min_1.6.2.js"></script>
    <script src="bootstrap/select/js/i18n/defaults-es_CL.js"></script>    
    <script src="js/fn_gestiondetmemo.js"></script>
    <script src="js/globalfn.js"></script>
    <script>
        <?php 
            $depto = $_SESSION["deptos"];
            echo "depto=".$depto.";";    
            $uid = $_SESSION["uid"];
            echo "uid=".$uid.";";
            $rolid = $_SESSION["rol"];
            echo "rolid=".$rolid.";";
            if(isset($_REQUEST['medetId'])){
                echo "medetId=".$_REQUEST['medetId'].";\n";
            }
        ?>
        $(document).ready(function(){
            $('[data-toggle="popover"]').popover();   
        });
    </script>
    <style type="text/css">
        .alert {
            margin:5px;
            padding: 5px;
            height: 30px;
        }
        .fixed-panel {
            min-height: 30px;
            max-height: 400px;
            overflow-y: scroll;
        }

        .panel-body {
            overflow-x: auto;
        }
        li#tabdetalle {
            background:#337ab726;
        }
        li#tabcdp {
            background:#5cb85c2e;
        }
        li#tabresolucion {
            /*background:#5cb85c2e;*/
            background:#8dc5e052;
        }
        li#tabobservacion {
            /*background:#f0ad4e2b;*/
            background:#efd79361;
        }

        li#tabusuarios{
            background:#5cb85c2e;
        }        
        li#tabestado {
            background:#8dc5e052;
        }
        li#tabdestino {
            background:#efd79361;
        }
    </style>    
</head>
<body> 
    <?php include "barranav.php"; ?>
    <div class="container-fluid" style="margin-top:50px">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="text-center" id="titulo">Gestión Detalle Memo</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9">
                <ul class="nav nav-tabs">
                    <li id="tabdatosmemo" class="active">
                        <a class="text-primary" data-toggle="tab"  href="#datosmemo">Datos Detalle Memo
                        </a>
                    </li>
                    <li id="tabarchivosmemo">
                        <a class="text-warning" data-toggle="tab" href="#archivosmemo">Listado archivos Detalle Memo 
                        <span class="badge" id="totalArch"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <br>
        <div class="tab-content">
            <div id="datosmemo" class="tab-pane fade in active">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">Datos Memo</div>
                            <div class="panel-body">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Numero</th>
                                            <td id="memnum"></td>
                                        </tr>
                                        <tr>
                                            <th>Fecha Memo</th>
                                            <td id="memfec"></td>
                                        </tr>
                                        <tr>
                                            <th>Asunto o Materia</th>
                                            <td id="memmat"></td>
                                        </tr>
                                        <tr>
                                            <th>Nombre Solicitante</th>
                                            <td id="memnsol"></td>
                                        </tr>
                                        <tr>
                                            <th>Depto. Solicitante</th>
                                            <td id="memdsol"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>    
                    </div>
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">Datos Detalle Memo</div>
                            <div class="panel-body">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Descripción</th>
                                            <td id=""></td>
                                        </tr>
                                        <tr>
                                            <th>Procedimiento Compra</th>
                                            <td id=""></td>
                                        </tr>
                                        <tr>
                                            <th>Proveedor</th>
                                            <td id=""></td>
                                        </tr>
                                        <tr>
                                            <th>Num. OC Sistema Interno</th>
                                            <td id=""></td>
                                        </tr>
                                        <tr>
                                            <th>Num. OC ChileCompra</th>
                                            <td id=""></td>
                                        </tr>
                                        <tr>
                                            <th>Monto Total</th>
                                            <td id=""></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <div id="archivosmemo" class="tab-pane fade">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-7">
                                <h4 class="success">Memo Escaneado </h4>
                            </div>
                            <div class="col-lg-5">
                                <button id="agrega-archivo" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModalArchivoMemo">
                                Agregar Memo
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th width="80%">Nombre Archivo</th>
                                                <th width="20%">Tamaño</th>
                                            </tr>
                                        </thead>
                                        <tbody id="verarchivoMemo">
                                        </tbody>
                                        </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-7">
                                <h4 class="info">Otros archivo Anexos</h4>
                            </div>
                            <div class="col-lg-5">
                                <button id="agrega-archivo-otros" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModalArchivoOtros">
                                Agregar Otros Archivos
                                </button>
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
                                        <tbody id="verlistaArchivosMemo">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                        <ul class="nav nav-tabs">
                            <li id="tabdetalle" class="active"><a class="text-primary" data-toggle="tab" href="#detalle">Facturas 
                                                    <span class="badge" id="totalDet"></span>
                                                </a>
                            </li>
                            <li id="tabcdp"><a class="text-success" data-toggle="tab" href="#cdp">CDP 
                                                    <span class="badge" id="totalCdp"></span>
                                                </a>
                            </li>
                            <li id="tabobservacion"><a class="text-warning" data-toggle="tab" href="#observaciones">Historial Observaciones 
                                    <span class="badge" id="totalObs"></span>
                                </a>
                            </li>
                            <li id="tabestado"><a class="text-info" data-toggle="tab" href="#estados">Historial Estados 
                                    <span class="badge" id="totalHist"></span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="detalle" class="tab-pane fade in active">
                                <div class="panel panel-primary">
                                    <!-- <div class="panel-heading">
                                        <h4 class="panel-title">Detalles<span class="badge" id="totalDet"></span></h4>
                                    </div> -->
                                        <div class="panel-body fixed-panel">
                                            <button id="agregar-det-memo" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModalDetalle">Agregar Detalle Memo</button>
                                            <div class="row" id="listadodet">
                                                <div class="col-lg-12">
                                                    <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th width="8%">Centro de Costo</th>
                                                                <th width="10%">Proc. Compra</th>
                                                                <th width="8%">N° OC CHC</th>
                                                                <th width="8%">OC Sist. Cont.</th>
                                                                <th width="8%">Monto</th>
                                                                <th width="23%">Proveedor</th>
                                                                
                                                                <th width="10%">Fecha</th>

                                                                <th width="10%">Estado</th>
                                                                <th width="8%">Usuario</th>
                                                                <th width="6%">Acciones</th> 
                                                            </tr>
                                                        </thead>
                                                        <tbody id="listaHistorialDet">
                                                            <!-- <tr>
                                                                <td>1018400-5-CM19</td>
                                                                <td>15-04-2019</td>
                                                                <td>15-04-2019</td>
                                                                <td>201900262</td>
                                                                <td>$ 600.297.282</td>
                                                                <td>EMPRESA COMERCIALIZADORA LUIS VALDES LYON EIRL</td>
                                                                <td>Maria José Garcés</td>
                                                                <td>En Espera de Antecedentes</td>
                                                                <td>
                                                                    <button class="btn btn-xs btn-success">ver</button>
                                                                    <button class="btn btn-xs btn-danger">Eliminar</button>
                                                                </td>
                                                            </tr> -->
                                                        </tbody>
                                                    </table>                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="alert alert-warning " id="resultdet">
                                                <span id="resultdetmsg"></span>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div id="cdp" class="tab-pane fade">
                                <div class="panel panel-success">
                                        <div class="panel-body fixed-panel" >
                                            <button id="agregarcdp"  type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#myModalCDPMemo" onclick="getlistaCcostos();">Agrega CDP</button> 
                                            <div class="row" id="listadocdp">
                                                <div class="col-lg-12">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th width="12%">Fecha CDP</th>
                                                                <th width="12%">Numero CDP</th>
                                                                <th width="12%">Codigo Centro Costo</th>
                                                                <th width="34%">Centro de Costo</th>
                                                                <th width="30%">Observacion</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="listacdp">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="alert alert-warning " id="resultcdp">
                                                <span id="resultcdpmsg"></span>
                                            </div>                                            
                                        </div>
                                </div>
                            </div>
                            <div id="observaciones" class="tab-pane fade">
                                <div class="panel panel-warning">
                                        <div class="panel-body fixed-panel" >
                                            <button id="agrega-obs" type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#myModalObsMemo">Agregar Observación</button>
                                            <div class="row" id="listadoobs">
                                                <div class="col-lg-12">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th width="50%">Observación</th>
                                                                <th width="25%">Fecha | Hora</th>
                                                                <th width="25%">Usuario</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="listaHistorialObs">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="alert alert-warning " id="resultobs">
                                                <span id="resultobsmsg"></span>
                                            </div>                                            
                                        </div>
                                </div>
                            </div>
                            <div id="estados" class="tab-pane fade">
                                <div class="panel panel-info">
                                    <!-- <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a id="accord2" data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                                                Historial Cambios Estados 
                                                <span class="badge" id="totalHist"></span>
                                            </a>
                                        </h4>
                                    </div> -->
                                        <div class="panel-body fixed-panel">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th width="15%">Estado</th>
                                                                <th width="40%">Observación</th>
                                                                <th width="15%">Fecha | Hora</th>
                                                                <th width="20%">Modificado por </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="listaHistorial">
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
    </div> <!-- /.container-->

    <!-- Modal HTML -->
    <!-- Modal DETALLE DEL MEMO-->
    <div class="modal fade" id="myModalDetalle" tabindex="-1" role="dialog" aria-labelledby="myModalDetalleLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title-form" id="myModalDetalleLabel">Agrega Detalle</h4>
                    <!-- <div class="alert alert-warning" id="estadoactual"></div> -->
                </div>
                <form role="form" name="formdetallememo" id="formdetallememo" method="post" action="">
                    <input type="hidden" name="Accion" id="Accion" value="registrardetalle" />
                    <input type="hidden" name="detmemId" id="detmemId" value=""/>
                    <input type="hidden" name="detId" id="detmemId" value=""/>
                    <div class="modal-body" id="detallememo">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label >Ingrese N° Memo</label>
                                    <input id="detmemonum" type="text" name="detmemonum" class="form-control" readonly>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="detmemocc">Centro de Costo</label>
                                    <select name="detmemocc" id="detmemocc" class="form-control" data-live-search="true" required>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="detmemonomsolicita">Nombre Contacto</label>
                                    <input id="detmemonomsolicita" type="text" name="detmemonomsolicita" class="form-control" value="">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="msgaddcdp">
                            <div class="col-md-10">
                                <div class="alert alert-warning" id="msgcdp">No existe CDP asociado al memo. Para Ingresar un Detalle debe Ingresar CDP</div>
                            </div>
                            <div class="col-md-2">
                                <button id="agregarcdp"  type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#myModalCDPMemo" onclick="getlistaCcostos();">Agrega CDP</button>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="detmemodescrip">Descripción o detalle </label>
                                    <textarea name="detmemodescrip" id="detmemodescrip" class="form-control"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="detmemoprocompra" >Procedimiento de compra</label>
                                    <select name="detmemoprocompra" id="detmemoprocompra" class="form-control" data-live-search="true" required>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="detmemoprov">Proveedor</label>
                                    <select name="detmemoprov" id="detmemoprov" class="form-control" data-live-search="true" required>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-md-2">
                                <div class="form-group">
                                    <label for="detmemoprovrut" >Rut proveedor</label>
                                    <input id="detmemoprovrut" type="text" name="detmemoprovrut" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>                             -->
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="detmemoocsac">Número OC Sistema Interno</label>
                                    <input id="detmemoocsac" type="text" name="detmemoocsac" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>                        
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="detmemoocchicom">Número OC Chilecompra</label>
                                    <input id="detmemoocchicom" type="text" name="detmemoocchicom" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="detmemomonto">Monto total</label>
                                    <input id="detmemomonto" type="text" name="detmemomonto" class="form-control">
                                    <div class="help-block with-errors"></div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-md-12">
                                <div class="panel-group" id="accordion3">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a id="accord" data-toggle="collapse" data-parent="#accordion3" href="#collapse3">
                                                    Agregar Archivos</a>
                                                    <a href="#" data-toggle="tooltip" title="Archivos que puede subir: pdf, jpg, png, doc, docx, xls, xlsx" data-content="pdf, jpg, png, doc, docx, xls, xlsx"><span class="glyphicon glyphicon-info-sign"></span></a>
                                                </h4>
                                        </div>
                                        <div id="collapse3" class="panel-collapse collapse">
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
                        </div> -->
                    </div>
                </form>
                <div class="modal-footer">
                    <button id="grabar-detmemo" name="grabar-detmemo" type="button" class="btn btn-primary">Guardar</button>
                    <button id="cancel" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Modal cambio estado del memo-->
    <div class="modal fade" id="myModalEstado" tabindex="-1" role="dialog" aria-labelledby="myModalEstadoLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title-form" id="myModalEstadoLabel">Cambio Estado del Memo</h4>
                    <div class="alert alert-warning" id="estadoactual"></div>
                </div>
                <form role="form" name="formcambioestado" id="formcambioestado" method="post" action="">
                    <input type="hidden" name="Accion" id="Accion" value="cambiaestado" />
                    <input type="hidden" name="ultimoEstado" id="ultimoEstado" value="" />
                    <!-- <input type="hidden" name="meId" id="meId" value="" />
                    <input type="hidden" name="uId" id="uId" value="" /> -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="memoEstado">Nuevo Estado</label>
                                    <select name="memoEstado" id="memoEstado" class="form-control"></select>
                                    <span class="help-block"></span>
                                </div> 
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="memoOtroDeptoNombre">
                                    <label for="memoDeptoNombre">Nombre Destinatario</label>
                                    <input name="memoDeptoNombre" id="memoDeptoNombre" type="text"  class="form-control">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" id="memoOtroDepto">
                                    <label for="memoOtroDeptoId">Departamento o Unidad Destino</label>
                                    <select name="memoOtroDeptoId" id="memoOtroDeptoId" class="form-control" data-live-search="true" required>
                                    </select>
                                    <span class="help-block" id ="msgerrordeptoid"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="memoObs">Observacion</label>
                                    <textarea class="form-control" rows="5" id="memoObs" name="memoObs" required></textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="grabar-estado" name="grabar-estado" type="button" class="btn btn-primary">Guardar</button>
                        <button id="cancel" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Modal AGREGA OBSERVACIONES al memo  myModalObsMemo-->
    <div class="modal fade" id="myModalObsMemo" tabindex="-1" role="dialog" aria-labelledby="myModalObsMemoLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title-form" id="myModalObsMemoLabel">Agrega Observación al memo</h4>
                </div>
                <form role="form" name="formobservacion" id="formobservacion" method="post" action="">
                    <input type="hidden" name="Accion" id="Accion" value="registrar" />
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="memobsTexto">Observacion</label>
                                    <textarea id="memobsTexto" name="memobsTexto" class="form-control" rows="5"></textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="grabar-addobs" name="guardar-estado" type="button" class="btn btn-primary">Guardar</button>
                        <button id="canceladdobs" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Modal AGREGA ARCHIVOS al memo-->
    <div class="modal fade" id="myModalArchivoMemo" tabindex="-1" role="dialog" aria-labelledby="myModalArchivoMemoLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title-form" id="myModalArchivoMemoLabel">Modifica Archivo Memo Escaneado</h4>
                </div>
                <form role="form" name="formarchivomemo" id="formarchivomemo" method="post" action="">
                    <input type="hidden" name="Accion" id="Accion" value="actualizarfiles" />
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="btn btn-success btn-sm" for="addmemoFile">
                                        <input id="addmemoFile" name="addmemoFile" type="file" accept=".jpg, .jpeg, .png, .pdf, .doc, .docx" style="display:none">Examinar...
                                    </label>
                                    <span class='label label-info' id="addmemoFileInfo"></span>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th width="80%">Nombre Archivo</th>
                                                <th width="20%">Tamaño</th>
                                            </tr>
                                        </thead>
                                        <tbody id="addarchivoMemo">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="msgarchivomemo" class="alert alert-warning" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            <span class="sr-only" >Error:</span>
                            ¡Ya Existe archivo del memo!. Si sube uno nuevo eliminará el archivo anterior
                        </div>
                    </div>    
                    <div class="modal-footer">
                        <button id="grabar-archivomemo" name="guardar-estado" type="button" class="btn btn-primary">Guardar Archivo</button>
                        <button id="cancel-archivomemo" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Modal AGREGA OTROS ARCHIVOS al memo-->
    <div class="modal fade" id="myModalArchivoOtros" tabindex="-1" role="dialog" aria-labelledby="myModalArchivoOtrosLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title-form" id="myModalArchivoOtrosLabel">Agrega Otros Archivos Anexos</h4>
                </div>
                <form role="form" name="formarchivomemootros" id="formarchivomemootros" method="post" action="">
                    <input type="hidden" name="Accion" id="Accion" value="actualizarfiles" />
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="btn btn-success btn-sm" for="addmemoFileList">
                                        <input id="addmemoFileList" name="addmemoFileList[]" type="file" accept=".jpg, .jpeg, .png, .pdf, .doc, .docx" multiple  style="display:none">Examinar...
                                    </label>
                                    <span class='label label-info' id="addmemoFileListInfo"></span>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th width="80%">Nombre Archivo</th>
                                                <th width="20%">Tamaño</th>
                                            </tr>
                                        </thead>
                                        <tbody id="addarchivoMemoList">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- <div id="msgarchivomemo" class="alert alert-warning" role="alert">
                                 <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                 <span class="sr-only" >Error:</span>
                                 ¡Ya Existe archivo del memo!. Si sube uno nuevo eliminará el archivo anterior
                        </div> --> 
                    </div>
                    <div class="modal-footer">
                        <button id="grabar-otrosarchivomemo" name="guardar-estado" type="button" class="btn btn-primary">Guardar Archivo</button>
                        <button id="cancel-otrosarchivomemo" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Modal mensajes cortos por Ej: Mensaje Memo guardado -->
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

    <!-- Modal Animacin cargando en epsera por Ej. para  Mensaje Memo guardado -->
    <div class="modal fade" id="ModalCargando" tabindex="-1" role="dialog" aria-labelledby="ModalCargandoLabel">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="loader"></div>
                    <p id="msg" class="msg">Guardando...</p>
                </div>
                <div class="modal-footer">
                    <!--  <button type="button" id="cerrarModalCargando" class="btn btn-default" data-dismiss="modal">Cerrar</button> -->
                </div>
            </div>
        </div>
    </div>
</body>
</html> 