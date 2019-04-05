<?php
//usuario
class Usuarios{
    private $usu_id;
    private $usu_rut;
    private $usu_nombre;
    private $usu_password;
    private $usu_rol_id;
	private $usu_rol_nombre;
    private $usu_estado_id;
    private $usu_fecha_ing;
    private $usu_email;
    private $usu_urlimg;
    private $usu_depto_id;
    private $usu_depto_nombre;
    private $usu_perfiles=array();

    public function __GET($k){
        return $this->$k;
    }

    public function __SET($k, $v){
        return $this->$k = $v;
    }

    public function returnArray(){
    	return get_object_vars($this);
    }
}
?>