<?php
//memo_detalle_estado
class MemoDetEst{
    private $memo_det_est_id;
    private $memo_det_est_tipo;
	private $memo_det_priori;

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