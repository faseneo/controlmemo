<?php
//usuario_perfil
class UsuPerfil{
    private $perf_id;
    private $perf_nombre;
    private $perf_desc;

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