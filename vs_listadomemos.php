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
    <link rel="stylesheet" href="bootstrap/select/css/bootstrap-select.min_1.11.2.css">
    <script src="bootstrap/select/js/bootstrap-select.min_1.6.2.js"></script>
    <script src="bootstrap/select/js/i18n/defaults-es_CL.js"></script>
    <script src="js/globalfn.js"></script>    
    <script src="js/fn_listadomemos.js"></script>
    <script>
        <?php 
        echo "depto=".$_SESSION["deptos"].";";
        $uid = $_SESSION["uid"];
        echo "uid=".$uid.";\n";
        $rolid = $_SESSION["rol"];
        echo "rolid=".$rolid.";\n";
        ?>
    </script>
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
        .checkbox input[type=checkbox], .checkbox-inline input[type=checkbox], .radio input[type=radio], .radio-inline input[type=radio] {
            position: relative;
            margin-left: -20px;
        }
        span .select2-container {
            z-index : 10050 ; 
        }
    </style>
</head>
<body>
    <?php include "barranav.php";?>
    <div class="container-fluid" style="margin-top:50px" id="bodyprincipal">  
        <div class="row"> 
            <div class="col-md-12 ">
                <center><h2>Listado Memos <span class="badge" id="totalmemos"></span></h2> </center><br>
                <div class="panel-group" id="accordion">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4 class="panel-title" id="tituloPanelDestino">
                                <a id="accord1" data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                </a>
                            </h4>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse">
                            <div class="panel-body">
                                <form id="formulariofiltro" method="post" action="#" role="form">
                                    <div class="row">
                                        <div class="col-sm-2">
                                             <div class="form-group">
                                                <label for="memoEstado">Estado</label>  
                                                <select name="memoEstado" id="memoEstado" class="form-control" data-live-search="true">
                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                             <div class="form-group">
                                                <label for="memoDeptoSol">Departamento Solicitante</label>  
                                                <select name="memoDeptoSol" id="memoDeptoSol" class="form-control" data-live-search="true">
                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                             <div class="form-group">
                                                <label for="memoDeptoDest">Departamento Destinatario</label>  
                                                <select name="memoDeptoDest" id="memoDeptoDest" class="form-control" data-live-search="true">
                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                             <div class="form-group">
                                                <label for="memoAnio">Año Doc.</label>  
                                                <select name="memoAnio" id="memoAnio" class="form-control" data-live-search="true">
                                                    <option value="0">Todos..</option>
                                                    <option value="2018">2018</option>
                                                    <option value="2019">2019</option>
                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                             <div class="form-group">
                                                <label for="memoMes">Mes Doc.</label>  
                                                <select name="memoMes" id="memoMes" class="form-control" data-live-search="true">
                                                    <option value="0">Todos..</option>
                                                    <option value="1">Enero</option>
                                                    <option value="2">Febrero</option>
                                                    <option value="3">Marzo</option>
                                                    <option value="4">Abril</option>
                                                    <option value="5">Mayo</option>
                                                    <option value="6">Junio</option>
                                                    <option value="7">Julio</option>
                                                    <option value="8">Agosto</option>
                                                    <option value="9">Septiembre</option>
                                                    <option value="10">Octubre</option>
                                                    <option value="11">Noviembre</option>
                                                    <option value="12">Diciembre</option>
                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>                            
                                        <div class="col-sm-1">
                                             <div class="form-group">
                                                <label class="control-label" for="numDoc">Número doc.</label>
                                                    <div class="input-group">
                                                        <input name="numDoc" id="numDoc" type="text"  class="form-control input-sm" maxlength="10">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-primary btn-sm" type="button" id="buscarnumdoc">
                                                                    <span class="glyphicon glyphicon-search"></span>
                                                            </button>
                                                        </span>
                                                    </div>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <button class="btn btn-primary btn-sm" type="button" id="activacest">Activar Cambio Estado Masivos</button>
                        <div id="capacest">
                            <img class="selectallarrow" width="38" height="22" src="img/arrow_rtl.png" alt="Para los elementos que están marcados:">
                            <button class="btn btn-primary btn-sm" type="button" id="cestmodal" data-toggle="modal" data-target="#myModalEstado">
                                Cambiar Estado
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                            <div id="boxloader">
                                <div class="loader"></div><!-- <p id="msg" class="msg">Cargando ...</p> -->
                            </div>
                    </div>
                    <div class="col-md-9">
                        <h4 id="titulolistado">Listado memos de : <span id="nombreusu"></span></h4>
                    </div>
                </div>                    
                <div class="row">
                    <div class="col-md-12">
                        <form id="cestadomasivos" name="cestadomasivos" method="" action="">
                            <table class="table table-responsive  table-hover">
                                    <thead>
                                        <tr>
                                            <th id="tdce" width="2%"><input type="checkbox" id="chekseltodos" value="opcion_1"></th>
                                            <th id="tdnu" width="6%" class="orden">Año / Número</th>
                                            <th id="tdfd" width="6%" class="orden">Fecha Documento</th>
                                            <th id="tdfr" width="6%" class="orden">Fecha Recepción</th>
                                            <th id="tdma" width="18%" class="orden">Materia o Asunto</th>
                                            <th id="tdds" width="18%" class="orden">Departamento Solicitante</th>
                                            <th id="tddd" width="18%" class="orden">Departamento Destinatario</th>
                                            <th id="tdea" width="12%" class="orden">Estado Actual</th>
                                            <th id="tddm" width="5%" class="orden">Dias sin Movimiento</th>
                                            <th id="tdac" width="10%">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="listamemos">
                                    </tbody>
                            </table>
                        </form>
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

    <!-- Modal Cargando-->
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
    <!-- Modal cambio estado del memo-->
    <div class="modal fade" id="myModalEstado" tabindex="-1" role="dialog" aria-labelledby="myModalEstadoLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="overflow:hidden;">
                <div class="modal-header bg-info" >
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title-form" id="myModalEstadoLabel">Cambio Estado del Memo</h4>
                    <div class="alert alert-danger" id="debeseleccionar"></div>
                </div>
                <form role="form" name="formcambioestado" id="formcambioestado" method="post" action="">
                    <input type="hidden" name="Accion" id="Accion" value="cambiaestado" />
                    <input type="hidden" name="ultimoEstado" id="ultimoEstado" value="" />
                    <!-- <input type="hidden" name="meId" id="meId" value="" />
                    <input type="hidden" name="uId" id="uId" value="" /> -->
                    <div class="modal-body" id="bodyestado">
                        <div class="alert alert-warning" id="estadoactual"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="memoEstadoce">Nuevo Estado</label>
                                    <select name="memoEstadoce" id="memoEstadoce" class="form-control"></select>
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
                                    <label for="memoOtroDeptoId" class="control-label">Departamento o Unidad Destino</label>
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
                    <div class="modal-footer" id="footerestado">
                        <button id="grabar-estado" name="grabar-estado" type="button" class="btn btn-primary">Guardar</button>
                        <button id="cancel" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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
    <!-- Modal Destinos-->
    <div class="modal fade" id="myModalDestino" tabindex="-1" role="dialog" aria-labelledby="myModalDestinoLabel">
        <div class="modal-dialog">
            <div class="modal-content"  style="overflow:hidden;">
                <div class="modal-header bg-warning">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Historial Destinos</h4>
                </div>
                <div class="modal-body">
                        <div class="row">
                                <div class="col-lg-12">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th width="50%">Destino</th>
                                                    <th width="50%">Fecha</th>
                                                </tr>
                                            </thead>
                                            <tbody id="listaHistorialDeriv">
                                            </tbody>
                                        </table>
                                </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="cerrarModalLittle" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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