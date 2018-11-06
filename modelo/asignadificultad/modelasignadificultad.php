<?php
    error_reporting( -1 );
    ini_set( 'display_startup_errors', 1 );
    ini_set( 'display_errors', 1 );

require_once("../config/config.php");
class ModelAsignaDificultad {
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
            $stm = $this->pdo->prepare("SELECT  ad.asigna_dificultad_id,
                                                ad.asigna_dificultad_texto
                                        FROM asigna_dificultad as ad");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new AsignaDificultad();
                    $busq->__SET('adificultad_id',       $r->asigna_dificultad_id);
                    $busq->__SET('adificultad_texto',    $r->asigna_dificultad_texto);
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
            $jsonresponse['message'] = 'Error al listar Asignacion Dificultad';
        }
    }

    public function Obtener($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                       ->prepare("SELECT ad.asigna_dificultad_id,
                                         ad.asigna_dificultad_texto
                                FROM asigna_dificultad as ad
                                WHERE ad.asigna_dificultad_id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $busq = new AsignaDificultad();
                    $busq->__SET('adificultad_id',       $r->asigna_dificultad_id);
                    $busq->__SET('adificultad_texto',    $r->asigna_dificultad_texto);

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
                      ->prepare("DELETE FROM asigna_dificultad WHERE asigna_dificultad_id = ? ");
            $stm->execute(array($id));

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Asignacion Dificultad eliminado correctamente';              
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar Asignacion Dificultad';            
        }
        return $jsonresponse;
    }

    public function Registrar(AsignaDificultad $data){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO asigna_dificultad (asigna_dificultad_texto) 
                    VALUES (?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('adificultad_texto'))
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

    public function Actualizar(AsignaDificultad $data){
        $jsonresponse = array();
        //print_r($data);
        try{
            $sql = "UPDATE asigna_dificultad SET 
                           asigna_dificultad_texto = ?
                    WHERE  asigna_dificultad_id = ?";

            $this->pdo->prepare($sql)
                 ->execute(array($data->__GET('adificultad_texto'), 
                                 $data->__GET('adificultad_id'))
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
             $stm = $this->pdo->prepare("SELECT  ad.asigna_dificultad_id,
                                                 ad.asigna_dificultad_texto
                                        FROM asigna_dificultad as ad");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new AsignaDificultad();
                    $busq->__SET('adificultad_id',       $r->asigna_dificultad_id);
                    $busq->__SET('adificultad_texto',    $r->asigna_dificultad_texto);
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