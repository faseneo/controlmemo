<?php
//memo_estado
class MemoCambioEst{
    private $memo_camest_id;
    private $memo_camest_memid;
    private $memo_camest_estid;
    private $memo_camest_obs;
    private $memo_camest_usuid;
    private $memo_camest_fecha;

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