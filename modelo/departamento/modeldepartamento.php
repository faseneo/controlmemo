<?php
    error_reporting( -1 );
    ini_set( 'display_startup_errors', 1 );
    ini_set( 'display_errors', 1 );

require_once("../config/config.php");
class ModelDepartamento {
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
            $stm = $this->pdo->prepare("SELECT  dp.dpto_id,
                                                dp.dpto_nombre
                                        FROM departamento as dp");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new Departamentos();
                    $busq->__SET('depto_id',        $r->dpto_id);
                    $busq->__SET('depto_nombre',    $r->dpto_nombre);
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
            $jsonresponse['message'] = 'Error al listar Departamentos';
        }
    }

    public function Obtener($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                       ->prepare("SELECT dp.dpto_id,
                                         dp.dpto_nombre
                                FROM departamento as dp
                                WHERE dp.dpto_id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $busq = new Departamentos();
                    $busq->__SET('depto_id',        $r->dpto_id);
                    $busq->__SET('depto_nombre',    $r->dpto_nombre);

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Se obtuvo los Departamentos correctamente';
            $jsonresponse['datos'] = $busq->returnArray();
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener Departamentos';             
        }
        return $jsonresponse;
    }

    public function Eliminar($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                      ->prepare("DELETE FROM departamento WHERE dpto_id = ? ");
            $stm->execute(array($id));

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Departamento eliminado correctamente';              
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar Departamento';            
        }
        return $jsonresponse;
    }

    public function Registrar(Departamentos $data){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO departamento (dpto_nombre) 
                    VALUES (?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('depto_nombre'))
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Departamento ingresado correctamente'; 
        } catch (PDOException $pdoException){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar Departamento';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            var_dump($jsonresponse);
        }
        return $jsonresponse;
    }

    public function Actualizar(Departamentos $data){
        $jsonresponse = array();
        //print_r($data);
        try{
            $sql = "UPDATE departamento SET 
                           dpto_nombre = ?
                    WHERE  dpto_id = ?";

            $this->pdo->prepare($sql)
                 ->execute(array($data->__GET('depto_nombre'), 
                                 $data->__GET('depto_id'))
                          );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Departamento actualizado correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar Departamento';             
        }
        return $jsonresponse;
    }

    public function Listar2(){
        $jsonresponse = array();
        try{
            $result = array();
             $stm = $this->pdo->prepare("SELECT  dp.dpto_id,
                                                 dp.dpto_nombre
                                        FROM departamento as dp");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new Departamentos();
                    $busq->__SET('depto_id',     $r->dpto_id);
                    $busq->__SET('depto_nombre', $r->dpto_nombre);
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