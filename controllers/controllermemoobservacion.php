<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once '../modelo/memoobservacion/entidadmemoobservacion.php';
require_once '../modelo/memoobservacion/modelmemoobservacion.php';
// Logica
$memoobs = new MemoObservacion();
$modelmemoobs = new ModelMemoObservacion();

if(isset($_REQUEST['Accion'])){

    switch($_REQUEST['Accion']){

        case 'actualizar':
            $memoobs->__SET('memoobs_id',       $_REQUEST['memobsId']);
            $memoobs->__SET('memoobs_texto',    $_REQUEST['memobsTexto']);
            $memoobs->__SET('memoobs_memo_id',  $_REQUEST['memobsMemid']);
            $memoobs->__SET('memoobs_usu_id',   $_REQUEST['memobsUsuid']);
            $jsondata = $modelmemoobs->Actualizar($memoobs);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'registrar':
            $memoobs->__SET('memoobs_texto',    $_REQUEST['memobsTexto']);
            $memoobs->__SET('memoobs_memo_id',  $_REQUEST['memobsMemid']);
            $memoobs->__SET('memoobs_usu_id',   $_REQUEST['memobsUsuid']);
            $jsondata = $modelmemoobs->Registrar($memoobs);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'eliminar':
            $jsondata = $modelmemoobs->Eliminar($_REQUEST['memobsId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtener':
            $jsondata = $modelmemoobs->Obtener($_REQUEST['memobsId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
            
        case 'listar':
            $jsondata = $modelmemoobs->Listar($_REQUEST['memobsMemid']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'listarmin':
            $jsondata = $modelmemoobs->ListarMin($_REQUEST['memobsMemid']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;            
    }
}

?>