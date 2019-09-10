<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../config/config.php");
class ModelMemoCDP {
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
    //lista cdp el memo, OK
    public function ListarMemoCDP($idmemo=NULL){
        $jsonresponse = array();
        try{
            if($idmemo!=NULL){
                $consulta = "SELECT COUNT(*) FROM memo_cdp AS mc WHERE mc.memo_cdp_memo_id=".$idmemo;
                $res = $this->pdo->query($consulta);
                if ($res->fetchColumn() == 0) {
                    $jsonresponse['success'] = true;
                    $jsonresponse['message'] = 'Memo sin CDP agregado';
                    $jsonresponse['datos'] = [];
                }else{
                    $result = array();
                    $stm = $this->pdo->prepare("SELECT mcdp.memo_cdp_id, mcdp.memo_cdp_num, mcdp.memo_cdp_fecha, mcdp.memo_cdp_cc_codigo, mcdp.memo_cdp_obs,
                                                mcdp.memo_cdp_memo_id, cc.cc_nombre
                                                FROM memo_cdp AS mcdp
                                                LEFT JOIN centro_costos AS cc ON cc.cc_codigo=mcdp.memo_cdp_cc_codigo
                                                WHERE memo_cdp_memo_id =".$idmemo);
                    $stm->execute();
                    foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                        //date_format(date_create($r->memo_observaciones_fecha),'d-m-Y' ));
                        $busq = new MemoCDP();
                            $busq->__SET('memocdp_id',      $r->memo_cdp_id);
                            $busq->__SET('memocdp_num',     $r->memo_cdp_num);
                            $busq->__SET('memocdp_fecha',   date_format(date_create($r->memo_cdp_fecha),'d-m-Y'));
                            $busq->__SET('memocdp_cod_cc',  $r->memo_cdp_cc_codigo);
                            $busq->__SET('memocdp_nom_cc',  $r->cc_nombre);
                            $busq->__SET('memocdp_obs',     $r->memo_cdp_obs);
                            $busq->__SET('memocdp_mem_id',  $r->memo_cdp_memo_id);
                        $result[] = $busq->returnArray();
                    }
                    $jsonresponse['success'] = true;
                    $jsonresponse['message'] = 'Listado correctamente CDP del memo';
                    $jsonresponse['datos'] = $result;
                }
            }else{
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Memo sin CDP';
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

    /*public function ObtenerMemoCDP($idmemo,$id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo->prepare("SELECT  cc.cc_codigo,
                                                cc.cc_nombre,
                                                cc.cc_tipo,
                                                cc.cc_estado,
                                                cc.cc_dependencia_codigo,
                                                dep.dependencia_nombre
                                        FROM centro_costos as cc, dependencia as dep
                                        WHERE cc.cc_dependencia_codigo = dep.dependencia_codigo
                                        AND cc.cc_codigo = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $busq = new CentroCostos();
                    $busq->__SET('ccosto_codigo',       $r->cc_codigo);
                    $busq->__SET('ccosto_nombre',       $r->cc_nombre);
                    $busq->__SET('ccosto_tipo',         $r->cc_tipo);
                    $busq->__SET('ccosto_estado',       $r->cc_estado);
                    $busq->__SET('ccosto_dep_codigo',   $r->cc_dependencia_codigo);
                    $busq->__SET('ccosto_dep_nombre',   $r->dependencia_nombre);

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Se obtuvo los Centros de Costos correctamente';
            $jsonresponse['datos'] = $busq->returnArray();
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener Centro de Costos';             
        }
        return $jsonresponse;
    }*/
    //elimina cdp del memo, OK
    public function EliminarMemoCDP($idmemo,$id){
        $jsonresponse = array();
        try{    
            //"DELETE FROM centro_costos WHERE cc_codigo = ? AND cc_dependencia_codigo = ?"
            $stm = $this->pdo->prepare("DELETE FROM memo_cdp WHERE cc_codigo = ? ");
            $stm->execute(array($id));

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Centro de Costos eliminado correctamente';              
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar Centro de Costos';            
        }
        return $jsonresponse;
    }
    // registra cdp al memo, OK
    public function RegistraMemoCDP(MemoCDP $data, $uid){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO memo_cdp (memo_cdp_num, memo_cdp_fecha, memo_cdp_cc_codigo,memo_cdp_obs,memo_cdp_memo_id) 
                    VALUES (?,?,?,?,?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('memocdp_num'),
                                                     $data->__GET('memocdp_fecha'),
                                                     $data->__GET('memocdp_cod_cc'),
                                                     $data->__GET('memocdp_obs'),
                                                     $data->__GET('memocdp_mem_id')
                                                     )
                                              );
            require_once("../modelo/usuario/modelusuario.php");
                          $modelUsu = new ModelUsuarios();
                          $arraydatos = $modelUsu->ObtenerAsignaMemo($data->__GET('memocdp_mem_id'));
                            if(count($arraydatos["datos"]) > 0){
                                for($i=0; $i<count($arraydatos["datos"]); $i++){
                                      if($arraydatos["datos"][$i]["asigna_usu_uid"]==$uid && $arraydatos["datos"][$i]["asigna_usu_estado_id"]==2){
                                        $modelUsu->CambiaEstadoAsignaMemo($uid,$data->__GET('memocdp_mem_id'),3);
                                            require_once("../modelo/memoestado/entidadmemocambioestado.php");
                                            require_once("../modelo/memoestado/modelmemoestado.php");
                                            $objcambioest = new MemoCambioEst();
                                            $modelcambioest = new ModelMemoEst();
                                            $resp= $modelcambioest->ObtieneEstadoMemoId($data->__GET('memocdp_mem_id'),27);
                                            if($resp==FALSE){
                                                $objcambioest->__SET('memo_camest_memid',$data->__GET('memocdp_mem_id'));
                                                $objcambioest->__SET('memo_camest_estid',27);
                                                $objcambioest->__SET('memo_camest_obs','Ingreso de datos al memo');
                                                $objcambioest->__SET('memo_camest_usuid',$uid);
                                                $modelcambioest->CambiaEstado($objcambioest, 26, 87);
                                            }
                                      }
                                }
                            }

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'CDP ingresado correctamente'; 
        } catch (PDOException $pdoException){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar CDP al Memo';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            var_dump($jsonresponse);
        }
        return $jsonresponse;
    }

    /*public function ActualizarMemoCDP(MemoCDP $data, $uid){
        $jsonresponse = array();
        //print_r($data);
        try{
            $sql = "UPDATE centro_costos SET 
                           cc_codigo = ?,
                           cc_nombre = ?,
                           cc_tipo = ?,
                           cc_estado = ?,
                           cc_dependencia_codigo = ?
                    WHERE  cc_codigo = ? AND  cc_dependencia_codigo=? ";

            $this->pdo->prepare($sql)->execute(array($data->__GET('ccosto_codigo'),
                                                     $data->__GET('ccosto_nombre'), 
                                                     $data->__GET('ccosto_tipo'),
                                                     $data->__GET('ccosto_estado'),
                                                     $data->__GET('ccosto_dep_codigo'),
                                                     $data->__GET('ccosto_codigo'),
                                                     $data->__GET('ccosto_dep_codigo')
                                                     )
                                                );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Centro de Costos actualizado correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar Centro de Costos';             
        }
        return $jsonresponse;
    }

    public function Listar2(){
        $jsonresponse = array();
        try{
            $result = array();
             $stm = $this->pdo->prepare("SELECT  cc.cc_codigo,
                                                cc.cc_nombre,
                                                cc.cc_tipo,
                                                cc.cc_estado,
                                                cc.cc_dependencia_codigo,
                                                dep.dependencia_nombre
                                        FROM centro_costos as cc, dependencia as dep
                                        WHERE cc.cc_dependencia_codigo = dep.dependencia_codigo");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new CentroCostos();
                    $busq->__SET('ccosto_codigo',       $r->cc_codigo);
                    $busq->__SET('ccosto_nombre',       $r->cc_nombre);
                    $busq->__SET('ccosto_tipo',         $r->cc_tipo);
                    $busq->__SET('ccosto_estado',       $r->cc_estado);
                    $busq->__SET('ccosto_dep_codigo',   $r->cc_dependencia_codigo);
                    $busq->__SET('ccosto_dep_nombre',   $r->dependencia_nombre);                    
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
            $stm = $this->pdo->prepare("SELECT  cc.cc_codigo,
                                                cc.cc_nombre
                                        FROM centro_costos as cc 
                                        WHERE cc.cc_estado=1");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $fila = array('ccosto_codigo'=>$r->cc_codigo,
                              'ccosto_nombre'=>$r->cc_nombre);
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
            $jsonresponse['message'] = 'Error al listar los Centro de Costos';
        }
    }*/
}
?>