<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../config/config.php");
class ModelMemoArch {
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
            $stm = $this->pdo->prepare("SELECT  ma.memo_archivo_id,
                                                ma.memo_archivo_url
                                        FROM memo_archivo as ma");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new MemoArchivos();
                    $busq->__SET('memo_arch_id', $r->memo_archivo_id);
                    $busq->__SET('memo_arch_url', $r->memo_archivo_url);                   
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
            $jsonresponse['message'] = 'Error al listar los memos archivos';
        }
    }

    public function Obtener($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                       ->prepare("SELECT ma.memo_archivo_id,
                                         ma.memo_archivo_url
                                FROM memo_archivo as ma
                                WHERE ma.memo_archivo_id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $busq = new MemoArchivos();
                    $busq->__SET('memo_arch_id', $r->memo_archivo_id);
                    $busq->__SET('memo_arch_url', $r->memo_archivo_url);

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Se obtuvo los memos archivos correctamente';
            $jsonresponse['datos'] = $busq->returnArray();
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener memos archivos';             
        }
        return $jsonresponse;
    }

    public function Eliminar($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                      ->prepare("DELETE FROM memo_archivo WHERE memo_archivo_id = ? ");
            $stm->execute(array($id));

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Memo archivo eliminado correctamente';              
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar memo archivo';            
        }
        return $jsonresponse;
    }

    public function Registrar(MemoArchivos $data){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO memo_archivo (memo_archivo_url) 
                    VALUES (?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('memo_arch_url'))
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Memo archivo ingresado correctamente'; 
        } catch (PDOException $pdoException){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar memo archivo';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            var_dump($jsonresponse);
        }
        return $jsonresponse;
    }

    public function Actualizar(MemoArchivos $data){
        $jsonresponse = array();
        //print_r($data);
        try{
            $sql = "UPDATE memo_archivo SET  
                           memo_archivo_url = ?
                    WHERE  memo_archivo_id = ?";

            $this->pdo->prepare($sql)
                 ->execute(array($data->__GET('memo_arch_url'),
                                 $data->__GET('memo_arch_id')) 
                          );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Memo archivo actualizado correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar memo archivo';             
        }
        return $jsonresponse;
    }

    public function Listar2(){
        $jsonresponse = array();
        try{
            $result = array();
             $stm = $this->pdo->prepare("SELECT  ma.memo_archivo_id,
                                                 ma.memo_archivo_url
                                        FROM memo_archivo as ma");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new MemoArchivos();
                    $busq->__SET('memo_arch_id', $r->memo_archivo_id);
                    $busq->__SET('memo_arch_url', $r->memo_archivo_url);
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