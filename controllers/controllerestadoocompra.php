<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/estado_ordencompra/entidadestadoocompra.php';
require_once '../modelo/estado_ordencompra/modelestadoocompra.php';

// Logica
$EstadoOC = new EstadoOCompra();
$modelEstadoOC = new ModelEstadoOCompra();

if(isset($_REQUEST['Accion'])){

    switch($_REQUEST['Accion']){

        case 'actualizar':
            $EstadoOC->__SET('est_oc_id',        $_REQUEST['estadoOCId']);
            $EstadoOC->__SET('est_oc_tipo',      $_REQUEST['estadoOCTipo']);
            $EstadoOC->__SET('est_oc_prioridad', $_REQUEST['estadoOCPriori']);
            $EstadoOC->__SET('est_oc_activo',    $_REQUEST['estadoOCActivo']);
            $jsondata = $modelEstadoOC->Actualizar($EstadoOC);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'registrar':
            $EstadoOC->__SET('est_oc_tipo',      $_REQUEST['estadoOCTipo']);
            $EstadoOC->__SET('est_oc_prioridad', $_REQUEST['estadoOCPriori']);
            $EstadoOC->__SET('est_oc_activo',    $_REQUEST['estadoOCActivo']);     
            $jsondata = $modelEstadoOC->Registrar($EstadoOC);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'eliminar':
            $jsondata = $modelEstadoOC->Eliminar($_REQUEST['estadoOCId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtener':
            $jsondata = $modelEstadoOC->Obtener($_REQUEST['estadoOCId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
            
        case 'listar':
            $jsondata = $modelEstadoOC->Listar();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'listarmin':
            $jsondata = $modelEstadoOC->ListarMin();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;
    }
}

?>