<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../config/config.php");
class ModelEstadoOCompra{
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
            $stm = $this->pdo->prepare("SELECT  oc.estado_oc_id,
                                                oc.estado_oc_tipo,
												oc.estado_oc_prioridad,
                                                oc.estado_oc_activo
                                        FROM estado_orden_compra as oc");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new EstadoOCompra();
                    $busq->__SET('est_oc_id',            $r->estado_oc_id);
                    $busq->__SET('est_oc_tipo',         $r->estado_oc_tipo);
                    $busq->__SET('est_oc_prioridad',    $r->estado_oc_prioridad);
                    $busq->__SET('est_oc_activo',       $r->estado_oc_activo);
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
            $jsonresponse['message'] = 'Error al listar estado orden de compra';
        }
    }

    public function Obtener($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo->prepare("SELECT  oc.estado_oc_id,
                                                oc.estado_oc_tipo,
                                                oc.estado_oc_prioridad,
                                                oc.estado_oc_activo
                                        FROM estado_orden_compra as oc
                                        WHERE oc.estado_oc_id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $busq = new EstadoOCompra();
                    $busq->__SET('est_oc_id',           $r->estado_oc_id);
                    $busq->__SET('est_oc_tipo',         $r->estado_oc_tipo);
                    $busq->__SET('est_oc_prioridad',    $r->estado_oc_prioridad);
                    $busq->__SET('est_oc_activo',       $r->estado_oc_activo);

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Se obtuvo estado orden de compra correctamente';
            $jsonresponse['datos'] = $busq->returnArray();
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener estado orden de compra';             
        }
        return $jsonresponse;
    }

    public function Eliminar($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo->prepare("DELETE FROM estado_orden_compra WHERE estado_oc_id = ? ");
            $stm->execute(array($id));
            $this->pdo->commit();
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'estado orden de compra eliminado correctamente';              
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar estado orden de compra';            
        }
        return $jsonresponse;
    }

    public function Registrar(EstadoOCompra $data){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO estado_orden_compra (estado_oc_tipo, estado_oc_prioridad, estado_oc_activo ) 
                    VALUES (?,?,?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('est_oc_tipo'),
													 $data->__GET('est_oc_prioridad'),
                                                     $data->__GET('est_oc_activo')
                                                     )
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'estado orden de compra ingresado correctamente'; 
        } catch (PDOException $pdoException){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar estado orden de compra';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            var_dump($jsonresponse);
        }
        return $jsonresponse;
    }

    public function Actualizar(EstadoOCompra $data){
        $jsonresponse = array();
        //print_r($data);
        try{
            $sql = "UPDATE estado_orden_compra SET 
                           estado_oc_tipo = ?,
						   estado_oc_prioridad = ?,
                           estado_oc_activo = ?
                    WHERE  estado_oc_id = ?";

            $this->pdo->prepare($sql)->execute(array($data->__GET('est_oc_tipo'),
                                                     $data->__GET('est_oc_prioridad'),
                                                     $data->__GET('est_oc_activo'),
                                                     $data->__GET('est_oc_id')
                                                     )
                                                );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'estado orden de compra actualizado correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar estado orden de compra';             
        }
        return $jsonresponse;
    }

    public function Listar2(){
        $jsonresponse = array();
        try{
            $result = array();
             $stm = $this->pdo->prepare("SELECT  oc.estado_oc_id,
                                                 oc.estado_oc_tipo,
                                                 oc.estado_oc_prioridad,
                                                 oc.estado_oc_activo
                                        FROM estado_orden_compra as oc");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new EstadoOCompra();
                    $busq->__SET('est_oc_id',            $r->estado_oc_id);
                    $busq->__SET('est_oc_tipo',         $r->estado_oc_tipo);
                    $busq->__SET('est_oc_prioridad',    $r->estado_oc_prioridad);
                    $busq->__SET('est_oc_activo',       $r->estado_oc_activo);
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
            $stm = $this->pdo->prepare("SELECT  oc.estado_oc_id,
                                                oc.estado_oc_tipo
                                        FROM estado_orden_compra as oc
                                        WHERE oc.estado_oc_activo = 1
                                        ORDER BY  oc.estado_oc_prioridad ASC");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new EstadoOCompra();
                    $busq->__SET('est_oc_id',            $r->estado_oc_id);
                    $busq->__SET('est_oc_tipo',         $r->estado_oc_tipo);
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
            $jsonresponse['message'] = 'Error al listar estado orden de compra';
        }
    }

}

?>