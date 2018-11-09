<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../modelo/usuario/entidadusuario.php';
require_once '../modelo/usuario/modelusuario.php';

	$rut=$_POST['formRut'];
	$pass=$_POST['formPass'];

$usu = new Usuarios();
$modelUsu = new ModelUsuarios();

if(isset($_REQUEST['Accion'])){
	
}


?>