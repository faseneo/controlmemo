<?php
//memo_detalle
class MemoDetalles{
    private $memo_detalle_id;
    private $memo_detalle_descripcion;
    private $memo_detalle_num_oc_chc;
    private $memo_detalle_cdp;
    private $memo_detalle_num_oc_manager;
    private $memo_detalle_num_factura;
    private $memo_detalle_fecha_factura;
    private $memo_detalle_monto_total;
    private $memo_detalle_observaciones;

    private $memo_detalle_memo_id;
    private $memo_detalle_proveedor_id;
    private $memo_detalle_memo_det_estado_id;
    private $memo_detalle_proc_compra_id;

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