<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../config/config.php");
class ModelMemoDetalle {
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
            $stm = $this->pdo->prepare("SELECT  md.memo_det_id,
                                                md.memo_det_descripcion,
                                                md.memo_det_num_orden_compra_chc,
                                                md.memo_det_cert_disp_presupuestaria,
                                                md.memo_det_num_orden_compra_manager,
                                                md.memo_det_num_factura,
                                                md.memo_det_fecha_factura,
                                                md.memo_det_monto_total,
                                                md.memo_det_observaciones
                                        FROM memo_detalle as md");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new MemoDetalles();
                    $busq->__SET('memo_detalle_id', $r->memo_det_id);
                    $busq->__SET('memo_detalle_descripcion', $r->memo_det_descripcion);
                    $busq->__SET('memo_detalle_num_oc_chc', $r->memo_det_num_orden_compra_chc);
                    $busq->__SET('memo_detalle_cdp', $r->memo_det_cert_disp_presupuestaria);
                    $busq->__SET('memo_detalle_num_oc_manager', $r->memo_det_num_orden_compra_manager);
                    $busq->__SET('memo_detalle_num_factura', $r->memo_det_num_factura);
                    $busq->__SET('memo_detalle_fecha_factura', $r->memo_det_fecha_factura);
                    $busq->__SET('memo_detalle_monto_total', $r->memo_det_monto_total);
                    $busq->__SET('memo_detalle_observaciones', $r->memo_det_observaciones);                    
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
            $jsonresponse['message'] = 'Error al listar memo detalles';
        }
    }

    public function Obtener($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                       ->prepare("SELECT  md.memo_det_id,
                                          md.memo_det_descripcion,
                                          md.memo_det_num_orden_compra_chc,
                                          md.memo_det_cert_disp_presupuestaria,
                                          md.memo_det_num_orden_compra_manager,
                                          md.memo_det_num_factura,
                                          md.memo_det_fecha_factura,
                                          md.memo_det_monto_total,
                                          md.memo_det_observaciones
                                FROM memo_detalle as md
                                WHERE md.memo_det_id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $busq = new MemoDetalles();
                    $busq->__SET('memo_detalle_id', $r->memo_det_id);
                    $busq->__SET('memo_detalle_descripcion', $r->memo_det_descripcion);
                    $busq->__SET('memo_detalle_num_oc_chc', $r->memo_det_num_orden_compra_chc);
                    $busq->__SET('memo_detalle_cdp', $r->memo_det_cert_disp_presupuestaria);
                    $busq->__SET('memo_detalle_num_oc_manager', $r->memo_det_num_orden_compra_manager);
                    $busq->__SET('memo_detalle_num_factura', $r->memo_det_num_factura);
                    $busq->__SET('memo_detalle_fecha_factura', $r->memo_det_fecha_factura);
                    $busq->__SET('memo_detalle_monto_total', $r->memo_det_monto_total);
                    $busq->__SET('memo_detalle_observaciones', $r->memo_det_observaciones);

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Se obtuvo los memo detalles correctamente';
            $jsonresponse['datos'] = $busq->returnArray();
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener memo detalles ';             
        }
        return $jsonresponse;
    }

    public function Eliminar($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                      ->prepare("DELETE FROM memo_detalle WHERE memo_det_id = ? ");
            $stm->execute(array($id));

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Memo detalle eliminado correctamente';              
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar memo detalle';            
        }
        return $jsonresponse;
    }

    public function Registrar(MemoDetalles $data){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO memo_detalle (memo_det_descripcion,
                                              memo_det_num_orden_compra_chc,
                                              memo_det_cert_disp_presupuestaria,
                                              memo_det_num_orden_compra_manager,
                                              memo_det_num_factura,
                                              memo_det_fecha_factura,
                                              memo_det_monto_total,
                                              memo_det_observaciones) 
                    VALUES (?,?,?,?,?,?,?,?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('memo_detalle_descripcion'),
                                                     $data->__GET('memo_detalle_num_oc_chc'),
                                                     $data->__GET('memo_detalle_cdp'),
                                                     $data->__GET('memo_detalle_num_oc_manager'),
                                                     $data->__GET('memo_detalle_num_factura'),
                                                     $data->__GET('memo_detalle_fecha_factura'),
                                                     $data->__GET('memo_detalle_monto_total'), 
                                                     $data->__GET('memo_detalle_observaciones'))
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Memo detalle ingresado correctamente'; 
        } catch (PDOException $pdoException){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar memo detalle';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            var_dump($jsonresponse);
        }
        return $jsonresponse;
    }

    public function Actualizar(MemoDetalles $data){
        $jsonresponse = array();
        //print_r($data);
        try{
            $sql = "UPDATE memo_detalle SET 
                           memo_det_descripcion = ?,
                           memo_det_num_orden_compra_chc= ?,
                           memo_det_cert_disp_presupuestaria = ?,
                           memo_det_num_orden_compra_manager= ?,
                           memo_det_num_factura= ?,
                           memo_det_fecha_factura = ?,
                           memo_det_monto_total = ?, 
                           memo_det_observaciones = ?
                    WHERE  memo_det_id = ?";

            $this->pdo->prepare($sql)
                 ->execute(array($data->__GET('memo_detalle_descripcion'),
                                 $data->__GET('memo_detalle_num_oc_chc'),
                                 $data->__GET('memo_detalle_cdp'),
                                 $data->__GET('memo_detalle_num_oc_manager'),
                                 $data->__GET('memo_detalle_num_factura'),
                                 $data->__GET('memo_detalle_fecha_factura'),
                                 $data->__GET('memo_detalle_monto_total'), 
                                 $data->__GET('memo_detalle_observaciones'),
                                 $data->__GET('memo_detalle_id')) 
                          );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Memo detalle actualizado correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar memo detalle';             
        }
        return $jsonresponse;
    }

    public function Listar2(){
        $jsonresponse = array();
        try{
            $result = array();
             $stm = $this->pdo->prepare("SELECT md.memo_det_id,
                                                md.memo_det_descripcion,
                                                md.memo_det_num_orden_compra_chc,
                                                md.memo_det_cert_disp_presupuestaria,
                                                md.memo_det_num_orden_compra_manager,
                                                md.memo_det_num_factura,
                                                md.memo_det_fecha_factura,
                                                md.memo_det_monto_total,
                                                md.memo_det_observaciones
                                        FROM memo_detalle as md");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new MemoDetalles();
                    $busq->__SET('memo_detalle_id', $r->memo_det_id);
                    $busq->__SET('memo_detalle_descripcion', $r->memo_det_descripcion);
                    $busq->__SET('memo_detalle_num_oc_chc', $r->memo_det_num_orden_compra_chc);
                    $busq->__SET('memo_detalle_cdp', $r->memo_det_cert_disp_presupuestaria);
                    $busq->__SET('memo_detalle_num_oc_manager', $r->memo_det_num_orden_compra_manager);
                    $busq->__SET('memo_detalle_num_factura', $r->memo_det_num_factura);
                    $busq->__SET('memo_detalle_fecha_factura', $r->memo_det_fecha_factura);
                    $busq->__SET('memo_detalle_monto_total', $r->memo_det_monto_total);
                    $busq->__SET('memo_detalle_observaciones', $r->memo_det_observaciones);
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