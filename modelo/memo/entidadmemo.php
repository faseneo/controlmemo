<?php
//memo
class Memos{
    private $mem_id;
    private $mem_fecha;
    private $mem_numero;
    private $mem_fecha_recep;
    private $mem_anio;
    private $mem_materia;
    private $mem_nom_sol;
    private $mem_depto_sol_id;
    private $mem_nom_dest;
    private $mem_depto_dest_id;
    private $mem_archivos=array();
    private $mem_estado_id;
    private $mem_fecha_ingr;

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