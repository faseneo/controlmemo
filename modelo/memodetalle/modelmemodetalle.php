<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../config/config.php");

require_once("../modelo/estado_detmemo/entidaddetmemocambioestado.php");
require_once("../modelo/estado_detmemo/modelestadodetmemo.php");

require_once("../modelo/logs/modelologs.php");
require_once("../modelo/logs/modelologsquerys.php");

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

    public function Listar($memid){
        $jsonresponse = array();
        try{
            $result = array();
                  $consulta = "SELECT detmemo_memo_id,
                                      detmemo_id,
                                      estado_max_id,
                                      edm.estado_detmemo_id,
                                      edm.estado_detmemo_tipo, 
                                      detmemo_fecha,
                                      detmemo_cc_codigo,
                                      cc.cc_nombre,
                                      detmemo_ocnum_sistema_interno, 
                                      detmemo_ocnum_chilecompra,
                                      detmemo_monto_total,
                                      detmemo_proc_compra_id,
                                      pc.proc_compra_tipo,
                                      detmemo_proveedor_id,
                                      pro.proveedor_nombre,
                                      cedm.cambio_estados_detmemo_observacion, 
                                      cedm.cambio_estados_detmemo_fecha, 
                                      cedm.cambio_estados_detmemo_usu_id,
                                      us.usuario_nombre
                  FROM (SELECT estado_max_det(dm.detmemo_id,1) as estado_max_id, dm.detmemo_id, dm.detmemo_cc_codigo, dm.detmemo_ocnum_sistema_interno, 
                        dm.detmemo_ocnum_chilecompra, dm.detmemo_monto_total, dm.detmemo_proc_compra_id, dm.detmemo_proveedor_id, dm.detmemo_memo_id,dm.detmemo_fecha FROM detalle_memo as dm)  AS TABLA_MEM_MAX
                  LEFT JOIN cambio_estados_detmemo as cedm ON cedm.cambio_estados_detmemo_id = estado_max_id
                  LEFT JOIN estado_detalle_memo AS edm ON edm.estado_detmemo_id = cedm.cambio_estados_detmemo_estado_detmemo_id
                  LEFT JOIN procedimiento_compra AS pc ON pc.proc_compra_id=detmemo_proc_compra_id
                  LEFT JOIN proveedor AS pro ON pro.proveedor_id=detmemo_proveedor_id
                  LEFT JOIN centro_costos AS cc ON cc.cc_codigo=detmemo_cc_codigo
                  LEFT JOIN usuario AS us ON us.usuario_id = cedm.cambio_estados_detmemo_usu_id
                  WHERE detmemo_memo_id = ".$memid;

            $stm = $this->pdo->prepare($consulta);
            $stm->execute();

            $logsq = new ModeloLogsQuerys();
                $logsq->GrabarLogsQuerys($consulta,1,'Listar Detalle Memo');
                $logsq = null;

            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new MemoDetalles();
                    $busq->__SET('memo_detalle_id',             $r->detmemo_id);
                    $busq->__SET('memo_detalle_memo_id',        $r->detmemo_memo_id);
                    $busq->__SET('memo_detalle_detmemocc',      $r->detmemo_cc_codigo);
                    $busq->__SET('memo_detalle_detmemocc_nom',  $r->cc_nombre);
                    //$busq->__SET('memo_detalle_solicita',       $r->detmemo_contacto_nombre);
                    //$busq->__SET('memo_detalle_descripcion',    $r->detmemo_descripcion);
                    $busq->__SET('memo_detalle_procompra',      $r->detmemo_proc_compra_id);
                    $busq->__SET('memo_detalle_procompra_nom',  $r->proc_compra_tipo);
                    $busq->__SET('memo_detalle_proveedor_id',   $r->detmemo_proveedor_id);
                    $busq->__SET('memo_detalle_proveedor_nom',  $r->proveedor_nombre);
                    $busq->__SET('memo_detalle_num_oc_sac',     $r->detmemo_ocnum_sistema_interno);
                    $busq->__SET('memo_detalle_num_oc_chc',     $r->detmemo_ocnum_chilecompra);
                    $busq->__SET('memo_detalle_monto_total',    $r->detmemo_monto_total);
                    $busq->__SET('memo_detalle_fecha',          date_format(date_create($r->detmemo_fecha),'d-m-Y / H:m' ));
                    
                    $busq->__SET('memo_detalle_estado_id',      $r->estado_detmemo_id);
                    $busq->__SET('memo_detalle_estado_nom',     $r->estado_detmemo_tipo);
                    $busq->__SET('memo_detalle_estado_fecha',   date_format(date_create($r->cambio_estados_detmemo_fecha),'d-m-Y / H:m' ));

                    $busq->__SET('memo_detalle_usu_id',         $r->cambio_estados_detmemo_usu_id);
                    $busq->__SET('memo_detalle_usu_nom',        $r->usuario_nombre);

                $result[] = $busq->returnArray();
            }
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Listado correctamente';
            $jsonresponse['datos'] = $result;
            return $jsonresponse;
        
        /*}catch(Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al listar memo detalles';
        }*/
        } catch (PDOException $Exception){
            $jsonresponsel['success'] = false;
            $jsonresponsel['message'] = 'Error al listar Detalles Memo';
            $logs = new modelologs();
            $trace = $Exception->getTraceAsString();
              $logs->GrabarLogs($Exception->getMessage(),$trace);
              $logs = null;
        }finally {
          $this->pdo=null;  
        }
    }

    public function Obtener($id){
        $jsonresponse = array();
        try{
          $consulta = "SELECT COUNT(*) FROM detalle_memo WHERE detmemo_id = ".$id;

          $res = $this->pdo->query($consulta);
            $total = $res->fetchColumn();
            if ($total == 0) {
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Detella memo no Existe';
                $jsonresponse['datos'] = [];
            }else{
              $consulta = "SELECT dm.detmemo_memo_id,
                                          dm.detmemo_id,
                                          dm.detmemo_descripcion,
                                          dm.detmemo_fecha,
                                          dm.detmemo_cc_codigo,
                                          cc.cc_nombre,
                                          dm.detmemo_contacto_nombre,
                                          dm.detmemo_ocnum_sistema_interno, 
                                          dm.detmemo_ocnum_chilecompra,
                                          dm.detmemo_monto_total,
                                          dm.detmemo_proc_compra_id,
                                          pc.proc_compra_tipo,
                                          dm.detmemo_proveedor_id,
                                          pro.proveedor_nombre
                      FROM detalle_memo as dm
                      LEFT JOIN procedimiento_compra AS pc ON pc.proc_compra_id=detmemo_proc_compra_id
                      LEFT JOIN proveedor AS pro ON pro.proveedor_id=detmemo_proveedor_id
                      LEFT JOIN centro_costos AS cc ON cc.cc_codigo=detmemo_cc_codigo
                      WHERE dm.detmemo_id = ".$id;
                      $stm = $this->pdo->prepare($consulta);
                      $stm->execute();
                
                $r = $stm->fetch(PDO::FETCH_OBJ);
                $busq = new MemoDetalles();
                        $busq->__SET('memo_detalle_id',             $r->detmemo_id);
                        $busq->__SET('memo_detalle_descripcion',    $r->detmemo_descripcion);
                        $busq->__SET('memo_detalle_memo_id',        $r->detmemo_memo_id);
                        $busq->__SET('memo_detalle_detmemocc',      $r->detmemo_cc_codigo);
                        $busq->__SET('memo_detalle_detmemocc_nom',  $r->cc_nombre);
                        $busq->__SET('memo_detalle_solicita',       $r->detmemo_contacto_nombre);
                        $busq->__SET('memo_detalle_procompra',      $r->detmemo_proc_compra_id);
                        $busq->__SET('memo_detalle_procompra_nom',  $r->proc_compra_tipo);
                        $busq->__SET('memo_detalle_proveedor_id',   $r->detmemo_proveedor_id);
                        $busq->__SET('memo_detalle_proveedor_nom',  $r->proveedor_nombre);

                        $busq->__SET('memo_detalle_num_oc_sac',     $r->detmemo_ocnum_sistema_interno);
                        $busq->__SET('memo_detalle_num_oc_chc',     $r->detmemo_ocnum_chilecompra);
                        $busq->__SET('memo_detalle_monto_total',    $r->detmemo_monto_total);
                        $busq->__SET('memo_detalle_fecha',          date_format(date_create($r->detmemo_fecha),'d-m-Y / H:m' ));

                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Se obtuvo detalle del memo correctamente';
                $jsonresponse['datos'] = $busq->returnArray();
            }
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

    public function Registrar(MemoDetalles $data, $uid){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO detalle_memo (detmemo_cc_codigo,
                                              detmemo_contacto_nombre,
                                              detmemo_descripcion,
                                              detmemo_proc_compra_id,
                                              detmemo_proveedor_id,
                                              detmemo_ocnum_sistema_interno,
                                              detmemo_ocnum_chilecompra,
                                              detmemo_monto_total,
                                              detmemo_memo_id) 
                    VALUES (?,?,?,?,?,?,?,?,?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('memo_detalle_detmemocc'),
                                                     $data->__GET('memo_detalle_solicita'),
                                                     $data->__GET('memo_detalle_descripcion'),
                                                     $data->__GET('memo_detalle_procompra'),
                                                     $data->__GET('memo_detalle_proveedor_id'),
                                                     $data->__GET('memo_detalle_num_oc_sac'), 
                                                     $data->__GET('memo_detalle_num_oc_chc'),
                                                     $data->__GET('memo_detalle_monto_total'),
                                                     $data->__GET('memo_detalle_memo_id'))
                                              );
            $logsq = new ModeloLogsQuerys();
                $logsq->GrabarLogsQuerys($sql,'0','Registrar');
            $iddetmemo = $this->pdo->lastInsertId();
           
              $obsestado = "Detalle ingresado por usuario"; 
              $estadoinicial = 1;
 
            $objcambioest = new DetMemoCambioEst();
            $modelcambioest = new ModelEstadoDetMemo();

              $objcambioest->__SET('detmemo_camest_memid',$iddetmemo);
              $objcambioest->__SET('detmemo_camest_estid',$estadoinicial);
              $objcambioest->__SET('detmemo_camest_obs',$obsestado);
              $objcambioest->__SET('detmemo_camest_usuid',$uid);
            $modelcambioest->CambiaEstadoDetMemo($objcambioest);

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