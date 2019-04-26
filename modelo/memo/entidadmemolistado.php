<?php
//memo
class MemosListado{
    private $mem_id;
    private $mem_numero;
    private $mem_anio;
    private $mem_materia;
    private $mem_fecha;
    private $mem_fecha_recep;
    private $mem_depto_sol_nom;
    private $mem_depto_dest_nom;
    private $mem_estado_id_max;
    private $mem_estado_nom_max;    
    private $mem_estado_colorbg;
    private $mem_estado_colortxt;
    private $mem_estado_obs_max;  
    private $mem_estado_fecha_max;
    private $mem_estado_dias;

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
