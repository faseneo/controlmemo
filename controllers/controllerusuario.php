<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/usuario/entidadusuario.php';
require_once '../modelo/usuario/modelusuario.php';

require_once '../modelo/memoestado/entidadmemocambioestado.php';
require_once '../modelo/memoestado/modelmemoestado.php';

// Logica
$usu = new Usuarios();
$modelUsu = new ModelUsuarios();

$CambioMEst = new MemoCambioEst();
$modelMemoEst = new ModelMemoEst();

if(isset($_REQUEST['Accion'])){

    switch($_REQUEST['Accion']){

        case 'actualizar':
            $usu->__SET('usu_id',           $_REQUEST['usuId']);
            $usu->__SET('usu_rut',          $_REQUEST['usuRut']);
            $usu->__SET('usu_nombre',       $_REQUEST['usuNombre']);
            $usu->__SET('usu_email',        $_REQUEST['usuEmail']);
            $usu->__SET('usu_password',     $_REQUEST['usuPass']);
            $usu->__SET('usu_rol_id',       $_REQUEST['usuRolId']);
            $usu->__SET('usu_estado_id',    $_REQUEST['usuEstadoId']);
            $usu->__SET('usu_depto_id',     $_REQUEST['usuDeptoId']);
            /*$usu->__SET('usu_perfil_nombre', $_REQUEST['usuarioperfilnom']);*/
            $jsondata = $modelUsu->Actualizar($usu);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'registrar':
            $usu->__SET('usu_rut',          $_REQUEST['usuRut']);
            $usu->__SET('usu_nombre',       $_REQUEST['usuNombre']);
            $usu->__SET('usu_email',        $_REQUEST['usuEmail']);
            $usu->__SET('usu_password',     $_REQUEST['usuPass']);
            $usu->__SET('usu_rol_id',       $_REQUEST['usuRolId']);
            $usu->__SET('usu_estado_id',    $_REQUEST['usuEstadoId']);
            $usu->__SET('usu_depto_id',     $_REQUEST['usuDeptoId']);
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

        case 'listarxrol':
            $jsondata = $modelUsu->Listarxrol($_REQUEST['rolId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'listarxperfil':
            $jsondata = $modelUsu->Listarxperfil($_REQUEST['perfilId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;            

        case 'asignamemo':
            $jsondata = $modelUsu->AsignaMemo($_REQUEST['asignausu'],
                                              $_REQUEST['memoId'],
                                              $_REQUEST['asignadif'],
                                              $_REQUEST['asignaprio'],
                                              $_REQUEST['asignaobs']);
            if($jsondata['success']==true && $_REQUEST['memoultest']){
                $CambioMEst->__SET('memo_camest_memid', $_REQUEST['memoId']);
                $CambioMEst->__SET('memo_camest_estid', 26);
                $CambioMEst->__SET('memo_camest_usuid', $_REQUEST['uId']);
                $CambioMEst->__SET('memo_camest_obs',   'Asignado a usuario : '.$_REQUEST['nomanalista']);
                $jsondata2 = $modelMemoEst->CambiaEstado($CambioMEst,17);
            }
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'getasignamemo':
            $jsondata = $modelUsu->ObtenerAsignaMemo($_REQUEST['memoId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'valida':
            $user=strtolower($_REQUEST['formUser']);
            $pass=$_REQUEST['formPass'];
            $jsondata = $modelUsu->Valida($user,$pass);
            echo json_encode($jsondata);
            break;           

        case 'valida2':
            //var_dump($_SESSION);
            /*$user=$_REQUEST['formRut'];
            $pass=$_REQUEST['formPass'];
            $jsondata = $modelUsu->Valida($_REQUEST['formRut'],$_REQUEST['formPass']);
            header ("Location: ../principal.php");*/
            //var_dump($jsondata);
            /*if($jsondata){
            }*/
            //header('Content-type: application/json; charset=utf-8');
            //echo json_encode($jsondata);
            break; 

        case 'addperfil':
         ///var_dump($_REQUEST);
            $jsondata = $modelUsu->RegistrarPerfiles($_REQUEST['idUsu'],$_REQUEST['usuPerfiles']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
    }
}






?>