<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/seccion/entidadseccion.php';
require_once '../modelo/seccion/modelseccion.php';

// Logica
$Sec = new Seccion();
$modelSec = new ModelSeccion();

if(isset($_REQUEST['Accion'])){

    switch($_REQUEST['Accion']){

        case 'actualizar':
            $Sec->__SET('sec_id',      $_REQUEST['secId']);
            $Sec->__SET('sec_nombre',  $_REQUEST['secNombre']);
			
            $jsondata = $modelSec->Actualizar($Sec);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'registrar':
            $Sec->__SET('sec_nombre',  $_REQUEST['secNombre']);

            $jsondata = $modelSec->Registrar($Sec);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'eliminar':
            $jsondata = $modelSec->Eliminar($_REQUEST['secId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtener':
            $jsondata = $modelSec->Obtener($_REQUEST['secId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
            
        case 'listar':
            $jsondata = $modelSec->Listar();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;
    }
}

?>