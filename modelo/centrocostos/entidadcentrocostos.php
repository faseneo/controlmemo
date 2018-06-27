<?php
//centro_costos
class CentroCostos{
    private $ccosto_codigo;
    private $ccosto_nombre;
    private $ccosto_dep_codigo;
    
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