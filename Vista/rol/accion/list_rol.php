<?php 
include_once "../../../configuracion.php";
$data = data_submitted();
$objControl = new AbmRol();
$list = $objControl->buscar(null);
//var_dump($data);
$arreglo_salida =  array();
foreach ($list as $elem ){
    
    $nuevoElem['idrol'] = $elem->getId();
    $nuevoElem["rodescripcion"]=$elem->getDescripcion();
    array_push($arreglo_salida,$nuevoElem);
}
//verEstructura($arreglo_salida);
echo json_encode($arreglo_salida,false,2);

?>