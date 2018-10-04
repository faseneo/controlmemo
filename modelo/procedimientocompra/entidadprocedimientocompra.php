<?php
//procedimiento_compra
class ProcCompra{
    private $proc_comp_id;
    private $proc_comp_tipo;
    private $proc_priori;
    private $proc_activo;

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
