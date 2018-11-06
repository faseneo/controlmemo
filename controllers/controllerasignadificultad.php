<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/asignadificultad/entidadasignadificultad.php';
require_once '../modelo/asignadificultad/modelasignadificultad.php';

// Logica
$asignadif = new AsignaDificultad();
$modelAsignaDif = new ModelAsignaDificultad();


if(isset($_REQUEST['Accion'])){

    switch($_REQUEST['Accion']){

        case 'actualizar':
            $asignadif->__SET('adificultad_id',         $_REQUEST['asignaDifId']);
            $asignadif->__SET('adificultad_texto',      $_REQUEST['asignaDifTexto']);
            $jsondata = $modelAsignaDif->Actualizar($asignadif);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'registrar':
            $asignadif->__SET('adificultad_id',         $_REQUEST['asignaDifId']);
            $asignadif->__SET('adificultad_texto',      $_REQUEST['asignaDifTexto']);         
            $jsondata = $modelAsignaDif->Registrar($asignadif);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'eliminar':
            $jsondata = $modelAsignaDif->Eliminar($_REQUEST['asignaDifId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtener':
            $jsondata = $modelAsignaDif->Obtener($_REQUEST['asignaDifId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
            
        case 'listar':
            $jsondata = $modelAsignaDif->Listar();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;            
    }
}












?>