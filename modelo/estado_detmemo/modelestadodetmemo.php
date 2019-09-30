<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../config/config.php");
class ModelEstadoDetMemo{
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

    public function Listar(){
        $jsonresponse = array();
        try{
            $result = array();
            $stm = $this->pdo->prepare("SELECT  edm.estado_detmemo_id,
                                                edm.estado_detmemo_tipo,
												edm.estado_detmemo_orden,
                                                edm.estado_detmemo_descripcion,
                                                edm.estado_detmemo_activo
                                        FROM estado_detalle_memo as edm");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new EstadoDetMemo();
                    $busq->__SET('est_detmemo_id',          $r->estado_detmemo_id);
                    $busq->__SET('est_detmemo_tipo',        $r->estado_detmemo_tipo);
                    $busq->__SET('est_detmemo_orden',       $r->estado_detmemo_orden);
                    $busq->__SET('est_detmemo_desc',        $r->estado_detmemo_descripcion);
                    $busq->__SET('est_detmemo_activo',      $r->estado_detmemo_activo);
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
            $jsonresponse['message'] = 'Error al listar Estado detalle';
        }
    }

    public function Obtener($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo->prepare("SELECT  edm.estado_detmemo_id,
                                                edm.estado_detmemo_tipo,
                                                edm.estado_detmemo_orden,
                                                edm.estado_detmemo_descripcion,
                                                edm.estado_detmemo_activo
                                        FROM estado_detalle_memo as edm
                                        WHERE edm.estado_detmemo_id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $busq = new EstadoDetMemo();
                    $busq->__SET('est_detmemo_id',          $r->estado_detmemo_id);
                    $busq->__SET('est_detmemo_tipo',        $r->estado_detmemo_tipo);
                    $busq->__SET('est_detmemo_orden',       $r->estado_detmemo_orden);
                    $busq->__SET('est_detmemo_desc',        $r->estado_detmemo_descripcion);
                    $busq->__SET('est_detmemo_activo',      $r->estado_detmemo_activo);

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Se obtuvo estado detalle correctamente';
            $jsonresponse['datos'] = $busq->returnArray();
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener estado detalle';             
        }
        return $jsonresponse;
    }

    public function Eliminar($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo->prepare("DELETE FROM estado_detalle_memo WHERE estado_detmemo_id = ? ");
            $stm->execute(array($id));
            $this->pdo->commit();
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Estado detalle eliminado correctamente';              
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar Estado detalle';            
        }
        return $jsonresponse;
    }

    public function Registrar(EstadoDetMemo $data){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO estado_detalle_memo (estado_detmemo_tipo, estado_detmemo_orden, estado_detmemo_descripcion, estado_detmemo_activo ) 
                    VALUES (?,?,?,?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('est_detmemo_tipo'),
													 $data->__GET('est_detmemo_orden'),
                                                     $data->__GET('est_detmemo_desc'),
                                                     $data->__GET('est_detmemo_activo')
                                                     )
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Estado detalle ingresado correctamente'; 
        } catch (PDOException $pdoException){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar Estado detalle';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            var_dump($jsonresponse);
        }
        return $jsonresponse;
    }

    public function Actualizar(EstadoDetMemo $data){
        $jsonresponse = array();
        //print_r($data);
        try{
            $sql = "UPDATE estado_detalle_memo SET 
                           estado_detmemo_tipo = ?,
						   estado_detmemo_orden = ?,
                           estado_detmemo_descripcion = ?,
                           estado_detmemo_activo = ?
                    WHERE  estado_detmemo_id = ?";

            $this->pdo->prepare($sql)->execute(array($data->__GET('est_detmemo_tipo'),
                                                     $data->__GET('est_detmemo_orden'),
                                                     $data->__GET('est_detmemo_desc'),
                                                     $data->__GET('est_detmemo_activo'),
                                                     $data->__GET('est_detmemo_id')
                                                     )
                                                );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Estado detalle actualizado correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar Estado detalle';             
        }
        return $jsonresponse;
    }
    //graba el cambio de estado del detalle del memo(se va agregando)
    public function CambiaEstadoDetMemo(DetMemoCambioEst $data){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO cambio_estados_detmemo (cambio_estados_detmemo_detmemo_id, 
                                                        cambio_estados_detmemo_estado_detmemo_id, 
                                                        cambio_estados_detmemo_observacion,
                                                        cambio_estados_detmemo_usu_id
                                                        ) 
                    VALUES (?,?,?,?)";
            $this->pdo->prepare($sql)->execute(array(   $data->__GET('detmemo_camest_memid'),
                                                        $data->__GET('detmemo_camest_estid'),
                                                        $data->__GET('detmemo_camest_obs'),
                                                        $data->__GET('detmemo_camest_usuid')
                                                    ));
            $logsq = new ModeloLogsQuerys();
                $logsq->GrabarLogsQuerys($sql,'0','CambiaEstadoDetMemo');
            
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Estado cambiado correctamente'; 
            $jsonresponse['mid'] = $data->__GET('detmemo_camest_memid');
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
    public function Listar2(){
        $jsonresponse = array();
        try{
            $result = array();
             $stm = $this->pdo->prepare("SELECT  edm.estado_detmemo_id,
                                                 edm.estado_detmemo_tipo,
                                                 edm.estado_detmemo_orden,
                                                 edm.estado_detmemo_activo
                                        FROM estado_detalle_memo as edm");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new EstadoDetMemo();
                    $busq->__SET('est_detmemo_id',          $r->estado_detmemo_id);
                    $busq->__SET('est_detmemo_tipo',        $r->estado_detmemo_tipo);
                    $busq->__SET('est_detmemo_orden',       $r->estado_detmemo_orden);
                    $busq->__SET('est_detmemo_activo',      $r->estado_detmemo_activo);
                $result[] = $busq;
            }
            return $result;
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function ListarMin(){
        $jsonresponse = array();
        try{
            $result = array();
            $stm = $this->pdo->prepare("SELECT  edm.estado_detmemo_id,
                                                edm.estado_detmemo_tipo
                                        FROM estado_detalle_memo as edm
                                        WHERE edm.estado_detmemo_activo = 1
                                        ORDER BY  edm.estado_detmemo_orden ASC");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new EstadoDetMemo();
                    $busq->__SET('est_detmemo_id',            $r->estado_detmemo_id);
                    $busq->__SET('est_detmemo_tipo',         $r->estado_detmemo_tipo);
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
            $jsonresponse['message'] = 'Error al listar Estado detalle';
        }
    }

}

?>