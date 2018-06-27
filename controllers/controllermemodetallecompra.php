<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/memodetallecompra/entidadmemodetallecompra.php';
require_once '../modelo/memodetallecompra/modelmemodetallecompra.php';

// Logica
$memoDetComp = new MemoDetCompra();
$modelMemoDetComp = new ModelMemoDetCompra();

if(isset($_REQUEST['Accion'])){

    switch($_REQUEST['Accion']){

        case 'actualizar':
            $memoDetComp->__SET('memo_detalle_compra_id',              $_REQUEST['detcompId']);
            $memoDetComp->__SET('memo_detalle_compra_nom_producto',    $_REQUEST['detcompNombre']);
            $memoDetComp->__SET('memo_detalle_compra_cantidad',        $_REQUEST['detcompCant']);
            $memoDetComp->__SET('memo_detalle_compra_valor',           $_REQUEST['detcompValor']);
            $memoDetComp->__SET('memo_detalle_compra_total',           $_REQUEST['detcompTotal']);
            $jsondata = $modelMemoDetComp->Actualizar($memoDetComp);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'registrar':
            $memoDetComp->__SET('memo_detalle_compra_nom_producto',    $_REQUEST['detcompNombre']);
            $memoDetComp->__SET('memo_detalle_compra_cantidad',        $_REQUEST['detcompCant']);  
            $memoDetComp->__SET('memo_detalle_compra_valor',           $_REQUEST['detcompValor']);
            $memoDetComp->__SET('memo_detalle_compra_total',           $_REQUEST['detcompTotal']);          
            $jsondata = $modelMemoDetComp->Registrar($memoDetComp);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'eliminar':
            $jsondata = $modelMemoDetComp->Eliminar($_REQUEST['detcompId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtener':
            $jsondata = $modelMemoDetComp->Obtener($_REQUEST['detcompId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
            
        case 'listar':
            $jsondata = $modelMemoDetComp->Listar();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;            
    }
}





?>