<?php
//departamento
class AsignaPrioridad{
    private $aprioridad_id;
    private $aprioridad_texto;


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