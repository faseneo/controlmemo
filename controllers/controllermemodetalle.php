<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/memodetalle/entidadmemodetalle.php';
require_once '../modelo/memodetalle/modelmemodetalle.php';

// Logica
$memoDet = new MemoDetalles();
$modelMemoDet = new ModelMemoDetalle();

if(isset($_REQUEST['Accion'])){

    switch($_REQUEST['Accion']){

        case 'actualizar':
            $memoDet->__SET('memo_detalle_id',              $_REQUEST['memodetId']);
            $memoDet->__SET('memo_detalle_descripcion',     $_REQUEST['memodetDesc']);
            $memoDet->__SET('memo_detalle_num_oc_chc',      $_REQUEST['memodetNumOcChc']);
            $memoDet->__SET('memo_detalle_cdp',             $_REQUEST['memodetCdp']);
            $memoDet->__SET('memo_detalle_num_oc_manager',  $_REQUEST['memodetNumOcMan']);
            $memoDet->__SET('memo_detalle_num_factura',     $_REQUEST['memodetNumFact']);
            $memoDet->__SET('memo_detalle_fecha_factura',   $_REQUEST['memodetFechFact']);
            $memoDet->__SET('memo_detalle_monto_total',     $_REQUEST['memodetMonTotal']);
            $memoDet->__SET('memo_detalle_observaciones',   $_REQUEST['memodetObs']); 
            $jsondata = $modelMemoDet->Actualizar($memoDet);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'registrar':
            $memoDet->__SET('memo_detalle_descripcion',     $_REQUEST['memodetDesc']);
            $memoDet->__SET('memo_detalle_num_oc_chc',      $_REQUEST['memodetNumOcChc']);
            $memoDet->__SET('memo_detalle_cdp',             $_REQUEST['memodetCdp']);
            $memoDet->__SET('memo_detalle_num_oc_manager',  $_REQUEST['memodetNumOcMan']);
            $memoDet->__SET('memo_detalle_num_factura',     $_REQUEST['memodetNumFact']);
            $memoDet->__SET('memo_detalle_fecha_factura',   $_REQUEST['memodetFechFact']);
            $memoDet->__SET('memo_detalle_monto_total',     $_REQUEST['memodetMonTotal']);
            $memoDet->__SET('memo_detalle_observaciones',   $_REQUEST['memodetObs']);            
            $jsondata = $modelMemoDet->Registrar($memoDet);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'eliminar':
            $jsondata = $modelMemoDet->Eliminar($_REQUEST['memodetId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtener':
            $jsondata = $modelMemoDet->Obtener($_REQUEST['memodetId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
            
        case 'listar':
            $jsondata = $modelMemoDet->Listar();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;            
    }
}

?>