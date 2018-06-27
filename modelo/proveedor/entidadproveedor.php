<?php
//proveedor
class Proveedores{
    private $prov_id;
    private $prov_nombre;
    private $prov_rut;
    

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