<?php
//memo
class Memos{
    private $mem_id;
    private $mem_numero;
    private $mem_fecha_recep;
    private $mem_fecha;
    private $mem_fecha_analista;

    private $mem_depto_id;
    private $mem_ccosto_id;
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