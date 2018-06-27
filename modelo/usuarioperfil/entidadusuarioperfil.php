<?php
//usuario_perfil
class UsuPerfil{
    private $usu_perfil_id;
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