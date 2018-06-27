<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/proveedor/entidadproveedor.php';
require_once '../modelo/proveedor/modelproveedor.php';

// Logica
$prov = new Proveedores();
$modelProv = new ModelProveedores();

if(isset($_REQUEST['Accion'])){

    switch($_REQUEST['Accion']){

        case 'actualizar':
            $prov->__SET('prov_id',        $_REQUEST['provId']);
            $prov->__SET('prov_nombre',    $_REQUEST['provNombre']);
            $prov->__SET('prov_rut',       $_REQUEST['provRut']);
            $jsondata = $modelProv->Actualizar($prov);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'registrar':
            $prov->__SET('prov_nombre',    $_REQUEST['provNombre']);
            $prov->__SET('prov_rut',       $_REQUEST['provRut']);            
            $jsondata = $modelProv->Registrar($prov);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'eliminar':
            $jsondata = $modelProv->Eliminar($_REQUEST['provId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtener':
            $jsondata = $modelProv->Obtener($_REQUEST['provId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
            
        case 'listar':
            $jsondata = $modelProv->Listar();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;            
    }
}











?>