<?php
//memo_detalle_estado
class EstadoOCompra{
    private $est_oc_id;
    private $est_oc_tipo;
	private $est_oc_prioridad;
    private $est_oc_activo;

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
