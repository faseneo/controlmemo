<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../config/config.php");
class ModelDependencia {
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
            $stm = $this->pdo->prepare("SELECT  dep.dependencia_codigo,
                                                dep.dependencia_nombre
                                        FROM dependencia as dep
                                        WHERE dep.dependencia_estado=1");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new Dependencia();
                    $busq->__SET('dep_codigo', $r->dependencia_codigo);
                    $busq->__SET('dep_nombre', $r->dependencia_nombre);
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
            $jsonresponse['message'] = 'Error al listar Dependencia';
        }
    }

    public function Obtener($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                       ->prepare("SELECT  dep.dependencia_codigo,
                                          dep.dependencia_nombre
                                FROM dependencia as dep
                                WHERE dep.dependencia_codigo = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $busq = new Dependencia();
                 $busq->__SET('dep_codigo', $r->dependencia_codigo);
                 $busq->__SET('dep_nombre', $r->dependencia_nombre);

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Se obtuvo las Dependencia correctamente';
            $jsonresponse['datos'] = $busq->returnArray();
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener Dependencia';             
        }
        return $jsonresponse;
    }

    public function Eliminar($id){
        $jsonresponse = array();
        try{    
                                        //"DELETE FROM dependencia WHERE dependencia_codigo = ? AND cc_dependencia_codigo = ?"
            $stm = $this->pdo->prepare("DELETE FROM dependencia WHERE dependencia_codigo = ? ");
            $stm->execute(array($id));

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Dependencia eliminada correctamente';              
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar Dependencia';            
        }
        return $jsonresponse;
    }

    public function Registrar(Dependencia $data){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO dependencia (dependencia_codigo, dependencia_nombre) 
                    VALUES (?,?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('dep_codigo'),
                                                     $data->__GET('dep_nombre'))
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Dependencia ingresada correctamente'; 
        } catch (PDOException $pdoException){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar Dependencia';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            var_dump($jsonresponse);
        }
        return $jsonresponse;
    }

    public function Actualizar(Dependencia $data){
        $jsonresponse = array();
        //print_r($data);
        try{
            $sql = "UPDATE dependencia SET 
                           dependencia_codigo = ?,
                           dependencia_nombre = ?
                    WHERE  dependencia_codigo = ?";

            $this->pdo->prepare($sql)->execute(array($data->__GET('dep_codigo'),
                                                     $data->__GET('dep_nombre'), 
                                                     $data->__GET('dep_codigo'))
                                                );

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Dependencia actualizada correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar Dependencia';             
        }
        return $jsonresponse;
    }

    public function Listar2(){
        $jsonresponse = array();
        try{
            $result = array();
             $stm = $this->pdo->prepare("SELECT  dep.dependencia_codigo,
                                                 dep.dependencia_nombre
                                        FROM dependencia as dep");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new Dependencia();
                    $busq->__SET('dep_codigo', $r->dependencia_codigo);
                    $busq->__SET('dep_nombre', $r->dependencia_nombre);
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