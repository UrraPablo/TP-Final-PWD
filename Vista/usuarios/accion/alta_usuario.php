<?php 
include_once "../../../configuracion.php";
$data = data_submitted();
$objR = new AbmRol();
$objUR =new AbmUsuarioRol();
$rol = $objR->buscar(['rodescripcion'=>'cliente'])[0];
$idCliente = $rol->getId();
//var_dump($data);
$respuesta = false;
if (isset($data['idusuario']) && $data['uspass'] && isset($data['usnombre']) && isset($data['usmail']) && isset($data['usdeshabilitado'])){
        $objC = new AbmUsuario();
        $data['uspass']=md5($data['uspass']);
        $respuesta = $objC->alta($data);
        if (!$respuesta){
            $mensaje = " La accion  ALTA No pudo concretarse";
            
        }
        //$objUR->alta(['idusuario'=>(int)$data['idusuario'],'idrol'=>$idCliente]);
}
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
    
    $retorno['errorMsg']=$mensaje;
   
}
 echo json_encode($retorno);
?>