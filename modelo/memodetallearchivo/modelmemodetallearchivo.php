<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../config/config.php");
class ModelMemoDetArchivo {
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
            $stm = $this->pdo->prepare("SELECT  md.memo_det_archivo_id,
                                                md.memo_det_archivo_url
                                        FROM memo_detalle_archivo as md");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new MemoDetArchivo();
                    $busq->__SET('memo_det_arch_id', $r->memo_det_archivo_id);
                    $busq->__SET('memo_det_arch_url', $r->memo_det_archivo_url);                    
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
            $jsonresponse['message'] = 'Error al listar memos detalles archivos';
        }
    }

    public function Obtener($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                       ->prepare("SELECT md.memo_det_archivo_id,
                                         md.memo_det_archivo_url
                                FROM memo_detalle_archivo as md
                                WHERE md.memo_det_archivo_id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $busq = new MemoDetArchivo();
                    $busq->__SET('memo_det_arch_id', $r->memo_det_archivo_id);
                    $busq->__SET('memo_det_arch_url', $r->memo_det_archivo_url);

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Se obtuvo memo detalle archivos correctamente';
            $jsonresponse['datos'] = $busq->returnArray();
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener memo detalle archivos';             
        }
        return $jsonresponse;
    }

    public function Eliminar($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                      ->prepare("DELETE FROM memo_detalle_archivo WHERE memo_det_archivo_id = ? ");
            $stm->execute(array($id));

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Memo detalle archivo eliminado correctamente';              
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar memo detalle archivo';            
        }
        return $jsonresponse;
    }

    public function Registrar(MemoDetArchivo $data){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO memo_detalle_archivo (memo_det_archivo_url) 
                    VALUES (?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('memo_det_arch_url'))
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Memo detalle archivo ingresado correctamente'; 
        } catch (PDOException $pdoException){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar memo detalle archivo';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            var_dump($jsonresponse);
        }
        return $jsonresponse;
    }

    public function Actualizar(MemoDetArchivo $data){
        $jsonresponse = array();
        //print_r($data);
        try{
            $sql = "UPDATE memo_detalle_archivo SET  
                           memo_det_archivo_url = ?
                    WHERE  memo_det_archivo_id = ?";

            $this->pdo->prepare($sql)
                 ->execute(array($data->__GET('memo_det_arch_url'),
                                 $data->__GET('memo_det_arch_id'))
                          );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Memo detalle archivo actualizado correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar memo detalle archivo';             
        }
        return $jsonresponse;
    }

    public function Listar2(){
        $jsonresponse = array();
        try{
            $result = array();
             $stm = $this->pdo->prepare("SELECT  md.memo_det_archivo_id,
                                                 md.memo_det_archivo_url
                                        FROM memo_detalle_archivo as md");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new MemoDetArchivo();
                    $busq->__SET('memo_det_arch_id', $r->memo_det_archivo_id);
                    $busq->__SET('memo_det_arch_url', $r->memo_det_archivo_url); 
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