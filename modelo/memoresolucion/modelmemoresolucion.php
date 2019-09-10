<?php
    error_reporting( -1 );
    ini_set( 'display_startup_errors', 1 );
    ini_set( 'display_errors', 1 );

require_once("../config/config.php");
class ModelMemoAsociaResolucion {
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
    //OK, falta probar
    public function Listar($idmemo=NULL){
        $jsonresponse = array();
        try{
            if($idmemo!=NULL){
                $consulta = "SELECT COUNT(*) FROM asocia_resolucion AS ar WHERE ar.asocia_resolucion_memo_id=".$idmemo;
                $res = $this->pdo->query($consulta);
                if ($res->fetchColumn() == 0) {
                    $jsonresponse['success'] = true;
                    $jsonresponse['message'] = 'Memo sin resoluciones agregadas';
                    $jsonresponse['datos'] = [];
                }else{
                    $result = array();
                    $stm = $this->pdo->prepare("SELECT asocia_resolucion_id, asocia_resolucion_memo_id, asocia_resolucion_res_id,
                                                        asocia_resolucion_res_url,asocia_resolucion_res_anio,asocia_resolucion_res_num,
                                                        asocia_resolucion_res_fecha, asocia_resolucion_res_fecha_pub, 
                                                        asocia_resolucion_fecha_agregacion
                                                FROM asocia_resolucion
                                                WHERE asocia_resolucion_memo_id= ".$idmemo);
                    $stm->execute();
                    foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                        //date_format(date_create($r->memo_observaciones_fecha),'d-m-Y' ));
                        $busq = new MemoAsociaresolucion();
                            $busq->__SET('mem_asoc_id',             $r->asocia_resolucion_id);
                            $busq->__SET('mem_asoc_memid',          $r->asocia_resolucion_memo_id);
                            $busq->__SET('mem_asoc_resid',          $r->asocia_resolucion_res_id);
                            $busq->__SET('mem_asoc_resurl',         $r->asocia_resolucion_res_url);
                            $busq->__SET('mem_asoc_resanio',        $r->asocia_resolucion_res_anio);
                            $busq->__SET('mem_asoc_resnum',         $r->asocia_resolucion_res_num);
                            //$busq->__SET('mem_asoc_rescatcod',  $r->asocia_resolucion_res_cat_cod);
                            $busq->__SET('mem_asoc_resfecha',     date_format(date_create($r->asocia_resolucion_res_fecha),'d-m-Y'));
                            $busq->__SET('mem_asoc_resfechapub',  date_format(date_create($r->asocia_resolucion_res_fecha_pub),'d-m-Y'));
                            $busq->__SET('mem_asoc_fecha_agrega', date_format(date_create($r->asocia_resolucion_fecha_agregacion),'d-m-Y'));
                            //$busq->__SET('mem_asoc_comentario',     $r->asocia_resolucion_comentario);
                        $result[] = $busq->returnArray();
                    }
                    $jsonresponse['success'] = true;
                    $jsonresponse['message'] = 'listado correctamente Resoluciones del memo';
                    $jsonresponse['datos'] = $result;
                }
            }else{
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Memo sin resoluciones';
                $jsonresponse['datos'] = [];
            }
            return $jsonresponse;
        }
        catch(Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al listar observaciones del memo';
        }
    }
    //falta desarrollar
    /*public function Obtener($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo->prepare("SELECT mo.memo_observaciones_id, mo.memo_observaciones_texto, mo.memo_observaciones_fecha,mo.memo_observaciones_memo_id, mo.memo_observaciones_usuario_id, us.usuario_email
                                                FROM memo_observaciones AS mo , usuario AS us
                                                WHERE mo.memo_observaciones_usuario_id = us.usuario_id
                                                AND  mo.memo_observaciones_memo_id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $busq = new MemoObservacion();
                            $busq->__SET('memoobs_id',          $r->memo_observaciones_id);
                            $busq->__SET('memoobs_texto',       $r->memo_observaciones_texto);
                            $busq->__SET('memoobs_fecha',       $r->memo_observaciones_fecha);
                            $busq->__SET('memoobs_memo_id',     $r->memo_observaciones_memo_id);
                            $busq->__SET('memoobs_usu_id',      $r->memo_observaciones_usuario_id);
                            $busq->__SET('memoobs_usu_nom',     $r->usuario_email);

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Se obtuvo Observacion correctamente';
            $jsonresponse['datos'] = $busq->returnArray();
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener Obs. Memo';             
        }
        return $jsonresponse;
    }*/
    //OK, falta probar
    public function Eliminar($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo->prepare("DELETE FROM asocia_resolucion WHERE asocia_resolucion_id = ? ");
            $stm->execute(array($id));

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Resolución  eliminada correctamente';              
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar Resolución Memo';            
        }
        return $jsonresponse;
    }
    //OK, falta probar
    public function Registrar(MemoAsociaresolucion $data,$uid){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO asocia_resolucion ( asocia_resolucion_memo_id,
                                                    asocia_resolucion_res_id,
                                                    asocia_resolucion_res_url,
                                                    asocia_resolucion_res_anio,
                                                    asocia_resolucion_res_num,
                                                    asocia_resolucion_res_cat_cod,
                                                    asocia_resolucion_res_fecha,
                                                    asocia_resolucion_res_fecha_pub,
                                                    asocia_resolucion_fecha_agregacion,
                                                    asocia_resolucion_comentario) 
                    VALUES (?,?,?,?,?,?,?,?,?,?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('mem_asoc_memid'),
                                                     $data->__GET('mem_asoc_resid'),
                                                     $data->__GET('mem_asoc_resurl'),
                                                     $data->__GET('mem_asoc_resanio'),
                                                     $data->__GET('mem_asoc_resnum'),
                                                     $data->__GET('mem_asoc_rescatcod'),
                                                     $data->__GET('mem_asoc_resfecha'),
                                                     $data->__GET('mem_asoc_resfechapub'),
                                                     $data->__GET('mem_asoc_fecha_agrega'),
                                                     ""
                                                     )
                                              );
            require_once("../modelo/usuario/modelusuario.php");
                          $modelUsu = new ModelUsuarios();
                          $arraydatos = $modelUsu->ObtenerAsignaMemo($data->__GET('mem_asoc_memid'));
                            if(count($arraydatos["datos"]) > 0){
                                for($i=0; $i<count($arraydatos["datos"]); $i++){
                                      if($arraydatos["datos"][$i]["asigna_usu_uid"]==$uid && $arraydatos["datos"][$i]["asigna_usu_estado_id"]==2){
                                        $modelUsu->CambiaEstadoAsignaMemo($uid,$data->__GET('mem_asoc_memid'),3);
                                        require_once("../modelo/memoestado/entidadmemocambioestado.php");
                                            require_once("../modelo/memoestado/modelmemoestado.php");
                                            $objcambioest = new MemoCambioEst();
                                            $modelcambioest = new ModelMemoEst();
                                            $resp= $modelcambioest->ObtieneEstadoMemoId($data->__GET('mem_asoc_memid'),27);
                                            if($resp==FALSE){
                                                $objcambioest->__SET('memo_camest_memid',$data->__GET('mem_asoc_memid'));
                                                $objcambioest->__SET('memo_camest_estid',27);
                                                $objcambioest->__SET('memo_camest_obs','Ingreso de datos al memo');
                                                $objcambioest->__SET('memo_camest_usuid',$uid);
                                                $modelcambioest->CambiaEstado($objcambioest, 26, 87);
                                            }
                                      }
                                }
                            }

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Resolucion ingresada correctamente'; 
        } catch (PDOException $pdoException){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar resolución al memo';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            var_dump($jsonresponse);
        }
        return $jsonresponse;
    }
    //no programado aun
    /*public function Actualizar(MemoAsociaresolucion $data){
        $jsonresponse = array();
        //print_r($data);
        try{
            $sql = "UPDATE memo_observaciones SET 
                           memo_observaciones_texto = ?
                    WHERE  memo_observaciones_id = ? ";

            $this->pdo->prepare($sql)->execute(array($data->__GET('memoobs_texto'),
                                                      $data->__GET('memoobs_id')
                                                     )
                                                );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'obs. memos actualizado correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar obs. memos';             
        }
        return $jsonresponse;
    }*/
    //OK, falta probar
    public function ListarMin($idmemo=NULL){
        $jsonresponse = array();
        try{
            if($idmemo!=NULL){
                $consulta = "SELECT COUNT(*) FROM asocia_resolucion AS ar WHERE ar.asocia_resolucion_memo_id= ".$idmemo;
                $res = $this->pdo->query($consulta);
                if ($res->fetchColumn() == 0) {
                    $jsonresponse['success'] = true;
                    $jsonresponse['message'] = 'Memo sin resoluciones';
                    $jsonresponse['datos'] = [];
                }else{
                    $result = array();
                    $stm = $this->pdo->prepare("SELECT * FROM asocia_resolucion AS ar WHERE ar.asocia_resolucion_memo_id = ".$idmemo);
                    $stm->execute();
                    foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                        $fila = array('mem_asoc_id'     =>$r->asocia_resolucion_id,
                                      'mem_asoc_memid'  =>$r->asocia_resolucion_memo_id,
                                      'mem_asoc_resid'  =>$r->asocia_resolucion_res_id,
                                      'mem_asoc_resurl' =>$r->asocia_resolucion_res_url,
                                      'mem_asoc_resnum' =>$r->asocia_resolucion_res_num,
                                      'mem_asoc_resanio' =>$r->asocia_resolucion_res_anio,
                                      'mem_asoc_resfecha'=>date_format(date_create($r->asocia_resolucion_res_fecha),'d-m-Y')
                                      );
                        $result[]=$fila;
                    }
                    $jsonresponse['success'] = true;
                    $jsonresponse['message'] = 'listado resoluciones memo correctamente';
                    $jsonresponse['datos'] = $result;
                }
                return $jsonresponse;
            }else{
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Memo sin resoluciones';
                $jsonresponse['datos'] = [];
            }
        }
        catch(Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al listar resoluciones del memo';
        }
    }
























}
 

?>