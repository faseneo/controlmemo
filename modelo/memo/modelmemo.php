<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("../config/config.php");
require_once("../modelo/conexion/conexion.php");

require_once('../modelo/memoarchivo/entidadmemoarchivo.php');
require_once("../modelo/memoarchivo/modelmemoarchivo.php");
require_once("../modelo/logs/modelologs.php");

class ModelMemo  {
    private $pdo;
    public $jsonresponse = array();

    public function __CONSTRUCT(){
        try{
          $conexion = new Conexion();
            $this->pdo = $conexion->connect();
        }catch(Exception $e){
            $logs = new modelologs();
            $trace=$e->getTraceAsString();
              $logs->GrabarLogs($e->getMessage(),$trace);
              $logs = null;
              return null;
        }
    }

    public function Listar(){
        try{
            $consulta = "SELECT COUNT(*) FROM memo";
            $res = $this->pdo->query($consulta);
            if ($res->fetchColumn() == 0) {
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Memo sin elementos';                
                $jsonresponse['datos'] = [];
            }else{
              $result = array();
              $stm = $this->pdo->prepare("SELECT * FROM memo");
              $stm->execute();
              foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                  $busq = new Memos();
                      $busq->__SET('mem_id', $r->memo_id);
                      $busq->__SET('mem_numero', $r->memo_num_memo);
                      $busq->__SET('mem_anio', $r->memo_anio);
                      $busq->__SET('mem_fecha', $r->memo_fecha_memo);
                      $busq->__SET('mem_fecha_recep', $r->memo_fecha_recepcion);
                      $busq->__SET('mem_materia', $r->memo_materia);
                      $busq->__SET('mem_nom_sol', $r->memo_nombre_solicitante);
                      $busq->__SET('mem_depto_sol_id', $r->memo_depto_solicitante_id);
                      $busq->__SET('mem_nom_dest', $r->memo_nombre_destinatario);
                      $busq->__SET('mem_depto_dest_id', $r->memo_depto_destinatario_id);
                      $busq->__SET('mem_estado_id', $r->memo_memo_estado_id);
                      $busq->__SET('mem_fecha_ingr', $r->memo_fecha_ingreso);
                  $result[] = $busq->returnArray();
              }
              $jsonresponse['success'] = true;
              $jsonresponse['message'] = 'listado correctamente los memos';
              $jsonresponse['datos'] = $result;
              $stm=null;
            }
            $res=null;
        } catch (PDOException $pdoException){
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al listar Memos';
            //$jsonresponse['errorQuery'] = $pdoException->getMessage();
            $logs = new modelologs();
            $trace=$pdoException->getTraceAsString();
              $logs->GrabarLogs($pdoException->getMessage(),$trace);
              $logs = null;
        }finally {
          $this->pdo=null;  
        }
        
        return $jsonresponse;
    }

    public function Obtener($id){
        try{
          $consulta = "SELECT COUNT(*) FROM memo";
            $res = $this->pdo->query($consulta);
            if ($res->fetchColumn() == 0) {
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Memo sin elementos';
                $jsonresponse['datos'] = [];
            }else{
              $stm = $this->pdo->prepare("SELECT  *
                                          FROM memo as mm
                                          WHERE mm.memo_id = ?");
              $stm->execute(array($id));
              $r = $stm->fetch(PDO::FETCH_OBJ);
              if($r){
                $busq = new Memos();
                          $busq->__SET('mem_id', $r->memo_id);
                          $busq->__SET('mem_numero', $r->memo_num_memo);
                          $busq->__SET('mem_anio', $r->memo_anio);
                          $busq->__SET('mem_fecha', $r->memo_fecha_memo);
                          $busq->__SET('mem_fecha_recep', $r->memo_fecha_recepcion);
                          $busq->__SET('mem_materia', $r->memo_materia);
                          $busq->__SET('mem_nom_sol', $r->memo_nombre_solicitante);
                          $busq->__SET('mem_depto_sol_id', $r->memo_depto_solicitante_id);
                          $busq->__SET('mem_nom_dest', $r->memo_nombre_destinatario);
                          $busq->__SET('mem_depto_dest_id', $r->memo_depto_destinatario_id);
                          $busq->__SET('mem_estado_id', $r->memo_memo_estado_id);
                          $busq->__SET('mem_fecha_ingr', $r->memo_fecha_ingreso);
                          $modelMemoArch = new ModelMemoArchivo();
                          $arrayfile = $modelMemoArch->listar($r->memo_id);
                          $busq->__SET('mem_archivos', $arrayfile['datos']);
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Se obtuvo el memo correctamente';
                $jsonresponse['datos'] = $busq->returnArray();
              }else{
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'NO exite el memo';
                $jsonresponse['datos'] = [];
              }
              $stm=null;
            }
            $res=null;
        } catch (Exception $e){
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener memos';
            $logs = new modelologs();
            $trace=$pdoException->getTraceAsString();
              $logs->GrabarLogs($pdoException->getMessage(),$trace);
              $logs = null;
        }
        $this->pdo=null;
        return $jsonresponse;
    }

    /* public function Eliminar($id){
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
    */
    public function Registrar(Memos $data, $files){

      try{
            $sql = "INSERT INTO memo (memo_num_memo,
                                      memo_anio,
                                      memo_fecha_memo,
                                      memo_fecha_recepcion,
                                      memo_materia,
                                      memo_nombre_solicitante,
                                      memo_depto_solicitante_id,
                                      memo_nombre_destinatario,
                                      memo_depto_destinatario_id,
                                      memo_memo_estado_id) 
                    VALUES (?,?,?,?,?,?,?,?,?,?)";

            /*$this->pdo->prepare($sql)->execute(array($data->__GET('mem_numero'),
                                                     $data->__GET('mem_anio'),
                                                     $data->__GET('mem_fecha'),
                                                     $data->__GET('mem_fecha_recep'),
                                                     $data->__GET('mem_materia'),
                                                     $data->__GET('mem_nom_sol'),
                                                     $data->__GET('mem_depto_sol_id'),
                                                     $data->__GET('mem_nom_dest'),
                                                     $data->__GET('mem_depto_dest_id'),
                                                     $data->__GET('mem_estado_id')
                                              ));*/
            var_dump($files);
            //$idmemo = $this->pdo->lastInsertId(); 
            $idmemo = 1;
            $modelMemoArch = new ModelMemoArchivo();
            $arrayfile = $modelMemoArch->Registrar($files,$idmemo,$data->__GET('mem_numero'),$data->__GET('mem_anio'));


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
/*
    public function Actualizar(Memos $data){
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
    }*/

  /*  public function Listar2(){
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
    }*/


}

?>

