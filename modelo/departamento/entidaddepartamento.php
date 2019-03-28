<?php
//departamento
class Departamentos{
    private $depto_id;
    private $depto_nombre;
    private $depto_nomcorto;
    private $depto_estado;
    private $depto_habilita;

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