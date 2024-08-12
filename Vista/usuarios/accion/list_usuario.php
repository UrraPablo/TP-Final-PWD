<?php 
include_once "../../../configuracion.php";
$data = data_submitted();
//var_dump($data);
$objControl = new AbmUsuario();
$list = $objControl->buscar(null);
//var_dump($data);
$arreglo_salida =  array();
foreach ($list as $elem ){
    
    $nuevoElem['idusuario'] = $elem->getId();
    $nuevoElem["usnombre"]=$elem->getNombre();
    if( "0000-00-00 00:00:00" == $elem->getDeshabilitado()){
        $nuevoElem["usdeshabilitado"]= "Si";
    }else{
        $nuevoElem["usdeshabilitado"]=$elem->getDeshabilitado();
    }
    $nuevoElem["usmail"]=$elem->getMail();
    array_push($arreglo_salida,$nuevoElem);
}
//verEstructura($arreglo_salida);
echo json_encode($arreglo_salida,false,2);

?>