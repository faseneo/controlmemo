<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
//require_once("../config/config.php");

class ModeloLogsQuerys {
    private $pdo;

    public function GrabarLogsQuerys($consulta, $resultado,$nomclase=null){
      $time = time();
      $fechahora = date("d-m-Y(H:i:s)", $time);

      $pathLogs = RAIZ.logdirectorio.logarchivoquerys;

      $file = fopen($pathLogs, "a+");
      //$item = array('fecha:'.$fechahora,'consulta:'.$consulta,'\n trace:'.$trace);
      
      $logfecha='Fecha:'.$fechahora;
      $lognomclase='Metodo:'.$nomclase;
      $logmsg = 'Consulta:'.$consulta;
      $logtrace = 'Resultado:'.$resultado;

      fwrite($file,$logfecha." \n");
      fwrite($file,$lognomclase." \n");
      fwrite($file,$logmsg." \n");
      fwrite($file,$logtrace." \n");
      //fwrite($file,$dispositivo." \n");
      //fwrite($file,implode('|',$item));
      fwrite($file,"---------------------------------------------------------------------\n\r");
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
