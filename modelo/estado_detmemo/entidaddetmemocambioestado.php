<?php
//memo_estado
class DetMemoCambioEst{
    private $detmemo_camest_id;
    private $detmemo_camest_memid;
    private $detmemo_camest_estid;
    private $detmemo_camest_obs;
    private $detmemo_camest_fecha;
    private $detmemo_camest_usuid;

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