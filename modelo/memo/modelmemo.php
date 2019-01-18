<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("../config/config.php");
require_once("../modelo/conexion/conexion.php");

require_once('../modelo/memoarchivo/entidadmemoarchivo.php');
require_once("../modelo/memoarchivo/modelmemoarchivo.php");
require_once("../modelo/logs/modelologs.php");
require_once("../modelo/logs/modelologsquerys.php");

class ModelMemo  {
    private $pdo;
    //public $jsonresponse = array();

    public function __CONSTRUCT(){
        try{
          $conexion = new Conexion();
            $this->pdo = $conexion->connect();
        }catch(Exception $e){
            $logs = new modelologs();
            $trace=$e->getTraceAsString();
              $logs->GrabarLogs($e->getMessage(),$trace);
              $logs = null;
              return null;
        }
    }
      // Lista todos los memos segun numpag, estado, seccion y/o usuario
    public function Listar($numpag = 1, $estadoid = 0, $usuid=0, $secid=1){
      $CantidadMostrar=10;
      $compag         =(int)($numpag);

        try{
            $respuesta = $this->contarTotal($secid,$estadoid,$usuid);
            $tot_reg = (int)$respuesta['total'];
            if ($tot_reg == 0) {
                $jsonresponsel['success'] = true;
                $jsonresponsel['message'] = 'La búsqueda No arrojó elementos';                
                $jsonresponsel['datos'] = [];
            }else{
              $result = array();
              $reginicio = ($compag-1) * $CantidadMostrar;

              $consulta = "CALL estado_max_por_seccion($secid,$estadoid,$reginicio,$CantidadMostrar,$usuid)";

              $logsq = new ModeloLogsQuerys();
                $logsq->GrabarLogsQuerys($consulta,'0','Listar');
                $logsq = null;

              $stm = $this->pdo->prepare($consulta);
              $stm->execute();
              $totquery = 0;
              foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                 $busq = new Memos();
                      $busq->__SET('mem_id', $r->memo_id);
                      $busq->__SET('mem_numero', $r->memo_num_memo);
                      $busq->__SET('mem_anio', $r->memo_anio);
                      $busq->__SET('mem_fecha', $r->memo_fecha_memo);
                      $busq->__SET('mem_fecha_recep', $r->memo_fecha_recepcion);
                      $busq->__SET('mem_materia', $r->memo_materia);
                      $busq->__SET('mem_depto_dest_nom', $r->dpto_nombre);
                      $busq->__SET('mem_estado_nombre', $r->memo_estado_tipo);
                      //$busq->__SET('mem_estado_fechamod', $r->memo_estado_fecha_modif);
                  $result[] = $busq->returnArray();
                  $totquery++;
              }


              $jsonresponsel['success'] = true;
              $jsonresponsel['message'] = 'listado correctamente los memos';
              $jsonresponsel['total'] = $totquery;
              $jsonresponsel['datos'] = $result;
              $stm=null;
            }
            $res=null;
        } catch (PDOException $Exception){
            $jsonresponsel['success'] = false;
            $jsonresponsel['message'] = 'Error al listar Memos';
            $logs = new modelologs();
            $trace = $Exception->getTraceAsString();
              $logs->GrabarLogs($Exception->getMessage(),$trace);
              $logs = null;
        }finally {
          $this->pdo=null;  
        }
        
