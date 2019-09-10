<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/memocdp/entidadmemocdp.php';
require_once '../modelo/memocdp/modelmemocdp.php';

$memocdp = new MemoCDP();
$modelMemocdp = new ModelMemoCDP();

if(isset($_REQUEST['Accion'])){
    switch($_REQUEST['Accion']){
       
        case 'registrarcdp': //OK
            $memocdp->__SET('memocdp_num',      $_REQUEST['numeroCDP']);
            $memocdp->__SET('memocdp_fecha',    $_REQUEST['FechaCDP']); 
            $memocdp->__SET('memocdp_cod_cc',   $_REQUEST['CCostoId']);
            $memocdp->__SET('memocdp_obs',      $_REQUEST['obsCDP']);
            $memocdp->__SET('memocdp_mem_id',   $_REQUEST['memocpdId']);
            $jsondata = $modelMemocdp->RegistraMemoCDP($memocdp,$_REQUEST['uid']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;
            
        case 'actualizarcdp':
            $memocdp->__SET('memocdp_id',       $_REQUEST['cdpId']);
            $memocdp->__SET('memocdp_num',      $_REQUEST['numeroCDP']);
            $memocdp->__SET('memocdp_fecha',    $_REQUEST['FechaCDP']); 
            $memocdp->__SET('memocdp_cod_cc',   $_REQUEST['CCostoId']);
            $memocdp->__SET('memocdp_obs',      $_REQUEST['obsCDP']);
            $memocdp->__SET('memocdp_mem_id',   $_REQUEST['memocpdId']);

            $jsondata = $modelMemocdp->ActualizarMemoCDP($memocdp,$_REQUEST['uid']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtenercdp':
            $jsondata = $modelMemocdp->ObtenerMemoCDP($_REQUEST['memoId'],$_REQUEST['cdpId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;

        case 'eliminarcdp'://OK
            $jsondata = $modelMemocdp->EliminarMemoCDP($_REQUEST['memoId'],$_REQUEST['cdpId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'listarcdp'://OK
            $jsondata = $modelMemocdp->ListarMemoCDP($_REQUEST['memId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;            

    }
}
?>