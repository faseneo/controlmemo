<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
require_once("../config/config.php");
require_once("../modelo/logs/modelologs.php");
require_once("../modelo/logs/modelologsquerys.php");
class ModelMemoArchivo {
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

    public function Listar($idmemo=NULL){
        $jsonresponse = array();
        try{
        $consulta = "SELECT COUNT(*) FROM memo_archivo";
            $res = $this->pdo->query($consulta);
            if ($res->fetchColumn() == 0) {
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Archivos sin elementos';                
                $jsonresponse['datos'] = [];
            }else{
                /*var_dump($idmemo);
                echo "<br>";*/
                //$filtro="";
                $filtro = $idmemo != NULL ? "AND ma.memo_archivo_memo_id = $idmemo":"";
                $result = array();
                $stm = $this->pdo->prepare("SELECT * FROM memo_archivo as ma WHERE 1=1 ".$filtro." AND ma.memo_archivo_estado = 1");

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
            $stm = $this->pdo->prepare("SELECT *
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
            $stm = $this->pdo->prepare("DELETE FROM memo_archivo WHERE memo_archivo_id = ? ");
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
    public function RegistrarArchivoGenerico($files,$tipoarch,$idmemo,$nummemmo,$aniomemo){
        $flagprincipal=0;
        try{
            if(!empty($files['name'])){
                $totalArchivo = sizeof($files['name']);
                if($tipoarch=='memo'){
                    $urlarchivodestino0 = RAIZ.memoarch_directorio.memoarch_prefijo;
                    $urlarchivo0 = memoarch_directorio.memoarch_prefijo;
                    $flagprincipal=1;
                    $archivotipo=1;
                }elseif($tipoarch=='memodet'){
                    $urlarchivodestino0 = RAIZ.memoarch_directorio.memoarch_prefijo_det;
                    $urlarchivo0 = memoarch_directorio.memoarch_prefijo_det;
                    $archivotipo=3;
                }elseif($tipoarch=='anexomemo'){
                    $urlarchivodestino0 = RAIZ.memoarch_directorio.memoarch_prefijo_otro;
                    $urlarchivo0 = memoarch_directorio.memoarch_prefijo_otro;
                    $archivotipo=2;
                }

                //if($totalArchivo==1){
                if(!is_array($files['name'])){
                    $urlarchivodestino=$urlarchivodestino0;
                    $urlarchivo=$urlarchivo0;
                    $extarch = explode(".",$files['name']);
                    $largo = count($extarch)-1;
                    $fecha = new DateTime();
                    $fehcatimestamp = $fecha->getTimestamp();

                    $urlarchivodestino .= $aniomemo.'_'.$nummemmo.'_F'.$fehcatimestamp.'.'.$extarch[$largo];
                    $urlarchivo .= $aniomemo.'_'.$nummemmo.'_F'.$fehcatimestamp.'.'.$extarch[$largo];
                        $data = new MemoArchivos();
                            $data->__SET('memoarch_url', $urlarchivo);
                            $data->__SET('memoarch_name',$files['name']);
                            $data->__SET('memoarch_type', $files['type']);
                            $data->__SET('memoarch_size', $files['size']);
                            $data->__SET('memoarch_flag', $flagprincipal);
                            $data->__SET('memoarch_memo_id', $idmemo);
                            $data->__SET('memoarch_estado',1);
                            $data->__SET('memoarch_tipoarchivoid',$archivotipo);
                    $dir=opendir(RAIZ.memoarch_directorio);
                    $origen = $files["tmp_name"];
                    if(move_uploaded_file($origen, $urlarchivodestino)) {
                        $arrayresponsegraba  = $this->Grabar($data);
                        $success=true;
                        $subearchivo=true;
                        $grabaarchivo=$arrayresponsegraba;
                        $msgarchivo= 'Archivos agregado correctamente';
                    }else{
                        $success=false;
                        $subearchivo=false;
                        $grabaarchivo=[];
                        $msgarchivo= 'Erro al agregar Archivos';
                    }
                    closedir($dir);
                }else{
                    for($i=0; $i<$totalArchivo; $i++ ){
                        $urlarchivodestino=$urlarchivodestino0;
                        $urlarchivo=$urlarchivo0;
                        $extarch = explode(".",$files['name'][$i]);
                        $largo = count($extarch)-1;
                        $fecha = new DateTime();
                        $fehcatimestamp = $fecha->getTimestamp();
                        $urlarchivodestino .= $aniomemo.'_'.$nummemmo.'_'.$i.'_F'.$fehcatimestamp.'.'.$extarch[$largo];
                        $urlarchivo .= $aniomemo.'_'.$nummemmo.'_'.$i.'_F'.$fehcatimestamp.'.'.$extarch[$largo];
                            $data = new MemoArchivos();
                                    $data->__SET('memoarch_url', $urlarchivo);
                                    $data->__SET('memoarch_name',$files['name'][$i]);
                                    $data->__SET('memoarch_type', $files['type'][$i]);
                                    $data->__SET('memoarch_size', $files['size'][$i]);
                                    $data->__SET('memoarch_flag', $flagprincipal);
                                    $data->__SET('memoarch_memo_id', $idmemo);
                                    $data->__SET('memoarch_estado',1);
                                    $data->__SET('memoarch_tipoarchivoid',$archivotipo);
                            $dir=opendir(RAIZ.memoarch_directorio);
                            $origen = $files["tmp_name"][$i];
                            if(move_uploaded_file($origen, $urlarchivodestino)) {
                                $arrayresponsegraba  = $this->Grabar($data);
                                $success=true;
                                $subearchivo=true;
                                $grabaarchivo=$arrayresponsegraba;
                                $msgarchivo= 'Archivos agregado correctamente';
                            }else{
                                $success=false;
                                $subearchivo=false;
                                $grabaarchivo=[];
                                $msgarchivo= 'Erro al agregar Archivos';
                            }
                        closedir($dir);
                    }
                }
            }else{
                $success=false;
                $subearchivo=false;
                $grabaarchivo=false;
                $msgarchivo='ERROR al subir archivos, campos vacíos';
            }

            $jsonresponse['success'] =$success;
            $jsonresponse['subearchivo'] = $subearchivo;
            $jsonresponse['grabaarchivo'] = $grabaarchivo;
            $jsonresponse['message'] = $msgarchivo;

        }catch(Exception $e){
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'ERROR al subir Archivos';
            $jsonresponse['messageerror'] = $e->getMessage();
            $logs = new modelologs();
                $trace = $e->getTraceAsString();
                $logs->GrabarLogs($e->getMessage(),$trace);
            $logs = null;
        }
        return $jsonresponse;
    }

    // funcion que graba archivo en la base de datos
    public function Grabar(MemoArchivos $data){
        $jsonresponse = array();
            try{            
                $sql = "INSERT INTO memo_archivo (memo_archivo_url, 
                                                memo_archivo_name,
                                                memo_archivo_type,
                                                memo_archivo_size,
                                                memo_archivo_principal_flag,
                                                memo_archivo_memo_id,
                                                memo_archivo_estado,
                                                memo_archivo_tipo_archivo_id)
                        VALUES (?,?,?,?,?,?,?,?)";

                $this->pdo->prepare($sql)->execute(array($data->__GET('memoarch_url'),
                                                        $data->__GET('memoarch_name'),
                                                        $data->__GET('memoarch_type'), 
                                                        $data->__GET('memoarch_size'),
                                                        $data->__GET('memoarch_flag'),
                                                        $data->__GET('memoarch_memo_id'),
                                                        $data->__GET('memoarch_estado'),
                                                        $data->__GET('memoarch_tipoarchivoid')
                                                    ));
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Memo archivo ingresado correctamente'; 
            }catch (PDOException $pdoException){
            //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
                $jsonresponse['success'] = false;
                $jsonresponse['message'] = 'Error al ingresar memo archivo';
                $jsonresponse['errorQuery'] = $pdoException->getMessage();
                $logs = new modelologs();
                    $trace = $pdoException->getTraceAsString();
                    $logs->GrabarLogs($pdoException->getMessage(),$trace);
                    $logs = null;
            }
        return $jsonresponse;
    }

    public function ActualizarArchivoMemo($files,$mid,$nummem,$aniomem){
        $mid=(int)$mid;
        if (array_key_exists('addmemoFileList', $files)) {
            $tipoarch='anexomemo';
            $jsonresponse = $this->RegistrarArchivoGenerico($files['addmemoFileList'],$tipoarch,$mid,$nummem,$aniomem);
        }else{
            try{
                $consulta = "SELECT COUNT(*) FROM memo_archivo WHERE memo_archivo_principal_flag=1 AND memo_archivo_memo_id=".$mid;
                $res = $this->pdo->query($consulta);

                if ($res->fetchColumn() != 0) {
                    $consultadatos = "SELECT * FROM memo_archivo WHERE memo_archivo_principal_flag=1 AND memo_archivo_memo_id=".$mid;
                    $stm = $this->pdo->query($consultadatos);
                    $r = $stm->fetch(PDO::FETCH_OBJ);

                        $urlanterior = RAIZ.$r->memo_archivo_url;
                        $arraynomarchivo = explode('.', $r->memo_archivo_url);
                        $fecha = new DateTime();
                        $fehcatimestamp = $fecha->getTimestamp();

                        $urlarchivo = memoarch_directorio.memoarch_prefijo.$aniomem.'_'.$nummem.'_'.$r->memo_archivo_id.'_'.'_F'.$fehcatimestamp.'.'.$arraynomarchivo[1];
                        $urlarchivonuevo = RAIZ.memoarch_directorio.memoarch_prefijo.$aniomem.'_'.$nummem.'_'.$r->memo_archivo_id.'_'.'_F'.$fehcatimestamp.'.'.$arraynomarchivo[1];

                        $dir=opendir(RAIZ.memoarch_directorio);  //Abre directorio donde se guardaran archivos
                      
                        if(rename($urlanterior, $urlarchivonuevo)) {
                            //cambia campo principal del registro para una nueva insercion del archivo del memo
                            $sql = "UPDATE memo_archivo SET  
                                           memo_archivo_principal_flag = 0,
                                           memo_archivo_estado = 0,
                                           memo_archivo_url = ?
                                    WHERE  memo_archivo_principal_flag = 1 AND memo_archivo_memo_id = ?";
                            $this->pdo->prepare($sql)->execute(array($urlarchivo,$mid));
                            $jsonresponse['success'] = true;
                            $jsonresponse['renopbraarchivo'] = true;
                            $jsonresponse['message'] = 'Archivo renombrado';
                            
                        }else{
                            $jsonresponse['success'] = false;
                            $jsonresponse['renopbraarchivo'] = false;
                            $jsonresponse['message'] = 'Error al subir archivo';
                        }
                        closedir($dir);
                }
                $tipoarch='memo';
                $arrayfile = $this->RegistrarArchivoGenerico($files['addmemoFile'],$tipoarch,$mid,$nummem,$aniomem);

                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Archivo Memo ingresado correctamente'; 
                $jsonresponse['messagefile'] = $arrayfile;
            } catch (Exception $Exception){
            //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
                $jsonresponse['success'] = false;
                $jsonresponse['message'] = 'Error al modificar e registrar el archivo del Memo';
                $jsonresponse['errorQuery'] = $Exception->getMessage();
                $logs = new modelologs();
                $trace=$Exception->getTraceAsString();
                  $logs->GrabarLogs($Exception->getMessage(),$trace);
                  $logs = null;            
            }
        }
        return $jsonresponse;
    }
}
?>