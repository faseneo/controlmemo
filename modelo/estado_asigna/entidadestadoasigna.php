<?php
//departamento
class EstadoAsigna{
    private $est_asigna_id;
    private $est_asigna_texto;


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