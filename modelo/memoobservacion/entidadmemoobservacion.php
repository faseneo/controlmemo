<?php
//departamento
class MemoObservacion{
    private $memoobs_id;
    private $memoobs_texto;
    private $memoobs_fecha;
    private $memoobs_memo_id;
    private $memoobs_usu_id;
    private $memoobs_usu_nom;

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