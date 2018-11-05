<?php
//memo_detalle_estado
class EstadoDetMemo{
    private $est_detmemo_id;
    private $est_detmemo_tipo;
	private $est_detmemo_orden;
    private $est_detmemo_activo;

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
