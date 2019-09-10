<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once '../modelo/memoresolucion/entidadmemoresolucion.php';
require_once '../modelo/memoresolucion/modelmemoresolucion.php';
// Logica
$memasocres = new MemoAsociaresolucion();
$modelmemasocres = new ModelMemoAsociaResolucion();

if(isset($_REQUEST['Accion'])){
    switch($_REQUEST['Accion']){

        case 'actualizar':
/*            $memasocres->__SET('mem_asoc_id',       $_REQUEST['memobsId']);
            $memasocres->__SET('mem_asoc_texto',    $_REQUEST['memobsTexto']);
            $memasocres->__SET('mem_asoc_memo_id',  $_REQUEST['memobsMemid']);
            $memasocres->__SET('mem_asoc_usu_id',   $_REQUEST['memobsUsuid']);
            $jsondata = $modelmemasocres->Actualizar($memoobs);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);*/
            break;
        case 'registrares':
            $resid = $_REQUEST['resId'];
            $memid = $_REQUEST['memId'];
            $uid = $_REQUEST['uId'];

               $ch = curl_init();
                // definimos la URL a la que hacemos la petición
                curl_setopt($ch, CURLOPT_URL,"http://resoluciones2.umce.cl/controllers/controllerresoluciones.php");
                // definimos el número de campos o parámetros que enviamos mediante POST
                curl_setopt($ch, CURLOPT_POST, 1);
                // definimos cada uno de los parámetros
                curl_setopt($ch, CURLOPT_POSTFIELDS, "Accion=obtener&resId=".$resid);
                 // recibimos la respuesta y la guardamos en una variable
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $rem_serv_respuesta = curl_exec ($ch);
                 // cerramos la sesión cURL
                curl_close ($ch);
                $jsonrespuesta = json_decode($rem_serv_respuesta);
                /* echo $jsonrespuesta->datos->res_id."<br>";
                echo URLRES.$jsonrespuesta->datos->res_ruta."<br>";
                echo $jsonrespuesta->datos->res_anio."<br>";
                echo $jsonrespuesta->datos->res_numero."<br>";
                echo $jsonrespuesta->datos->res_categoria."<br>";
                echo $jsonrespuesta->datos->res_fecha."<br>";
                echo $jsonrespuesta->datos->res_fechapub."<br>";*/

            $memasocres->__SET('mem_asoc_memid',        $memid);
            $memasocres->__SET('mem_asoc_resid',        $jsonrespuesta->datos->res_id);
            $memasocres->__SET('mem_asoc_resurl',       URLRES.$jsonrespuesta->datos->res_ruta);
            $memasocres->__SET('mem_asoc_resanio',      $jsonrespuesta->datos->res_anio);
            $memasocres->__SET('mem_asoc_resnum',       $jsonrespuesta->datos->res_numero);
            $memasocres->__SET('mem_asoc_rescatcod',    $jsonrespuesta->datos->res_categoria);
            $memasocres->__SET('mem_asoc_resfecha',     $jsonrespuesta->datos->res_fecha);
            $memasocres->__SET('mem_asoc_resfechapub',  $jsonrespuesta->datos->res_fechapub);
            
            $jsondata = $modelmemasocres->Registrar($memasocres,$uid);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'eliminar':
            $jsondata = $modelmemasocres->Eliminar($_REQUEST['resId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        /*case 'obtener':
            $jsondata = $modelmemasocres->Obtener($_REQUEST['memid']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;*/
            
        case 'listar':
            $jsondata = $modelmemasocres->Listar($_REQUEST['memId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'listarmin':
            $jsondata = $modelmemasocres->ListarMin($_REQUEST['memId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;            
    }
}

?>