<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$objC=new AbmUsuario();
$id=(int)$data['idusuario'];
$listaObj = $objC->buscar(['idusuario'=>$id])[0];
$data["uspass"] = $listaObj->getPassword();
$data["usdeshabilitado"]=$listaObj->getDeshabilitado();
$respuesta = false;
var_dump($data);
if (isset($data['idusuario']) && isset($data['usnombre']) && isset($data['usmail'])){
        echo('entro al modificacion');
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