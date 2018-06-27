<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../config/config.php");
class ModelProveedores{
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
            $stm = $this->pdo->prepare("SELECT  pp.proveedor_id,
                                                pp.proveedor_nombre,
                                                pp.proveedor_rut
                                        FROM proveedor as pp");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new Proveedores();
                    $busq->__SET('prov_id', $r->proveedor_id);
                    $busq->__SET('prov_nombre', $r->proveedor_nombre);
                    $busq->__SET('prov_rut', $r->proveedor_rut);                    
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
            $jsonresponse['message'] = 'Error al listar proveedores';
        }
    }

    public function Obtener($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                       ->prepare("SELECT  pp.proveedor_id,
                                          pp.proveedor_nombre,
                                          pp.proveedor_rut
                                FROM proveedor as pp
                                WHERE pp.proveedor_id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $busq = new Proveedores();
                    $busq->__SET('prov_id', $r->proveedor_id);
                    $busq->__SET('prov_nombre', $r->proveedor_nombre);
                    $busq->__SET('prov_rut', $r->proveedor_rut); 

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Se obtuvo los proveedores correctamente';
            $jsonresponse['datos'] = $busq->returnArray();
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener proveedores';             
        }
        return $jsonresponse;
    }

    public function Eliminar($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                      ->prepare("DELETE FROM proveedor WHERE proveedor_id = ? ");
            $stm->execute(array($id));

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Proveedor eliminado correctamente';              
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar proveedor';            
        }
        return $jsonresponse;
    }

    public function Registrar(Proveedores $data){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO proveedor (proveedor_nombre, proveedor_rut) 
                    VALUES (?,?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('prov_nombre'),
                                                     $data->__GET('prov_rut'))
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Proveedor ingresado correctamente'; 
        } catch (PDOException $pdoException){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar proveedor';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            var_dump($jsonresponse);
        }
        return $jsonresponse;
    }

    public function Actualizar(Proveedores $data){
        $jsonresponse = array();
        //print_r($data);
        try{
            $sql = "UPDATE proveedor SET 
                           proveedor_nombre = ?, 
                           proveedor_rut = ?
                    WHERE  proveedor_id = ?";

            $this->pdo->prepare($sql)
                 ->execute(array($data->__GET('prov_nombre'), 
                                 $data->__GET('prov_rut'),
                                 $data->__GET('prov_id')) 
                          ); 
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Proveedor actualizado correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar proveedor';             
        }
        return $jsonresponse;
    }

    public function Listar2(){
        $jsonresponse = array();
        try{
            $result = array();
             $stm = $this->pdo->prepare("SELECT pp.proveedor_id,
                                                pp.proveedor_nombre,
                                                pp.proveedor_rut
                                        FROM proveedor as pp");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new Proveedores();
                    $busq->__SET('prov_id', $r->proveedor_id);
                    $busq->__SET('prov_nombre', $r->proveedor_nombre);
                    $busq->__SET('prov_rut', $r->proveedor_rut); 
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