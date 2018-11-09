<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../config/config.php");
class ModelSeccion{
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
            $stm = $this->pdo->prepare("SELECT * FROM seccion");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new Seccion();
                    $busq->__SET('sec_id', $r->seccion_id);
                    $busq->__SET('sec_nombre', $r->seccion_nombre);
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
            $jsonresponse['message'] = 'Error al listar secciones';
        }
    }

    public function Obtener($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo->prepare("SELECT * FROM seccion as sec
                                        WHERE sec.seccion_id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $busq = new Seccion();
                $busq->__SET('sec_id', $r->seccion_id);
                    $busq->__SET('sec_nombre', $r->seccion_nombre);

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Se obtuvo seccion correctamente';
            $jsonresponse['datos'] = $busq->returnArray();
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener seccion';
        }
        return $jsonresponse;
    }

    public function Eliminar($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo->prepare("DELETE FROM seccion WHERE seccion_id = ? ");
            $stm->execute(array($id));

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Seccion eliminada correctamente';              
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar seccion';
        }
        return $jsonresponse;
    }

    public function Registrar(Seccion $data){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO seccion (seccion_nombre) 
                    VALUES (?)";

            $this->pdo->prepare($sql)->execute(array( $data->__GET('sec_nombre')
                                                    )
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Seccion ingresado correctamente'; 
        } catch (PDOException $pdoException){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar Seccion';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            var_dump($jsonresponse);
        }
        return $jsonresponse;
    }

    public function Actualizar(Seccion $data){
        $jsonresponse = array();
        //print_r($data);
        try{
            $sql = "UPDATE seccion SET 
                           seccion_nombre = ?
                    WHERE  seccion_id = ?";

            $this->pdo->prepare($sql)->execute(array($data->__GET('sec_nombre'),
                                                     $data->__GET('sec_id')
                                                    )
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Seccion actualizada correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar Seccion';             
        }
        return $jsonresponse;
    }

    public function Listar2(){
        $jsonresponse = array();
        try{
            $result = array();
             $stm = $this->pdo->prepare("SELECT * FROM seccion");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
               $busq = new Seccion();
                    $busq->__SET('sec_id', $r->seccion_id);
                    $busq->__SET('sec_nombre', $r->seccion_nombre);
                $result[] = $busq;
            }
            return $result;
        }catch(Exception $e){
            die($e->getMessage());
        }
    }


}

?>