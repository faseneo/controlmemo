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
    /*
    INSERT INTO `memo_archivo` (`memo_archivo_id`, `memo_archivo_url`, `memo_archivo_name`, `memo_archivo_type`, `memo_archivo_size`, `memo_archivo_fecha_registro`, `memo_archivo_principal_flag`, `memo_archivo_memo_id`) 
    VALUES (NULL, 'archivos/memo23_otro.pdf', 'cotizacion_memo23.pdf', 'pdf', '230', CURRENT_TIMESTAMP, '0', '1');
    */
    public function Registrar($files,$idmemo,$nummemmo,$aniomemo){
        $archivos = array();
       /* var_dump(empty($files['memoFile']));
        echo "<br>";        
        var_dump($nombrearch);
        echo "<br>";        
        var_dump($urlarchivo);
        echo "<br>";                
        var_dump(RAIZ);
        echo "<br>";        
        var_dump(memoarch_directorio);
        echo "<br>";
        var_dump(memoarch_prefijo);
        echo "<br>";*/
        if(empty($files['memoFile'])){
            $nombrearch = explode(".",$files['memoFile']['name']);
            $largo = count($nombrearch)-1;

            $urlarchivo = RAIZ.memoarch_directorio.memoarch_prefijo.$aniomemo.'_'.$nummemmo.'.'.$nombrearch[$largo];            
            $data = new MemoArchivos();
                $data->__SET('memoarch_url', $urlarchivo);
                $data->__SET('memoarch_name',$files['memoFile']['name']);
                $data->__SET('memoarch_type', $files['memoFile']['type']);
                $data->__SET('memoarch_size', $files['memoFile']['size']);
                $data->__SET('memoarch_flag', 1);
                $data->__SET('memoarch_memo_id', $idmemo);
                var_dump($data);
            $dir=opendir(RAIZ.memoarch_directorio);  //Abre directorio donde se guardaran archivos
            $origen = $files["tmp_name"];  // orgine temporal del archivo
            $archivos[]=$files['memoFile']['name'];
            if(move_uploaded_file($origen, $urlarchivo)) {
                $sql="INSERT INTO memo_archivo (memo_archivo_url,memo_archivo_name,memo_archivo_type,memo_archivo_size,memo_archivo_principal_flag,memo_archivo_memo_id) VALUES (?,?,?,?,?,?)";
                try{
                    $this->pdo->prepare($sql)->execute(array($data->__GET('memoarch_url'),
                                                             $data->__GET('memoarch_name'),
                                                             $data->__GET('memoarch_type'),
                                                             $data->__GET('memoarch_size'),
                                                             $data->__GET('memoarch_flag'),
                                                             $data->__GET('memoarch_memo_id')
                                                                    ));
                    $jsonresponse['success'] = true;
                    $jsonresponse['message'] = 'Archivos cargados correctamente';
                    //$jsonresponse['messagebd'] = 'Archivos guardados correctamente';
                }catch (PDOException $pdoException){
                        //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
                    $jsonresponse['success'] = false;
                    $jsonresponse['message'] = 'ERROR al subir Archivos'; 
                    //$jsonresponse['messagebd'] = 'Error al insertar los archivos';
                    $jsonresponse['errorQuery'] = $pdoException->getMessage();
                }
            }
        }else{

        }


        //$this->Grabar($data);
            /*
            foreach($files as $key => $value){
                if($files[$key]) {
                    $dir=opendir(RAIZ);  //Abre directorio donde se guardaran archivos

                    $nom = ($key=="cedula") ? "cedula_":"registro_social_";  //crea nombre generico por rut y tipoarchivo

                    $destino = RAIZ.$nom.$_REQUEST['rut'].".pdf";  // crea url completa para guardar archivo
                    $origen = $_FILES[$key]["tmp_name"];  // orgine temporal del archivo
                    $urllink = $directorio.$nom.$_REQUEST['rut'].".pdf"; // url para base de datos

                    if(move_uploaded_file($origen, $destino)) {    // mueve el archivo a su destino
                        //echo "El archivo $urllink se ha almacenado en forma exitosa.<br>";
                        try{
                            $this->pdo->prepare($sql)->execute(array($data->__GET('alumbeca_rut'),
                                                                        $value["name"],
                                                                        $value["type"],
                                                                        $value["size"],
                                                                        $urllink
                                                                    ));
                            $jsonresponse['success'] = true;
                            $jsonresponse['message'] = 'Archivos cargados correctamente';
                            
                            //$jsonresponse['messagebd'] = 'Archivos guardados correctamente';
                        } catch (PDOException $pdoException){
                             //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
                            $jsonresponse['success'] = false;
                            $jsonresponse['message'] = 'ERROR al subir Archivos'; 
                            //$jsonresponse['messagebd'] = 'Error al insertar los archivos';
                            $jsonresponse['errorQuery'] = $pdoException->getMessage();
                        }
                    } else {   
                        //echo "Ha ocurrido un error, por favor inténtelo de nuevo.<br>";
                        $jsonresponse['success'] = false;
                        $jsonresponse['message'] = 'ERROR al subir Archivos'; 
                    }
                }
            }*/
            
    }

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

                $this->pdo->prepare($sql)->execute(array($data->__GET('memo_arch_url'),
                                                        $data->__GET('memoarch_name'),
                                                        $data->__GET('memoarch_type'), 
                                                        $data->__GET('memoarch_size'),
                                                        $data->__GET('memoarch_flag'),
                                                        $data->__GET('memoarch_memo_id')
                                                    ));
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Memo archivo ingresado correctamente'; 
            } catch (PDOException $pdoException){
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