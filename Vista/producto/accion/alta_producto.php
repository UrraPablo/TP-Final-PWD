<?php 
include_once "../../../configuracion.php";
$data = data_submitted();
$respuesta = false;
if (isset($data['idproducto']) && isset($data['pronombre']) &&isset($data['precio'])
 && isset($data['prodetalle']) && isset($data['procantstock']) && isset($data['imagen'])){
        $objC = new AbmProducto();
        $respuesta = $objC->alta($data);
        if (!$respuesta){
            $mensaje = " La accion  ALTA No pudo concretarse";
            
        }
}
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
    
    $retorno['errorMsg']=$mensaje;
   
}
 echo json_encode($retorno);
?>