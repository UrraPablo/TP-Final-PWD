<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$objC=new AbmUsuario();
$listaObj = $objC->buscar($data["idusuario"]);
$id=$data["idusuario"]-1;
$data["uspass"] = $listaObj[$id]->getPassword();
$respuesta = false;
if (isset($data['idusuario']) && $data['uspass'] && isset($data['usnombre']) && isset($data['usmail']) && isset($data['usdeshabilitado'])){
    if($data['usdeshabilitado'] == "Si"){
        $data['usdeshabilitado'] = "0000-00-00 00:00:00";
    }
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