<?php
//usuario
class Usuarios{
    private $usu_id;
    private $usu_rut;
    private $usu_nombre;
    private $usu_password;
    
    private $usu_usu_perfil_id;
	private $usu_perfil_nombre;

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