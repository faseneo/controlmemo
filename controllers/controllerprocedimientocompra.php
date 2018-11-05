<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/procedimientocompra/entidadprocedimientocompra.php';
require_once '../modelo/procedimientocompra/modelprocedimientocompra.php';

// Logica
$procComp = new ProcCompra();
$modelProcComp = new ModelProcCompra();

if(isset($_REQUEST['Accion'])){

    switch($_REQUEST['Accion']){

        case 'actualizar':
            $procComp->__SET('proc_comp_id',        $_REQUEST['proccompId']);
            $procComp->__SET('proc_comp_tipo',      $_REQUEST['proccompTipo']);
            $procComp->__SET('proc_orden',          $_REQUEST['proccompOrden']);
            $procComp->__SET('proc_activo',         $_REQUEST['proccompActivo']);
            $jsondata = $modelProcComp->Actualizar($procComp);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'registrar':
            $procComp->__SET('proc_comp_tipo',  $_REQUEST['proccompTipo']);
            $procComp->__SET('proc_orden',      $_REQUEST['proccompOrden']);
            $procComp->__SET('proc_activo',     $_REQUEST['proccompActivo']);
            $jsondata = $modelProcComp->Registrar($procComp);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'eliminar':
            $jsondata = $modelProcComp->Eliminar($_REQUEST['proccompId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtener':
            $jsondata = $modelProcComp->Obtener($_REQUEST['proccompId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
            
        case 'listar':
            $jsondata = $modelProcComp->Listar();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'listarmin':
            $jsondata = $modelProcComp->ListarMin();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;
    }
}









?>