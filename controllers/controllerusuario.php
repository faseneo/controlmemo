<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/usuario/entidadusuario.php';
require_once '../modelo/usuario/modelusuario.php';

// Logica
$usu = new Usuarios();
$modelUsu = new ModelUsuarios();
if(isset($_REQUEST['Accion'])){

    switch($_REQUEST['Accion']){

        case 'actualizar':
            $usu->__SET('usu_id',            $_REQUEST['usuId']);
            $usu->__SET('usu_rut',           $_REQUEST['usuRut']);
            $usu->__SET('usu_nombre',        $_REQUEST['usuNombre']);
            $usu->__SET('usu_password',      $_REQUEST['usuContr']);
            $usu->__SET('usu_usu_perfil_id', $_REQUEST['usuarioperfil']);
            $usu->__SET('usu_perfil_nombre', $_REQUEST['usuarioperfilnom']);
            $jsondata = $modelUsu->Actualizar($usu);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'registrar':
            $usu->__SET('usu_rut',           $_REQUEST['usuRut']);
            $usu->__SET('usu_nombre',        $_REQUEST['usuNombre']);
            $usu->__SET('usu_password',    $_REQUEST['usuContr']);
            $usu->__SET('usu_usu_perfil_id', $_REQUEST['usuarioperfil']);
			$usu->__SET('usu_perfil_nombre', $_REQUEST['usuarioperfilnom']);            
            $jsondata = $modelUsu->Registrar($usu);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'eliminar':
            $jsondata = $modelUsu->Eliminar($_REQUEST['usuId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtener':
            $jsondata = $modelUsu->Obtener($_REQUEST['usuId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
            
        case 'listar':
            $jsondata = $modelUsu->Listar();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;            
    }
}






?>