<?php
//memo_archivo
class MemoArchivos{
    private $memoarch_id;
    private $memoarch_url;
    private $memoarch_name;
    private $memoarch_type;
    private $memoarch_size;
    private $memoarch_fecha_registro;
    private $memoarch_flag;
    private $memoarch_memo_id;

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