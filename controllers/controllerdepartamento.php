<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/departamento/entidaddepartamento.php';
require_once '../modelo/departamento/modeldepartamento.php';

// Logica
$dptos = new Departamentos();
$modelDptos = new ModelDepartamento();


if(isset($_REQUEST['Accion'])){

    switch($_REQUEST['Accion']){

        case 'actualizar':
            $dptos->__SET('depto_id',             $_REQUEST['deptoId']);
            $dptos->__SET('depto_nombre',         $_REQUEST['deptoNombre']);
            $dptos->__SET('depto_nomcorto',       $_REQUEST['deptoNombreCorto']);
            $dptos->__SET('depto_estado',         $_REQUEST['deptoEstado']);
            $dptos->__SET('depto_habilita',       $_REQUEST['deptoHabilitado']);
            $jsondata = $modelDptos->Actualizar($dptos);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'registrar':
            $dptos->__SET('depto_id',       $_REQUEST['deptoId']);
            $dptos->__SET('depto_nombre',   $_REQUEST['deptoNombre']);
            $dptos->__SET('depto_nomcorto', $_REQUEST['deptoNombreCorto']);
            $dptos->__SET('depto_estado',   $_REQUEST['deptoEstado']);
            $dptos->__SET('depto_habilita', $_REQUEST['deptoHabilitado']);
            $jsondata = $modelDptos->Registrar($dptos);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'eliminar':
            $jsondata = $modelDptos->Eliminar($_REQUEST['deptoId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtener':
            $jsondata = $modelDptos->Obtener($_REQUEST['deptoId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
            
        case 'listar':
            $jsondata = $modelDptos->Listar();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;
        case 'listarmin':
            $jsondata = $modelDptos->ListarMin();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;
        case 'listarminhabilita':
            $jsondata = $modelDptos->ListarMinHabilitado();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;
            
        case 'listarminhabilitaxusu':
            $jsondata = $modelDptos->ListarMinHabilitadoPorUsu($_REQUEST['usuid']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;            
    }
}
?>