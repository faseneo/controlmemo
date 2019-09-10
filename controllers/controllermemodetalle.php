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
            $memoDet->__SET('memo_detalle_id',              $_REQUEST['detmemId']);
            $memoDet->__SET('memo_detalle_num',             $_REQUEST['detmemonum']);
            $memoDet->__SET('memo_detalle_detmemocc',       $_REQUEST['detmemocc']);
            $memoDet->__SET('memo_detalle_solicita',        $_REQUEST['detmemonomsolicita']);
            $memoDet->__SET('memo_detalle_descripcion',     $_REQUEST['detmemodescrip']);
            $memoDet->__SET('memo_detalle_procompra',       $_REQUEST['detmemoprocompra']);
            $memoDet->__SET('memo_detalle_proveedor_id',    $_REQUEST['detmemoprov']);
            $memoDet->__SET('memo_detalle_num_oc_sac',      $_REQUEST['detmemoocsac']);
            $memoDet->__SET('memo_detalle_num_oc_chc',      $_REQUEST['detmemoocchicom']);
            $memoDet->__SET('memo_detalle_monto_total',     $_REQUEST['detmemomonto']);
            $memoDet->__SET('memo_detalle_memo_id',         $_REQUEST['detmemId']);

            $jsondata = $modelMemoDet->Actualizar($memoDet);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'registrardetalle':
            $memoDet->__SET('memo_detalle_num',             $_REQUEST['detmemonum']);
            $memoDet->__SET('memo_detalle_detmemocc',       $_REQUEST['detmemocc']);
            $memoDet->__SET('memo_detalle_solicita',        $_REQUEST['detmemonomsolicita']);
            $memoDet->__SET('memo_detalle_descripcion',     $_REQUEST['detmemodescrip']);
            $memoDet->__SET('memo_detalle_procompra',       $_REQUEST['detmemoprocompra']);
            $memoDet->__SET('memo_detalle_proveedor_id',    $_REQUEST['detmemoprov']);
            $memoDet->__SET('memo_detalle_num_oc_sac',      $_REQUEST['detmemoocsac']);
            $memoDet->__SET('memo_detalle_num_oc_chc',      $_REQUEST['detmemoocchicom']);
            $memoDet->__SET('memo_detalle_monto_total',     $_REQUEST['detmemomonto']);
            $memoDet->__SET('memo_detalle_memo_id',         $_REQUEST['detmemId']);
                      
            $jsondata = $modelMemoDet->Registrar($memoDet,$_REQUEST['uid']);
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
            $jsondata = $modelMemoDet->Listar($_REQUEST['memoId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;            
    }
}

?>