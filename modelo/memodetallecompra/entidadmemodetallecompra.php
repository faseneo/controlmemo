<?php
//memo_detalle_compra
class MemoDetCompra{
    private $memo_detalle_compra_id;
    private $memo_detalle_compra_nom_producto;
    private $memo_detalle_compra_cantidad;
    private $memo_detalle_compra_valor;
    private $memo_detalle_compra_total;

    private $memo_detalle_compra_memo_detalle_id;
    private $memo_detalle_compra_memo_id;

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