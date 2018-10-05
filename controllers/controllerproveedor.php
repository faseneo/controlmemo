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
            $prov->__SET('prov_id',             $_REQUEST['provId']);
            $prov->__SET('prov_nombre',         $_REQUEST['provNombre']);
            $prov->__SET('prov_rut',            $_REQUEST['provRut']);
            $prov->__SET('prov_fono',           $_REQUEST['provFono']);
            $prov->__SET('prov_direccion',      $_REQUEST['provDireccion']);
            $prov->__SET('prov_ciudad',         $_REQUEST['provCiudad']);
            $prov->__SET('prov_region',         $_REQUEST['provRegion']);
            $prov->__SET('prov_cuenta',         $_REQUEST['provCuenta']);
            $prov->__SET('prov_contacto_nombre',$_REQUEST['provContNombre']);
            $prov->__SET('prov_contacto_email', $_REQUEST['provContEmail']);
            $prov->__SET('prov_contacto_fono',  $_REQUEST['provContFono']);
            $prov->__SET('prov_estado',         $_REQUEST['provEstado']);
            $jsondata = $modelProv->Actualizar($prov);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'registrar':
            $prov->__SET('prov_nombre',         $_REQUEST['provNombre']);
            $prov->__SET('prov_rut',            $_REQUEST['provRut']);
            $prov->__SET('prov_direccion',      $_REQUEST['provDireccion']);
            $prov->__SET('prov_fono',           $_REQUEST['provFono']);
            $prov->__SET('prov_ciudad',         $_REQUEST['provCiudad']);
            $prov->__SET('prov_region',         $_REQUEST['provRegion']);
            $prov->__SET('prov_cuenta',         $_REQUEST['provCuenta']);
            $prov->__SET('prov_contacto_nombre',$_REQUEST['provContNombre']);
            $prov->__SET('prov_contacto_email', $_REQUEST['provContEmail']);
            $prov->__SET('prov_contacto_fono',  $_REQUEST['provContFono']);
            $prov->__SET('prov_estado',         $_REQUEST['provEstado']);
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

        case 'listarmin':
            $jsondata = $modelProv->ListarMin();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;            
    }
}











?>