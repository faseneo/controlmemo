<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../config/config.php");
class ModelCentroCostos {
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
            $stm = $this->pdo->prepare("SELECT  cc.cc_codigo,
                                                cc.cc_nombre,
                                                cc.cc_dependencia_codigo,
                                                dep.dependencia_nombre
                                        FROM centro_costos as cc, dependencia as dep
                                        WHERE cc.cc_dependencia_codigo = dep.dependencia_codigo ");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new CentroCostos();
                    $busq->__SET('ccosto_codigo',       $r->cc_codigo);
                    $busq->__SET('ccosto_nombre',       $r->cc_nombre);
                    $busq->__SET('ccosto_dep_codigo',   $r->cc_dependencia_codigo);
                    $busq->__SET('ccosto_dep_nombre',   $r->dependencia_nombre);
                $result[] = $busq->returnArray();
            }
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'listado correctamente';
            $jsonresponse['datos'] = $result;
            return $jsonresponse;
        }
        catch(Exception $e){
            die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al listar los Centro de Costos';
        }
    }

    public function Obtener($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo->prepare("SELECT  cc.cc_codigo,
                                                cc.cc_nombre,
                                                cc.cc_dependencia_codigo,
                                                dep.dependencia_nombre
                                        FROM centro_costos as cc, dependencia as dep
                                        WHERE cc.cc_dependencia_codigo = dep.dependencia_codigo
                                        AND cc.cc_codigo = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $busq = new CentroCostos();
                    $busq->__SET('ccosto_codigo', $r->cc_codigo);
                    $busq->__SET('ccosto_nombre', $r->cc_nombre);
                    $busq->__SET('ccosto_dep_codigo', $r->cc_dependencia_codigo);
                    $busq->__SET('ccosto_dep_nombre',   $r->dependencia_nombre);

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Se obtuvo los Centros de Costos correctamente';
            $jsonresponse['datos'] = $busq->returnArray();
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener Centro de Costos';             
        }
        return $jsonresponse;
    }

    public function Eliminar($id){
        $jsonresponse = array();
        try{    
                                        //"DELETE FROM centro_costos WHERE cc_codigo = ? AND cc_dependencia_codigo = ?"
            $stm = $this->pdo->prepare("DELETE FROM centro_costos WHERE cc_codigo = ? ");
            $stm->execute(array($id));

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Centro de Costos eliminado correctamente';              
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar Centro de Costos';            
        }
        return $jsonresponse;
    }

    public function Registrar(CentroCostos $data){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO centro_costos (cc_codigo, cc_nombre, cc_dependencia_codigo) 
                    VALUES (?,?,?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('ccosto_codigo'),
                                                     $data->__GET('ccosto_nombre'),
                                                     $data->__GET('ccosto_dep_codigo'))
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Centro de Costos ingresado correctamente'; 
        } catch (PDOException $pdoException){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar Centro de Costos';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            var_dump($jsonresponse);
        }
        return $jsonresponse;
    }

    public function Actualizar(CentroCostos $data){
        $jsonresponse = array();
        //print_r($data);
        try{
            $sql = "UPDATE centro_costos SET 
                           cc_codigo = ?,
                           cc_nombre = ?,
                           cc_dependencia_codigo = ?
                    WHERE  cc_codigo = ? AND  cc_dependencia_codigo=? ";

            $this->pdo->prepare($sql)->execute(array($data->__GET('ccosto_codigo'),
                                                     $data->__GET('ccosto_nombre'), 
                                                     $data->__GET('ccosto_dep_codigo'),
                                                     $data->__GET('ccosto_codigo'),
                                                     $data->__GET('ccosto_dep_codigo')
                                                     )
                                                );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Centro de Costos actualizado correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar Centro de Costos';             
        }
        return $jsonresponse;
    }

    public function Listar2(){
        $jsonresponse = array();
        try{
            $result = array();
             $stm = $this->pdo->prepare("SELECT  cc.cc_codigo,
                                                 cc.cc_nombre,
                                                 cc.cc_dependencia_codigo
                                        FROM centro_costos as cc");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new CentroCostos();
                    $busq->__SET('ccosto_codigo', $r->cc_codigo);
                    $busq->__SET('ccosto_nombre', $r->cc_nombre);
                    $busq->__SET('ccosto_dep_codigo', $r->cc_dependencia_codigo); 
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
            $stm = $this->pdo->prepare("SELECT  cc.cc_codigo,
                                                cc.cc_nombre
                                        FROM centro_costos as cc");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new CentroCostos();
                    $busq->__SET('ccosto_codigo',       $r->cc_codigo);
                    $busq->__SET('ccosto_nombre',       $r->cc_nombre);
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
            $jsonresponse['message'] = 'Error al listar los Centro de Costos';
        }
    }
}
?>