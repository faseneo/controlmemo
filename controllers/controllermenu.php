<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/menu/entidadmenu.php';
require_once '../modelo/menu/modelmenu.php';

$Men = new Menu();
$modelMen = new ModelMenu();

if(isset($_REQUEST['Accion'])){
    switch($_REQUEST['Accion']){
        case 'actualizar':
            $Men->__SET('men_id',       $_REQUEST['menuId']);
            $Men->__SET('men_nombre',   $_REQUEST['menuNombre']);
            $Men->__SET('men_url',      $_REQUEST['menuUrl']);
            $Men->__SET('men_descrip',  $_REQUEST['menuDescrip']);
            $Men->__SET('men_estado',   $_REQUEST['menuEstado']);
            $jsondata = $modelMen->Actualizar($Men);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'registrar':
            $Men->__SET('men_nombre',   $_REQUEST['menuNombre']);
            $Men->__SET('men_url',      $_REQUEST['menuUrl']);
            $Men->__SET('men_descrip',  $_REQUEST['menuDescrip']);
            $Men->__SET('men_estado',   $_REQUEST['menuEstado']);
            $jsondata = $modelMen->Registrar($Men);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'eliminar':
            $jsondata = $modelMen->Eliminar($_REQUEST['menuId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtener':
            $jsondata = $modelMen->Obtener($_REQUEST['menuId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
            
        case 'listar':
            $jsondata = $modelMen->Listar();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;
            
        case 'listarmin':
            $jsondata = $modelMen->ListarMin();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;             
    }
}
?>