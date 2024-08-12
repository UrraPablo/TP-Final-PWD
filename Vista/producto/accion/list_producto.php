<?php 
include_once "../../../configuracion.php";
$data = data_submitted();
$objControl = new AbmProducto();
$list = $objControl->buscar(null);
$arreglo_salida =  array();
foreach ($list as $elem ){
    
    $nuevoElem['idproducto'] = $elem->getId();
    $nuevoElem["pronombre"]=$elem->getNombre();
    $nuevoElem["prodetalle"]=$elem->getDetalle();
    $nuevoElem["procantstock"]=$elem->getStock();
    $nuevoElem["precio"]=$elem->getPrecio();
    $nuevoElem["imagen"]=$elem->getImagen();
    array_push($arreglo_salida,$nuevoElem);
}
//verEstructura($arreglo_salida);
echo json_encode($arreglo_salida, false, 2);

?>