<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../config/config.php");
class ModelMemoEst{
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
            $stm = $this->pdo->prepare("SELECT  me.memo_estado_id,
                                                me.memo_estado_tipo,
                                                me.memo_estado_prioridad,
                                                me.memo_estado_activo,
                                                sec.seccion_id,
                                                sec.seccion_nombre
                                        FROM memo_estado as me, seccion as sec
                                        WHERE sec.seccion_id = me.memo_estado_seccion_id
                                        ORDER BY sec.seccion_id ASC, me.memo_estado_prioridad ASC");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new MemoEst();
                    $busq->__SET('memo_est_id', $r->memo_estado_id);
                    $busq->__SET('memo_est_tipo', $r->memo_estado_tipo);
                    $busq->__SET('memo_est_prioridad', $r->memo_estado_prioridad);
                    $busq->__SET('memo_est_activo', $r->memo_estado_activo);
                    $busq->__SET('memo_est_seccion_id', $r->seccion_id);
                    $busq->__SET('memo_est_seccion_nombre', $r->seccion_nombre);
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
                                                me.memo_estado_prioridad,
                                                me.memo_estado_activo,
                                                sec.seccion_id,
                                                sec.seccion_nombre
                                        FROM memo_estado as me, seccion as sec
                                        WHERE sec.seccion_id = me.memo_estado_seccion_id AND me.memo_estado_id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $busq = new MemoEst();
                $busq->__SET('memo_est_id', $r->memo_estado_id);
                $busq->__SET('memo_est_tipo', $r->memo_estado_tipo);
                $busq->__SET('memo_est_prioridad', $r->memo_estado_prioridad);
                $busq->__SET('memo_est_activo', $r->memo_estado_activo);
                $busq->__SET('memo_est_seccion_id', $r->seccion_id);
                $busq->__SET('memo_est_seccion_nombre', $r->seccion_nombre);

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
            $sql = "INSERT INTO memo_estado (memo_estado_tipo, memo_estado_prioridad, memo_estado_activo, memo_estado_seccion_id) 
                    VALUES (?,?,?,?)";

            $this->pdo->prepare($sql)->execute(array(   $data->__GET('memo_est_tipo'),
                                                        $data->__GET('memo_est_prioridad'),
                                                        $data->__GET('memo_est_activo'),
                                                        $data->__GET('memo_est_seccion_id')
                                                    )
                                              );
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
        //print_r($data);
        try{
            $sql = "UPDATE memo_estado SET 
                           memo_estado_tipo = ?,
			               memo_estado_prioridad = ?,
                           memo_estado_activo = ?,
                           memo_estado_seccion_id = ?
                    WHERE  memo_estado_id = ?";
            $this->pdo->prepare($sql)->execute(array($data->__GET('memo_est_tipo'),
                                                     $data->__GET('memo_est_prioridad'),
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

    public function Listar2(){
        $jsonresponse = array();
        try{
            $result = array();
             $stm = $this->pdo->prepare("SELECT me.memo_estado_id,
                                                me.memo_estado_tipo,
                                                me.memo_estado_prioridad
                                        FROM memo_estado as me");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new MemoEst();
                    $busq->__SET('memo_est_id', $r->memo_estado_id);
                    $busq->__SET('memo_est_tipo', $r->memo_estado_tipo); 
                    $busq->__SET('memo_est_prioridad', $r->memo_estado_prioridad);
                $result[] = $busq;
            }
            return $result;
        }catch(Exception $e){
            die($e->getMessage());
        }
    }
    public function ListarMin(){
        $jsonresponse = array();
        try{
            $result = array();
            $stm = $this->pdo->prepare("SELECT  me.memo_estado_id,
                                                me.memo_estado_tipo
                                        FROM memo_estado as me, seccion as sec
                                        WHERE sec.seccion_id = me.memo_estado_seccion_id
                                        AND me.memo_estado_activo = 1
                                        ORDER BY me.memo_estado_prioridad ASC ");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new MemoEst();
                    $busq->__SET('memo_est_id', $r->memo_estado_id);
                    $busq->__SET('memo_est_tipo', $r->memo_estado_tipo);
                    $busq->__SET('memo_est_prioridad', $r->memo_estado_prioridad);
                    $busq->__SET('memo_est_activo', $r->memo_estado_activo);
                    $busq->__SET('memo_est_seccion_nombre', $r->seccion_nombre);                    
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

}

?>