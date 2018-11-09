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
    public $jsonresponse = array();

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
    /*
SELECT m.memo_id, m.memo_num_memo, m.memo_fecha_recepcion, m.memo_fecha_memo, m.memo_materia, dep.dpto_nombre, 
(SELECT me.memo_estado_tipo FROM cambio_estados as ce, memo_estado as me WHERE me.memo_estado_id=ce.cambio_estados_memo_estado_id AND ce.cambio_estados_memo_id=m.memo_id order by ce.cambio_estados_id DESC limit 1) as estado,
(SELECT ce.cambio_estados_fecha FROM cambio_estados as ce, memo_estado as me WHERE me.memo_estado_id=ce.cambio_estados_memo_estado_id AND ce.cambio_estados_memo_id=m.memo_id order by ce.cambio_estados_id DESC limit 1) as fechamodificacion
FROM memo AS m, departamento as dep 
WHERE dep.dpto_id = m.memo_depto_solicitante_id 
GROUP BY m.memo_id
ORDER BY m.memo_fecha_recepcion ASC, m.memo_fecha_memo DESC
-------------------------------------------------------
SELECT m.memo_id, m.memo_num_memo, m.memo_fecha_recepcion, m.memo_fecha_memo, m.memo_materia, dep.dpto_nombre, 
(SELECT me.memo_estado_tipo FROM cambio_estados as ce, memo_estado as me WHERE me.memo_estado_id=ce.cambio_estados_memo_estado_id AND ce.cambio_estados_memo_id=m.memo_id order by ce.cambio_estados_id DESC limit 1) as estado
FROM memo AS m, departamento as dep, cambio_estados as ces, memo_estado as mes
WHERE dep.dpto_id = m.memo_depto_solicitante_id AND ces.cambio_estados_memo_id=m.memo_id  AND mes.memo_estado_id=ces.cambio_estados_memo_estado_id AND mes.memo_estado_seccion_id=2
GROUP BY m.memo_id
ORDER BY m.memo_fecha_recepcion ASC, m.memo_fecha_memo DESC
---------------------------------------------------------

SELECT m.memo_id, m.memo_num_memo, m.memo_fecha_recepcion, m.memo_fecha_memo, m.memo_materia, dep.dpto_nombre, 
(SELECT me.memo_estado_tipo FROM cambio_estados as ce, memo_estado as me WHERE me.memo_estado_id=ce.cambio_estados_memo_estado_id AND ce.cambio_estados_memo_id=m.memo_id AND me.memo_estado_seccion_id=2 order by ce.cambio_estados_id DESC limit 1) as estado,
(SELECT ce.cambio_estados_fecha FROM cambio_estados as ce, memo_estado as me WHERE me.memo_estado_id=ce.cambio_estados_memo_estado_id AND ce.cambio_estados_memo_id=m.memo_id AND me.memo_estado_seccion_id=2 order by ce.cambio_estados_id DESC limit 1) as fechamodificacion
FROM memo AS m, departamento as dep, cambio_estados as ces, memo_estado as mes
WHERE dep.dpto_id = m.memo_depto_solicitante_id AND ces.cambio_estados_memo_id=m.memo_id  AND mes.memo_estado_id=ces.cambio_estados_memo_estado_id AND mes.memo_estado_seccion_id=2
GROUP BY m.memo_id
ORDER BY m.memo_fecha_recepcion ASC, m.memo_fecha_memo DESC


     */

    public function Listar($numpag = 1, $estadoid = 0, $usuid=0, $secid=0){
      $CantidadMostrar=10;
      $compag         =(int)($numpag);

      if($usuid == 0){
        $agregatabla = "";
        $filtrousuario = "";
      }else{
        $agregatabla = " ,asigna_usuario as mtu ";
        $filtrousuario = " AND mtu.asigna_usuario_memo_id = m.memo_id AND mtu.asigna_usuario_usuario_id=".$usuid;
      }

      if($estadoid == 0){
        $filtroestado = "";
        $filtroestado2 = "";
        $agregatablacamest ="";
      }else{
        $filtroestado = " AND me.memo_estado_id=".$estadoid;
        $filtroestado2 = " AND ces.cambio_estados_memo_id=".$estadoid;
        $agregatablacamest =",cambio_estados as ces ";
      }

      if($secid==0){
        $filtroseccion = "";
        $filtroseccion2 = "";
        $agregatablaestado = "";
      }else{
        $filtroseccion = " AND me.memo_estado_seccion_id=".$secid;
        $agregatablaestado = ", memo_estado as mes ";
        if($estadoid == 0){
          $agregatablaestado .=", cambio_estados as ces ";
        }
        $filtroseccion2 = " AND ces.cambio_estados_memo_id=m.memo_id 
                           AND mes.memo_estado_id=ces.cambio_estados_memo_estado_id 
                           AND mes.memo_estado_seccion_id=".$secid;
      }

        try{
            $respuesta = $this->contarTotal($estadoid,$usuid);
            $tot_reg = (int)$respuesta['total'];
            if ($tot_reg == 0) {
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'La búsqueda No arrojó elementos';                
                $jsonresponse['datos'] = [];
            }else{
              $result = array();
              $reginicio = ($compag-1) * $CantidadMostrar;

              $consulta = "SELECT m.memo_id, m.memo_num_memo, m.memo_anio, m.memo_fecha_recepcion, m.memo_fecha_memo, m.memo_materia, dep.dpto_nombre,";

              $consulta .= "(SELECT me.memo_estado_tipo FROM cambio_estados as ce, memo_estado as me 
                            WHERE me.memo_estado_id = ce.cambio_estados_memo_estado_id 
                            AND ce.cambio_estados_memo_id=m.memo_id "
                            .$filtroseccion
                            .$filtroestado
                            ." ORDER BY ce.cambio_estados_id DESC limit 1) as memo_estado_tipo,";

              $consulta .= "(SELECT ce.cambio_estados_fecha FROM cambio_estados as ce, memo_estado as me 
                            WHERE me.memo_estado_id = ce.cambio_estados_memo_estado_id 
                            AND ce.cambio_estados_memo_id=m.memo_id "
                            .$filtroseccion
                            .$filtroestado
                            ." ORDER BY ce.cambio_estados_id DESC limit 1) as memo_estado_fecha_modif";

              $consulta .= " FROM memo AS m, departamento as dep"
                           .$agregatablacamest
                           .$agregatablaestado
                           .$agregatabla;

              $consulta .= " WHERE dep.dpto_id = m.memo_depto_solicitante_id"
                            .$filtroseccion2
                            .$filtroestado2
                            .$filtrousuario;
              $consulta .= " GROUP BY m.memo_id ORDER BY m.memo_fecha_recepcion ASC, m.memo_fecha_memo DESC";

              $consulta .= " LIMIT ".$reginicio.",".$CantidadMostrar;

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
                      $busq->__SET('mem_estado_fechamod', $r->memo_estado_fecha_modif);
                  $result[] = $busq->returnArray();
                  $totquery++;
              }


              $jsonresponse['success'] = true;
              $jsonresponse['message'] = 'listado correctamente los memos';
              $jsonresponse['total'] = $totquery;
              $jsonresponse['datos'] = $result;
              $stm=null;
            }
            $res=null;
        } catch (PDOException $Exception){
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al listar Memos';
            $logs = new modelologs();
            $trace = $Exception->getTraceAsString();
              $logs->GrabarLogs($Exception->getMessage(),$trace);
              $logs = null;
        }finally {
          $this->pdo=null;  
        }
        
        return $jsonresponse;
    }
    //cuenta total de memos en el sistema
    public function contarTotal($estadoid = 0, $usuid = 0){
        $jsonresponse = array();
        if($estadoid == 0){
          $tablaestado = "";
          $filtroestado = "";
        }else{
          $tablaestado = ", cambio_estados as ce ";
          $filtroestado = " AND ce.cambio_estados_memo_id = m.memo_id AND ce.cambio_estados_memo_estado_id=".$estadoid;
        }   
        if($usuid == 0){
          $agregatabla = "";
          $filtrousuario = "";
        }else{
          $agregatabla = ", asigna_usuario as mtu ";
          $filtrousuario = " AND mtu.asigna_usuario_memo_id = m.memo_id AND mtu.asigna_usuario_usuario_id=".$usuid;
        }         
        try{
          $consulta="SELECT COUNT(memo_id) AS cantidad 
                     FROM memo AS m "
                     .$tablaestado
                     .$agregatabla
                     ."WHERE 1 "
                     .$filtroestado
                     .$filtrousuario;


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
    public function Obtener($id){
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
                          $arrayestados = $this->ObtenerCambiosEstadosMemo($r->memo_id);
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
    public function ObtenerCambiosEstadosMemo($idmemo){
         try{
          $consulta = "SELECT COUNT(*) FROM cambio_estados where cambio_estados_memo_id = ".$idmemo;
            $res = $this->pdo->query($consulta);
            if ($res->fetchColumn() == 0) {
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Cambios Estados  sin elementos';
                $jsonresponse['datos'] = [];
            }else{
              $stm = $this->pdo->prepare("SELECT  cambio_estados_memo_estado_id,
                                                  memo_estado_tipo,
                                                  cambio_estados_observacion,
                                                  cambio_estados_fecha,
                                                  memo_estado_seccion_id
                                          FROM cambio_estados as ce, 
                                               memo_estado as me 
                                          WHERE memo_estado_id = cambio_estados_memo_estado_id 
                                          AND cambio_estados_memo_id = ?");

              $stm->execute(array($idmemo));
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
                                      memo_depto_destinatario_id
                                      ) 
                    VALUES (?,?,?,?,?,?,?,?,?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('mem_numero'),
                                                     $data->__GET('mem_anio'),
                                                     $data->__GET('mem_fecha'),
                                                     $data->__GET('mem_fecha_recep'),
                                                     $data->__GET('mem_materia'),
                                                     $data->__GET('mem_nom_sol'),
                                                     $data->__GET('mem_depto_sol_id'),
                                                     $data->__GET('mem_nom_dest'),
                                                     $data->__GET('mem_depto_dest_id')
                                              ));
            $idmemo = $this->pdo->lastInsertId(); 
            $idestado = $data->__GET('mem_estado_id');
            $obsestado = $data->__GET('mem_estado_obs');

            $sqlinsertaestados="INSERT INTO cambio_estados (cambio_estados_memo_id,
                                                            cambio_estados_memo_estado_id,
                                                            cambio_estados_observacion)
                                VALUES ($idmemo, $idestado, '$obsestado')";
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

