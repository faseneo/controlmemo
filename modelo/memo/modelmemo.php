<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("../config/config.php");
require_once("../modelo/conexion/conexion.php");

require_once('../modelo/memoarchivo/entidadmemoarchivo.php');
require_once("../modelo/memoarchivo/modelmemoarchivo.php");

require_once("../modelo/memoestado/entidadmemocambioestado.php");
require_once("../modelo/memoestado/modelmemoestado.php");

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
      // $deptosol=1,$deptodes=1,$estadoid=0,$usuid=0,$anio=0
      //public function Listar($numpag = 1, $estadoid = 0, $usuid=0, $secid=1){
    public function Listar($deptosol=1,$deptodes=1, $numpag = 1, $estadoid = 0, $usuid=0, $anio=0, $numdoc=0){
      $CantidadMostrar=10;
      $compag         =(int)($numpag);
        try{
            $respuesta = $this->contarTotal($deptosol,$deptodes,$estadoid,$usuid,$anio,$numdoc);
            $tot_reg = (int)$respuesta['total'];
            if ($tot_reg == 0) {
                $jsonresponsel['success'] = true;
                $jsonresponsel['message'] = 'La búsqueda No arrojó elementos';                
                $jsonresponsel['datos'] = [];
            }else{
              $result = array();
              $reginicio = ($compag-1) * $CantidadMostrar;

              $consulta = "CALL listado_memo_por_estadomax_depto($deptosol,$deptodes,$estadoid,$reginicio,$CantidadMostrar,$usuid,$anio,$numdoc);";

              $logsq = new ModeloLogsQuerys();
                $logsq->GrabarLogsQuerys($consulta,$tot_reg,'Listar');
                $logsq = null;

              $stm = $this->pdo->prepare($consulta);
              $stm->execute();
              $totquery = 0;
              foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                 $busq = new MemosListado();
                      $busq->__SET('mem_id', $r->memo_id);
                      $busq->__SET('mem_numero', $r->memo_num_memo);
                      $busq->__SET('mem_anio', $r->memo_anio);
                      $busq->__SET('mem_fecha', date_format(date_create($r->memo_fecha_memo),'d-m-Y' ));
                      $busq->__SET('mem_fecha_recep', date_format(date_create($r->memo_fecha_recepcion),'d-m-Y' ));
                      $busq->__SET('mem_materia', $r->memo_materia);
                      $busq->__SET('mem_depto_sol_nom', $r->depto_nombre);
                      $busq->__SET('mem_depto_dest_nom', $r->depto_nombre_dest);
                      $busq->__SET('mem_estado_id_max', $r->estado_max_id);
                      $busq->__SET('mem_estado_nom_max', $r->memo_estado_tipo);
                      $busq->__SET('mem_estado_colorbg', $r->memo_estado_color_bg);
                      $busq->__SET('mem_estado_colortxt', $r->memo_estado_color_font);                      
                      $busq->__SET('mem_estado_obs_max', $r->cambio_estados_observacion);
                      $busq->__SET('mem_estado_fecha_max', date_format(date_create($r->cambio_estados_fecha),'d-m-Y' ));
                      $busq->__SET('mem_estado_dias', $r->cambio_estados_dias);
                  $result[] = $busq->returnArray();
                  $totquery++;
              }

              $jsonresponsel['success'] = true;
              $jsonresponsel['message'] = 'listado correctamente los memos';
              $jsonresponsel['total'] = $tot_reg;
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
    public function contarTotal($deptosol=1,$deptodes=1,$estadoid=0,$usuid=0,$anio=0,$numdoc=0){
        $jsonresponse = array();
        try{
            $consulta = "CALL total_listado_memos_estado_depto($deptosol,$deptodes,$estadoid,$usuid,$anio,$numdoc);";

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
    public function Obtener($id,$dep){
        try{
          $consulta = "SELECT COUNT(*) FROM memo WHERE memo_id = ".$id;
            $res = $this->pdo->query($consulta);
            $total = $res->fetchColumn();
            if ($total == 0) {
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Memo no existe';
                $jsonresponse['datos'] = [];
            }else{
              $consultamemo = "SELECT  *
                            FROM memo as mm, departamento as dep, centro_costos as cc
                            WHERE dep.depto_id = mm.memo_depto_solicitante_id 
                            AND cc.cc_codigo=mm.memo_cc_codigo
                            AND mm.memo_id = ?";
              $stm = $this->pdo->prepare($consultamemo);
              $logsq = new ModeloLogsQuerys();
                $logsq->GrabarLogsQuerys($consultamemo,$total,'Obtener');
                $logsq = null;

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
                          $busq->__SET('mem_depto_sol_nom', $r->depto_nombre);

                          $busq->__SET('mem_depto_dest_id', $r->memo_depto_destinatario_id);
                          $busq->__SET('mem_nom_dest', $r->memo_nombre_destinatario);

                          $busq->__SET('mem_fecha_ingr', $r->memo_fecha_ingreso);
                          $busq->__SET('mem_cc_codigo', $r->memo_cc_codigo);
                          $busq->__SET('mem_fecha_cdp', date_format(date_create($r->memo_fecha_cdp),'d-m-Y' ));
                          $busq->__SET('mem_nom_cc', $r->cc_nombre);

                          $modelMemoArch = new ModelMemoArchivo();

                          $arrayfile = $modelMemoArch->listar($r->memo_id);
                            $busq->__SET('mem_archivos', $arrayfile['datos']);
                          $arrayestados = $this->ObtenerCambiosEstadosMemo($r->memo_id,$dep);
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

    //Funcion que lista los cambios de estados del memo
    public function ObtenerCambiosEstadosMemo($idmemo,$dep=1){
        $depto = (int) $dep;
         try{
          if($depto == 1 || $depto == null || $depto=='null'){
                $deptofiltro = "";
            }else{
                $deptofiltro="AND  me.memo_estado_depto_id = ".$depto;
            }
            $consulta = "SELECT COUNT(*) FROM cambio_estados where cambio_estados_memo_id = ".$idmemo;
            $res = $this->pdo->query($consulta);
            $totalestados = $res->fetchColumn();

            if ($totalestados == 0) {
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Cambios Estados  sin elementos';
                $jsonresponse['datos'] = [];
            }else{
              $query = "SELECT  ce.cambio_estados_memo_estado_id,
                                                  me.memo_estado_tipo,
                                                  me.memo_estado_orden,
                                                  ce.cambio_estados_observacion,
                                                  ce.cambio_estados_fecha,
                                                  me.memo_estado_depto_id,
                                                  us.usuario_email,
                                                  us.usuario_nombre
                                          FROM cambio_estados as ce, memo_estado as me, usuario as us 
                                          WHERE me.memo_estado_id = ce.cambio_estados_memo_estado_id 
                                          AND us.usuario_id = ce.cambio_estados_usuario_id
                                          AND ce.cambio_estados_memo_id = $idmemo ".$deptofiltro;
              $stm = $this->pdo->prepare($query);
              $stm->execute();
              $logsq = new ModeloLogsQuerys();
                $logsq->GrabarLogsQuerys($query,$totalestados,'Obtener Cambios Estados');
                $logsq = null;

              //$stm->execute(array($idmemo));
              //$r = $stm->fetch(PDO::FETCH_OBJ);

                foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                    $fila = array('estado_id'=>$r->cambio_estados_memo_estado_id,
                                  'estado_tipo'=>$r->memo_estado_tipo,
                                  'estado_orden'=>$r->memo_estado_orden,
                                  'observacion'=>$r->cambio_estados_observacion,
                                  'fecha'=>date_format(date_create($r->cambio_estados_fecha),'d-m-Y H:i:s' ),
                                  'depto_id'=>$r->memo_estado_depto_id,
                                  'user'=>$r->usuario_email,
                                  'user_nom'=>$r->usuario_nombre
                                  );
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
    //Funcion que lista los derivados del memo
    public function ObtenerCambiosDerivadosMemo($idmemo){
        $jsonresponse = array();
        try{
            $consulta = "SELECT COUNT(*) FROM memo_derivado where memo_derivado_memo_id = ".$idmemo;
            $res = $this->pdo->query($consulta);
            $totalderivados = $res->fetchColumn();

            if ($totalderivados == 0) {
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Derivados sin elementos';
                $jsonresponse['datos'] = [];
            }else{
              $query = "SELECT md.memo_derivado_id,md.memo_derivado_dpto_id, md.memo_derivado_nombre_destinatario, md.memo_derivado_fecha, 
                              md.memo_derivado_depto_actual, d.depto_nombre_corto
                        FROM memo_derivado AS md, departamento AS d
                        WHERE depto_id =  memo_derivado_dpto_id 
                        AND memo_derivado_memo_id =  $idmemo ";
              $stm = $this->pdo->prepare($query);
              $stm->execute();
              $logsq = new ModeloLogsQuerys();
                $logsq->GrabarLogsQuerys($query,$totalderivados,'Obtener Derivados');
                $logsq = null;

                foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                    $fila = array('memder_id'=>$r->memo_derivado_id,
                                  'memder_deptoid'=>$r->memo_derivado_dpto_id,
                                  'memder_deptonom'=>$r->memo_derivado_nombre_destinatario,
                                  'memder_fecha'=>date_format(date_create($r->memo_derivado_fecha),'d-m-Y H:i:s' ),
                                  'memder_actual'=>$r->memo_derivado_depto_actual,
                                  'memder_deptocorto'=>$r->depto_nombre_corto
                                  );
                    $result[]=$fila;
                }

                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Se obtuvo derivados correctamente';
                $jsonresponse['datos'] = $result;
              $stm=null;
            }
            $res=null;
        } catch (Exception $Exception){
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener derivados correctamente';
            $logs = new modelologs();
            $trace=$Exception->getTraceAsString();
              $logs->GrabarLogs($Exception->getMessage(),$trace);
              $logs = null;
        }
        $this->pdo=null;
        return $jsonresponse;
    }    
    //Registra un nuevo Memo
    public function Registrar(Memos $data, $files,$uid,$tiporeg){
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
                                                     0
                                                    ));
            $logsq = new ModeloLogsQuerys();
                $logsq->GrabarLogsQuerys($sql,'0','Registrar');
                //$logsq = null;
            $idmemo = $this->pdo->lastInsertId(); 
            if($tiporeg=='ingreso'){
              $idestado = 1; //$data->__GET('mem_estado_id');
            }else{
              $idestado = 2; 
            }

            

            $obsestado = "Ingresado por usuario"; //$data->__GET('mem_estado_obs')
            $objcambioest = new MemoCambioEst();
            $modelcambioest = new ModelMemoEst();
              $objcambioest->__SET('memo_camest_memid',$idmemo);
              $objcambioest->__SET('memo_camest_estid',$idestado);
              $objcambioest->__SET('memo_camest_obs',$obsestado);
              $objcambioest->__SET('memo_camest_usuid',$uid);
              $objcambioest->__SET('memo_camest_deptoid',$data->__GET('mem_depto_dest_id'));
              $objcambioest->__SET('memo_camest_deptonom',$data->__GET('mem_nom_dest'));

            /*$sqlinsertaestados="INSERT INTO cambio_estados (cambio_estados_memo_id,
                                                            cambio_estados_memo_estado_id,
                                                            cambio_estados_observacion,
                                                            cambio_estados_usuario_id)
                                VALUES ($idmemo, $idestado, '$obsestado',$uid)";*/
                $modelcambioest->CambiaEstado($objcambioest);
            exit();
                /*$logsq->GrabarLogsQuerys($sqlinsertaestados,'0','RegistrarEstado');
                $stm = $this->pdo->prepare($sqlinsertaestados);
                $stm->execute();*/

            //insertar derivado
              /*$deptodestino = $data->__GET('mem_depto_dest_id');
              $deptonomdestino = $data->__GET('mem_nom_dest');
              $sqlinsertaderivado = "INSERT INTO memo_derivado (memo_derivado_memo_id, memo_derivado_dpto_id,memo_derivado_nombre_destinatario,
                                    memo_derivado_depto_actual,memo_derivado_estado_id) 
                                  VALUES ($idmemo,$deptodestino,'$deptonomdestino',1,1)";*/
            //$logsq = new ModeloLogsQuerys();
                /*$logsq->GrabarLogsQuerys($sqlinsertaderivado,'0','RegistraDerivado');
              $stm = $this->pdo->prepare($sqlinsertaderivado);
              $stm->execute();                */

            $logsq = null;
            //var_dump($sqlinsertaestados); exit(1);
            $modelMemoArch = new ModelMemoArchivo();
            //$files['memoFile'];
            //$idmemo=7;
            $tipoarch='memo';
            $tipoarch2='anexomemo';
            $arrayfile = $modelMemoArch->RegistrarArchivoGenerico($files['memoFile'],$tipoarch,$idmemo,$data->__GET('mem_numero'),$data->__GET('mem_anio'));
            $arrayfile = $modelMemoArch->RegistrarArchivoGenerico($files['memoFileList'],$tipoarch2,$idmemo,$data->__GET('mem_numero'),$data->__GET('mem_anio'));
            //$arrayfile = $modelMemoArch->Registrar($files,$idmemo,$data->__GET('mem_numero'),$data->__GET('mem_anio'));

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

    public function Actualizar(Memos $data){
      //var_dump($data);
      try{
            $sql = "UPDATE memo SET 
                           memo_materia = ?,
                           memo_nombre_solicitante = ?,
                           memo_depto_solicitante_id = ?,
                           memo_nombre_destinatario = ?,
                           memo_depto_destinatario_id = ? 
                    WHERE  memo_id = ?";

            $this->pdo->prepare($sql)->execute(array($data->__GET('mem_materia'),
                                                     $data->__GET('mem_nom_sol'),
                                                     $data->__GET('mem_depto_sol_id'),
                                                     $data->__GET('mem_nom_dest'),
                                                     $data->__GET('mem_depto_dest_id'),
                                                     $data->__GET('mem_id')
                                                    ));
            $logsq = new ModeloLogsQuerys();
                $logsq->GrabarLogsQuerys($sql,'0','Actualizar');
                $logsq = null;

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Memo Actualizado correctamente'; 
        } catch (Exception $Exception){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizad Memo';
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
            $sql = "UPDATE memo SET memo_cc_codigo = $ccCodigo,memo_fecha_cdp = '$fechaCDP' WHERE  memo_id = $memoId";                      
            $this->pdo->prepare($sql)->execute();
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Datos Memo actualizados correctamente';                 
        } catch (Exception $e){
            die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar datos del memo';             
        }
        return $jsonresponse;
    }
}
?>

