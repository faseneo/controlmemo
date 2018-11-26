<?php
//memo_estado
class MenuItem{
    private $menitem_id;
    private $menitem_nombre;
    private $menitem_url;
    private $menitem_estado;
    private $menitem_memid;
    private $menitem_memnom;

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