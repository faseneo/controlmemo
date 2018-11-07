<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/asignaprioridad/entidadasignaprioridad.php';
require_once '../modelo/asignaprioridad/modelasignaprioridad.php';

// Logica
$asignaprio = new AsignaPrioridad();
$modelAsignaPrio = new ModelAsignaPrioridad();


if(isset($_REQUEST['Accion'])){

    switch($_REQUEST['Accion']){

        case 'actualizar':
            $asignaprio->__SET('aprioridad_id',         $_REQUEST['asignaPrioId']);
            $asignaprio->__SET('aprioridad_texto',      $_REQUEST['asignaPrioTexto']);
            $jsondata = $modelAsignaPrio->Actualizar($asignaprio);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'registrar':
            $asignaprio->__SET('aprioridad_id',         $_REQUEST['asignaPrioId']);
            $asignaprio->__SET('aprioridad_texto',      $_REQUEST['asignaPrioTexto']);         
            $jsondata = $modelAsignaPrio->Registrar($asignaprio);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'eliminar':
            $jsondata = $modelAsignaPrio->Eliminar($_REQUEST['asignaPrioId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtener':
            $jsondata = $modelAsignaPrio->Obtener($_REQUEST['asignaPrioId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
            
        case 'listar':
            $jsondata = $modelAsignaPrio->Listar();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;            
    }
}












?>