<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/perfil/entidadperfil.php';
require_once '../modelo/perfil/modelperfil.php';

// Logica
$usuPer = new UsuPerfil();
$modelUsuPer = new ModelUsuperfil();

if(isset($_REQUEST['Accion'])){

    switch($_REQUEST['Accion']){

        case 'actualizar':
            $usuPer->__SET('perf_id',       $_REQUEST['perfilId']);
            $usuPer->__SET('perf_nombre',   $_REQUEST['perfilNombre']);
            $usuPer->__SET('perf_desc',     $_REQUEST['perfilDesc']);
            $jsondata = $modelUsuPer->Actualizar($usuPer);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'registrar':
            $usuPer->__SET('perf_nombre',    $_REQUEST['perfilNombre']);
            $usuPer->__SET('perf_desc',     $_REQUEST['perfilDesc']);
            $jsondata = $modelUsuPer->Registrar($usuPer);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'eliminar':
            $jsondata = $modelUsuPer->Eliminar($_REQUEST['perfilId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtener':
            $jsondata = $modelUsuPer->Obtener($_REQUEST['perfilId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
            
        case 'listar':
            $jsondata = $modelUsuPer->Listar();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;            
    }
}






?>