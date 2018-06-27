<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../config/config.php");
class ModelMemo {
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
            $stm = $this->pdo->prepare("SELECT  mm.memo_id,
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
            $jsonresponse['message'] = 'Error al listar Memos';
        }
    }

    public function Obtener($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                       ->prepare("SELECT  mm.memo_id,
                                          mm.memo_num_memo,
                                          mm.memo_fecha_recepcion,
                                          mm.memo_fecha_memo,
                                          mm.memo_fecha_entrega_analista,
                                          mm.memo_depto_id,
                                          mm.memo_cc_id,
                                          mm.memo_memo_estado_id,
                                          mm.memo_fecha_ingreso
                                FROM memo as mm
                                WHERE mm.memo_id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
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

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Se obtuvo los memos correctamente';
            $jsonresponse['datos'] = $busq->returnArray();
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener memos';             
        }
        return $jsonresponse;
    }

    public function Eliminar($id){
        $jsonresponse = array();
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

    public function Registrar(Memos $data){
        if($data->__GET('mem_fecha_recep')=="" || $data->__GET('mem_fecha_recep')==NULL) 
          $fecharecep=null;
        else
          $fecharecep=$data->__GET('mem_fecha_recep');
        if($data->__GET('mem_fecha')=="" || $data->__GET('mem_fecha')==NULL) 
          $fechamemo=null;
        else
          $fechamemo=$data->__GET('mem_fecha');
        if($data->__GET('mem_fecha_analista')=="" || $data->__GET('mem_fecha_analista')==NULL) 
          $fechaanalista=null;
        else
          $fechaanalista=$data->__GET('mem_fecha_analista');

        $jsonresponse = array();
        try{
            $sql = "INSERT INTO memo (memo_num_memo,
                                      memo_fecha_recepcion,
                                      memo_fecha_memo,
                                      memo_fecha_entrega_analista,
                                      memo_depto_id,
                                      memo_cc_id,
                                      memo_memo_estado_id) 
                    VALUES (?,?,?,?,?,?,?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('mem_numero'),
                                                     $fecharecep,
                                                     $fechamemo,
                                                     $fechaanalista,
                                                     $data->__GET('mem_depto_id'),
                                                     $data->__GET('mem_ccosto_id'),
                                                     $data->__GET('mem_estado_id'))
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Memo ingresado correctamente'; 
        } catch (PDOException $pdoException){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar Memo';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
        }
        return $jsonresponse;
    }

    public function Actualizar(Memos $data){
        $jsonresponse = array();
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
    }

    public function Listar2(){
        $jsonresponse = array();
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
    }


}

?>

