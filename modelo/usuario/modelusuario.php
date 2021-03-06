<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../config/config.php");
require_once("../modelo/logs/modelologs.php");
require_once("../modelo/logs/modelologsquerys.php");

class ModelUsuarios{
    private $pdo;

    public function __CONSTRUCT(){
        try{
            $this->pdo = new PDO("mysql:host=".HOST.";dbname=".DB, USERDB, PASSDB, array(PDO::MYSQL_ATTR_INIT_COMMAND => CHARSETDB));
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);                
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }
    //Lista todos los usuarios, mantenedor
    public function Listar(){
        $jsonresponse = array();
        try{
            $result = array();
 
            $consultalistado="SELECT  us.usuario_id,
                                                us.usuario_rut,
                                                us.usuario_nombre,
                                                us.usuario_email,
                                                us.usuario_usu_rol_id,
                                                us.usuario_estado,
                                                us.usuario_fecha_ingreso,
                                                ur.usu_rol_nombre
                            FROM usuario as us 
                            INNER JOIN usuario_rol as ur ON us.usuario_usu_rol_id= ur.usu_rol_id
                            ORDER BY us.usuario_usu_rol_id ASC";

            $stm = $this->pdo->prepare($consultalistado);
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new Usuarios(); 
                    $busq->__SET('usu_id',          $r->usuario_id);
                    $busq->__SET('usu_rut',         $r->usuario_rut);
                    $busq->__SET('usu_nombre',      $r->usuario_nombre); 
                    $busq->__SET('usu_email',       $r->usuario_email);
                    $busq->__SET('usu_rol_id',      $r->usuario_usu_rol_id);
                    $busq->__SET('usu_rol_nombre',  $r->usu_rol_nombre);
					$busq->__SET('usu_estado_id',   $r->usuario_estado);
                    $busq->__SET('usu_fecha_ing',   $r->usuario_fecha_ingreso);
                    $arraydeptos = $this->ObtenerDeptosUsuario($r->usuario_id);
                            $busq->__SET('usu_deptos', $arraydeptos['datos']);
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
        $this->pdo=null;
		return $jsonresponse;
    }
    // Lista los usuarios por rolid, 
    public function Listarxrol($rolid){
        $jsonresponse = array();
        try{
            $result = array();
            $stm = $this->pdo->prepare("SELECT  us.usuario_id,
                                                us.usuario_rut,
                                                us.usuario_nombre,
                                                us.usuario_email,
                                                us.usuario_usu_rol_id,
                                                us.usuario_estado,
                                                us.usuario_fecha_ingreso,
                                                ur.usu_rol_nombre
                                        FROM usuario as us ,usuario_rol as ur
                                        WHERE us.usuario_usu_rol_id= ur.usu_rol_id
                                        AND  ur.usu_rol_id = ?");
            
            $stm->execute(array($rolid));
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new Usuarios(); 
                    $busq->__SET('usu_id',          $r->usuario_id);
                    $busq->__SET('usu_rut',         $r->usuario_rut);
                    $busq->__SET('usu_nombre',      $r->usuario_nombre); 
                    $busq->__SET('usu_email',       $r->usuario_email);
                    $busq->__SET('usu_rol_id',      $r->usuario_usu_rol_id);
                    $busq->__SET('usu_rol_nombre',  $r->usu_rol_nombre);
                    $busq->__SET('usu_estado_id',   $r->usuario_estado);
                    $busq->__SET('usu_fecha_ing',   $r->usuario_fecha_ingreso);
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
    //Lista por Perfil , usado en listadomemoasigna de adquisiciones
    public function Listarxperfil($perfilid){
        $jsonresponse = array();
        try{
            $result = array();
            $stm = $this->pdo->prepare("SELECT  us.usuario_id,
                                                us.usuario_nombre,
                                                us.usuario_email,
                                                us.usuario_estado
                                        FROM usuario AS us 
                                        LEFT JOIN usu_perfiles AS uper ON uper.usu_perfiles_usuario_id= us.usuario_id
                                        WHERE uper.usu_perfiles_perfiles_id = ? AND us.usuario_estado=1
                                        ORDER BY us.usuario_nombre ASC");
            
            $stm->execute(array($perfilid));
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $fila = array('usu_id'=>$r->usuario_id,
                              'usu_nombre'=>$r->usuario_nombre,
                              'usu_email'=>$r->usuario_email,
                              'usu_estado_id'=>$r->usuario_estado);
                $result[]=$fila;
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
    // trae datos de un usuario por id, , mantenedor
    public function Obtener($id){
        $jsonresponse = array();
        try{
            $consultaobtiene="SELECT  us.usuario_id,
                                                us.usuario_rut,
                                                us.usuario_nombre,
                                                us.usuario_email,
                                                us.usuario_password,
                                                us.usuario_usu_rol_id,
                                                us.usuario_estado,
                                                us.usuario_fecha_ingreso,
                                                ur.usu_rol_nombre
                            FROM usuario as us 
                            INNER JOIN usuario_rol as ur ON us.usuario_usu_rol_id= ur.usu_rol_id
                            WHERE us.usuario_id = ?";
            $stm = $this->pdo->prepare($consultaobtiene);
            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);
            $busq = new Usuarios();
                    $busq->__SET('usu_id',          $r->usuario_id);
                    $busq->__SET('usu_rut',         $r->usuario_rut);
                    $busq->__SET('usu_nombre',      $r->usuario_nombre); 
                    $busq->__SET('usu_email',       $r->usuario_email);
                    $busq->__SET('usu_password',    $r->usuario_password);
                    $busq->__SET('usu_rol_id',      $r->usuario_usu_rol_id);
                    $busq->__SET('usu_rol_nombre',  $r->usu_rol_nombre);
                    $busq->__SET('usu_estado_id',   $r->usuario_estado);
                    $busq->__SET('usu_fecha_ing',   $r->usuario_fecha_ingreso);
                    $arraydeptos = $this->ObtenerDeptosIdUsuario($r->usuario_id);
                            $busq->__SET('usu_deptos', $arraydeptos['datos']);

                    $arrayperfiles = $this->ObtenerPerfilesUsuaro($id);
                            $busq->__SET('usu_perfiles', $arrayperfiles['datos']);

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
    // obtiene perfiles del ususario por su id, , mantenedor
    public function ObtenerPerfilesUsuaro($idusu){
        try{
            $consulta = "SELECT COUNT(*) FROM usu_perfiles where usu_perfiles_usuario_id = ".$idusu;
            $res = $this->pdo->query($consulta);
            if ($res->fetchColumn() == 0) {
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Usuario No tiene asignado perfiles';
                $jsonresponse['datos'] = [];
            }else{
              $stm = $this->pdo->prepare("SELECT  pe.perfiles_id,
                                                  pe.perfiles_nombre,
                                                  up.usu_perfiles_fecha
                                          FROM usu_perfiles as up, 
                                               perfiles as pe
                                          WHERE pe.perfiles_id = up.usu_perfiles_perfiles_id
                                          AND usu_perfiles_usuario_id = ?");
              $stm->execute(array($idusu));
                foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                    $fila = array('perf_id'=>$r->perfiles_id,
                                  'perf_nombre'=>$r->perfiles_nombre,
                                  'usuperfil_fecha'=>$r->usu_perfiles_fecha);
                    $result[]=$fila;
                }

                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Listado perfiles por usuario';
                $jsonresponse['datos'] = $result;

              $stm=null;
            }
            $res=null;
        }catch (Exception $Exception){
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener perfiles';
            $logs = new modelologs();
            $trace=$Exception->getTraceAsString();
              $logs->GrabarLogs($Exception->getMessage(),$trace);
              $logs = null;
        }
        $this->pdo=null;
        return $jsonresponse;
    }
    // obtiene departamentos del ususario por su id, mantenedor
    public function ObtenerDeptosUsuario($idusu){
        try{
            $consulta = "SELECT COUNT(*) FROM dpto_tiene_usu where dpto_tiene_usu_usuario_id = ".$idusu;
            $res = $this->pdo->query($consulta);
            if ($res->fetchColumn() == 0) {
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Usuario No tiene Deptos asignados';
                $jsonresponse['datos'] = [];
            }else{
              $stm = $this->pdo->prepare("SELECT  dtu.dpto_tiene_usu_depto_id,
                                                  dtu.dpto_tiene_usu_usuario_id,
                                                  de.depto_nombre
                                          FROM dpto_tiene_usu as dtu,
                                               departamento as de
                                          WHERE dtu.dpto_tiene_usu_depto_id = de.depto_id
                                          AND dtu.dpto_tiene_usu_usuario_id = ?");
              $stm->execute(array($idusu));
                foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                    $fila = array('depto_id'    => $r->dpto_tiene_usu_depto_id,
                                  'depto_nombre'=> $r->depto_nombre,
                                  'usuario_id'  => $r->dpto_tiene_usu_usuario_id);
                    $result[]=$fila;
                }

                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Listado departamentos por usuario';
                $jsonresponse['datos'] = $result;

              $stm=null;
            }
            $res=null;
        }catch (Exception $Exception){
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener perfiles';
            $logs = new modelologs();
            $trace=$Exception->getTraceAsString();
              $logs->GrabarLogs($Exception->getMessage(),$trace);
              $logs = null;
        }
        return $jsonresponse;
    }
    // obtiene departamentos del ususario por su id generando un arreglo de id de los deptos.
    public function ObtenerDeptosIdUsuario($idusu){
        try{
            $consulta = "SELECT COUNT(*) FROM dpto_tiene_usu where dpto_tiene_usu_usuario_id = ".$idusu;
            $res = $this->pdo->query($consulta);
            if ($res->fetchColumn() == 0) {
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Usuario No tiene Deptos asignados';
                $jsonresponse['datos'] = [];
            }else{
              $stm = $this->pdo->prepare("SELECT  dtu.dpto_tiene_usu_depto_id,
                                                  dtu.dpto_tiene_usu_usuario_id,
                                                  de.depto_nombre
                                          FROM dpto_tiene_usu as dtu,
                                               departamento as de
                                          WHERE dtu.dpto_tiene_usu_depto_id = de.depto_id
                                          AND dtu.dpto_tiene_usu_usuario_id = ?");
              $stm->execute(array($idusu));
                foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                    //$fila = array($r->dpto_tiene_usu_depto_id);
                    $result[]=$r->dpto_tiene_usu_depto_id;
                }

                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Listado departamentos por usuario';
                $jsonresponse['datos'] = $result;

              $stm=null;
            }
            $res=null;
        }catch (Exception $Exception){
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener perfiles';
            $logs = new modelologs();
            $trace=$Exception->getTraceAsString();
              $logs->GrabarLogs($Exception->getMessage(),$trace);
              $logs = null;
        }
        return $jsonresponse;
    }
    // elimina usuario , , mantenedor
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
    // Registra por primera vez un usuario, , mantenedor
    public function Registrar(Usuarios $data){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO usuario (usuario_rut, 
                                        usuario_nombre,
                                        usuario_email,
                                        usuario_password, 
                                        usuario_usu_rol_id,
                                        usuario_estado) 
                            VALUES (?,?,?,?,?,?)";

            $this->pdo->prepare($sql)->execute(array($data->__GET('usu_rut'),
                                                     $data->__GET('usu_nombre'),
                                                     $data->__GET('usu_email'),
                                                     $data->__GET('usu_password'),
													 $data->__GET('usu_rol_id'),
                                                     $data->__GET('usu_estado_id')
                                              ));
            $logsq = new ModeloLogsQuerys();
                $logsq->GrabarLogsQuerys($sql,'0','Registra');
                $logsq = null;
            $idUsu =    $this->pdo->lastInsertId();
            $deptosid =  $data->__GET('usu_depto_id');
            $this->RegistrarUsuDeptos($idUsu,$deptosid);
            /*
            $idestado = 1;
            $deptoid=$data->__GET('usu_depto_id');
            $sqlinsertausuDepto = "INSERT INTO dpto_tiene_usu (dpto_tiene_usu_depto_id,
                                                              dpto_tiene_usu_usuario_id,
                                                              dpto_tiene_usu_estado)
                                    VALUES ($deptoid,$idUsu,$idestado)";
            $logsq2 = new ModeloLogsQuerys();
                $logsq2->GrabarLogsQuerys($sqlinsertausuDepto,'0','RegistrarusuDepto');
                $logsq2 = null;
            $stm = $this->pdo->prepare($sqlinsertausuDepto);
            $stm->execute();*/

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Usuario ingresado correctamente'; 
        } catch (PDOException $pdoException){
            //echo 'Error crear un nuevo elemento busquedas en Registrar(...): '.$pdoException->getMessage();
            //var_dump($jsonresponse);
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener perfiles';
            $jsonresponse['errorQuery'] = $pdoException->getMessage();

            $logs = new modelologs();
            $trace=$Exception->getTraceAsString();
              $logs->GrabarLogs($Exception->getMessage(),$trace);
              $logs = null;

        }
        return $jsonresponse;
    }
    //registra los perfiles asignados al usuario, mantenedor
    public function RegistrarPerfiles($idusu , $perfiles){
        $jsonresponse = array();
        try{
            $consulta = "SELECT COUNT(*) FROM usu_perfiles where usu_perfiles_usuario_id = ".$idusu;
            $res = $this->pdo->query($consulta);

            if ($res->fetchColumn() <> 0) {
                $sql0 = "DELETE FROM usu_perfiles WHERE usu_perfiles_usuario_id = ?";
                $this->pdo->prepare($sql0)->execute(array($idusu));
            }
               foreach ($perfiles as $perfilid) {
                    $sql = "INSERT INTO usu_perfiles (usu_perfiles_usuario_id, usu_perfiles_perfiles_id) VALUES (?,?)";
                    $this->pdo->prepare($sql)->execute(array($idusu,$perfilid));
                }
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Ingresado correctamente';
                $jsonresponse['datos'] = [];
            $res=null;

        }catch (Exception $Exception){
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar perfil(es)';
            $logs = new modelologs();
            $trace=$Exception->getTraceAsString();
              $logs->GrabarLogs($Exception->getMessage(),$trace);
              $logs = null;
        }
        $this->pdo=null;
        return $jsonresponse;
    }
    //actualiza datos del usuario, mantenedor
    public function Actualizar(Usuarios $data){
        $jsonresponse = array();
        //print_r($data);
        try{
            $sql = "UPDATE usuario SET 
                           usuario_rut = ?, 
                           usuario_nombre = ?,
                           usuario_email = ?,
                           usuario_password = ?,
						   usuario_usu_rol_id = ?,
                           usuario_estado = ?
                    WHERE  usuario_id = ?";

            $this->pdo->prepare($sql)->execute(array($data->__GET('usu_rut'),
                                                     $data->__GET('usu_nombre'), 
                                                     $data->__GET('usu_email'), 
                                                     $data->__GET('usu_password'),
                                                     $data->__GET('usu_rol_id'),
                                                     $data->__GET('usu_estado_id'),
                                                     $data->__GET('usu_id'))
                                                );
            $this->RegistrarUsuDeptos($data->__GET('usu_id'),$data->__GET('usu_depto_id'));
            
            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Usuario actualizado correctamente';                 
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al actualizar usuario';             
        }
        return $jsonresponse;
    }
    //registra los departamentos asignados al usuario, mantenedor
    public function RegistrarUsuDeptos($idusu , $deptosid){
        /*
        INSERT INTO `dpto_tiene_usu` (`dpto_tiene_usu_depto_id`, `dpto_tiene_usu_usuario_id`, `dpto_tiene_usu_estado`) 
        VALUES ('87', '1', CURRENT_TIMESTAMP, '1'), ('87', '2', CURRENT_TIMESTAMP, '1');
         */
        $jsonresponse = array();
        try{
            $consulta = "SELECT COUNT(*) FROM dpto_tiene_usu where dpto_tiene_usu_usuario_id = ".$idusu;
            $res = $this->pdo->query($consulta);

            if ($res->fetchColumn() <> 0) {
                $sql0 = "DELETE FROM dpto_tiene_usu WHERE dpto_tiene_usu_usuario_id = ?";
                $this->pdo->prepare($sql0)->execute(array($idusu));
            }
            $idestado = 1;
               //foreach ($perfiles as $perfilid) {
               /*     $sql = "INSERT INTO dpto_tiene_usu (dpto_tiene_usu_usuario_id, dpto_tiene_usu_depto_id,dpto_tiene_usu_estado) 
                            VALUES (?,?,?)";
                    $this->pdo->prepare($sql)->execute(array($idusu,$deptosid,1));*/
                //}
               foreach ($deptosid as $deptoid) {
                    $sql = "INSERT INTO dpto_tiene_usu (dpto_tiene_usu_depto_id, dpto_tiene_usu_usuario_id,dpto_tiene_usu_estado) 
                            VALUES (?,?,?)";
                    $this->pdo->prepare($sql)->execute(array($deptoid,$idusu,$idestado));
                }                
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Ingresado correctamente';
                $jsonresponse['datos'] = [];
            $res=null;

        }catch (Exception $Exception){
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al ingresar perfil(es)';
            $logs = new modelologs();
            $trace=$Exception->getTraceAsString();
              $logs->GrabarLogs($Exception->getMessage(),$trace);
              $logs = null;
        }
        $this->pdo=null;
        return $jsonresponse;
    }
    //Revisar a quien esta asignado antes (no es necesario, puede tener mas de un usuario asignado y un usuario mas de una asignación)
    //Ver permisos para ayudante admin(ingreso de factura)
    public function AsignaMemo($usuid,$memid,$dif,$prio,$coment){
        $jsonresponse = array();
        try{
            $sql = "INSERT INTO asigna_usuario (asigna_usuario_memo_id,
                                                asigna_usuario_usuario_id,
                                                asigna_usuario_comentario,
                                                asigna_usuario_asigna_prioridad_id,
                                                asigna_usuario_asigna_dificultad_id,
                                                asigna_usuario_estado_asignacion_id,
                                                asigna_usuario_ultimamod)
                    VALUES ($memid,$usuid,'$coment',$prio,$dif,1,now())";

            $logsq = new ModeloLogsQuerys();
                $logsq->GrabarLogsQuerys($sql,'0','AsignaMemo');
                $logsq = null;

            $stm= $this->pdo->prepare($sql);
            $stm->execute();

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Memo asignado correctamente';
        }catch(Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al asginar memo al usuario';             
        }
        return $jsonresponse;        
    }
    //Funcion que actualiza estado de la asignacion
    public function CambiaEstadoAsignaMemo($usuid,$memid,$estadonuevo){

        $jsonresponse = array();
        try{
            $sql = "UPDATE asigna_usuario SET asigna_usuario_estado_asignacion_id=$estadonuevo, asigna_usuario_ultimamod=now()
                    WHERE asigna_usuario_memo_id=$memid AND asigna_usuario_usuario_id=$usuid";

            $this->pdo->prepare($sql)->execute();

            $logsq = new ModeloLogsQuerys();
                $logsq->GrabarLogsQuerys($sql,'0','Cambia estado AsignaMemo');
                $logsq = null;

            $stm= $this->pdo->prepare($sql);
            $stm->execute();

            $jsonresponse['success'] = true;
            $jsonresponse['message'] = 'Cambiado estado asignacion correctamente';
        }catch(Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al cambiar estado asignacion';             
        }
        return $jsonresponse;        
    }

    //Funcion que obtiene usuarios asignados del memo, 
    public function ObtenerAsignaMemo($memid){
        $sql=
        $jsonresponse = array();
        $result=array();
        try{
            $consulta = "SELECT count(*) FROM asigna_usuario WHERE asigna_usuario_memo_id = ".$memid;
            $res = $this->pdo->query($consulta);
            $totalasignados = $res->fetchColumn();

            if ($totalasignados == 0) {
                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Memo sin usuarios asignados';
                $jsonresponse['datos'] = [];
            }else{
                $consultaobtiene = "SELECT asu.asigna_usuario_id, 
                                            asu.asigna_usuario_usuario_id, 
                                            usu.usuario_nombre,
                                            asu.asigna_usuario_comentario,
                                            asu.asigna_usuario_fecha, 
                                            asu.asigna_usuario_ultimamod,
                                            ap.asigna_prioridad_texto,
                                            ad.asigna_dificultad_texto,
                                            ea.estado_asignacion_texto,
                                            ea.estado_asignacion_id
                                    FROM asigna_usuario AS asu
                                    LEFT JOIN usuario AS usu ON usu.usuario_id=asu.asigna_usuario_usuario_id
                                    LEFT JOIN asigna_dificultad as ad ON ad.asigna_dificultad_id = asu.asigna_usuario_asigna_dificultad_id
                                    LEFT JOIN asigna_prioridad AS ap ON ap.asigna_prioridad_id = asu.asigna_usuario_asigna_prioridad_id
                                    LEFT JOIN estado_asignacion AS ea ON ea.estado_asignacion_id = asu.asigna_usuario_estado_asignacion_id
                                    WHERE  asu.asigna_usuario_memo_id= ?";

                $stm = $this->pdo->prepare($consultaobtiene);
                $stm->execute(array($memid));
                // formatea fecha date_format(date_create($r->asigna_usuario_fecha),'d-m-Y H:i:s' )
                $arrayString="";
                foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                    $fila = array('asigna_usu_id'           =>  $r->asigna_usuario_id,
                                    'asigna_usu_uid'        =>  $r->asigna_usuario_usuario_id,
                                    'asigna_usu_nom'        =>  $r->usuario_nombre,
                                    'asigna_usu_coment'     =>  $r->asigna_usuario_comentario,
                                    'asigna_usu_fecha'      =>  date_format(date_create($r->asigna_usuario_fecha),'d-m-Y' ),
                                    'asigna_usu_fecha_mod'  =>  date_format(date_create($r->asigna_usuario_ultimamod),'d-m-Y' ),
                                    'asigna_usu_estado'     =>  $r->estado_asignacion_texto,
                                    'asigna_usu_estado_id'  =>  $r->estado_asignacion_id,
                                    'asigna_usu_prioridad'  =>  $r->asigna_prioridad_texto,
                                    'asigna_usu_dificultad' =>  $r->asigna_dificultad_texto
                                  );
                    $result[] = $fila;
                    $arrayString = implode(',', $fila);
                }
                $logsq = new ModeloLogsQuerys();
                    $logsq->GrabarLogsQuerys($consultaobtiene,$totalasignados,'ObtenerAsignaMemo');
                    $logsq = null;

                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Se obtuvo los usuarios asginados correctamente';
                $jsonresponse['datos'] = $result;
            }
        } catch (Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al obtener usuarios';             
        }
        return $jsonresponse;
    }
    // valida usuario al loguearse
    public function valida($user,$pass){
        $jsonresponse = array();
        try{
            $consulta = "SELECT COUNT(*) FROM usuario where usuario_email = '".$user."' AND usuario_password = '".$pass."'";
            
            $res = $this->pdo->query($consulta);
            if ($res->fetchColumn() == 0) {
                $jsonresponse['success'] = false;
                $jsonresponse['message'] = 'Usuario o contraseña incorreto';
                $jsonresponse['datos'] = [];
            }else{
                $stm = $this->pdo->prepare("SELECT  us.usuario_id,
                                                us.usuario_rut,
                                                us.usuario_nombre,
                                                us.usuario_email,
                                                us.usuario_password,
                                                us.usuario_usu_rol_id,
                                                us.usuario_estado,
                                                us.usuario_fecha_ingreso,
                                                ur.usu_rol_nombre,
                                                dtu.dpto_tiene_usu_depto_id
                                            FROM usuario as us 
                                            INNER JOIN usuario_rol as ur ON us.usuario_usu_rol_id= ur.usu_rol_id
                                            LEFT JOIN dpto_tiene_usu as dtu ON us.usuario_id = dtu.dpto_tiene_usu_usuario_id
                                            WHERE us.usuario_email = ? AND us.usuario_password = ?");
                $stm->execute(array($user,$pass));
                $r = $stm->fetch(PDO::FETCH_OBJ);

                $busq = new Usuarios();
                        $busq->__SET('usu_id',          $r->usuario_id);
                        $busq->__SET('usu_rut',         $r->usuario_rut);
                        $busq->__SET('usu_email',       $r->usuario_email);
                        $busq->__SET('usu_nombre',      $r->usuario_nombre); 
                        $busq->__SET('usu_rol_id',      $r->usuario_usu_rol_id);
                        $busq->__SET('usu_rol_nombre',  $r->usu_rol_nombre);
                        $busq->__SET('usu_estado_id',   $r->usuario_estado);
                        //$busq->__SET('usu_depto_id',    $r->dpto_tiene_usu_depto_id);

                        $arraydeptos = $this->ObtenerDeptosIdUsuario($r->usuario_id);
                            $busq->__SET('usu_deptos', $arraydeptos['datos']);
                        $arrayperfiles = $this->ObtenerPerfilesUsuaro($r->usuario_id);
                            $busq->__SET('usu_perfiles', $arrayperfiles['datos']);
                
                $result = $busq->returnArray();
                
                //$fechaactual = date("d-m-Y H:i:s");
                $fechaactual = date("d-m-Y");
                //session_start();
                   $_SESSION["autentica"] = "SIP";
                   $_SESSION["email"] = $r->usuario_email;
                   $_SESSION["uid"] = $r->usuario_id;
                   $_SESSION["nombre"] = $r->usuario_nombre;
                   $_SESSION["rol"] = $r->usuario_usu_rol_id;
                   $deptos="[";
                        foreach($busq->__GET('usu_deptos') as $dep){
                            $deptos .= $dep.',';
                        };
                        $deptos = trim($deptos, ',');
                        $deptos .= ']';
                   $_SESSION["deptos"] = $deptos;
                   $_SESSION["fecactual"] = $fechaactual;
                   $_SESSION["datos"] = $result;

                $jsonresponse['success'] = true;
                $jsonresponse['message'] = 'Validado correctamente';
                $jsonresponse['datos'] = $result;
            }

        }catch(Exception $e){
            //die($e->getMessage());
            $jsonresponse['success'] = false;
            $jsonresponse['message'] = 'Error al validar usuario';             
        }
        return $jsonresponse;    
    }
    // listado usuarios como arreglo
    public function Listar2(){
        $jsonresponse = array();
        try{
            $result = array();
            $stm = $this->pdo->prepare("SELECT  us.usuario_id,
                                                us.usuario_rut,
                                                us.usuario_nombre,
                                                us.usuario_usu_rol_id,
                                                us.usuario_estado,
                                                us.usuario_fecha_ingreso,
                                                ur.usu_rol_nombre
                                        FROM usuario as us ,usuario_rol as ur
                                        WHERE us.usuario_usu_rol_id= ur.usu_rol_id ");
            $stm->execute();
            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                $busq = new Usuarios();
                    $busq->__SET('usu_id',          $r->usuario_id);
                    $busq->__SET('usu_rut',         $r->usuario_rut);
                    $busq->__SET('usu_nombre',      $r->usuario_nombre); 
                    $busq->__SET('usu_rol_id',      $r->usuario_usu_rol_id);
                    $busq->__SET('usu_rol_nombre',  $r->usu_rol_nombre);
                    $busq->__SET('usu_estado_id',   $r->usuario_estado);
                    $busq->__SET('usu_fecha_ing',   $r->usuario_fecha_ingreso);
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