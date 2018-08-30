<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

require_once("../config/config.php");
class ModelMemoArchivo {
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

    public function Listar($idmemo=NULL){
        $jsonresponse = array();
        try{
        $consulta = "SELECT COUNT(*) FROM memo";
            $res = $this->pdo->query($consulta);
            if ($res->fetchColumn() == 0) {
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Archivos sin elementos';                
                $jsonresponse['datos'] = [];
            }else{
                /*var_dump($idmemo);
                echo "<br>";*/
                //$filtro="";
                $filtro = $idmemo != NULL ? "WHERE ma.memo_archivo_memo_id = $idmemo":"";
                $result = array();
                $stm = $this->pdo->prepare("SELECT * FROM memo_archivo as ma ".$filtro);
                //var_dump($stm);
                $stm->execute();
                foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                    $busq = new MemoArchivos();
                        $busq->__SET('memoarch_id', $r->memo_archivo_id);
                        $busq->__SET('memoarch_url', $r->memo_archivo_url);
                        $busq->__SET('memoarch_name', $r->memo_archivo_name);
                        $busq->__SET('memoarch_type', $r->memo_archivo_type);
                        $busq->__SET('memoarch_size', $r->memo_archivo_size);
                        $busq->__SET('memoarch_fecha_registro', $r->memo_archivo_fecha_registro);
                        $busq->__SET('memoarch_flag', $r->memo_archivo_principal_flag);
                        $busq->__SET('memoarch_memo_id', $r->memo_archivo_memo_id);
                    $result[] = $busq->returnArray();
                }
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'listado correctamente';
                $jsonresponse['datos'] = $result;
            }
        }
        catch(Exception $e){
            die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al listar los archivos';
        }
        return $jsonresponse;
    }

    public function Obtener($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                       ->prepare("SELECT *
                                FROM memo_archivo as ma
                                WHERE ma.memo_archivo_id = ?");
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
                $busq = new MemoArchivos();
                    $busq->__SET('memoarch_id', $r->memo_archivo_id);
                    $busq->__SET('memoarch_url', $r->memo_archivo_url);
                    $busq->__SET('memoarch_name', $r->memo_archivo_name);
                    $busq->__SET('memoarch_type', $r->memo_archivo_type);
                    $busq->__SET('memoarch_size', $r->memo_archivo_size);
                    $busq->__SET('memoarch_fecha_registro', $r->memo_archivo_fecha_registro);
                    $busq->__SET('memoarch_flag', $r->memo_archivo_principal_flag);
                    $busq->__SET('memoarch_memo_id', $r->memo_archivo_memo_id);

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Se obtuvo datos del archivo correctamente';
            $jsonresponse['datos'] = $busq->returnArray();
        } catch (Exception $e){
            die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener archivo';
        }
        return $jsonresponse;
    }

    public function Eliminar($id){
        $jsonresponse = array();
        try{
            $stm = $this->pdo
                      ->prepare("DELETE FROM memo_archivo WHERE memo_archivo_id = ? ");
            $stm->execute(array($id));
            $cuenta = $stm->rowCount();
            $msg = $cuenta > 0 ? "$cuenta filas afectas, eliminado correctamente" : "$cuenta filas afectas, no existe el archivo";
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = $msg;
        } catch (Exception $e){
            die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al eliminar memo archivo';            
        }
        return $jsonresponse;
    }
    // ingreso del archio viene desde el modelmemo, 
    public function Registrar($files,$idmemo,$nummemmo,$aniomemo){
        $archivos = array();
        $jsonresponse = array();
        try{
            //graba archivo escaneado del memo
            if(!empty($files['memoFile']['name'])){
                $nombrearch = explode(".",$files['memoFile']['name']);
                
               // $arrayresponsesube = $this->subearchivo($nombrearch,$idmemo,$nummemmo,$aniomemo);

                $largo = count($nombrearch)-1;
                $urlarchivodestino = RAIZ.memoarch_directorio.memoarch_prefijo.$aniomemo.'_'.$nummemmo.'.'.$nombrearch[$largo];
                $urlarchivo = memoarch_directorio.memoarch_prefijo.$aniomemo.'_'.$nummemmo.'.'.$nombrearch[$largo];

                $data = new MemoArchivos();
                    $data->__SET('memoarch_url', $urlarchivo);
                    $data->__SET('memoarch_name',$files['memoFile']['name']);
                    $data->__SET('memoarch_type', $files['memoFile']['type']);
                    $data->__SET('memoarch_size', $files['memoFile']['size']);
                    $data->__SET('memoarch_flag', 1);
                    $data->__SET('memoarch_memo_id', $idmemo);

                $dir=opendir(RAIZ.memoarch_directorio);  //Abre directorio donde se guardaran archivos
                $origen = $files['memoFile']["tmp_name"];  // origen temporal del archivo
                //$archivos[]=$files['memoFile']['name'];
                if(move_uploaded_file($origen, $urlarchivodestino)) {
                    $arrayresponsegraba  = $this->Grabar($data);
                    if ($arrayresponsegraba['success']){
                        $jsonresponse['success'] = true;
                        $jsonresponse['grabaarchivo'] = true;
                        $jsonresponse['message'] = 'Archivos grabado correctamente';
                    }else{
                        $jsonresponse['success'] = $arrayresponsegraba['success'];
                        $jsonresponse['grabaarchivo'] = true;
                        $jsonresponse['message'] = $arrayresponsegraba['message'];
                    }
                }else{
                    $jsonresponse['success'] = false;
                    $jsonresponse['grabaarchivo'] = false;
                    $jsonresponse['message'] = 'Error al subir archivo';
                }
                closedir($dir);
            }else{
                $jsonresponse['success'] = false;
                $jsonresponse['messageMEM'] = 'ERROR al subir Archivos, campo vacio'; 
            }
            // Graba lista de archivos anexos del memo

            if(!empty($files['memoFileList']['name'][0])){
                $dir=opendir(RAIZ.memoarch_directorio);  //Abre directorio donde se guardaran archivos

                $totalArchivo = sizeof($files['memoFileList']['name']);  //total de archivos
                for($i=0; $i<$totalArchivo; $i++ ){
                    //$files['memoFileList']['name'][$i];

                    $nombrearch = explode(".",$files['memoFileList']['name'][$i]);
                    $largo = count($nombrearch)-1;
                    $urlarchivodestino = RAIZ.memoarch_directorio.memoarch_prefijo.$aniomemo.'_'.$nummemmo.'_'.$i.'.'.$nombrearch[$largo];
                    $urlarchivo = memoarch_directorio.memoarch_prefijo.$aniomemo.'_'.$nummemmo.'_'.$i.'.'.$nombrearch[$largo];
                    $data = new MemoArchivos();
                        $data->__SET('memoarch_url', $urlarchivo);
                        $data->__SET('memoarch_name',$files['memoFileList']['name'][$i]);
                        $data->__SET('memoarch_type', $files['memoFileList']['type'][$i]);
                        $data->__SET('memoarch_size', $files['memoFileList']['size'][$i]);
                        $data->__SET('memoarch_flag', 0);
                        $data->__SET('memoarch_memo_id', $idmemo);

                    $origen = $files['memoFileList']["tmp_name"][$i];  // origen temporal del archivo
                    //closedir(RAIZ.memoarch_directorio);
                    //VALIDAR QUE ARCHIVO SUBIO SIN ERRORES
                    if(move_uploaded_file($origen, $urlarchivodestino)) {
                        
                        $arrayresponsegraba  = $this->Grabar($data);
                        
                        if ($arrayresponsegraba['success']){
                            $jsonresponse['success'] = true;
                            $jsonresponse['grabaarchivo'] = true;
                            $jsonresponse['message'] = 'Archivos grabado correctamente';
                        }else{
                            $jsonresponse['success'] = $arrayresponsegraba['success'];
                            $jsonresponse['grabaarchivo'] = true;
                            $jsonresponse['message'] = $arrayresponsegraba['message'];
                        }
                    }else{
                        $jsonresponse['success'] = false;
                        $jsonresponse['grabaarchivo'] = false;
                        $jsonresponse['message'] = 'Error al subir archivo';
                    }                    
                }
                closedir($dir);
            }else{
                $jsonresponse['success'] = false;
                $jsonresponse['messageMEMLIST'] = 'ERROR al subir Archivos, campo vacio'; 
            }
        }catch(Exception $e){
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'ERROR al subir Archivos, campo vacio';
            $jsonresponse['messageerror'] = $e->getMessage();
        }
        return $jsonresponse;
    }
    /*public function subearchivo(){
        $jsonresponse = array();        
        try{

        }catch(Exception $e){
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'ERROR al subir Archivos, campo vacio';
            $jsonresponse['messageerror'] = $e->getMessage();
        }
    }*/
    public function Grabar(MemoArchivos $data){
        $jsonresponse = array();
            try{            
                $sql = "INSERT INTO memo_archivo (memo_archivo_url, 
                                                memo_archivo_name,
                                                memo_archivo_type,
                                                memo_archivo_size,
                                                memo_archivo_principal_flag,
                                                memo_archivo_memo_id)
                        VALUES (?,?,?,?,?,?)";

                $this->pdo->prepare($sql)->execute(array($data->__GET('memoarch_url'),
                                                        $data->__GET('memoarch_name'),
                                                        $data->__GET('memoarch_type'), 
                                                        $data->__GET('memoarch_size'),
                                                        $data->__GET('memoarch_flag'),
                                                        $data->__GET('memoarch_memo_id')
                                                    ));
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Memo archivo ingresado correctamente'; 
            }catch (PDOException $pdoException){
            //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
                $jsonresponse['success'] = false;
                $jsonresponse['message'] = 'Error al ingresar memo archivo';
                $jsonresponse['errorQuery'] = $pdoException->getMessage();
            }
        return $jsonresponse;
    }


    /*
    public function Actualizar(MemoArchivos $data){
        $jsonresponse = array();
        //print_r($data);
        try{
            $sql = "UPDATE memo_archivo SET  
                           memo_archivo_url = ?
                    WHERE  memo_archivo_id = ?";

            $this->pdo->prepare($sql)
                 ->execute(array($data->__GET('memo_arch_url'),
                                 $data->__GET('memo_arch_id')) 
                          );
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Memo archivo actualizado correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar memo archivo';             
        }
        return $jsonresponse;
    }

    public function Listar2(){
        $jsonresponse = array();
        try{
            $result = array();
             $stm = $this->pdo->prepare("SELECT  ma.memo_archivo_id,
                                                 ma.memo_archivo_url
                                        FROM memo_archivo as ma");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new MemoArchivos();
                    $busq->__SET('memo_arch_id', $r->memo_archivo_id);
                    $busq->__SET('memo_arch_url', $r->memo_archivo_url);
                $result[] = $busq;
            }
            return $result;
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }*/
}
?>