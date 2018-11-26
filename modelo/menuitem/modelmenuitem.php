<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../config/config.php");
class ModelMenuItem{
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
            $stm = $this->pdo->prepare("SELECT mi.menuitem_id, mi.menuitem_nombre, mi.menuitem_url, mi.menuitem_estado, mi.menuitem_menu_id, m.menu_nombre
                                        FROM menuitem as mi, menu as m 
                                        WHERE m.menu_id = mi.menuitem_menu_id");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new MenuItem();
                    $busq->__SET('menitem_id',      $r->menuitem_id);
                    $busq->__SET('menitem_nombre',  $r->menuitem_nombre);
                    $busq->__SET('menitem_url',     $r->menuitem_url);
                    $busq->__SET('menitem_estado',  $r->menuitem_estado);
                    $busq->__SET('menitem_memid',   $r->menuitem_menu_id);
                    $busq->__SET('menitem_memnom',  $r->menu_nombre);
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
            $jsonresponse['message'] = 'Error al listar menuitemes';
        }
    }

    public function Obtener($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo->prepare("SELECT mi.menuitem_id, mi.menuitem_nombre, mi.menuitem_url, mi.menuitem_estado, mi.menuitem_menu_id, m.menu_nombre
                                        FROM menuitem as mi, menu as m 
                                        WHERE m.menu_id = mi.menuitem_menu_id 
                                        AND  mi.menuitem_id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $busq = new MenuItem();
                    $busq->__SET('menitem_id',      $r->menuitem_id);
                    $busq->__SET('menitem_nombre',  $r->menuitem_nombre);
                    $busq->__SET('menitem_url',     $r->menuitem_url);
                    $busq->__SET('menitem_estado',  $r->menuitem_estado);
                    $busq->__SET('menitem_memid',   $r->menuitem_menu_id);
                    $busq->__SET('menitem_memnom',  $r->menu_nombre);

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Se obtuvo menuitem correctamente';
            $jsonresponse['datos'] = $busq->returnArray();
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener menuitem';
        }
        return $jsonresponse;
    }

    public function Eliminar($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo->prepare("DELETE FROM menuitem WHERE menuitem_id = ? ");
            $stm->execute(array($id));

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'MenuItem eliminada correctamente';              
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar MenuItem';
        }
        return $jsonresponse;
    }

    public function Registrar(MenuItem $data){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO menuitem (menuitem_nombre, menuitem_url, menuitem_estado, menuitem_menu_id) 
                    VALUES (?,?,?,?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('menitem_nombre'),
                                                     $data->__GET('menitem_url'),
                                                     $data->__GET('menitem_estado'),
                                                     $data->__GET('menitem_memid')
                                                    )
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'MenuItem ingresado correctamente'; 
        } catch (PDOException $pdoException){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar MenuItem';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            var_dump($jsonresponse);
        }
        return $jsonresponse;
    }

    public function Actualizar(MenuItem $data){
        $jsonresponse = array();
        try{
            $sql = "UPDATE menuitem SET 
                           menuitem_nombre = ?,
                           menuitem_url = ?,
                           menuitem_estado = ?,
                           menuitem_menu_id = ?
                    WHERE  menuitem_id = ?";

            $this->pdo->prepare($sql)->execute(array($data->__GET('menitem_nombre'),
                                                     $data->__GET('menitem_url'),
                                                     $data->__GET('menitem_estado'),
                                                     $data->__GET('menitem_memid'),
                                                     $data->__GET('menitem_id')
                                                    )
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'MenuItem actualizada correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar MenuItem';             
        }
        return $jsonresponse;
    }

    public function Listar2(){
        $jsonresponse = array();
        try{
            $result = array();
            $stm = $this->pdo->prepare("SELECT * FROM menuitem");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
               $busq = new MenuItem();
                    $busq->__SET('mem_id', $r->menuitem_id);
                    $busq->__SET('mem_nombre', $r->menuitem_nombre);
                $result[] = $busq;
            }
            return $result;
        }catch(Exception $e){
            die($e->getMessage());
        }
    }


}

?>