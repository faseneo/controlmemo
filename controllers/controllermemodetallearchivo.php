<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/memodetallearchivo/entidadmemodetallearchivo.php';
require_once '../modelo/memodetallearchivo/modelmemodetallearchivo.php';

// Logica
$memoDetArch = new MemoDetArchivo();
$modelMemoDetArch = new ModelMemoDetArchivo();

if(isset($_REQUEST['Accion'])){

    switch($_REQUEST['Accion']){

        case 'actualizar':
            $memoDetArch->__SET('memo_det_arch_id',        $_REQUEST['memodetarchId']);
            $memoDetArch->__SET('memo_det_arch_url',    $_REQUEST['memodetarchUrl']);
            $jsondata = $modelMemoDetArch->Actualizar($memoDetArch);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'registrar':
            $memoDetArch->__SET('memo_det_arch_url',    $_REQUEST['memodetarchUrl']);            
            $jsondata = $modelMemoDetArch->Registrar($memoDetArch);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'eliminar':
            $jsondata = $modelMemoDetArch->Eliminar($_REQUEST['memodetarchId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtener':
            $jsondata = $modelMemoDetArch->Obtener($_REQUEST['memodetarchId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
            
        case 'listar':
            $jsondata = $modelMemoDetArch->Listar();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;            
    }
}








?>