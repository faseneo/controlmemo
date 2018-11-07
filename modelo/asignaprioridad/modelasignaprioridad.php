<?php
    error_reporting( -1 );
    ini_set( 'display_startup_errors', 1 );
    ini_set( 'display_errors', 1 );

require_once("../config/config.php");
class ModelAsignaPrioridad {
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
            $stm = $this->pdo->prepare("SELECT  ad.asigna_prioridad_id,
                                                ad.asigna_prioridad_texto
                                        FROM asigna_prioridad as ad");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new AsignaPrioridad();
                    $busq->__SET('aprioridad_id',       $r->asigna_prioridad_id);
                    $busq->__SET('aprioridad_texto',    $r->asigna_prioridad_texto);
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
            $jsonresponse['message'] = 'Error al listar Asignacion Prioridad';
        }
    }

    public function Obtener($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                       ->prepare("SELECT ad.asigna_prioridad_id,
                                         ad.asigna_prioridad_texto
                                FROM asigna_prioridad as ad
                                WHERE ad.asigna_prioridad_id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $busq = new AsignaPrioridad();
                    $busq->__SET('aprioridad_id',       $r->asigna_prioridad_id);
                    $busq->__SET('aprioridad_texto',    $r->asigna_prioridad_texto);

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Se obtuvo el Estado Asignacion correctamente';
            $jsonresponse['datos'] = $busq->returnArray();
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener Estado Asignacion';             
        }
        return $jsonresponse;
    }

    public function Eliminar($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                      ->prepare("DELETE FROM asigna_prioridad WHERE asigna_prioridad_id = ? ");
            $stm->execute(array($id));

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Asignacion Prioridad eliminado correctamente';              
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar Asignacion Prioridad';            
        }
        return $jsonresponse;
    }

    public function Registrar(AsignaPrioridad $data){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO asigna_prioridad (asigna_prioridad_texto) 
                    VALUES (?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('aprioridad_texto'))
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Estado Asignacion ingresado correctamente'; 
        } catch (PDOException $pdoException){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar Estado Asignacion';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            var_dump($jsonresponse);
        }
        return $jsonresponse;
    }

    public function Actualizar(AsignaPrioridad $data){
        $jsonresponse = array();
        //print_r($data);
        try{
            $sql = "UPDATE asigna_prioridad SET 
                           asigna_prioridad_texto = ?
                    WHERE  asigna_prioridad_id = ?";

            $this->pdo->prepare($sql)
                 ->execute(array($data->__GET('aprioridad_texto'), 
                                 $data->__GET('aprioridad_id'))
                          );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Estado Asignacion actualizado correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar Estado Asignacion';             
        }
        return $jsonresponse;
    }

    public function Listar2(){
        $jsonresponse = array();
        try{
            $result = array();
             $stm = $this->pdo->prepare("SELECT  ad.asigna_prioridad_id,
                                                 ad.asigna_prioridad_texto
                                        FROM asigna_prioridad as ad");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new AsignaPrioridad();
                    $busq->__SET('aprioridad_id',       $r->asigna_prioridad_id);
                    $busq->__SET('aprioridad_texto',    $r->asigna_prioridad_texto);
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