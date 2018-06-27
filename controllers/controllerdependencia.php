<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once '../modelo/dependencia/entidaddependencia.php';
require_once '../modelo/dependencia/modeldependencia.php';
// Logica
$dependencia = new Dependencia();
$modelDep = new ModelDependencia();

if(isset($_REQUEST['Accion'])){

    switch($_REQUEST['Accion']){

        case 'actualizar':
            $dependencia->__SET('dep_codigo',        $_REQUEST['depCodigo']);
            $dependencia->__SET('dep_nombre',        $_REQUEST['depNombre']);
            $jsondata = $modelDep->Actualizar($dependencia);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'registrar':
            $dependencia->__SET('dep_codigo',    $_REQUEST['depCodigo']);
            $dependencia->__SET('dep_nombre',    $_REQUEST['depNombre']);
            $jsondata = $modelDep->Registrar($dependencia);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'eliminar':
            $jsondata = $modelDep->Eliminar($_REQUEST['depCodigo']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtener':
            $jsondata = $modelDep->Obtener($_REQUEST['depCodigo']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
            
        case 'listar':
            $jsondata = $modelDep->Listar();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;            
    }
}

?>