<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/memo/entidadmemo.php';
require_once '../modelo/memo/modelmemo.php';

$memo = new Memos();
$modelMemo = new ModelMemo();

if(isset($_REQUEST['Accionmem'])){
    switch($_REQUEST['Accionmem']){
        /*case 'actualizar':
            $jsondata = $modelMemo->Actualizar($memo,$_FILES);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;*/    	

        case 'registrar':
            //CODIGO TEMPORAL DONDE DEBERIA VALIDAR FECHA (NO SIRVE AUN)
                /*if($data->__GET('mem_fecha_recep')=="" || $data->__GET('mem_fecha_recep')==NULL) 
                  $fecharecep=null;
                else
                  $fecharecep=$data->__GET('mem_fecha_recep');
                if($data->__GET('mem_fecha')=="" || $data->__GET('mem_fecha')==NULL) 
                  $fechamemo=null;
                else
                  $fechamemo=$data->__GET('mem_fecha');*/
                  //exit(1);     
                     
            $memo->__SET('mem_fecha',           $_REQUEST['memoFecha']);
            $memo->__SET('mem_numero',          $_REQUEST['memoNum']);
            $memo->__SET('mem_anio',            $_REQUEST['memoAnio']);
            $memo->__SET('mem_fecha_recep',     $_REQUEST['memoFechaRecep']);
            $memo->__SET('mem_materia',         $_REQUEST['memoMateria']);
            $memo->__SET('mem_nom_sol',         $_REQUEST['memoNombreSol']); 
            $memo->__SET('mem_depto_sol_id',    $_REQUEST['memoDeptoSol']);
            $memo->__SET('mem_nom_dest',        $_REQUEST['memoNombreDest']);
            $memo->__SET('mem_depto_dest_id',   $_REQUEST['memoDeptoDest']);

            $jsondata = $modelMemo->Registrar($memo,$_FILES);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtener':
            $jsondata = $modelMemo->Obtener($_REQUEST['memoId'],$_REQUEST['seccion']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;    	

        case 'listar':
            $jsondata = $modelMemo->Listar($_REQUEST['nump'],$_REQUEST['idest'],$_REQUEST['idusu'],$_REQUEST['idsec']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'contar':
            $jsondata = $modelMemo->contarTotal($_REQUEST['idest'], $_REQUEST['idusu']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;     
        case 'listarestmemo':
            $jsondata = $modelMemo->ObtenerCambiosEstadosMemo($_REQUEST['memoId'],$_REQUEST['seccion']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
            
    }
}
?>