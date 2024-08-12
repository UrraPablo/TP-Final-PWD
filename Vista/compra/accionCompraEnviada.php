<?php
include_once '../../configuracion.php';

$datoCI=data_submitted();
$objC=new AbmCompra();
//var_dump($datoCI);

if(isset($datoCI['idcompraitem'])){
    $salida = $objC->itemCancelado($datoCI['idcompraitem']);
    echo(json_encode($salida));
    
}// fin if

if(isset($datoCI['idcompra'])){
    $respuesta =$objC->compraEnviada($datoCI['idcompra']);
    echo(json_encode($respuesta));

}// fin if 


?>