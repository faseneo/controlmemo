<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/memodetalleestado/entidadmemodetalleestado.php';
require_once '../modelo/memodetalleestado/modelmemodetalleestado.php';

// Logica
$MDetEst = new MemoDetEst();
$modelMDetEst = new ModelMemoDetEst();

if(isset($_REQUEST['Accion'])){

    switch($_REQUEST['Accion']){

        case 'actualizar':
            $MDetEst->__SET('memo_det_est_id',      $_REQUEST['memodetestId']);
            $MDetEst->__SET('memo_det_est_tipo',    $_REQUEST['memodetestTipo']);
            $MDetEst->__SET('memo_det_priori',    $_REQUEST['memodetPriori']);
            $jsondata = $modelMDetEst->Actualizar($MDetEst);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'registrar':
            $MDetEst->__SET('memo_det_est_tipo',    $_REQUEST['memodetestTipo']);
            $MDetEst->__SET('memo_det_priori',    $_REQUEST['memodetPriori']);            
            $jsondata = $modelMDetEst->Registrar($MDetEst);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'eliminar':
            $jsondata = $modelMDetEst->Eliminar($_REQUEST['memodetestId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtener':
            $jsondata = $modelMDetEst->Obtener($_REQUEST['memodetestId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
            
        case 'listar':
            $jsondata = $modelMDetEst->Listar();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;            
    }
}

?>