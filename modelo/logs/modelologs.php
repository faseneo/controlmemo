<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
//require_once("../config/config.php");

class ModeloLogs {
    private $pdo;

    public function GrabarLogs($msg, $trace,$nomclase=null){
      $time = time();
      $fechahora = date("d-m-Y(H:i:s)", $time);

      $pathLogs = RAIZ.logdirectorio.logarchivoerror;

      $file = fopen($pathLogs, "a+");
      //$item = array('fecha:'.$fechahora,'msg:'.$msg,'\n trace:'.$trace);
      
      $logfecha='fecha:'.$fechahora;
      $lognomclase='metodo:'.$nomclase;
      $logmsg = 'msg:'.$msg;
      $logtrace = 'trace:'.$trace;

      fwrite($file,$logfecha." \n");
      fwrite($file,$lognomclase." \n");
      fwrite($file,$logmsg." \n");
      fwrite($file,$logtrace." \n");
      //fwrite($file,$dispositivo." \n");
      //fwrite($file,implode('|',$item));
      fwrite($file,"\r");
      fclose($file);
    }

    /*public function __CONSTRUCT(){
        try{
            $this->pdo = new PDO("mysql:host=".HOST.";dbname=".DB, USERDB, PASSDB);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);              
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }  */
}

?>
