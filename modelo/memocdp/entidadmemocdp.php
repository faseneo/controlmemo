<?php
//centro_costos
class MemoCDP{
    private $memocdp_id;
    private $memocdp_num;
    private $memocdp_fecha;
    private $memocdp_cod_cc;
    private $memocdp_nom_cc;
    private $memocdp_obs;
    private $memocdp_mem_id;
    
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