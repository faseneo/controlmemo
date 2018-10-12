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
            $usu->__SET('usu_id',           $_REQUEST['usuId']);
            $usu->__SET('usu_rut',          $_REQUEST['usuRut']);
            $usu->__SET('usu_nombre',       $_REQUEST['usuNombre']);
            $usu->__SET('usu_password',     $_REQUEST['usuPass']);
            $usu->__SET('usu_rol_id',       $_REQUEST['usuRolId']);
            $usu->__SET('usu_estado_id',    $_REQUEST['usuEstadoId']);
            /*$usu->__SET('usu_perfil_nombre', $_REQUEST['usuarioperfilnom']);*/
            $jsondata = $modelUsu->Actualizar($usu);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'registrar':
            $usu->__SET('usu_rut',          $_REQUEST['usuRut']);
            $usu->__SET('usu_nombre',       $_REQUEST['usuNombre']);
            $usu->__SET('usu_password',     $_REQUEST['usuPass']);
            $usu->__SET('usu_rol_id',       $_REQUEST['usuRolId']);
            $usu->__SET('usu_estado_id',    $_REQUEST['usuEstadoId']);
            /*$usu->__SET('usu_perfil_nombre', $_REQUEST['usuarioperfilnom']);*/
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
            
        case 'asignamemo':
            var_dump($_REQUEST);
            $jsondata = $modelUsu->AsignaMemo($_REQUEST['asignausu'],$_REQUEST['memoId'],$_REQUEST['asignaobs']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;            
    }
}






?>