<?php
//memo
class MemoAsociaresolucion{
    private $mem_asoc_id;
    private $mem_asoc_memid;
    private $mem_asoc_resid;//$res_id
    private $mem_asoc_resurl;  //$res_ruta 
    private $mem_asoc_resanio; //$res_anio
    private $mem_asoc_resnum; //$res_numero
    private $mem_asoc_rescatcod;  //$res_categoria
    private $mem_asoc_resfecha; //$res_fecha
    private $mem_asoc_resfechapub;  //$res_fechapub
    private $mem_asoc_fecha_agrega;
    private $mem_asoc_comentario;

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
