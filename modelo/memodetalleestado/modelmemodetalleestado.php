<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../config/config.php");
class ModelMemoDetEst{
    private $pdo;

    public function __CONSTRUCT(){
        try{
            $this->pdo = new PDO("mysql:host=".HOST.";dbname=".DB, USERDB, PASSDB);
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
            $stm = $this->pdo->prepare("SELECT  de.memo_detalle_estado_id,
                                                de.memo_detalle_estado_tipo,
												de.memo_detalle_prioridad
                                        FROM memo_detalle_estado as de");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new MemoDetEst();
                    $busq->__SET('memo_det_est_id', $r->memo_detalle_estado_id);
                    $busq->__SET('memo_det_est_tipo', $r->memo_detalle_estado_tipo);
                    $busq->__SET('memo_det_priori', $r->memo_detalle_prioridad);                   
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
            $jsonresponse['message'] = 'Error al listar memo detalle estado';
        }
    }

    public function Obtener($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                       ->prepare("SELECT de.memo_detalle_estado_id,
                                         de.memo_detalle_estado_tipo,
										 de.memo_detalle_prioridad
                                FROM memo_detalle_estado as de
                                WHERE de.memo_detalle_estado_id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $busq = new MemoDetEst();
                    $busq->__SET('memo_det_est_id', $r->memo_detalle_estado_id);
                    $busq->__SET('memo_det_est_tipo', $r->memo_detalle_estado_tipo);
                    $busq->__SET('memo_det_priori', $r->memo_detalle_prioridad); 

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Se obtuvo memo detalle estado correctamente';
            $jsonresponse['datos'] = $busq->returnArray();
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener memo detalle estado';             
        }
        return $jsonresponse;
    }

    public function Eliminar($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                      ->prepare("DELETE FROM memo_detalle_estado WHERE memo_detalle_estado_id = ? ");
            $stm->execute(array($id));
            $this->pdo->commit();
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Memo detalle estado eliminado correctamente';              
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar memo detalle estado';            
        }
        return $jsonresponse;
    }

    public function Registrar(MemoDetEst $data){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO memo_detalle_estado (memo_detalle_estado_tipo, memo_detalle_prioridad) 
                    VALUES (?,?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('memo_det_est_tipo'),
													 $data->__GET('memo_det_priori'))
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Memo detalle estado ingresado correctamente'; 
        } catch (PDOException $pdoException){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar memo detalle estado';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            var_dump($jsonresponse);
        }
        return $jsonresponse;
    }

    public function Actualizar(MemoDetEst $data){
        $jsonresponse = array();
        //print_r($data);
        try{
            $sql = "UPDATE memo_detalle_estado SET 
                           memo_detalle_estado_tipo = ?,
						   memo_detalle_prioridad = ?	
                    WHERE  memo_detalle_estado_id = ?";

            $this->pdo->prepare($sql)
                 ->execute(array($data->__GET('memo_det_est_tipo'),
								 $data->__GET('memo_det_priori'))
                          );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Memo detalle estado actualizado correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar memo detalle estado';             
        }
        return $jsonresponse;
    }

    public function Listar2(){
        $jsonresponse = array();
        try{
            $result = array();
             $stm = $this->pdo->prepare("SELECT  de.memo_detalle_estado_id,
                                                 de.memo_detalle_estado_tipo,
												 de.memo_detalle_prioridad
                                        FROM memo_detalle_estado as de");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new MemoDetEst();
                    $busq->__SET('memo_det_est_id', $r->memo_detalle_estado_id);
                    $busq->__SET('memo_det_est_tipo', $r->memo_detalle_estado_tipo);
                    $busq->__SET('memo_det_priori', $r->memo_detalle_prioridad); 
                $result[] = $busq;
            }
            return $result;
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

















}

?>