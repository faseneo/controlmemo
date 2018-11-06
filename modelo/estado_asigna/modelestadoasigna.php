<?php
    error_reporting( -1 );
    ini_set( 'display_startup_errors', 1 );
    ini_set( 'display_errors', 1 );

require_once("../config/config.php");
class ModelEstadoAsigna {
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
            $stm = $this->pdo->prepare("SELECT  ea.estado_asignacion_id,
                                                ea.estado_asignacion_texto
                                        FROM estado_asignacion as ea");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new EstadoAsigna();
                    $busq->__SET('est_asigna_id',       $r->estado_asignacion_id);
                    $busq->__SET('est_asigna_texto',    $r->estado_asignacion_texto);
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
            $jsonresponse['message'] = 'Error al listar Estados Asignacion';
        }
    }

    public function Obtener($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                       ->prepare("SELECT ea.estado_asignacion_id,
                                         ea.estado_asignacion_texto
                                FROM estado_asignacion as ea
                                WHERE ea.estado_asignacion_id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $busq = new EstadoAsigna();
                    $busq->__SET('est_asigna_id',       $r->estado_asignacion_id);
                    $busq->__SET('est_asigna_texto',    $r->estado_asignacion_texto);

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
                      ->prepare("DELETE FROM estado_asignacion WHERE estado_asignacion_id = ? ");
            $stm->execute(array($id));

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Estados Asignacion eliminado correctamente';              
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar Estados Asignacion';            
        }
        return $jsonresponse;
    }

    public function Registrar(EstadoAsigna $data){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO estado_asignacion (estado_asignacion_texto) 
                    VALUES (?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('est_asigna_texto'))
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

    public function Actualizar(EstadoAsigna $data){
        $jsonresponse = array();
        //print_r($data);
        try{
            $sql = "UPDATE estado_asignacion SET 
                           estado_asignacion_texto = ?
                    WHERE  estado_asignacion_id = ?";

            $this->pdo->prepare($sql)
                 ->execute(array($data->__GET('est_asigna_texto'), 
                                 $data->__GET('est_asigna_id'))
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
             $stm = $this->pdo->prepare("SELECT  ea.estado_asignacion_id,
                                                 ea.estado_asignacion_texto
                                        FROM estado_asignacion as ea");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new EstadoAsigna();
                    $busq->__SET('est_asigna_id',       $r->estado_asignacion_id);
                    $busq->__SET('est_asigna_texto',    $r->estado_asignacion_texto);
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