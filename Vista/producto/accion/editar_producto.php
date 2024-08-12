<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$objC=new AbmProducto();
$listaObj = $objC->buscar($data["idproducto"]);
$respuesta = false;
if (isset($data['idproducto']) && isset($data['pronombre']) && isset($data['prodetalle']) 
&& isset($data['procantstock']) && isset($data['imagen']) && isset($data['precio'])){
    $respuesta = $objC->modificacion($data);
    
    if (!$respuesta){

        $sms_error = " La accion  MODIFICACION No pudo concretarse";
        
    }//else $respuesta =true;
    
}
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
    
    $retorno['errorMsg']=$sms_error;
    
}
echo json_encode($retorno);
?>