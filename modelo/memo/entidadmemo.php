<?php
//memo
class Memos{
    private $mem_id;
    private $mem_numero;
    private $mem_anio;
    private $mem_materia;
    private $mem_fecha;
    private $mem_fecha_recep;

    private $mem_depto_sol_id;
    private $mem_nom_sol;
    private $mem_depto_sol_nom;

    private $mem_depto_dest_id;
    private $mem_nom_dest;
    private $mem_depto_dest_nom;

    private $mem_fecha_ingr;
/*    private $mem_cc_codigo;
    private $mem_fecha_cdp;
    private $mem_nom_cc;*/

    private $mem_archivos=array();
    
    private $mem_estados=array();
    /*private $mem_estado_id;
    private $mem_estado_obs;  
    private $mem_estado_nombre;
    private $mem_estado_fechamod;*/

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
/*
proveedor_id
proveedor_rut
proveedor_nombre
proveedor_direccion
proveedor_fono
proveedor_ciudad
proveedor_region
proveedor_cuenta
proveedor_contacto_nombre
proveedor_contacto_email
proveedor_contacto_fono
proveedor_estado

 */
?>
