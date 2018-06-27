<?php
//memo_archivo
class MemoArchivos{
    private $memo_arch_id;
    private $memo_arch_url;

    private $memo_arch_memo_id;

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