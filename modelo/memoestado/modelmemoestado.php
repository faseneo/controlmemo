<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../config/config.php");
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
                $filtro = "";
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
                                    dep.depto_nombre
                        FROM memo_estado as me, departamento as dep
                        WHERE dep.depto_id = me.memo_estado_depto_id "
                        .$filtro
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
                    $busq->__SET('memo_est_depto_id',     $r->depto_id);
                    $busq->__SET('memo_est_depto_nombre', $r->depto_nombre);
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
    //graba el cambio de estado del memo(se va agregando)
    public function CambiaEstado(MemoCambioEst $data){
        /*
        INSERT INTO `memo_derivado` (`memo_derivado_id`, `memo_derivado_memo_id`, `memo_derivado_dpto_id`, `memo_derivado_nombre_destinatario`, `memo_derivado_fecha`, `memo_derivado_depto_actual`, `memo_derivado_estado_id`) VALUES (NULL, '12', '9', 'Leonel Duran', CURRENT_TIMESTAMP, '1', '1');
         */
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO cambio_estados (cambio_estados_memo_id, cambio_estados_memo_estado_id, cambio_estados_observacion, cambio_estados_usuario_id) 
                    VALUES (?,?,?,?)";

            $this->pdo->prepare($sql)->execute(array(   $data->__GET('memo_camest_memid'),
                                                        $data->__GET('memo_camest_estid'),
                                                        $data->__GET('memo_camest_obs'),
                                                        $data->__GET('memo_camest_usuid')
                                                    )
                                              );
            if($data->__GET('memo_camest_estid')==8 || $data->__GET('memo_camest_estid')==9){
                $observacion='Memo aprobado con CDP, Derivado a Depto. Adquisiciones';
                $usuid=0;
                $ejecutatrigger = $this->CambiaEstadoTriggers($data->__GET('memo_camest_memid'),13,$observacion,$usuid);
            }
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Estado cambiado correctamente'; 
        } catch (PDOException $pdoException){
            //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar cambiar estado';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
        }
        return $jsonresponse;
    }
    // funcion cambia estado para el Estado = 8 o Estado = 9, para que pase a depto. adquisiciones
    public function CambiaEstadoTriggers($memid, $estid, $obs, $usuid){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO cambio_estados (cambio_estados_memo_id, cambio_estados_memo_estado_id, cambio_estados_observacion, cambio_estados_usuario_id) 
                    VALUES (?,?,?,?)";

            $this->pdo->prepare($sql)->execute(array($memid,
                                                     $estid,
                                                     $obs,
                                                     $usuid
                                                    )
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Trigger ejecutado correctamente'; 
        } catch (PDOException $pdoException){
            //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar cambiar estado';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
        }
        return $jsonresponse;
    }

    public function ListarMin($depto = 1){
        $depto = (int) $depto;
        $jsonresponse = array();
        try{
            $result = array();
            if($depto == 1 || $depto == null || $depto=='null'){
                $filtro = "";
            }else{
                $filtro = " AND me.memo_estado_depto_id = ".$depto;
            }
            $stm = $this->pdo->prepare("SELECT  me.memo_estado_id,
                                                me.memo_estado_tipo,
                                                me.memo_estado_color_bg,
                                                me.memo_estado_color_font,                                                
                                                dep.depto_nombre
                                        FROM memo_estado as me, departamento as dep
                                        WHERE dep.depto_id = me.memo_estado_depto_id
                                        AND me.memo_estado_activo = 1 "
                                        .$filtro
                                        ." ORDER BY me.memo_estado_id ASC, me.memo_estado_orden ASC ");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $fila = array('memo_est_id'=>$r->memo_estado_id,
                              'memo_est_tipo'=>$r->memo_estado_tipo,
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