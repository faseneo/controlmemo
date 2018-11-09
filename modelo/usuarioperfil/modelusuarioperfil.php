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
            $stm = $this->pdo->prepare("SELECT  up.usuario_perfil_id,
                                                up.usuario_perfil_nombre
                                        FROM usuario_perfil as up");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new UsuPerfil();
                    $busq->__SET('usu_perfil_id', $r->usuario_perfil_id);
                    $busq->__SET('usu_perfil_nombre', $r->usuario_perfil_nombre);                    
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
            $jsonresponse['message'] = 'Error al listar usuario perfil';
        }
    }

    public function Obtener($id){

        $jsonresponse = array();
        try{
            $stm = $this->pdo
                       ->prepare("SELECT up.usuario_perfil_id,
                                         up.usuario_perfil_nombre
                                FROM usuario_perfil as up
                                WHERE up.usuario_perfil_id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $busq = new UsuPerfil();
                    $busq->__SET('usu_perfil_id', $r->usuario_perfil_id);
                    $busq->__SET('usu_perfil_nombre', $r->usuario_perfil_nombre);

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Se obtuvo los usuario perfil correctamente';
            $jsonresponse['datos'] = $busq->returnArray();

        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener usuario perfil';             
        }
        return $jsonresponse;
    }

    public function Eliminar($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                      ->prepare("DELETE FROM usuario_perfil WHERE usuario_perfil_id = ? ");
            $stm->execute(array($id));

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Usuario perfil eliminado correctamente';              
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar usuario perfil';            
        }
        return $jsonresponse;
    }

    public function Registrar(UsuPerfil $data){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO usuario_perfil (usuario_perfil_nombre) 
                    VALUES (?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('usu_perfil_nombre'))
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Usuario perfil ingresado correctamente'; 
        } catch (PDOException $pdoException){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar usuario perfil';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            var_dump($jsonresponse);
        }
        return $jsonresponse;
    }

    public function Actualizar(UsuPerfil $data){
        $jsonresponse = array();
        //print_r($data);
        try{
            $sql = "UPDATE usuario_perfil SET 
                           usuario_perfil_nombre = ?
                    WHERE  usuario_perfil_id = ?";

            $this->pdo->prepare($sql)
                 ->execute(array($data->__GET('usu_perfil_nombre'),
                                 $data->__GET('usu_perfil_id'))
                          );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Usuario perfil actualizado correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar usuario perfil';             
        }
        return $jsonresponse;
    }

    public function Listar2(){
        $jsonresponse = array();
        try{
            $result = array();
             $stm = $this->pdo->prepare("SELECT  up.usuario_perfil_id,
                                                 up.usuario_perfil_nombre
                                        FROM usuario_perfil as up");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new UsuPerfil();
                    $busq->__SET('usu_perfil_id', $r->usuario_perfil_id);
                    $busq->__SET('usu_perfil_nombre', $r->usuario_perfil_nombre); 
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