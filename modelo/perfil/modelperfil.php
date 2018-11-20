<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../config/config.php");
class ModelUsuPerfil {
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
            $stm = $this->pdo->prepare("SELECT  per.perfiles_id,
                                                per.perfiles_nombre,
                                                per.perfiles_descripcion
                                        FROM perfiles as per");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new UsuPerfil();
                    $busq->__SET('perf_id',     $r->perfiles_id);
                    $busq->__SET('perf_nombre', $r->perfiles_nombre);
                    $busq->__SET('perf_desc', $r->perfiles_descripcion);
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
            $jsonresponse['message'] = 'Error al listar usuario perfiles';
        }
    }

    public function Obtener($id){

        $jsonresponse = array();
        try{
            $stm = $this->pdo
                       ->prepare("SELECT per.perfiles_id,
                                         per.perfiles_nombre,
                                         per.perfiles_descripcion
                                FROM perfiles as per
                                WHERE per.perfiles_id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $busq = new UsuPerfil();
                    $busq->__SET('perf_id',     $r->perfiles_id);
                    $busq->__SET('perf_nombre', $r->perfiles_nombre);
                    $busq->__SET('perf_desc',   $r->perfiles_descripcion);

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Se obtuvo los usuario perfiles correctamente';
            $jsonresponse['datos'] = $busq->returnArray();

        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener usuario perfiles';             
        }
        return $jsonresponse;
    }

    public function Eliminar($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                      ->prepare("DELETE FROM perfiles WHERE perfiles_id = ? ");
            $stm->execute(array($id));

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Usuario perfiles eliminado correctamente';              
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar usuario perfiles';            
        }
        return $jsonresponse;
    }

    public function Registrar(UsuPerfil $data){
        //var_dump($data);
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO perfiles (perfiles_nombre,perfiles_descripcion) 
                    VALUES (?,?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('perf_nombre'),
                                                     $data->__GET('perf_desc'))
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Usuario perfiles ingresado correctamente'; 
        } catch (PDOException $pdoException){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar usuario perfiles';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            var_dump($jsonresponse);
        }
        return $jsonresponse;
    }

    public function Actualizar(UsuPerfil $data){
        $jsonresponse = array();
        //print_r($data);
        try{
            $sql = "UPDATE perfiles SET 
                           perfiles_nombre = ?,
                           perfiles_descripcion= ?
                    WHERE  perfiles_id = ?";

            $this->pdo->prepare($sql)
                 ->execute(array($data->__GET('perf_nombre'),
                                 $data->__GET('perf_desc'),
                                 $data->__GET('perf_id'))
                          );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Usuario perfiles actualizado correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar usuario perfiles';             
        }
        return $jsonresponse;
    }

    public function Listar2(){
        $jsonresponse = array();
        try{
            $result = array();
             $stm = $this->pdo->prepare("SELECT  per.perfiles_id,
                                                 per.perfiles_nombre,
                                                 per.perfiles_descripcion
                                        FROM perfiles as per");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new UsuPerfil();
                    $busq->__SET('perf_id',     $r->perfiles_id);
                    $busq->__SET('perf_nombre', $r->perfiles_nombre);
                    $busq->__SET('perf_desc',   $r->perfiles_descripcion); 
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