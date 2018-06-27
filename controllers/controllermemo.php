<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/memo/entidadmemo.php';
require_once '../modelo/memo/modelmemo.php';

// Logica
$memo = new Memos();
$modelMemo = new ModelMemo();

if(isset($_REQUEST['AccionMemo'])){

    switch($_REQUEST['AccionMemo']){

        case 'actualizar':
            $memo->__SET('mem_id',             $_REQUEST['memoId']);
            $memo->__SET('mem_numero',          $_REQUEST['memoNum']);
            $memo->__SET('mem_fecha_recep',     $_REQUEST['memoFechaRecep']);
            $memo->__SET('mem_fecha',           $_REQUEST['memoFecha']);
            $memo->__SET('mem_fecha_analista',  $_REQUEST['memoFechaAnalista']);
            //$memo->__SET('memo_url',            $_REQUEST['memoUrlRes']);
            $memo->__SET('mem_depto_id',        $_REQUEST['memoDepto']);
            $memo->__SET('mem_ccosto_id',       $_REQUEST['memoCcosto']); //deberia serl id
            //$memo->__SET('memo_url',            $_REQUEST['memoCodigoCcosto']); 
            $memo->__SET('mem_estado_id',       $_REQUEST['memoEstado']);
            $jsondata = $modelMemo->Actualizar($memo);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'registrar':
            $memo->__SET('mem_numero',          $_REQUEST['memoNum']);
            $memo->__SET('mem_fecha_recep',     $_REQUEST['memoFechaRecep']);
            $memo->__SET('mem_fecha',           $_REQUEST['memoFecha']);
            $memo->__SET('mem_fecha_analista',  $_REQUEST['memoFechaAnalista']);
            //$memo->__SET('memo_url',            $_REQUEST['memoUrlRes']);
            $memo->__SET('mem_depto_id',        $_REQUEST['memoDepto']);
            $memo->__SET('mem_ccosto_id',       $_REQUEST['memoCcosto']); //deberia serl id
            //$memo->__SET('memo_url',            $_REQUEST['memoCodigoCcosto']); 
            $memo->__SET('mem_estado_id',       $_REQUEST['memoEstado']);

            $jsondata = $modelMemo->Registrar($memo);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'eliminar':
            $jsondata = $modelMemo->Eliminar($_REQUEST['memoId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtener':
            $jsondata = $modelMemo->Obtener($_REQUEST['memoId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
            
        case 'listar':
            $jsondata = $modelMemo->Listar();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'registrartmp':
            $memo->__SET('memo_numero',             $_REQUEST['memoNum']);
            $memo->__SET('memo_fecha_recepcion',    $_REQUEST['memoFechRec']);
            $memo->__SET('memo_fecha',              $_REQUEST['memoFecha']);
            $memo->__SET('memo_fecha_entrega',      $_REQUEST['memoFechEnt']);
            $memo->__SET('memo_num_resolucion',     $_REQUEST['memoNumRes']);
            $memo->__SET('memo_url',                $_REQUEST['memoUrl']);
            $jsondata = $modelMemo->Registrar($memo);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;
    }
}
?>