<?php
    error_reporting( -1 );
    ini_set( 'display_startup_errors', 1 );
    ini_set( 'display_errors', 1 );

require_once("../config/config.php");
class ModelUsuarioRol {
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
            $stm = $this->pdo->prepare("SELECT  ur.usu_rol_id,
                                                ur.usu_rol_nombre
                                        FROM usuario_rol as ur");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new UsuarioRol();
                    $busq->__SET('usuario_rol_id', $r->usu_rol_id);
                    $busq->__SET('usuario_rol_nombre', utf8_encode($r->usu_rol_nombre));
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
            $jsonresponse['message'] = 'Error al listar Usuario Rol';
        }
    }

    public function Obtener($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                       ->prepare("SELECT ur.usu_rol_id,
                                         ur.usu_rol_nombre
                                FROM usuario_rol as ur
                                WHERE ur.usu_rol_id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $busq = new UsuarioRol();
                    $busq->__SET('usuario_rol_id', $r->usu_rol_id);
                    $busq->__SET('usuario_rol_nombre', $r->usu_rol_nombre);

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Se obtuvo Usuario Rol correctamente';
            $jsonresponse['datos'] = $busq->returnArray();
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener Usuario Rol';             
        }
        return $jsonresponse;
    }

    public function Eliminar($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                      ->prepare("DELETE FROM usuario_rol WHERE usu_rol_id = ? ");
            $stm->execute(array($id));

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Usuario Rol eliminado correctamente';              
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar Usuario Rol';            
        }
        return $jsonresponse;
    }

    public function Registrar(UsuarioRol $data){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO usuario_rol (usu_rol_nombre) 
                    VALUES (?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('usuario_rol_nombre'))
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Usuario Rol ingresado correctamente'; 
        } catch (PDOException $pdoException){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar Usuario Rol';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            var_dump($jsonresponse);
        }
        return $jsonresponse;
    }

    public function Actualizar(UsuarioRol $data){
        $jsonresponse = array();
        //print_r($data);
        try{
            $sql = "UPDATE usuario_rol SET 
                           usu_rol_nombre = ?
                    WHERE  usu_rol_id = ?";

            $this->pdo->prepare($sql)
                 ->execute(array($data->__GET('usuario_rol_nombre'), 
                                 $data->__GET('usuario_rol_id'))
                          );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Usuario Rol actualizado correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar Usuario Rol';             
        }
        return $jsonresponse;
    }

    public function Listar2(){
        $jsonresponse = array();
        try{
            $result = array();
             $stm = $this->pdo->prepare("SELECT  ur.usu_rol_id,
                                                 ur.usu_rol_nombre
                                        FROM usuario_rol as ur");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new UsuarioRol();
                    $busq->__SET('usuario_rol_id', $r->usu_rol_id);
                    $busq->__SET('usuario_rol_nombre', $r->usu_rol_nombre);
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