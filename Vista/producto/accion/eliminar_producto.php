<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$id["idproducto"]=$data["idproducto"];
if (isset($data['idproducto'])){
    $objC = new AbmProducto();
    $producto=$objC->buscar($id);
    $data["pronombre"]=$producto[0]->getNombre();
    $data["prodetalle"]=$producto[0]->getDetalle();
    $data["imagen"]=$producto[0]->getImagen();
    $data["precio"]=$producto[0]->getPrecio();
    $data["procantstock"]= 0;
    $respuesta = $objC->modificacion($data);
    if (!$respuesta){
        $mensaje = " La accion  ELIMINACION No pudo concretarse";
    }
}

$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
   
    $retorno['errorMsg']=$mensaje;

}
    echo json_encode($retorno);
?>