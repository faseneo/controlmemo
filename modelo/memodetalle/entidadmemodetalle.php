<?php
//memo_detalle
class MemoDetalles{
    private $memo_detalle_id;
    private $memo_detalle_num;
    private $memo_detalle_detmemocc;
    private $memo_detalle_detmemocc_nom;
    private $memo_detalle_solicita;
    private $memo_detalle_descripcion;
    private $memo_detalle_procompra;
    private $memo_detalle_procompra_nom;
    private $memo_detalle_proveedor_id;
    private $memo_detalle_proveedor_nom;
    private $memo_detalle_num_oc_sac;
    private $memo_detalle_num_oc_chc;
    private $memo_detalle_monto_total;
    private $memo_detalle_fecha;
    private $memo_detalle_memo_id;

    private $memo_detalle_estado_id;
    private $memo_detalle_estado_nom;
    private $memo_detalle_estado_fecha;

    private $memo_detalle_usu_id;
    private $memo_detalle_usu_nom;


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