<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../config/config.php");
require_once("../modelo/logs/modelologs.php");
require_once("../modelo/logs/modelologsquerys.php");

class ModelMemoEst{
    private $pdo;

    public function __CONSTRUCT(){
        try{
            $this->pdo = new PDO("mysql:host=".HOST.";dbname=".DB, USERDB, PASSDB,array(PDO::MYSQL_ATTR_INIT_COMMAND => CHARSETDB));
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);                
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function Listar($depto = 1){
        $depto = (int) $depto;
        $jsonresponse = array();
        try{
            $result = array();
            if($depto == 1 || $depto == null || $depto=='null'){
                $filtro = " ";
            }else{
                $filtro = " AND me.memo_estado_depto_id = ".$depto;
            }
            $consulta = "SELECT  me.memo_estado_id,
                                    me.memo_estado_tipo,
                                    me.memo_estado_orden,
                                    me.memo_estado_descripcion,
                                    me.memo_estado_color_bg,
                                    me.memo_estado_color_font,
                                    me.memo_estado_activo,
                                    dep.depto_id,
                                    dep.depto_nombre,
                                    me.memo_estado_memo_estadogenerico_id,
                                    meg.memo_estadogenerico_nombre
                        FROM memo_estado as me
                        INNER JOIN departamento as dep ON dep.depto_id = me.memo_estado_depto_id
                        LEFT JOIN memo_estadogenerico as meg ON meg.memo_estadogenerico_id = me.memo_estado_memo_estadogenerico_id 
                        WHERE 1 = 1 ".$filtro
                        ." ORDER BY me.memo_estado_depto_id ASC, me.memo_estado_orden ASC, memo_estado_tipo ASC";
            $stm = $this->pdo->prepare($consulta);
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new MemoEst();
                    $busq->__SET('memo_est_id',             $r->memo_estado_id);
                    $busq->__SET('memo_est_tipo',           $r->memo_estado_tipo);
                    $busq->__SET('memo_est_orden',          $r->memo_estado_orden);
                    $busq->__SET('memo_est_desc',           $r->memo_estado_descripcion);
                    $busq->__SET('memo_est_colorbg',        $r->memo_estado_color_bg);
                    $busq->__SET('memo_est_colortxt',       $r->memo_estado_color_font);
                    $busq->__SET('memo_est_activo',         $r->memo_estado_activo);
                    $busq->__SET('memo_est_depto_id',       $r->depto_id);
                    $busq->__SET('memo_est_depto_nombre',   $r->depto_nombre);
                    $busq->__SET('memo_est_generico_id',    $r->memo_estado_memo_estadogenerico_id);
                    $busq->__SET('memo_est_generico_nom',   $r->memo_estadogenerico_nombre);
                    
                $result[] = $busq->returnArray();
            }
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'listado correctamente';
            $jsonresponse['datos'] = $result;
            return $jsonresponse;
        }
        catch(Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al listar memo estado';
        }
    }

    public function Obtener($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo->prepare("SELECT me.memo_estado_id,
                                                me.memo_estado_tipo,
                                                me.memo_estado_orden,
                                                me.memo_estado_descripcion,
                                                me.memo_estado_color_bg,
                                                me.memo_estado_color_font,
                                                me.memo_estado_activo,
                                                dep.depto_id,
                                                dep.depto_nombre
                                        FROM memo_estado as me, departamento as dep
                                        WHERE dep.depto_id = me.memo_estado_depto_id AND me.memo_estado_id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $busq = new MemoEst();
                    $busq->__SET('memo_est_id',             $r->memo_estado_id);
                    $busq->__SET('memo_est_tipo',           $r->memo_estado_tipo);
                    $busq->__SET('memo_est_orden',          $r->memo_estado_orden);
                    $busq->__SET('memo_est_desc',           $r->memo_estado_descripcion);
                    $busq->__SET('memo_est_colorbg',        $r->memo_estado_color_bg);
                    $busq->__SET('memo_est_colortxt',       $r->memo_estado_color_font);
                    $busq->__SET('memo_est_activo',         $r->memo_estado_activo);
                    $busq->__SET('memo_est_depto_id',     $r->depto_id);
                    $busq->__SET('memo_est_depto_nombre', $r->depto_nombre);

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Se obtuvo memo estado correctamente';
            $jsonresponse['datos'] = $busq->returnArray();
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener memo estado';             
        }
        return $jsonresponse;
    }

