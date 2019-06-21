<?php
    error_reporting( -1 );
    ini_set( 'display_startup_errors', 1 );
    ini_set( 'display_errors', 1 );

require_once("../config/config.php");
class ModelDepartamento {
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
            $stm = $this->pdo->prepare("SELECT  dp.depto_id,
                                                dp.depto_nombre,
                                                dp.depto_nombre_corto,
                                                dp.depto_estado,
                                                dp.depto_habilitado
                                        FROM departamento as dp ORDER BY dp.depto_nombre ASC ");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new Departamentos();
                    $busq->__SET('depto_id',        $r->depto_id);
                    $busq->__SET('depto_nombre',    $r->depto_nombre);
                    $busq->__SET('depto_nomcorto',  $r->depto_nombre_corto);
                    $busq->__SET('depto_estado',    $r->depto_estado);
                    $busq->__SET('depto_habilita',  $r->depto_habilitado);
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
            $jsonresponse['message'] = 'Error al listar Departamentos';
        }
    }

    public function Obtener($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo->prepare("SELECT  dp.depto_id,
                                                dp.depto_nombre,
                                                dp.depto_nombre_corto,
                                                dp.depto_estado,
                                                dp.depto_habilitado
                                        FROM departamento as dp
                                        WHERE dp.depto_id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $busq = new Departamentos();
                    $busq->__SET('depto_id',        $r->depto_id);
                    $busq->__SET('depto_nombre',    $r->depto_nombre);
                    $busq->__SET('depto_nomcorto',  $r->depto_nombre_corto);
                    $busq->__SET('depto_estado',    $r->depto_estado);
                    $busq->__SET('depto_habilita',  $r->depto_habilitado);

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Se obtuvo los Departamentos correctamente';
            $jsonresponse['datos'] = $busq->returnArray();
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener Departamentos';             
        }
        return $jsonresponse;
    }

    public function Eliminar($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                      ->prepare("DELETE FROM departamento WHERE depto_id = ? ");
            $stm->execute(array($id));

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Departamento eliminado correctamente';              
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar Departamento';            
        }
        return $jsonresponse;
    }

    public function Registrar(Departamentos $data){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO departamento (depto_nombre, depto_nombre_corto, depto_estado, depto_habilitado) 
                    VALUES (?,?,?,?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('depto_nombre'),
                                                     $data->__GET('depto_nomcorto'),
                                                     $data->__GET('depto_estado'),
                                                     $data->__GET('depto_habilita')
                                                    )
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Departamento ingresado correctamente'; 
        } catch (PDOException $pdoException){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar Departamento';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
            var_dump($jsonresponse);
        }
        return $jsonresponse;
    }

    public function Actualizar(Departamentos $data){
        $jsonresponse = array();
        //print_r($data);
        try{
            $sql = "UPDATE departamento SET 
                           depto_nombre = ?,
                           depto_nombre_corto = ?,
                           depto_estado = ?,
                           depto_habilitado = ?
                    WHERE  depto_id = ?";

            $this->pdo->prepare($sql)->execute(array($data->__GET('depto_nombre'),
                                                     $data->__GET('depto_nomcorto'),
                                                     $data->__GET('depto_estado'),
                                                     $data->__GET('depto_habilita'),
                                                     $data->__GET('depto_id')
                                                     )
                                            );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Departamento actualizado correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar Departamento';             
        }
        return $jsonresponse;
    }

    public function ListarMinHabilitado(){
        $jsonresponse = array();
        try{
            $result = array();
             $stm = $this->pdo->prepare("SELECT  dp.depto_id,
                                                 dp.depto_nombre
                                        FROM departamento as dp
                                        WHERE dp.depto_habilitado=1 and dp.depto_estado=1");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $fila = array('depto_id'=>$r->depto_id,
                              'depto_nombre'=>$r->depto_nombre);
                $result[]=$fila;
            }
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'listado correctamente';
            $jsonresponse['datos'] = $result;
            return $jsonresponse;  
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function ListarMinHabilitadoPorUsu($idusu){
        $jsonresponse = array();
        try{
            $result = array();
             $stm = $this->pdo->prepare("SELECT  dp.depto_id,dp.depto_nombre
                                        FROM departamento as dp
                                        INNER JOIN dpto_tiene_usu AS dtu ON dtu.dpto_tiene_usu_depto_id=dp.depto_id
                                        WHERE dp.depto_habilitado=1 and dp.depto_estado=1
                                        AND dtu.dpto_tiene_usu_usuario_id=?");
            $stm->execute(array($idusu));
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $fila = array('depto_id'=>$r->depto_id,
                              'depto_nombre'=>$r->depto_nombre);
                $result[]=$fila;
            }
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'listado deptos correctamente';
            $jsonresponse['datos'] = $result;
            return $jsonresponse;  
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function ListarMin(){
        $jsonresponse = array();
        try{
            $result = array();
             $stm = $this->pdo->prepare("SELECT  dp.depto_id,
                                                 dp.depto_nombre,
                                                 dp.depto_nombre_corto
                                        FROM departamento as dp
                                        WHERE dp.depto_estado=1 
                                        ORDER BY dp.depto_nombre");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $fila = array('depto_id'=>$r->depto_id,
                              'depto_nombre'=>$r->depto_nombre,
                              'depto_nombre_corto'=>$r->depto_nombre_corto);
                $result[]=$fila;
            }
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'listado correctamente';
            $jsonresponse['datos'] = $result;
            return $jsonresponse;            
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }
}
 

?>