        return $jsonresponsel;
    }
    //cuenta total de memos en el sistema
    public function contarTotal($secid=1,$estadoid = 0, $usuid=0){
        $jsonresponse = array();

        try{
            $consulta = "CALL total_listado_memos(".$secid.",".$estadoid.",".$usuid.");";

            $stm = $this->pdo->prepare($consulta);
            $stm->execute();
            $total_reg = $stm->fetch(PDO::FETCH_OBJ);

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'correctamente';
            $jsonresponse['total'] = $total_reg->cantidad;
            $stm=null;
            $logsq = new ModeloLogsQuerys();
              $logsq->GrabarLogsQuerys($consulta,$total_reg->cantidad,'contarTotal');
              $logsq = null;
        }
        catch(Exception $Exception){
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al contar los Memos';
            $logs = new modelologs();
            $trace = $Exception->getTraceAsString();
              $logs->GrabarLogs($Exception->getMessage(),$trace,'contarTotal');
              $logs = null;            
        }
      return $jsonresponse;        
    }
    //Obtiene datos del memo  por su id
    public function Obtener($id,$sec){
        try{
          $consulta = "SELECT COUNT(*) FROM memo";
            $res = $this->pdo->query($consulta);
            if ($res->fetchColumn() == 0) {
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Memo sin elementos';
                $jsonresponse['datos'] = [];
            }else{
              $stm = $this->pdo->prepare("SELECT  *
                                          FROM memo as mm, departamento as dep
                                          WHERE dep.dpto_id = mm.memo_depto_solicitante_id 
                                          AND mm.memo_id = ?");
                                          /*              SELECT  *
                                          FROM memo as mm, departamento as dep, cambio_estados as ce, memo_estado as me
                                          WHERE ce.cambio_estados_memo_id = mm.memo_id
                                          AND ce.cambio_estados_memo_estado_id = me.memo_estado_id
                                          AND dep.dpto_id = mm.memo_depto_solicitante_id 
                                          AND mm.memo_id = ?*/
              $stm->execute(array($id));
              $r = $stm->fetch(PDO::FETCH_OBJ);
              if($r){
                $busq = new Memos();
                          $busq->__SET('mem_id', $r->memo_id);
                          $busq->__SET('mem_numero', $r->memo_num_memo);
                          $busq->__SET('mem_anio', $r->memo_anio);
                          $busq->__SET('mem_materia', $r->memo_materia);
                          $busq->__SET('mem_fecha', $r->memo_fecha_memo);
                          $busq->__SET('mem_fecha_recep', $r->memo_fecha_recepcion);

                          $busq->__SET('mem_depto_sol_id', $r->memo_depto_solicitante_id);
                          $busq->__SET('mem_nom_sol', $r->memo_nombre_solicitante);

                          $busq->__SET('mem_depto_sol_nom', $r->dpto_nombre);
                          
                          $busq->__SET('mem_depto_dest_id', $r->memo_depto_destinatario_id);
                          $busq->__SET('mem_nom_dest', $r->memo_nombre_destinatario);

                          $busq->__SET('mem_fecha_ingr', $r->memo_fecha_ingreso);
                          $busq->__SET('mem_cc_codigo', $r->memo_cc_codigo);
                          $busq->__SET('mem_fecha_cdp', $r->memo_fecha_cdp);

                          $modelMemoArch = new ModelMemoArchivo();
                          
                          $arrayfile = $modelMemoArch->listar($r->memo_id);
                            $busq->__SET('mem_archivos', $arrayfile['datos']);
                          $arrayestados = $this->ObtenerCambiosEstadosMemo($r->memo_id,$sec);
                            $busq->__SET('mem_estados', $arrayestados['datos']);

                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Se obtuvo el memo correctamente';
                $jsonresponse['datos'] = $busq->returnArray();
              }else{
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'NO exite el memo';
                $jsonresponse['datos'] = [];
              }
              $stm=null;
            }
            $res=null;
        } catch (Exception $Exception){
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener memos';
            $logs = new modelologs();
            $trace=$Exception->getTraceAsString();
              $logs->GrabarLogs($Exception->getMessage(),$trace);
              $logs = null;
        }
        $this->pdo=null;
        return $jsonresponse;
    }

    public function ObtenerCambiosEstadosMemo($idmemo,$sec=1){
        $seccion = (int) $sec;
         try{
          if($seccion == 1 || $seccion == null || $seccion=='null'){
                $filtro = "";
            }else{
                $seccionfiltro="AND  me.memo_estado_seccion_id = ".$seccion;
            }
            $consulta = "SELECT COUNT(*) FROM cambio_estados where cambio_estados_memo_id = ".$idmemo;

            $res = $this->pdo->query($consulta);
            if ($res->fetchColumn() == 0) {
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Cambios Estados  sin elementos';
                $jsonresponse['datos'] = [];
            }else{
              $query = "SELECT  ce.cambio_estados_memo_estado_id,
                                                  me.memo_estado_tipo,
                                                  ce.cambio_estados_observacion,
                                                  ce.cambio_estados_fecha,
                                                  me.memo_estado_seccion_id
                                          FROM cambio_estados as ce, memo_estado as me 
                                          WHERE me.memo_estado_id = ce.cambio_estados_memo_estado_id 
                                          AND ce.cambio_estados_memo_id = $idmemo ".$seccionfiltro;
              $stm = $this->pdo->prepare($query);
              $stm->execute();
              //$stm->execute(array($idmemo));
              //$r = $stm->fetch(PDO::FETCH_OBJ);

                foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                    $fila = array('estado_id'=>$r->cambio_estados_memo_estado_id,
                                  'estado_tipo'=>$r->memo_estado_tipo,
                                  'observacion'=>$r->cambio_estados_observacion,
                                  'fecha'=>$r->cambio_estados_fecha,
                                  'seccion_id'=>$r->memo_estado_seccion_id);
                    $result[]=$fila;
                }

                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Se Cambios Estados correctamente';
                $jsonresponse['datos'] = $result;
              $stm=null;
            }
            $res=null;
        } catch (Exception $Exception){
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener Cambios Estados';
            $logs = new modelologs();
            $trace=$Exception->getTraceAsString();
              $logs->GrabarLogs($Exception->getMessage(),$trace);
              $logs = null;
        }
        $this->pdo=null;
        return $jsonresponse;
    }
    /* public function Eliminar($id){
        try{
            $stm = $this->pdo->prepare("DELETE FROM memo WHERE memo_id = ? ");
            $stm->execute(array($id));

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Memo eliminado correctamente';              
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar Memo';            
        }
        return $jsonresponse;
    }
    */
    public function Registrar(Memos $data, $files){
      try{
            $sql = "INSERT INTO memo (memo_num_memo,
                                      memo_anio,
                                      memo_fecha_memo,
                                      memo_fecha_recepcion,
                                      memo_materia,
                                      memo_nombre_solicitante,
                                      memo_depto_solicitante_id,
                                      memo_nombre_destinatario,
                                      memo_depto_destinatario_id,
                                      memo_cc_codigo
                                      ) 
                    VALUES (?,?,?,?,?,?,?,?,?,?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('mem_numero'),
                                                     $data->__GET('mem_anio'),
                                                     $data->__GET('mem_fecha'),
                                                     $data->__GET('mem_fecha_recep'),
                                                     $data->__GET('mem_materia'),
                                                     $data->__GET('mem_nom_sol'),
                                                     $data->__GET('mem_depto_sol_id'),
                                                     $data->__GET('mem_nom_dest'),
                                                     $data->__GET('mem_depto_dest_id'),
                                                     $data->__GET('mem_cc_codigo')
                                                    ));
            $logsq = new ModeloLogsQuerys();
                $logsq->GrabarLogsQuerys($sql,'0','Registrar');
                $logsq = null;

            $idmemo = $this->pdo->lastInsertId(); 
            $idestado = 1; //$data->__GET('mem_estado_id');
            $obsestado = "Ingresado por usuario"; //$data->__GET('mem_estado_obs')

            $sqlinsertaestados="INSERT INTO cambio_estados (cambio_estados_memo_id,
                                                            cambio_estados_memo_estado_id,
                                                            cambio_estados_observacion)
                                VALUES ($idmemo, $idestado, '$obsestado')";
            $logsq2 = new ModeloLogsQuerys();
                $logsq2->GrabarLogsQuerys($sqlinsertaestados,'0','RegistrarEstado');
                $logsq2 = null;

            $stm = $this->pdo->prepare($sqlinsertaestados);
            $stm->execute();
            //var_dump($sqlinsertaestados); exit(1);
            $modelMemoArch = new ModelMemoArchivo();
            $arrayfile = $modelMemoArch->Registrar($files,$idmemo,$data->__GET('mem_numero'),$data->__GET('mem_anio'));

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Memo ingresado correctamente'; 
            $jsonresponse['messagefile'] = $arrayfile;
        } catch (Exception $Exception){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar Memo';
            $jsonresponse['errorQuery'] = $Exception->getMessage();
            $logs = new modelologs();
            $trace=$Exception->getTraceAsString();
              $logs->GrabarLogs($Exception->getMessage(),$trace);
              $logs = null;            
        }
        return $jsonresponse;
    }

    public function ActualizarMemoCDP($memoId,$ccCodigo,$fechaCDP){
        $jsonresponse = array();
        try{
            $sql = "UPDATE memo SET 
                           memo_cc_codigo = ?,
                           memo_fecha_cdp = ?
                    WHERE  memo_id = ?";
            $this->pdo->prepare($sql)->execute(array($ccCodigo,
                                                     $fechaCDP,
                                                     $memoId
                                                    )
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Memo estado actualizado correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar memo estado';             
        }
        return $jsonresponse;
    }

    public function Actualizar(MemoEst $data){
        $jsonresponse = array();
        //print_r($data);
        try{
            $sql = "UPDATE memo_estado SET 
                           memo_estado_tipo = ?,
                     memo_estado_orden = ?,
                           memo_estado_activo = ?,
                           memo_estado_seccion_id = ?
                    WHERE  memo_estado_id = ?";
            $this->pdo->prepare($sql)->execute(array($data->__GET('memo_est_tipo'),
                                                     $data->__GET('memo_est_orden'),
                                                     $data->__GET('memo_est_activo'),
                                                     $data->__GET('memo_est_seccion_id'),
                                                     $data->__GET('memo_est_id')
                                                    )
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Memo estado actualizado correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar memo estado';             
        }
        return $jsonresponse;
    }
    /*
    public function Actualizar(Memos $data){
        //print_r($data);
        try{
            $sql = "UPDATE memo SET 
                           memo_num_memo = ?,
                           memo_fecha_recepcion = ?,
                           memo_fecha_memo = ?,
                           memo_fecha_entrega_analista = ?,
                           memo_depto_id = ?, 
                           memo_cc_id = ?,
                           memo_memo_estado_id = ?
                    WHERE  memo_id = ?";

            $this->pdo->prepare($sql)
                 ->execute(array($data->__GET('mem_numero'),
                                 $data->__GET('mem_fecha_recep'),
                                 $data->__GET('mem_fecha'),
                                 $data->__GET('mem_fecha_analista'),
                                 $data->__GET('mem_depto_id'),
                                 $data->__GET('mem_ccosto_id'),
                                 $data->__GET('mem_estado_id'),
                                 $data->__GET('mem_id'))
                          );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Memo actualizado correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar memo';             
        }
        return $jsonresponse;
    }*/

  /* public function Listar2(){
        try{
            $result = array();
             $stm = $this->pdo->prepare("SELECT   mm.memo_id,
                                                  mm.memo_num_memo,
                                                  mm.memo_fecha_recepcion,
                                                  mm.memo_fecha_memo,
                                                  mm.memo_fecha_entrega_analista,
                                                  mm.memo_depto_id,
                                                  mm.memo_cc_id,
                                                  mm.memo_memo_estado_id,
                                                  mm.memo_fecha_ingreso
                                        FROM memo as mm");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new Memos();
                    $busq->__SET('mem_id', $r->memo_id);
                    $busq->__SET('mem_numero', $r->memo_num_memo);
                    $busq->__SET('mem_fecha_recep', $r->memo_fecha_recepcion);
                    $busq->__SET('mem_fecha', $r->memo_fecha_memo);
                    $busq->__SET('mem_fecha_analista', $r->memo_fecha_entrega_analista);  
                    $busq->__SET('mem_depto_id', $r->memo_depto_id);
                    $busq->__SET('mem_ccosto_id', $r->memo_cc_id);
                    $busq->__SET('mem_estado_id', $r->memo_memo_estado_id);
                    $busq->__SET('mem_fecha_ingr', $r->memo_fecha_ingreso);
                $result[] = $busq;
            }
            return $result;
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }*/
}
?>

