<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/menuitem/entidadmenuitem.php';
require_once '../modelo/menuitem/modelmenuitem.php';

$MenItem = new MenuItem();
$modelMenItem = new ModelMenuItem();

if(isset($_REQUEST['Accion'])){
    switch($_REQUEST['Accion']){
        case 'actualizar':
            $MenItem->__SET('menitem_id',       $_REQUEST['menuitemId']);
            $MenItem->__SET('menitem_nombre',   $_REQUEST['menuitemNombre']);
            $MenItem->__SET('menitem_url',      $_REQUEST['menuitemUrl']);
            $MenItem->__SET('menitem_estado',   $_REQUEST['menuitemEstado']);
            $MenItem->__SET('menitem_memid',    $_REQUEST['menuitemMemid']);
            $jsondata = $modelMenItem->Actualizar($MenItem);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'registrar':
            $MenItem->__SET('menitem_nombre',   $_REQUEST['menuitemNombre']);
            $MenItem->__SET('menitem_url',      $_REQUEST['menuitemUrl']);
            $MenItem->__SET('menitem_estado',   $_REQUEST['menuitemEstado']);
            $MenItem->__SET('menitem_memid',    $_REQUEST['menuitemMemid']);
            $jsondata = $modelMenItem->Registrar($MenItem);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'eliminar':
            $jsondata = $modelMenItem->Eliminar($_REQUEST['menuitemId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtener':
            $jsondata = $modelMenItem->Obtener($_REQUEST['menuitemId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
            
        case 'listar':
            $jsondata = $modelMenItem->Listar();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;
    }
}
?>