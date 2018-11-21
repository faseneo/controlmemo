<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../config/config.php");
require_once("../modelo/logs/modelologs.php");

class ModelProveedores{
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
            $stm = $this->pdo->prepare("SELECT  pp.proveedor_id,
                                                pp.proveedor_nombre,
                                                pp.proveedor_rut,
                                                pp.proveedor_direccion,
                                                pp.proveedor_fono,
                                                pp.proveedor_ciudad,
                                                pp.proveedor_region,
                                                pp.proveedor_cuenta,
                                                pp.proveedor_contacto_nombre,
                                                pp.proveedor_contacto_email,
                                                pp.proveedor_contacto_fono,
                                                pp.proveedor_estado
                                        FROM proveedor as pp");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new Proveedores();
                    $busq->__SET('prov_id',                 $r->proveedor_id);
                    $busq->__SET('prov_nombre',             $r->proveedor_nombre);
                    $busq->__SET('prov_rut',                $r->proveedor_rut);
                    $busq->__SET('prov_direccion',          $r->proveedor_direccion);
                    $busq->__SET('prov_fono',               $r->proveedor_fono);
                    $busq->__SET('prov_ciudad',             $r->proveedor_ciudad);
                    $busq->__SET('prov_region',             $r->proveedor_region);
                    $busq->__SET('prov_cuenta',             $r->proveedor_cuenta);
                    $busq->__SET('prov_contacto_nombre',    $r->proveedor_contacto_nombre);
                    $busq->__SET('prov_contacto_email',     $r->proveedor_contacto_email);
                    $busq->__SET('prov_contacto_fono',      $r->proveedor_contacto_fono);
                    $busq->__SET('prov_estado',             $r->proveedor_estado);

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
            $stm = $this->pdo->prepare("SELECT  pp.proveedor_id,
                                                pp.proveedor_nombre,
                                                pp.proveedor_rut,
                                                pp.proveedor_direccion,
                                                pp.proveedor_fono,
                                                pp.proveedor_ciudad,
                                                pp.proveedor_region,
                                                pp.proveedor_cuenta,
                                                pp.proveedor_contacto_nombre,
                                                pp.proveedor_contacto_email,
                                                pp.proveedor_contacto_fono,
                                                pp.proveedor_estado
                                        FROM proveedor as pp
                                        WHERE pp.proveedor_id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $busq = new Proveedores();
                    $busq->__SET('prov_id',                 $r->proveedor_id);
                    $busq->__SET('prov_nombre',             $r->proveedor_nombre);
                    $busq->__SET('prov_rut',                $r->proveedor_rut);
                    $busq->__SET('prov_direccion',          $r->proveedor_direccion);
                    $busq->__SET('prov_fono',               $r->proveedor_fono);
                    $busq->__SET('prov_ciudad',             $r->proveedor_ciudad);
                    $busq->__SET('prov_region',             $r->proveedor_region);
                    $busq->__SET('prov_cuenta',             $r->proveedor_cuenta);
                    $busq->__SET('prov_contacto_nombre',    $r->proveedor_contacto_nombre);
                    $busq->__SET('prov_contacto_email',     $r->proveedor_contacto_email);
                    $busq->__SET('prov_contacto_fono',      $r->proveedor_contacto_fono);
                    $busq->__SET('prov_estado',             $r->proveedor_estado);

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
            $sql = "INSERT INTO proveedor (proveedor_nombre, proveedor_rut,proveedor_direccion,proveedor_fono,proveedor_ciudad,proveedor_region,proveedor_cuenta,proveedor_contacto_nombre,proveedor_contacto_email,proveedor_contacto_fono,proveedor_estado) 
                    VALUES (?,?,?,?,?,?,?,?,?,?,?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('prov_nombre'),
                                                     $data->__GET('prov_rut'),
                                                     $data->__GET('prov_direccion'),
                                                     $data->__GET('prov_fono'),
                                                     $data->__GET('prov_ciudad'),
                                                     $data->__GET('prov_region'),
                                                     $data->__GET('prov_cuenta'),
                                                     $data->__GET('prov_contacto_nombre'),
                                                     $data->__GET('prov_contacto_email'),
                                                     $data->__GET('prov_contacto_fono'),
                                                     $data->__GET('prov_estado')
                                                     )
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
                           proveedor_rut = ?,
                           proveedor_direccion = ?,
                           proveedor_fono = ?,
                           proveedor_ciudad = ?,
                           proveedor_region = ?,
                           proveedor_cuenta = ?,
                           proveedor_contacto_nombre = ?,
                           proveedor_contacto_email = ?,
                           proveedor_contacto_fono = ?,
                           proveedor_estado = ?
                    WHERE  proveedor_id = ?";

            $this->pdo->prepare($sql)->execute(array( $data->__GET('prov_nombre'),
                                                            $data->__GET('prov_rut'),
                                                            $data->__GET('prov_direccion'),
                                                            $data->__GET('prov_fono'),
                                                            $data->__GET('prov_ciudad'),
                                                            $data->__GET('prov_region'),
                                                            $data->__GET('prov_cuenta'),
                                                            $data->__GET('prov_contacto_nombre'),
                                                            $data->__GET('prov_contacto_email'),
                                                            $data->__GET('prov_contacto_fono'),
                                                            $data->__GET('prov_estado'),
                                                            $data->__GET('prov_id')
                                                     ) 
                                                ); 
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Proveedor actualizado correctamente';                 
        } catch (Exception $Exception){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar proveedor';
            $jsonresponse['errorQuery'] = $Exception->getMessage();
            $logs = new modelologs();
            $trace=$Exception->getTraceAsString();
              $logs->GrabarLogs($Exception->getMessage(),$trace);
              $logs = null;            
        }
        return $jsonresponse;
    }

    public function Listar2(){
        $jsonresponse = array();
        try{
            $result = array();
            $stm = $this->pdo->prepare("SELECT * FROM proveedor");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new Proveedores();
                    $busq->__SET('prov_id',                 $r->proveedor_id);
                    $busq->__SET('prov_nombre',             $r->proveedor_nombre);
                    $busq->__SET('prov_rut',                $r->proveedor_rut);
                    $busq->__SET('prov_direccion',          $r->proveedor_direccion);
                    $busq->__SET('prov_fono',               $r->proveedor_fono);
                    $busq->__SET('prov_ciudad',             $r->proveedor_ciudad);
                    $busq->__SET('prov_region',             $r->proveedor_region);
                    $busq->__SET('prov_cuenta',             $r->proveedor_cuenta);
                    $busq->__SET('prov_contacto_nombre',    $r->proveedor_contacto_nombre);
                    $busq->__SET('prov_contacto_email',     $r->proveedor_contacto_email);
                    $busq->__SET('prov_contacto_fono',      $r->proveedor_contacto_fono);
                    $busq->__SET('prov_estado',             $r->proveedor_estado);
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
            $stm = $this->pdo->prepare("SELECT  pp.proveedor_id,
                                                pp.proveedor_nombre,
                                                pp.proveedor_rut
                                        FROM proveedor as pp");
            $stm->execute();
           foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $fila = array('prov_id'=>$r->proveedor_id,
                              'prov_nombre'=>$r->proveedor_nombre,
                              'prov_rut'=>$r->proveedor_rut);
                $result[]=$fila;
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

}
?>