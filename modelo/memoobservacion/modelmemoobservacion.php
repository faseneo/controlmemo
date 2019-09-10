<?php
    error_reporting( -1 );
    ini_set( 'display_startup_errors', 1 );
    ini_set( 'display_errors', 1 );

require_once("../config/config.php");
class ModelMemoObservacion {
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

    public function Listar($idmemo=NULL){
        $jsonresponse = array();
        try{
            if($idmemo!=NULL){
                $consulta = "SELECT COUNT(*) FROM memo_observaciones AS mo WHERE mo.memo_observaciones_memo_id = ".$idmemo;
                $res = $this->pdo->query($consulta);
                if ($res->fetchColumn() == 0) {
                    $jsonresponse['success'] = true;
                    $jsonresponse['message'] = 'Memo sin observaciones';
                    $jsonresponse['datos'] = [];
                }else{
                    $result = array();
                    $stm = $this->pdo->prepare("SELECT mo.memo_observaciones_id, mo.memo_observaciones_texto, mo.memo_observaciones_fecha,mo.memo_observaciones_memo_id, mo.memo_observaciones_usuario_id, us.usuario_email
                                                FROM memo_observaciones AS mo , usuario AS us
                                                WHERE mo.memo_observaciones_usuario_id = us.usuario_id
                                                AND  mo.memo_observaciones_memo_id = ".$idmemo);

                    $stm->execute();
                    foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                        $busq = new MemoObservacion();
                            $busq->__SET('memoobs_id',          $r->memo_observaciones_id);
                            $busq->__SET('memoobs_texto',       $r->memo_observaciones_texto);
                            $busq->__SET('memoobs_fecha', date_format(date_create($r->memo_observaciones_fecha),'d-m-Y' ));
                            //$busq->__SET('memoobs_fecha',       $r->memo_observaciones_fecha);
                            $busq->__SET('memoobs_memo_id',     $r->memo_observaciones_memo_id);
                            $busq->__SET('memoobs_usu_id',  $r->memo_observaciones_usuario_id);
                            $busq->__SET('memoobs_usu_nom',  $r->usuario_email);
                        $result[] = $busq->returnArray();
                    }
                    $jsonresponse['success'] = true;
                    $jsonresponse['message'] = 'listado obs. memo correctamente';
                    $jsonresponse['datos'] = $result;
                }
            }else{
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Memo sin otras observaciones';
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

    public function Obtener($id){
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
    }

    public function Eliminar($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo->prepare("DELETE FROM memo_observaciones WHERE memo_observaciones_id = ? ");
            $stm->execute(array($id));

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Observacion eliminada correctamente';              
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar Obs. Memo';            
        }
        return $jsonresponse;
    }

    public function Registrar(MemoObservacion $data){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO memo_observaciones (memo_observaciones_texto, memo_observaciones_memo_id,memo_observaciones_usuario_id) 
                    VALUES (?,?,?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('memoobs_texto'),
                                                     $data->__GET('memoobs_memo_id'),
                                                     $data->__GET('memoobs_usu_id')
                                                     )
                                              );
            require_once("../modelo/usuario/modelusuario.php");
                          $modelUsu = new ModelUsuarios();
                          $arraydatos = $modelUsu->ObtenerAsignaMemo($data->__GET('memoobs_memo_id'));
                            if(count($arraydatos["datos"]) > 0){
                                for($i=0; $i<count($arraydatos["datos"]); $i++){
                                      if($arraydatos["datos"][$i]["asigna_usu_uid"]==$data->__GET('memoobs_usu_id') && $arraydatos["datos"][$i]["asigna_usu_estado_id"]==2){
                                        $modelUsu->CambiaEstadoAsignaMemo($data->__GET('memoobs_usu_id'),$data->__GET('memoobs_memo_id'),3);
                                            require_once("../modelo/memoestado/entidadmemocambioestado.php");
                                            require_once("../modelo/memoestado/modelmemoestado.php");
                                            $objcambioest = new MemoCambioEst();
                                            $modelcambioest = new ModelMemoEst();
                                            $resp= $modelcambioest->ObtieneEstadoMemoId($data->__GET('memoobs_memo_id'),27);
                                            if($resp==FALSE){
                                              $objcambioest->__SET('memo_camest_memid',$data->__GET('memoobs_memo_id'));
                                              $objcambioest->__SET('memo_camest_estid',27);
                                              $objcambioest->__SET('memo_camest_obs','Ingreso de datos al memo');
                                              $objcambioest->__SET('memo_camest_usuid',$data->__GET('memoobs_usu_id'));
                                                $modelcambioest->CambiaEstado($objcambioest, 26, 87);
                                            }
                                      }
                                }
                            }
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'obs. memos ingresado correctamente'; 
        } catch (PDOException $pdoException){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar obs. memos';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            var_dump($jsonresponse);
        }
        return $jsonresponse;
    }

    public function Actualizar(MemoObservacion $data){
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
    }

     public function ListarMin($idmemo=NULL){
        $jsonresponse = array();
        try{
            if($idmemo!=NULL){
                $consulta = "SELECT COUNT(*) FROM memo_observaciones AS mo WHERE memo_observaciones_memo_id = ".$idmemo;
                $res = $this->pdo->query($consulta);
                if ($res->fetchColumn() == 0) {
                    $jsonresponse['success'] = true;
                    $jsonresponse['message'] = 'Memo sin otras observaciones';
                    $jsonresponse['datos'] = [];
                }else{
                    $result = array();
                    $stm = $this->pdo->prepare("SELECT * FROM memo_observaciones AS mo WHERE memo_observaciones_memo_id = ".$idmemo);

                    $stm->execute();
                    foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                        $fila = array('memoobs_id'=>$r->memo_observaciones_id,
                                      'memoobs_texto'=>$r->memo_observaciones_texto,
                                      'memoobs_usu_id'=>$r->memo_observaciones_usuario_id);
                        $result[]=$fila;
                    }
                    $jsonresponse['success'] = true;
                    $jsonresponse['message'] = 'listado obs. memo correctamente';
                    $jsonresponse['datos'] = $result;
                }
                return $jsonresponse;
            }else{
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Memo sin otras observaciones';
                $jsonresponse['datos'] = [];
            }
        }
        catch(Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al listar observaciones del memo';
        }
    }
























}
 

?>