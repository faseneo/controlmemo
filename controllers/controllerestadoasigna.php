<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/estado_asigna/entidadestadoasigna.php';
require_once '../modelo/estado_asigna/modelestadoasigna.php';

// Logica
$est_asigna = new EstadoAsigna();
$modelEAsigna = new ModelEstadoAsigna();


if(isset($_REQUEST['Accion'])){

    switch($_REQUEST['Accion']){

        case 'actualizar':
            $est_asigna->__SET('est_asigna_id',         $_REQUEST['estadoAsignaId']);
            $est_asigna->__SET('est_asigna_texto',      $_REQUEST['estadoAsignaTexto']);
            $jsondata = $modelEAsigna->Actualizar($est_asigna);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'registrar':
            $est_asigna->__SET('est_asigna_id',         $_REQUEST['estadoAsignaId']);
            $est_asigna->__SET('est_asigna_texto',      $_REQUEST['estadoAsignaTexto']);         
            $jsondata = $modelEAsigna->Registrar($est_asigna);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'eliminar':
            $jsondata = $modelEAsigna->Eliminar($_REQUEST['estadoAsignaId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtener':
            $jsondata = $modelEAsigna->Obtener($_REQUEST['estadoAsignaId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
            
        case 'listar':
            $jsondata = $modelEAsigna->Listar();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;            
    }
}












?>