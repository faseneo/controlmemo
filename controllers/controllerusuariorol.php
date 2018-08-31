<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/usuariorol/entidadusuariorol.php';
require_once '../modelo/usuariorol/modelusuariorol.php';

// Logica
$usurol = new UsuarioRol();
$modelUsurol = new ModelUsuarioRol();

if(isset($_REQUEST['Accion'])){

    switch($_REQUEST['Accion']){

        case 'actualizar':
            $usurol->__SET('usuario_rol_id',             $_REQUEST['usuRolId']);
            $usurol->__SET('usuario_rol_nombre',         $_REQUEST['usuRolNom']);
            $jsondata = $modelUsurol->Actualizar($usurol);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'registrar':
            $usurol->__SET('usuario_rol_id',         $_REQUEST['usuRolId']);
            $usurol->__SET('usuario_rol_nombre',    $_REQUEST['usuRolNom']);            
            $jsondata = $modelUsurol->Registrar($usurol);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'eliminar':
            $jsondata = $modelUsurol->Eliminar($_REQUEST['usuRolId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtener':
            $jsondata = $modelUsurol->Obtener($_REQUEST['usuRolId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
            
        case 'listar':
            $jsondata = $modelUsurol->Listar();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;            
    }
}