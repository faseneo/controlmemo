<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/usuarioperfil/entidadusuarioperfil.php';
require_once '../modelo/usuarioperfil/modelusuarioperfil.php';

// Logica
$usuPer = new UsuPerfil();
$modelUsuPer = new ModelUsuperfil();

if(isset($_REQUEST['Accion'])){

    switch($_REQUEST['Accion']){

        case 'actualizar':
            $usuPer->__SET('usu_perfil_id',        $_REQUEST['perfilId']);
            $usuPer->__SET('usu_perfil_nombre',    $_REQUEST['perfilNombre']);
            $jsondata = $modelUsuPer->Actualizar($usuPer);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'registrar':
            $usuPer->__SET('usu_perfil_nombre',    $_REQUEST['perfilNombre']);           
            $jsondata = $modelUsuPer->Registrar($usuPer);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'eliminar':
            $jsondata = $modelUsuPer->Eliminar($_REQUEST['perfilId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtener':
            $jsondata = $modelUsuPer->Obtener($_REQUEST['perfilId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
            
        case 'listar':
            $jsondata = $modelUsuPer->Listar();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;            
    }
}






?>