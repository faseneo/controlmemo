<?php
//memo_detalle_archivo
class MemoDetArchivo{
    private $memo_det_arch_id;
    private $memo_det_arch_url;

    private $memo_det_arch_memo_detalle_id;

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