    public function Eliminar($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo->prepare("DELETE FROM memo_estado WHERE memo_estado_id = ? ");
            $stm->execute(array($id));

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Memo estado eliminado correctamente';              
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar memo estado';            
        }
        return $jsonresponse;
    }

    public function Registrar(MemoEst $data){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO memo_estado (memo_estado_tipo, memo_estado_orden, memo_estado_descripcion, memo_estado_color_bg, memo_estado_color_font, memo_estado_activo, memo_estado_depto_id) 
                    VALUES (?,?,?,?,?,?,?)";

            $this->pdo->prepare($sql)->execute(array(   $data->__GET('memo_est_tipo'),
                                                        $data->__GET('memo_est_orden'),
                                                        $data->__GET('memo_est_desc'),
                                                        $data->__GET('memo_est_colorbg'),
                                                        $data->__GET('memo_est_colortxt'),
                                                        $data->__GET('memo_est_activo'),
                                                        $data->__GET('memo_est_depto_id')
                                                    ));
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Memo estado ingresado correctamente'; 
        } catch (PDOException $pdoException){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar memo estado';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            var_dump($jsonresponse);
        }
        return $jsonresponse;
    }

    public function Actualizar(MemoEst $data){
        $jsonresponse = array();
        try{
            $sql = "UPDATE memo_estado SET 
                           memo_estado_tipo = ?,
			               memo_estado_orden = ?,
                           memo_estado_descripcion = ?,
                           memo_estado_color_bg = ?,
                           memo_estado_color_font = ?,
                           memo_estado_activo = ?,
                           memo_estado_depto_id = ?
                    WHERE  memo_estado_id = ?";
            $this->pdo->prepare($sql)->execute(array($data->__GET('memo_est_tipo'),
                                                     $data->__GET('memo_est_orden'),
                                                     $data->__GET('memo_est_desc'),
                                                     $data->__GET('memo_est_colorbg'),
                                                     $data->__GET('memo_est_colortxt'),
                                                     $data->__GET('memo_est_activo'),
                                                     $data->__GET('memo_est_depto_id'),
                                                     $data->__GET('memo_est_id')
                                                    ));
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Memo estado actualizado correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar memo estado';             
        }
        return $jsonresponse;
    }
    //graba el cambio de estado de varios memos del listadomemo(se va agregando)
    public function CambiaEstadoMasivo(MemoCambioEst $data){
        $jsonresponse = array();
        //var_dump($data);
        try{
            $result = array();
            $arraymemosid = explode(',',$data->__GET('memo_camest_memid'));
            $cambioest = new MemoCambioEst();
            $cambioest->__SET('memo_camest_estid',      $data->__GET('memo_camest_estid'));
            $cambioest->__SET('memo_camest_obs',        $data->__GET('memo_camest_obs'));
            $cambioest->__SET('memo_camest_usuid',      $data->__GET('memo_camest_usuid'));
            $cambioest->__SET('memo_camest_deptoid',    $data->__GET('memo_camest_deptoid'));
            $cambioest->__SET('memo_camest_deptonom',   $data->__GET('memo_camest_deptonom'));
            
            foreach ($arraymemosid as $memid) {
                $cambioest->__SET('memo_camest_memid',  $memid);
                $resultado = $this->CambiaEstado($cambioest);
                $result[] = $resultado;
            }
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Cambios de estado realizado correctamente'; 
            $jsonresponse['datamasivo'] = $result;

        } catch (Exception $e) {
            //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar cambiar estado masivo';
            $jsonresponse['errorQuery'] = $e->getMessage();
            $logs = new modelologs();
            $trace=$e->getTraceAsString();
              $logs->GrabarLogs($e->getMessage(),$trace);
              $logs = null;             
        }
        return $jsonresponse;

    }
    //graba el cambio de estado del memo(se va agregando)
    public function CambiaEstado(MemoCambioEst $data, $ultimoestado=0, $deptosolid=0){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO cambio_estados (cambio_estados_memo_id, cambio_estados_memo_estado_id, cambio_estados_observacion, cambio_estados_usuario_id) 
                    VALUES (?,?,?,?)";
            $this->pdo->prepare($sql)->execute(array(   $data->__GET('memo_camest_memid'),
                                                        $data->__GET('memo_camest_estid'),
                                                        $data->__GET('memo_camest_obs'),
                                                        $data->__GET('memo_camest_usuid')
                                                    ));
            $logsq = new ModeloLogsQuerys();
                $logsq->GrabarLogsQuerys($sql,'0','Registracambioestado');

            $consultamemoestado="SELECT memo_estado_memo_estadogenerico_id  FROM memo_estado
                                     WHERE memo_estado_id = ".$data->__GET('memo_camest_estid');
            $res = $this->pdo->query($consultamemoestado);
                $estadogenerico = $res->fetchColumn();

                $logsq->GrabarLogsQuerys('estado : '.$data->__GET('memo_camest_estid'),'0','Registracambioestado_variableestado');

            $consultaultimoestadogen="SELECT memo_estado_memo_estadogenerico_id  FROM memo_estado
                                     WHERE memo_estado_id = ".$ultimoestado;
            $res = $this->pdo->query($consultaultimoestadogen);
                $ultimoestadogenerico = $res->fetchColumn();

            $activatrigger=0;
            if ($estadogenerico != 0 || $estadogenerico != NULL) {
                switch ($estadogenerico) {
                    case 1:
                        //$deptodestino = $data->__GET('memo_camest_deptoid');
                        //$activatrigger = 1;
                        //$this->ValidaCambiaEstadoOtroDepto($data,0,2);
                        break;
                    case 2:
                        $deptodestino = $data->__GET('memo_camest_deptoid');
                        $activatrigger = 1;
                        //$this->ValidaCambiaEstadoOtroDepto($data,$deptosolid,1);
                        break;
                    case 5:
                        $deptodestino = $data->__GET('memo_camest_deptoid');
                        $activatrigger = 1;
                        $this->ValidaCambiaEstadoOtroDepto($data,0,2);
                        if($ultimoestadogenerico==1){
                            $this->actualizaFechaRecepcion($data->__GET('memo_camest_memid'));   
                        }
                        break;
                    case 6:
                        $deptodestino = 0;
                        $activatrigger = 1;
                        $this->ValidaCambiaEstadoOtroDepto($data,0,5);
                        break;
                    case 10:
                        $deptodestino = 0;
                        $activatrigger = 1;
                        //$this->ValidaCambiaEstadoOtroDepto($data,0,5);
                        break;
                    default:
                        // n/a aun...
                        break;
                }
            }else{
                if($data->__GET('memo_camest_estid')==11){
                    $deptodestino = 83;
                    $activatrigger=1;
                }else if($data->__GET('memo_camest_estid')==14){
                    $deptodestino = 87;
                    $activatrigger=1;
                    $data->__SET('memo_camest_estid',17);
                    $this->ValidaCambiaEstadoOtroDepto($data,$deptodestino,2);
                }
                //agregar los otros id de estado para adquisiciones
            }
            if($activatrigger){
                $ejecutatrigger = $this->agregaDerivadoTriggers($data->__GET('memo_camest_memid'),
                                                                $deptodestino,
                                                                $data->__GET('memo_camest_deptonom'),
                                                                $estadogenerico);
            }
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Estado cambiado correctamente'; 
            $jsonresponse['mid'] = $data->__GET('memo_camest_memid');
        } catch (PDOException $pdoException){
            //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar cambiar estado';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            $logs = new modelologs();
            $trace=$pdoException->getTraceAsString();
              $logs->GrabarLogs($pdoException->getMessage(),$trace);
              $logs = null;             
        }
        return $jsonresponse;
    }
    //graba el cambio de estado del memo(se va agregando)
    public function ValidaCambiaEstadoOtroDepto(MemoCambioEst $data, $deptosolid=0,$estadogenerico=0){
        $jsonresponse = array();
        try{
            $deptobusca=0;
            if($deptosolid<>0){
                $deptobusca = $deptosolid;
            }else{
                $deptobusca = $data->__GET('memo_camest_deptoid');
            }
            $consultamemoestado = "SELECT memo_estado_id  FROM memo_estado
                                     WHERE memo_estado_depto_id = ".$deptobusca." AND memo_estado_memo_estadogenerico_id = ".$estadogenerico;
            $res = $this->pdo->query($consultamemoestado);
            $estadomemootrodepto = $res->fetchColumn();

            if($estadomemootrodepto != 0 || $estadomemootrodepto != NULL ){
                $sql = "INSERT INTO cambio_estados (cambio_estados_memo_id, cambio_estados_memo_estado_id, cambio_estados_observacion, cambio_estados_usuario_id) 
                    VALUES (?,?,?,?)";

                $this->pdo->prepare($sql)->execute(array( $data->__GET('memo_camest_memid'),
                                                          $estadomemootrodepto,
                                                          $data->__GET('memo_camest_obs'),
                                                          $data->__GET('memo_camest_usuid')
                                                    ));
                $logsq = new ModeloLogsQuerys();
                    $logsq->GrabarLogsQuerys($sql,'0','Registracambioestado_Otro_Depto');
                    $logsq->GrabarLogsQuerys('estado : '.$estadomemootrodepto, '0', 'Registracambioestado_OtroDepto');
                $jsonresponse['message'] = 'Estado cambiado correctamente';
            }else{
                $jsonresponse['message'] = 'No hubo cambio estado';
            }
            $jsonresponse['success'] = true;
            $jsonresponse['mid'] = $data->__GET('memo_camest_memid');
            //var_dump($jsonresponse);
            //exit();
        } catch (PDOException $pdoException){
            //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar cambiar estado';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            $logs = new modelologs();
            $trace=$pdoException->getTraceAsString();
              $logs->GrabarLogs($pdoException->getMessage(),$trace);
              $logs = null;             
        }
        return $jsonresponse;
    }
    //funcion que agrega nuevo depto en el derivado
    public function agregaDerivadoTriggers($memid,$deptoid,$deptonom,$estadogenid=0){
        $jsonresponse = array();
        try{
            $logsq = new ModeloLogsQuerys();
            $consultaexistederivado="SELECT memo_derivado_id
                                     FROM memo_derivado 
                                     WHERE memo_derivado_memo_id = ".$memid." and memo_derivado_depto_actual = 1";
            $res = $this->pdo->query($consultaexistederivado);
            $derivadoid = $res->fetchColumn();
            // se actualiza el derivado anterior a 0, solo puede estar en un derivado a la vez
            if ($derivadoid != 0 || $derivadoid != NULL) {
                $sqlactualiza = "UPDATE memo_derivado SET  memo_derivado_depto_actual = 0
                        WHERE memo_derivado_id = ?";
                $this->pdo->prepare($sqlactualiza)->execute(array($derivadoid));
                $logsq->GrabarLogsQuerys($sqlactualiza,'0','ActualizaDerivadoAnterior');

            }
            if($estadogenid != 0 || $estadogenid != NULL){
                $deptoanteriorid=0;
                //condicion para estado generico 6 Devuelto otro departamento, se devuelve al depto. anteriormente derivado
                if($estadogenid==6){
                    $buscadeptoanterior="SELECT memo_derivado_dpto_id,memo_derivado_nombre_destinatario
                                        FROM memo_derivado
                                        WHERE memo_derivado_memo_id=".$memid." ORDER BY memo_derivado_id DESC LIMIT 1, 1";
                            
                        $resdeptoanterior = $this->pdo->query($buscadeptoanterior);
                        $r0 = $resdeptoanterior->fetch(PDO::FETCH_OBJ);
                    if($r0 != NULL || $r0 != false){
                        $deptoanteriorid = $r0->memo_derivado_dpto_id;
                        $deptoid = $deptoanteriorid;
                        $deptonom = $r0->memo_derivado_nombre_destinatario;
                    }
                }
                //condicion para estado generico 10 Respondido, se devuelve al depto. origen, o estado generico 6
                if($estadogenid==10 || (($deptoanteriorid==0 || $deptoanteriorid==NULL) && $estadogenid==6)){
                    $buscadeptoorigen="SELECT memo_depto_solicitante_id, memo_nombre_solicitante
                                         FROM memo
                                         WHERE memo_id=".$memid;
                        $resdeptoorigen = $this->pdo->query($buscadeptoorigen);
                        $r = $resdeptoorigen->fetch(PDO::FETCH_OBJ);
                        $deptoid = $r->memo_depto_solicitante_id;
                        $deptonom = $r->memo_nombre_solicitante;
                }
            }

            $sql = "INSERT INTO memo_derivado (memo_derivado_memo_id,
                                               memo_derivado_dpto_id,
                                               memo_derivado_nombre_destinatario,
                                               memo_derivado_depto_actual,
                                               memo_derivado_estado_id) 
                    VALUES (?,?,?,?,?)";

            $this->pdo->prepare($sql)->execute(array($memid,
                                                     $deptoid,
                                                     $deptonom,
                                                     1,
                                                     1
                                                ));
                $logsq->GrabarLogsQuerys($sql,'0','RegistraDerivado');
                $logsq = null;
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Trigger Derivado ejecutado correctamente'; 
        } catch (PDOException $pdoException){
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar Derivado';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            $logs = new modelologs();
            $trace=$pdoException->getTraceAsString();
              $logs->GrabarLogs($pdoException->getMessage(),$trace);
              $logs = null; 
        }
        return $jsonresponse;
    }    
    // funcion cambia estado para el Estado = 8 o Estado = 9, para que pase a depto. adquisiciones
    public function actualizaFechaRecepcion($memid){
        $jsonresponse = array();
        try{
            $sqlactualizafecharecep = "UPDATE memo SET memo_fecha_recepcion = NOW() WHERE memo_id = ?";
                $this->pdo->prepare($sqlactualizafecharecep)->execute(array($memid));
                $logsq = new ModeloLogsQuerys();                
                $logsq->GrabarLogsQuerys($sqlactualizafecharecep,'0','Actualiza Fecha Recepcion');
                $logsq = null;
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Actualiza fecha recepcion correctamente'; 
        } catch (PDOException $pdoException){
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al Actualizar fecha recepcion';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            $logs = new modelologs();
            $trace=$pdoException->getTraceAsString();
              $logs->GrabarLogs($pdoException->getMessage(),$trace);
              $logs = null;            
        }
        return $jsonresponse;
    }

    public function ListarMin($depto = 1,$ultimoestado=0){
        $depto = (int) $depto;
        $jsonresponse = array();
        try{
            $result = array();
            if($depto == 1 || $depto == null || $depto=='null'){
                $filtro = "";
            }else if(is_array($depto)){
                foreach($depto as $dp){
                    $deptos .= $dp.',';
                }
                $deptos = trim($deptos, ',');
                $filtro = " AND me.memo_estado_depto_id in (".$deptos.") ";
            }else{
                $filtro = " AND me.memo_estado_depto_id = ".$depto;
            }
            if($ultimoestado<>0){
                $filtroflujo = " AND memo_estado_id in(select memo_estado_flujo_estado_id_hijo FROM memo_estado_flujo WHERE memo_estado_flujo_estado_id=".$ultimoestado.")";
            }else{
                $filtroflujo="";
            }
            $queryestadosflujo = "SELECT  me.memo_estado_id,
                                                me.memo_estado_tipo,
                                                me.memo_estado_color_bg,
                                                me.memo_estado_color_font,
                                                dep.depto_nombre,
                                                dep.depto_nombre_corto
                                        FROM memo_estado as me
                                        INNER JOIN departamento as dep ON dep.depto_id = me.memo_estado_depto_id
                                        WHERE me.memo_estado_activo = 1 "
                                        .$filtro
                                        .$filtroflujo
                                        ." ORDER BY me.memo_estado_id ASC, me.memo_estado_orden ASC ";
            $stm = $this->pdo->prepare($queryestadosflujo);
            $stm->execute();

            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                if($depto == 1){
                    $nomestado = $r->depto_nombre_corto.'-'.$r->memo_estado_tipo;
                }else{
                    $nomestado = $r->memo_estado_tipo;
                }
                $fila = array('memo_est_id'=>$r->memo_estado_id,
                              'memo_est_tipo'=>$nomestado,
                              'memo_est_depto_nombre'=>$r->depto_nombre);
                $result[]=$fila;
            }
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'listado correctamente';
            $jsonresponse['datos'] = $result;
            return $jsonresponse;
        }
        catch(Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al listar memo estado';
        }
    }

    public function Listar2(){
        $jsonresponse = array();
        try{
            $result = array();
             $stm = $this->pdo->prepare("SELECT me.memo_estado_id,
                                                me.memo_estado_tipo,
                                                me.memo_estado_color_bg,
                                                me.memo_estado_color_font,                                                
                                                me.memo_estado_orden
                                        FROM memo_estado as me");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new MemoEst();
                    $busq->__SET('memo_est_id', $r->memo_estado_id);
                    $busq->__SET('memo_est_tipo', $r->memo_estado_tipo); 
                    $busq->__SET('memo_est_orden', $r->memo_estado_orden);
                $result[] = $busq;
            }
            return $result;
        }catch(Exception $e){
            die($e->getMessage());
        }
    }    
}

?>