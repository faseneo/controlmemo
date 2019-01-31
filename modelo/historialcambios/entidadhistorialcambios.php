<?php
//memo_estado
class HistorialCambios{
    private $histcamb_id;
    private $histcamb_tipo_id;
    private $histcamb_tipo_nom;
    private $histcamb_tabla;
    private $histcamb_pk;
    private $histcamb_camp_nom;
    private $histcamb_val_ant;
    private $histcamb_val_nuevo;
    private $histcamb_fecha_trans;
    private $histcamb_usu_id;

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