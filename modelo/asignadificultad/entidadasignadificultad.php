<?php
//departamento
class AsignaDificultad{
    private $adificultad_id;
    private $adificultad_texto;


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