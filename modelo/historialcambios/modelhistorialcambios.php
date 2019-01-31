<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../config/config.php");
class ModelMemoEst{
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

    public function Registrar(HistorialCambios $data){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO historial_cambios (historial_cambios_id, 
                                                    historial_cambios_tipo_id,
                                                    historial_cambios_tabla, 
                                                    historial_cambios_pk,
                                                    historial_cambios_campo_nombre,
                                                    historial_cambios_valor_anterior,
                                                    historial_cambios_valor_nuevo,
                                                    historial_cambios_usuario_id) 
                    VALUES (?,?,?,?,?,?,?,?)";

            $this->pdo->prepare($sql)->execute(array(   $data->__GET('histcamb_id'),
                                                        $data->__GET('histcamb_tipo_id'),
                                                        $data->__GET('histcamb_tabla'),
                                                        $data->__GET('histcamb_pk'),
                                                        $data->__GET('histcamb_camp_nom'),
                                                        $data->__GET('histcamb_val_ant'),
                                                        $data->__GET('histcamb_val_nuevo'),
                                                        $data->__GET('histcamb_usu_id')
                                                    )
                                              );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Historial ingresado correctamente'; 
        } catch (PDOException $pdoException){
        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar Historial';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();
        }
        return $jsonresponse;
    }

    public function Listar($usuid=0,$idpk=0){
        $usuid = (int) $usuid;
        $idpk = (int) $idpk;

        $jsonresponse = array();
        $filtro = "";
        try{
            $result = array();
            if($usuid == 0 || $usuid == null || $usuid=='null'){
                $filtro .= "";
            }else{
                $filtro .= " AND hc.historial_cambios_usuario_id = ".$usuid;
            }
            if($idpk == 0 || $idpk == null || $idpk=='null'){
                $filtro .= "";
            }else{
                $filtro .= " AND hc.historial_cambios_pk = ".$idpk;
            }
            $consulta = "SELECT *  FROM historial_cambios as hc, historial_cambios_tipo as hct
                                   WHERE hct.hist_camb_tipo_id = hc.historial_cambios_id "
                                   .$filtro
                                   ." ORDER BY hc.historial_cambios_fecha_transaccion DESC";
            $stm = $this->pdo->prepare($consulta);
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new HistorialCambios();
                    $busq->__SET('histcamb_id',         $r->historial_cambios_id);
                    $busq->__SET('histcamb_tipo_id',    $r->historial_cambios_tipo_id);
                    $busq->__SET('histcamb_tipo_nom',   $r->hist_camb_tipo_texto);
                    $busq->__SET('histcamb_tabla',      $r->historial_cambios_tabla);
                    $busq->__SET('histcamb_pk',         $r->historial_cambios_pk);
                    $busq->__SET('histcamb_camp_nom',   $r->historial_cambios_campo_nombre);
                    $busq->__SET('histcamb_val_ant',    $r->historial_cambios_valor_anterior);
                    $busq->__SET('histcamb_val_nuevo',  $r->historial_cambios_valor_nuevo);
                    $busq->__SET('histcamb_fecha_trans',$r->historial_cambios_fecha_transaccion);
                    $busq->__SET('histcamb_usu_id',     $r->historial_cambios_usuario_id);

                $result[] = $busq->returnArray();
            }
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'listado correctamente';
            $jsonresponse['datos'] = $result;
            return $jsonresponse;
        }catch(Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al listar historial';
        }
    }

    public function Obtener($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo->prepare("SELECT *  FROM historial_cambios as hc, historial_cambios_tipo as hct
                                        WHERE hct.hist_camb_tipo_id = hc.historial_cambios_id AND hc.historial_cambios_id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
                $busq = new HistorialCambios();
                    $busq->__SET('histcamb_id',         $r->historial_cambios_id);
                    $busq->__SET('histcamb_tipo_id',    $r->historial_cambios_tipo_id);
                    $busq->__SET('histcamb_tipo_nom',   $r->hist_camb_tipo_texto);
                    $busq->__SET('histcamb_tabla',      $r->historial_cambios_tabla);
                    $busq->__SET('histcamb_pk',         $r->historial_cambios_pk);
                    $busq->__SET('histcamb_camp_nom',   $r->historial_cambios_campo_nombre);
                    $busq->__SET('histcamb_val_ant',    $r->historial_cambios_valor_anterior);
                    $busq->__SET('histcamb_val_nuevo',  $r->historial_cambios_valor_nuevo);
                    $busq->__SET('histcamb_fecha_trans',$r->historial_cambios_fecha_transaccion);
                    $busq->__SET('histcamb_usu_id',     $r->historial_cambios_usuario_id);

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Se obtuvo historial correctamente';
            $jsonresponse['datos'] = $busq->returnArray();
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener historial';             
        }
        return $jsonresponse;
    }
    //metodo definido no implementado
    public function Eliminar($id){
    }
    //metodo definido no implementado
    public function ListarMin($usuid=0,$idpk=0){
    }
}
?>