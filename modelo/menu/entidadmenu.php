<?php
//memo_estado
class Menu{
    private $men_id;
    private $men_nombre;
    private $men_url;
    private $men_descrip;
    private $men_estado;

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