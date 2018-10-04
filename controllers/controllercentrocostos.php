<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once '../modelo/centrocostos/entidadcentrocostos.php';
require_once '../modelo/centrocostos/modelcentrocostos.php';
// Logica
$centroc = new CentroCostos();
$modelCentroc = new ModelCentroCostos();

if(isset($_REQUEST['Accion'])){

    switch($_REQUEST['Accion']){

        case 'actualizar':
            $centroc->__SET('ccosto_codigo',        $_REQUEST['ccCodigo']);
            $centroc->__SET('ccosto_nombre',        $_REQUEST['ccNombre']);
            $centroc->__SET('ccosto_dep_codigo',    $_REQUEST['ccDependencia']);
            $jsondata = $modelCentroc->Actualizar($centroc);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'registrar':
            $centroc->__SET('ccosto_codigo',    $_REQUEST['ccCodigo']);
            $centroc->__SET('ccosto_nombre',    $_REQUEST['ccNombre']);
            $centroc->__SET('ccosto_dep_codigo',$_REQUEST['ccDependencia']);
            $jsondata = $modelCentroc->Registrar($centroc);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'eliminar':
            $jsondata = $modelCentroc->Eliminar($_REQUEST['ccCodigo']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtener':
            $jsondata = $modelCentroc->Obtener($_REQUEST['ccCodigo']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
            
        case 'listar':
            $jsondata = $modelCentroc->Listar();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'listarmin':
            $jsondata = $modelCentroc->ListarMin();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;            
    }
}

?>