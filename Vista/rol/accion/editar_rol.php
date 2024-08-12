<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$objC=new AbmRol();
$id=(int)$data['idrol'];
$listaObj = $objC->buscar(['idrol'=>$id]);
$data['idrol']=$id;
$respuesta = false;
if (isset($data['idrol']) && $data['rodescripcion']){
        $respuesta = $objC->modificacion($data);
    
    if (!$respuesta){

        $sms_error = " La accion  MODIFICACION No pudo concretarse";
        
    }else $respuesta =true;
    
}
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
    
    $retorno['errorMsg']=$sms_error;
    
}
echo json_encode($retorno);
?>