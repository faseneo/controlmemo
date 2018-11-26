<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../config/config.php");
class ModelMenu{
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
            $stm = $this->pdo->prepare("SELECT * FROM menu");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new Menu();
                    $busq->__SET('men_id',      $r->menu_id);
                    $busq->__SET('men_nombre',  $r->menu_nombre);
                    $busq->__SET('men_url',     $r->menu_url);
                    $busq->__SET('men_descrip', $r->menu_descripcion);
                    $busq->__SET('men_estado',  $r->menu_estado);
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
            $jsonresponse['message'] = 'Error al listar menues';
        }
    }

    public function Obtener($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo->prepare("SELECT * FROM menu as mem
                                        WHERE mem.menu_id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $busq = new Menu();
                    $busq->__SET('men_id',      $r->menu_id);
                    $busq->__SET('men_nombre',  $r->menu_nombre);
                    $busq->__SET('men_url',     $r->menu_url);
                    $busq->__SET('men_descrip', $r->menu_descripcion);
                    $busq->__SET('men_estado',  $r->menu_estado);

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Se obtuvo menu correctamente';
            $jsonresponse['datos'] = $busq->returnArray();
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener menu';
        }
        return $jsonresponse;
    }

    public function Eliminar($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo->prepare("DELETE FROM menu WHERE menu_id = ? ");
            $stm->execute(array($id));

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Menu eliminada correctamente';              
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar menu';
        }
        return $jsonresponse;
    }

    public function Registrar(Menu $data){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO menu (menu_nombre, menu_url, menu_descripcion, menu_estado) 
                    VALUES (?,?,?,?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('men_nombre'),
                                                     $data->__GET('men_url'),
                                                     $data->__GET('men_descrip'),
                                                     $data->__GET('men_estado')
                                                    )
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Menu ingresado correctamente'; 
        } catch (PDOException $pdoException){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar Menu';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            var_dump($jsonresponse);
        }
        return $jsonresponse;
    }

    public function Actualizar(Menu $data){
        $jsonresponse = array();
        try{
            $sql = "UPDATE menu SET 
                           menu_nombre = ?,
                           menu_url = ?,
                           menu_descripcion = ?,
                           menu_estado = ?
                    WHERE  menu_id = ?";

            $this->pdo->prepare($sql)->execute(array($data->__GET('men_nombre'),
                                                     $data->__GET('men_url'),
                                                     $data->__GET('men_descrip'),
                                                     $data->__GET('men_estado'),
                                                     $data->__GET('men_id')
                                                    )
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Menu actualizada correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar Menu';             
        }
        return $jsonresponse;
    }

    public function Listar2(){
        $jsonresponse = array();
        try{
            $result = array();
            $stm = $this->pdo->prepare("SELECT * FROM menu");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
               $busq = new Menu();
                    $busq->__SET('mem_id', $r->menu_id);
                    $busq->__SET('mem_nombre', $r->menu_nombre);
                $result[] = $busq;
            }
            return $result;
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function ListarMin(){
        $jsonresponse = array();
        try{
            $result = array();
            $stm = $this->pdo->prepare("SELECT menu_id,menu_nombre FROM menu WHERE menu_estado=1");
            $stm->execute();

            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $fila = array('mem_id'=>$r->menu_id,
                              'mem_nombre'=>$r->menu_nombre);
                $result[]=$fila;
            } 
            return $result;
        }catch(Exception $e){
            die($e->getMessage());
        }
    }    


}

?>