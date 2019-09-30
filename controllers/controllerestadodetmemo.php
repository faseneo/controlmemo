<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/estado_detmemo/entidadestadodetmemo.php';
require_once '../modelo/estado_detmemo/modelestadodetmemo.php';

// Logica
$estadoDM = new EstadoDetMemo();
$modelestadoDM = new ModelEstadoDetMemo();

if(isset($_REQUEST['Accion'])){

    switch($_REQUEST['Accion']){

        case 'actualizar':
            $estadoDM->__SET('est_detmemo_id',        $_REQUEST['estadoDMId']);
            $estadoDM->__SET('est_detmemo_tipo',      $_REQUEST['estadoDMTipo']);
            $estadoDM->__SET('est_detmemo_orden',     $_REQUEST['estadoDMOrden']);
            $estadoDM->__SET('est_detmemo_desc',      $_REQUEST['estadoDMDesc']);
            $estadoDM->__SET('est_detmemo_activo',    $_REQUEST['estadoDMActivo']);
            $jsondata = $modelestadoDM->Actualizar($estadoDM);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'registrar':
            $estadoDM->__SET('est_detmemo_tipo',      $_REQUEST['estadoDMTipo']);
            $estadoDM->__SET('est_detmemo_orden',     $_REQUEST['estadoDMOrden']);
            $estadoDM->__SET('est_detmemo_desc',      $_REQUEST['estadoDMDesc']);
            $estadoDM->__SET('est_detmemo_activo',    $_REQUEST['estadoDMActivo']);     
            $jsondata = $modelestadoDM->Registrar($estadoDM);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'eliminar':
            $jsondata = $modelestadoDM->Eliminar($_REQUEST['estadoDMId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtener':
            $jsondata = $modelestadoDM->Obtener($_REQUEST['estadoDMId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
            
        case 'listar':
            $jsondata = $modelestadoDM->Listar();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'listarmin':
            $jsondata = $modelestadoDM->ListarMin();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;
    }
}

?>