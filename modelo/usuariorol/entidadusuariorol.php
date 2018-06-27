<?php
//usuario_rol
class UsuarioRol{
    private $usuario_rol_id;
    private $usuario_rol_nombre;


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