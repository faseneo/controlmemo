<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/memoestado/entidadmemoestado.php';
require_once '../modelo/memoestado/entidadmemocambioestado.php';
require_once '../modelo/memoestado/modelmemoestado.php';
require_once '../modelo/memo/modelmemo.php';

// Logica
$MEst = new MemoEst();
$CambioMEst = new MemoCambioEst();
$modelMEst = new ModelMemoEst();
$modelMemo = new ModelMemo();

if(isset($_REQUEST['Accion'])){
    switch($_REQUEST['Accion']){
        case 'actualizar':
            $MEst->__SET('memo_est_id',         $_REQUEST['memoestId']);
            $MEst->__SET('memo_est_tipo',       $_REQUEST['memoestTipo']);
			$MEst->__SET('memo_est_orden',      $_REQUEST['memoestOrden']);
            $MEst->__SET('memo_est_desc',       $_REQUEST['memoestDesc']);
            $MEst->__SET('memo_est_colorbg',    $_REQUEST['memoestColorbg']);
            $MEst->__SET('memo_est_colortxt',   $_REQUEST['memoestColortxt']);
            $MEst->__SET('memo_est_activo',     $_REQUEST['memoestActivo']);
            $MEst->__SET('memo_est_seccion_id', $_REQUEST['memoestSeccionId']);
            $jsondata = $modelMEst->Actualizar($MEst);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'cambiaestado':
            $CambioMEst->__SET('memo_camest_memid', $_REQUEST['meId']);
            $CambioMEst->__SET('memo_camest_usuid', $_REQUEST['uId']);
            $CambioMEst->__SET('memo_camest_estid', $_REQUEST['memoEstado']);
            $CambioMEst->__SET('memo_camest_obs',   $_REQUEST['memoObs']);
            //llenar datos en el memo 
            if($_REQUEST['memoEstado']==8 || $_REQUEST['memoEstado']==9){
                $grabaCDP = $modelMemo->ActualizarMemoCDP($_REQUEST['meId'],$_REQUEST['memoCodigoCC'],$_REQUEST['memoFechaCDP']);
            }
            $jsondata = $modelMEst->CambiaEstado($CambioMEst);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;            

        case 'registrar':
            $MEst->__SET('memo_est_tipo',       $_REQUEST['memoestTipo']);
			$MEst->__SET('memo_est_orden',      $_REQUEST['memoestOrden']);
            $MEst->__SET('memo_est_desc',       $_REQUEST['memoestDesc']);
            $MEst->__SET('memo_est_colorbg',    $_REQUEST['memoestColorbg']);
            $MEst->__SET('memo_est_colortxt',   $_REQUEST['memoestColortxt']);            
            $MEst->__SET('memo_est_activo',     $_REQUEST['memoestActivo']);
            $MEst->__SET('memo_est_seccion_id', $_REQUEST['memoestSeccionId']);            
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
            $jsondata = $modelMEst->Listar($_REQUEST['seccion']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;
        case 'listarmin':
            $jsondata = $modelMEst->ListarMin($_REQUEST['seccion']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;            
    }
}

?>