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
    <script src="js/fn_listadomemoasigna.js"></script>
    <script>
        <?php 
        echo "depto=".$_SESSION["deptos"].";";
        $uid = $_SESSION["uid"];
        echo "uid=".$uid.";";
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
    <?php include "barranav.php"; ?>
    <div class="container-fluid" style="margin-top:50px" id="bodyprincipal">  
        <div class="row"> 
            <div class="col-md-12 ">
                <center><h2>Listado Memos <span class="badge" id="totalmemos"></span></h2> </center><br>
                <div class="panel-group" id="accordion">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4 class="panel-title" id="tituloPanelDestino">
                                <a id="accord1" data-toggle="collapse" data-parent="#accordion" href="#collapse1"></a>
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
                                                <label for="usuarioasigna">Usuario Asignado</label>
                                                <select name="usuarioasigna" id="usuarioasigna" class="form-control" >
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
                        <div id="boxloader">
                                <div class="loader"></div>
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
                                            <th id="tdfd" width="6%" class="orden">Fecha Doc.</th>
                                            <th id="tdfr" width="6%" class="orden">Fecha Recepción</th>
                                            <th id="tdma" width="26%" class="orden">Materia o Asunto</th>
                                            <th id="tdds" width="18%" class="orden">Departamento Solicitante</th>
                                            <th id="tddd" width="10%" class="orden">Analísta</th>
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

    <!-- Modal para asignar usuarios -->
    <div class="modal fade" id="myModalAsiganUsu" tabindex="-1" role="dialog" aria-labelledby="myModalAsiganUsuLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="overflow:hidden;">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="myModalAsiganUsuLabel"><b>Asigna Analista</b></h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Datos Memo</h3>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th width="15%">Numero Memo</th>
                                        <th width="50%">Materia</th>
                                        <th width="35%">Departamento</th>    
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td id="memonum"></td>
                                        <td id="memomat"></td>
                                        <td id="memodpto"></td>    
                                    </tr>    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Asignaciones</h3>
                        </div>
                    </div>
                    <div class="row">
                        <form role="form" name="formAsignaMem" id="formAsignaMem" method="POST" action="">
                            <input type="hidden" name="Accion" id="Accion" value="asignamemo" />
                            <input type="hidden" name="memoId" id="memoId" value="" />
                            <input type="hidden" name="memoultest" id="memoultest" value="" />
                            <input type="hidden" name="nomanalista" id="nomanalista" value="" />
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="asignausu">Analista</label>
                                    <select name="asignausu" id="asignausu" class="form-control" >
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="asignadif">Dificultad</label>
                                    <select name="asignadif" id="asignadif" class="form-control" >
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="asignaprio">Prioridad</label>
                                    <select name="asignaprio" id="asignaprio" class="form-control" >
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>                            
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="asignaobs">Observacion</label>
                                    <textarea class="form-control" rows="1" id="asignaobs" name="asignaobs" ></textarea>
                                </div>
                            </div>
                        </form>                            
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-md-offset-9" style="text-align: right;">
                            <button id="asigna" name="asigna" type="button" class="btn btn-primary">Asignar</button>
                            <button id="limpiar-memo" name="limpia" type="button" class="btn btn-default">Limpiar</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="10%">Fecha/Hora</th>
                                        <th width="30%">Analista</th>
                                        <th width="20%">Estado</th>
                                        <th width="20%">Dificultad</th>
                                        <th width="20%">Prioridad</th>
                                    </tr>
                                </thead>
                                <tbody id="listusuasigna">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button id="asigna" name="asigna" type="button" class="btn btn-primary">Asignar</button>
                     -->
                    <button id="cancel" name="cancel" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button> 
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