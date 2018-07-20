<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/memo/entidadmemo.php';
require_once '../modelo/memo/modelmemo.php';

// Logica
$memo = new Memos();
$modelMemo = new ModelMemo();

if(isset($_REQUEST['AccionMemo'])){

    switch($_REQUEST['AccionMemo']){

        case 'actualizar':
            $memo->__SET('mem_id',              $_REQUEST['memoId']);
            $memo->__SET('mem_fecha',           $_REQUEST['memoFecha']);
            $memo->__SET('mem_numero',          $_REQUEST['memoNum']);
            $memo->__SET('mem_fecha_recep',     $_REQUEST['memoFechaRecep']);
            $memo->__SET('mem_anio',            $_REQUEST['memoAnio']);
            $memo->__SET('mem_materia',         $_REQUEST['memoMateria']);
            $memo->__SET('mem_nom_sol',         $_REQUEST['memoNombreSol']); 
            $memo->__SET('mem_depto_sol_id',    $_REQUEST['memoDeptoSol']);
            $memo->__SET('mem_nom_dest',        $_REQUEST['memoNombreDest']); 
            $memo->__SET('mem_depto_dest_id',   $_REQUEST['memoDeptoDest']);
/*            $memo->__SET('mem_archivo_memo',    $_REQUEST['memoFile']); 
            $memo->__SET('mem_archivo_lista',   $_REQUEST['memoFileList']);*/
            $memo->__SET('mem_estado_id',       $_REQUEST['memoEstado']); 
/*            $memo->__SET('mem_fecha_ingr',      $_REQUEST['memoDeptoSol']);*/
            $jsondata = $modelMemo->Actualizar($memo,$_FILES);
            header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
            break;

        case 'registrar':
            $memo->__SET('mem_fecha',           $_REQUEST['memoFecha']);
            $memo->__SET('mem_numero',          $_REQUEST['memoNum']);
            $memo->__SET('mem_fecha_recep',     $_REQUEST['memoFechaRecep']);
            $memo->__SET('mem_anio',            $_REQUEST['memoAnio']);
            $memo->__SET('mem_materia',         $_REQUEST['memoMateria']);
            $memo->__SET('mem_nom_sol',         $_REQUEST['memoNombreSol']); 
            $memo->__SET('mem_depto_sol_id',    $_REQUEST['memoDeptoSol']);
            $memo->__SET('mem_nom_dest',        $_REQUEST['memoNombreDest']); 
            $memo->__SET('mem_depto_dest_id',   $_REQUEST['memoDeptoDest']);
/*            $memo->__SET('mem_archivo_memo',  $_REQUEST['memoFile']); 
            $memo->__SET('mem_archivo_lista',   $_REQUEST['memoFileList']);*/
            $memo->__SET('mem_estado_id',       $_REQUEST['memoEstado']); 
/*            $memo->__SET('mem_fecha_ingr',    $_REQUEST['memoDeptoSol']);*/

            $jsondata = $modelMemo->Registrar($memo,$_FILES);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'eliminar':
            $jsondata = $modelMemo->Eliminar($_REQUEST['memoId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtener':
            $jsondata = $modelMemo->Obtener($_REQUEST['memoId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;
            
        case 'listar':
            $jsondata = $modelMemo->Listar();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;
    }
}
?>