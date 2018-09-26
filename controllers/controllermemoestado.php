<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/memoestado/entidadmemoestado.php';
require_once '../modelo/memoestado/modelmemoestado.php';

// Logica
$MEst = new MemoEst();
$modelMEst = new ModelMemoEst();

if(isset($_REQUEST['Accion'])){

    switch($_REQUEST['Accion']){

        case 'actualizar':
            $MEst->__SET('memo_est_id',         $_REQUEST['memoestId']);
            $MEst->__SET('memo_est_tipo',       $_REQUEST['memoestTipo']);
			$MEst->__SET('memo_est_prioridad',  $_REQUEST['memoestPrioridad']);
            $jsondata = $modelMEst->Actualizar($MEst);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'registrar':
            $MEst->__SET('memo_est_tipo',       $_REQUEST['memoestTipo']);
			$MEst->__SET('memo_est_prioridad',  $_REQUEST['memoestPrioridad']);            
            $jsondata = $modelMEst->Registrar($MEst);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'eliminar':
            $jsondata = $modelMEst->Eliminar($_REQUEST['memoestId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtener':
            $jsondata = $modelMEst->Obtener($_REQUEST['memoestId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
            
        case 'listar':
            $jsondata = $modelMEst->Listar();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;            
    }
}

?>