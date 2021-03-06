<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/memo/entidadmemo.php';
require_once '../modelo/memo/entidadmemolistado.php';
require_once '../modelo/memo/modelmemo.php';

$memo = new Memos();
$modelMemo = new ModelMemo();

if(isset($_REQUEST['Accionmem'])){
    switch($_REQUEST['Accionmem']){
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
            $uid=$_REQUEST['uid'];
            $tiporeg=$_REQUEST['tiporeg'];
            if($tiporeg=='ingreso'){
              $estgenerico = 1;
            }else{
              $estgenerico = 2;
            }
            //se supone que aqui no entra cualquiera ,  segun permisos , a ingresar o recibir
            //no se valida al usuario segun permisos, en esta parte entran los que tienen permisos de ingreso o recibido
            $estadoinicial = $modelMemo->ValidaEstadoDepto($uid, $estgenerico);

            if($estadoinicial['estadoinicial'] <> false){
                $memo->__SET('mem_fecha',           $_REQUEST['memoFecha']);
                $memo->__SET('mem_numero',          $_REQUEST['memoNum']);
                $memo->__SET('mem_anio',            $_REQUEST['memoAnio']);
                if(isset($_REQUEST['tiporeg']) and $_REQUEST['tiporeg']=='ingreso'){
                    $memo->__SET('mem_fecha_recep', $_REQUEST['memoFecha']);
                }else{
                    $memo->__SET('mem_fecha_recep', $_REQUEST['memoFechaRecep']);
                }
                $memo->__SET('mem_materia',         $_REQUEST['memoMateria']);
                $memo->__SET('mem_nom_sol',         $_REQUEST['memoNombreSol']); 
                $memo->__SET('mem_depto_sol_id',    $_REQUEST['memoDeptoSol']);
                $memo->__SET('mem_nom_dest',        $_REQUEST['memoNombreDest']);
                $memo->__SET('mem_depto_dest_id',   $_REQUEST['memoDeptoDest']);
                /*var_dump($_FILES);
                $files=$_FILES['memoFile']; $files2=$_FILES['memoFileList'];
                $totalArchivo = sizeof($files['name']);  $totalArchivo2 = sizeof($files2['name']);
                var_dump(is_array($files['name'])); var_dump(is_array($files2['name']));
                var_dump($files['name']); var_dump($files2['name']); var_dump($totalArchivo); var_dump($totalArchivo2);*/
                $jsondata = $modelMemo->Registrar($memo,$_FILES,$uid,$tiporeg,$estadoinicial['estadoinicial']);
            }else{
                $jsondata = $estadoinicial;
            }
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;
        case 'registrarcdp':
            $jsondata = $modelMemo->ActualizarMemoCDP($_REQUEST['memoId'],$_REQUEST['CCostoId'],$_REQUEST['FechaCDP'],$_REQUEST['uid']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;
            
        case 'actualizar':
            $memo->__SET('mem_id',              $_REQUEST['memoId']);
            $memo->__SET('mem_materia',         $_REQUEST['memoMateria']);
            $memo->__SET('mem_nom_sol',         $_REQUEST['memoNombreSol']); 
            $memo->__SET('mem_depto_sol_id',    $_REQUEST['memoDeptoSol']);
            $memo->__SET('mem_nom_dest',        $_REQUEST['memoNombreDest']);
            $memo->__SET('mem_depto_dest_id',   $_REQUEST['memoDeptoDest']);

            $jsondata = $modelMemo->Actualizar($memo);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'obtener':
            $uid=isset($_REQUEST['uid']) ? $_REQUEST['uid'] : 0;
            $jsondata = $modelMemo->Obtener($_REQUEST['memoId'],$_REQUEST['depto'],$uid);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;

        case 'listar':
             if(isset($_REQUEST['usuasigna'])){
                $usuasigna = $_REQUEST['usuasigna'];
             }else{
                $usuasigna=0;
             }
            $jsondata = $modelMemo->Listar($_REQUEST['deptosolid'],
                                           $_REQUEST['deptodesid'],
                                           $_REQUEST['nump'],
                                           $_REQUEST['idest'],
                                           $_REQUEST['idusu'],
                                           $_REQUEST['anio'],
                                           $_REQUEST['mes'],
                                           $_REQUEST['numdoc'],
                                           $_REQUEST['dptoid'],
                                           $usuasigna);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'contar':
            $jsondata = $modelMemo->contarTotal($_REQUEST['idest'], $_REQUEST['idusu']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            break;

        case 'listarestmemo':
            $jsondata = $modelMemo->ObtenerCambiosEstadosMemo($_REQUEST['memoId'],$_REQUEST['depto']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;

        case 'listarderiv':
            $jsondata = $modelMemo->ObtenerCambiosDerivadosMemo($_REQUEST['memoId']);
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);            
            break;        
    }
}
?>