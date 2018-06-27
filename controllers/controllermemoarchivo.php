<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/memoarchivo/entidadmemoarchivo.php';
require_once '../modelo/memoarchivo/modelmemoarchivo.php';

// Logica
$memoArch = new MemoArchivos();
$modelMemoArch = new ModelMemoArch();

if(isset($_REQUEST['Accion'])){

    switch($_REQUEST['Accion']){

        case 'actualizar':
            $memoArch->__SET('memo_arch_id',        $_REQUEST['memoarchId']);
            $memoArch->__SET('memo_arch_url',    $_REQUEST['memoarchUrl']);
            $jsondata = $modelMemoArch->Actualizar($memoArch);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'registrar':
            $memoArch->__SET('memo_arch_url',    $_REQUEST['memoarchUrl']);            
            $jsondata = $modelMemoArch->Registrar($memoArch);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'eliminar':
            $jsondata = $modelMemoArch->Eliminar($_REQUEST['memoarchId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtener':
            $jsondata = $modelMemoArch->Obtener($_REQUEST['memoarchId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
            
        case 'listar':
            $jsondata = $modelMemoArch->Listar();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;            
    }
}













?>