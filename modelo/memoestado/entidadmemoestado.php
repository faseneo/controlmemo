<?php
//memo_estado
class MemoEst{
    private $memo_est_id;
    private $memo_est_tipo;
    private $memo_est_prioridad;

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