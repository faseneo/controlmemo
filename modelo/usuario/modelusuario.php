<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../config/config.php");
class ModelUsuarios{
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
            $stm = $this->pdo->prepare("SELECT  us.usuario_id,
                                                us.usuario_rut,
                                                us.usuario_nombre,
                                                us.usuario_password,
                                                us.usuario_usuario_perfil_id,
												usp.usuario_perfil_nombre
                                        FROM usuario as us ,usuario_perfil as usp 
										WHERE us.usuario_usuario_perfil_id= usp.usuario_perfil_id ");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new Usuarios(); 
                    $busq->__SET('usu_id', $r->usuario_id);
                    $busq->__SET('usu_rut', $r->usuario_rut);
                    $busq->__SET('usu_nombre', $r->usuario_nombre); 
                    $busq->__SET('usu_password', $r->usuario_password);
                    $busq->__SET('usu_usu_perfil_id', $r->usuario_usuario_perfil_id);
					$busq->__SET('usu_perfil_nombre', $r->usuario_perfil_nombre);                    
                $result[] = $busq->returnArray();
            }
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'listado correctamente';
            $jsonresponse['datos'] = $result;
           
        }
        catch(Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al listar los usuarios';
        } 
		return $jsonresponse;
    }

    public function Obtener($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                       ->prepare("SELECT  us.usuario_id,
                                          us.usuario_rut,
                                          us.usuario_nombre,
                                          us.usuario_password,
										  us.usuario_usuario_perfil_id,
									   	  usp.usuario_perfil_nombre
                                        FROM usuario as us ,usuario_perfil as usp 
										WHERE us.usuario_usuario_perfil_id= usp.usuario_perfil_id
                                		AND us.usuario_id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $busq = new Usuarios();
                    $busq->__SET('usu_id', $r->usuario_id);
                    $busq->__SET('usu_rut', $r->usuario_rut);
                    $busq->__SET('usu_nombre', $r->usuario_nombre); 
                    $busq->__SET('usu_password', $r->usuario_password);
        			$busq->__SET('usu_usu_perfil_id', $r->usuario_usuario_perfil_id);
					$busq->__SET('usu_perfil_nombre', $r->usuario_perfil_nombre);
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Se obtuvo los usuarios correctamente';
            $jsonresponse['datos'] = $busq->returnArray();
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener usuarios';             
        }
        return $jsonresponse;
    }

    public function Eliminar($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                      ->prepare("DELETE FROM usuario WHERE usuario_id = ? ");
            $stm->execute(array($id));

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Usuario eliminado correctamente';              
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar usuario';            
        }
        return $jsonresponse;
    }

    public function Registrar(Usuarios $data){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO usuario (usuario_rut, usuario_nombre, usuario_password, usuario_usuario_perfil_id) 
                    VALUES (?,?,?,?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('usu_rut'),
                                                     $data->__GET('usu_nombre'),
                                                     $data->__GET('usu_password'),
													 $data->__GET('usu_usu_perfil_id'))
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Usuario ingresado correctamente'; 
        } catch (PDOException $pdoException){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar usuario';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            var_dump($jsonresponse);
        }
        return $jsonresponse;
    }

    public function Actualizar(Usuarios $data){
        $jsonresponse = array();
        //print_r($data);
        try{
            $sql = "UPDATE usuario SET 
                           usuario_rut = ?, 
                           usuario_nombre = ?,
                           usuario_password = ?,
						   usuario_usuario_perfil_id = ?
                    WHERE  usuario_id = ?";

            $this->pdo->prepare($sql)
                 ->execute(array($data->__GET('usu_rut'),
                                 $data->__GET('usu_nombre'), 
                                 $data->__GET('usu_password'),
                                 $data->__GET('usu_usu_perfil_id'),
                                 $data->__GET('usu_id'))
                          );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Usuario actualizado correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar usuario';             
        }
        return $jsonresponse;
    }

    public function Listar2(){
        $jsonresponse = array();
        try{
            $result = array();
             $stm = $this->pdo->prepare("SELECT us.usuario_id,
                                                us.usuario_rut,
                                                us.usuario_nombre,
                                                us.usuario_password
                                        FROM usuario as us");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new Usuarios();
                    $busq->__SET('usu_id', $r->usuario_id);
                    $busq->__SET('usu_rut', $r->usuario_rut);
                    $busq->__SET('usu_nombre', $r->usuario_nombre);
                    $busq->__SET('usu_password', $r->usuario_password); 
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