<?php
//proveedor
class Proveedores{
    private $prov_id;
    private $prov_nombre;
    private $prov_rut;
    private $prov_direccion;
    private $prov_fono;
    private $prov_ciudad;
    private $prov_region;
    private $prov_cuenta;
    private $prov_contacto_nombre;
    private $prov_contacto_email;
    private $prov_contacto_fono;
    private $prov_estado;

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