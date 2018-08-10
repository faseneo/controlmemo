<?php
//require_once("../config/config.php");
    # Clase Conection que se encarga de realizar la conexion con la base de datos usando PDO
    class Conexion {
        public  $con;
        # Funcion estatica que devuelve la conexion si no encuentra ningun error
        public  function connect() {

        # Realizamos un try and catch (prueba y captura del error).
        # Si la prueba es verdadera ejecuta el codigo que hay en su interior: realiza la conexion con la base de datos y lo devuelve como valor del metodo
        # Si da error mostrara en pantalla un error en pantalla con el numero de linea que se esta ejecutando mal en el codigo
            try {
                $this->con = new PDO("mysql:host=".HOST."; dbname=".DB, USERDB, PASSDB,array(PDO::MYSQL_ATTR_INIT_COMMAND => CHARSETDB)); 
                //, array(PDO::MYSQL_ATTR_INIT_COMMAND => CHARSETDB)
                $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
               /* $link = new PDO('mysql:host=' . $host . '; dbname=' . $dbname, $dbuser, $dbpass,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => $charset));
                $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);*/
                return $this->con;

            } catch (Exception $e) {
                $logs = new modelologs();
                $trace=$e->getTraceAsString();
                $logs->GrabarLogs($e->getMessage(),$trace,get_class($this));
                $logs = null;
                die();
                return null;
            }
        }
    }
?>
