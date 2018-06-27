<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../config/config.php");
class ModelMemoDetCompra {
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
            $stm = $this->pdo->prepare("SELECT  md.memo_det_compra_id,
                                                md.memo_det_compra_nombre_producto,
                                                md.memo_det_compra_cantidad,
                                                md.memo_det_compra_valor,
                                                md.memo_det_compra_total
                                        FROM memo_detalle_compra as md");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new MemoDetCompra();
                    $busq->__SET('memo_detalle_compra_id', $r->memo_det_compra_id);
                    $busq->__SET('memo_detalle_compra_nom_producto', $r->memo_det_compra_nombre_producto);
                    $busq->__SET('memo_detalle_compra_cantidad', $r->memo_det_compra_cantidad);
                    $busq->__SET('memo_detalle_compra_valor', $r->memo_det_compra_valor);
                    $busq->__SET('memo_detalle_compra_total', $r->memo_det_compra_total);                    
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
            $jsonresponse['message'] = 'Error al listar los memo detalle compra';
        }
    }

    public function Obtener($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                       ->prepare("SELECT md.memo_det_compra_id,
                                         md.memo_det_compra_nombre_producto,
                                         md.memo_det_compra_cantidad,
                                         md.memo_det_compra_valor,
                                         md.memo_det_compra_total
                                FROM memo_detalle_compra as md
                                WHERE md.memo_det_compra_id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $busq = new MemoDetCompra();
                    $busq->__SET('memo_detalle_compra_id', $r->memo_det_compra_id);
                    $busq->__SET('memo_detalle_compra_nom_producto', $r->memo_det_compra_nombre_producto);
                    $busq->__SET('memo_detalle_compra_cantidad', $r->memo_det_compra_cantidad);
                    $busq->__SET('memo_detalle_compra_valor', $r->memo_det_compra_valor);
                    $busq->__SET('memo_detalle_compra_total', $r->memo_det_compra_total); 

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Se obtuvo memo detalle compra correctamente';
            $jsonresponse['datos'] = $busq->returnArray();
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener memo detalle compra';             
        }
        return $jsonresponse;
    }

    public function Eliminar($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                      ->prepare("DELETE FROM memo_detalle_compra WHERE memo_det_compra_id = ? ");
            $stm->execute(array($id));

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Memo detalle compra eliminado correctamente';              
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar memo detalle compra';            
        }
        return $jsonresponse;
    }

    public function Registrar(MemoDetCompra $data){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO memo_detalle_compra (memo_det_compra_nombre_producto,
                                                     memo_det_compra_cantidad,
                                                     memo_det_compra_valor
                                                     memo_det_compra_total) 
                    VALUES (?,?,?,?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('memo_detalle_compra_nom_producto'),
                                                     $data->__GET('memo_detalle_compra_cantidad'),
                                                     $data->__GET('memo_detalle_compra_valor'),
                                                     $data->__GET('memo_detalle_compra_total'))
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Memo detalle compra ingresado correctamente'; 
        } catch (PDOException $pdoException){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar memo detalle compra';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            var_dump($jsonresponse);
        }
        return $jsonresponse;
    }

    public function Actualizar(MemoDetCompra $data){
        $jsonresponse = array();
        //print_r($data);
        try{
            $sql = "UPDATE memo_detalle_compra SET 
                           memo_det_compra_nombre_producto = ?,
                           memo_det_compra_cantidad = ?,
                           memo_det_compra_valor = ?, 
                           memo_det_compra_total = ?
                    WHERE  memo_det_compra_id = ?";

            $this->pdo->prepare($sql)
                 ->execute(array($data->__GET('memo_detalle_compra_nom_producto'),
                                 $data->__GET('memo_detalle_compra_cantidad'),
                                 $data->__GET('memo_detalle_compra_valor'),
                                 $data->__GET('memo_detalle_compra_total'),
                                 $data->__GET('memo_detalle_compra_id'))
                          );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Memo detalle compra actualizado correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar memo detalle compra';             
        }
        return $jsonresponse;
    }

    public function Listar2(){
        $jsonresponse = array();
        try{
            $result = array();
             $stm = $this->pdo->prepare("SELECT md.memo_det_compra_id,
                                                md.memo_det_compra_nombre_producto,
                                                md.memo_det_compra_cantidad,
                                                md.memo_det_compra_valor,
                                                md.memo_det_compra_total
                                        FROM memo_detalle_compra as md");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new MemoDetCompra();
                    $busq->__SET('memo_detalle_compra_id', $r->memo_det_compra_id);
                    $busq->__SET('memo_detalle_compra_nom_producto', $r->memo_det_compra_nombre_producto);
                    $busq->__SET('memo_detalle_compra_cantidad', $r->memo_det_compra_cantidad);
                    $busq->__SET('memo_detalle_compra_valor', $r->memo_det_compra_valor);
                    $busq->__SET('memo_detalle_compra_total', $r->memo_det_compra_total); 
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