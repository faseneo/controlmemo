<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../config/config.php");
class ModelProcCompra {
    private $pdo;

    public function __CONSTRUCT(){
        try{
            $this->pdo = new PDO("mysql:host=".HOST.";dbname=".DB, USERDB, PASSDB, array(PDO::MYSQL_ATTR_INIT_COMMAND => CHARSETDB));
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
            $stm = $this->pdo->prepare("SELECT  pc.proc_compra_id,
                                                pc.proc_compra_tipo,
						                        pc.proc_compra_orden,
                                                pc.proc_compra_descripcion,
                                                pc.proc_compra_activo
                                        FROM procedimiento_compra as pc
                                        ORDER BY pc.proc_compra_orden ASC");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new ProcCompra();
                    $busq->__SET('proc_comp_id',    $r->proc_compra_id);
                    $busq->__SET('proc_comp_tipo',  $r->proc_compra_tipo);
                    $busq->__SET('proc_orden',      $r->proc_compra_orden);
                    $busq->__SET('proc_descrip',    $r->proc_compra_descripcion);
                    $busq->__SET('proc_activo',     $r->proc_compra_activo);
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
            $jsonresponse['message'] = 'Error al listar procedimientos de compras';
        }
    }

    public function Obtener($id){
       $jsonresponse = array();
        try{
            $stm = $this->pdo->prepare("SELECT  pc.proc_compra_id,
                                                pc.proc_compra_tipo,
                                                pc.proc_compra_orden,
                                                pc.proc_compra_descripcion,
                                                pc.proc_compra_activo
                                        FROM procedimiento_compra as pc
                                        WHERE pc.proc_compra_id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);

            $busq = new ProcCompra();
                    $busq->__SET('proc_comp_id',    $r->proc_compra_id);
                    $busq->__SET('proc_comp_tipo',  $r->proc_compra_tipo);
                    $busq->__SET('proc_orden',      $r->proc_compra_orden);
                    $busq->__SET('proc_descrip',    $r->proc_compra_descripcion);
                    $busq->__SET('proc_activo',     $r->proc_compra_activo);

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Se obtuvo procedimiento de compra correctamente';
            $jsonresponse['datos'] = $busq->returnArray();
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener procedimiento de compra';             
        }
        return $jsonresponse;
    }

    public function Eliminar($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo->prepare("DELETE FROM procedimiento_compra WHERE proc_compra_id = ? ");
            $stm->execute(array($id));

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Procedimiento de compra eliminado correctamente';              
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar procedimiento de compra';            
        }
        return $jsonresponse;
    }

    public function Registrar(ProcCompra $data){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO procedimiento_compra (proc_compra_tipo, proc_compra_descripcion, proc_compra_orden, proc_compra_activo) 
                    VALUES (?,?,?,?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('proc_comp_tipo'),
                                                     $data->__GET('proc_descrip'),
							                         $data->__GET('proc_orden'),
                                                     $data->__GET('proc_activo')
                                                     )
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Procedimiento de compra ingresado correctamente'; 
        } catch (PDOException $pdoException){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar procedimiento de compra';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            var_dump($jsonresponse);
        }
        return $jsonresponse;
    }

    public function Actualizar(ProcCompra $data){
        $jsonresponse = array();
        //print_r($data);
        try{
            $sql = "UPDATE procedimiento_compra SET 
                           proc_compra_tipo = ?,
			               proc_compra_orden = ?,
                           proc_compra_descripcion = ?,
                           proc_compra_activo = ?                           
                    WHERE  proc_compra_id = ?";

            $this->pdo->prepare($sql)->execute(array($data->__GET('proc_comp_tipo'),
                                                     $data->__GET('proc_orden'),
                                                     $data->__GET('proc_descrip'),
                                                     $data->__GET('proc_activo'),                                                     
                                                     $data->__GET('proc_comp_id')
                                                    )
                                                );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Procedimiento de compra actualizado correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar procedimiento de compra';             
        }
        return $jsonresponse;
    }

    public function Listar2(){
        $jsonresponse = array();
        try{
            $result = array();
             $stm = $this->pdo->prepare("SELECT  pc.proc_compra_id,
                                                 pc.proc_compra_tipo,
                                                 pc.proc_compra_orden,
                                                 pc.proc_compra_descripcion,
                                                 pc.proc_compra_activo
                                        FROM procedimiento_compra as pc
                                        ORDER BY pc.proc_compra_orden ASC");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new ProcCompra();
                    $busq->__SET('proc_comp_id',    $r->proc_compra_id);
                    $busq->__SET('proc_comp_tipo',  $r->proc_compra_tipo);
                    $busq->__SET('proc_orden',     $r->proc_compra_orden);
                    $busq->__SET('proc_descrip',    $r->proc_compra_descripcion);
                    $busq->__SET('proc_activo',     $r->proc_compra_activo);
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
            $stm = $this->pdo->prepare("SELECT  pc.proc_compra_id,
                                                pc.proc_compra_tipo
                                        FROM procedimiento_compra as pc
                                        WHERE pc.proc_compra_activo=1
                                        ORDER BY pc.proc_compra_orden ASC");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $fila = array('proc_comp_id'=>$r->proc_compra_id,
                            'proc_comp_tipo'=>$r->proc_compra_tipo);
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
            $jsonresponse['message'] = 'Error al listar procedimientos de compras';
        }
    }    
}








?>