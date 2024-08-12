<?php
include_once '../../configuracion.php';
$datos=data_submitted();
$objCI = new AbmCompraItem();
$objC=new AbmCompra();
$objP=new AbmProducto();

// ELIMINACION LOGICA DE UN ITEM ANTES DE CONFIRMAR LA COMPRA 
if(isset($datos['idItem'])){
    $datosCI['idcompraitem'] =$datos['idItem']; 
    $item =$objCI->buscar($datosCI)[0]; 
    $salida = $objCI->modificacion(['idcompraitem'=>$datos['idItem'],'idcompra'=>$item->getObjCompra()->getId(),'idproducto'=>$item->getObjProducto()->getId(),'cicantidad'=>0]);
    if($salida){
        $mensaje['eliminado']=true;
    }// fin if
    else{
        $mensaje['eliminado']=false;
    }// fin else

    echo(json_encode($mensaje));

}// fin if 

// CAMBIO DE ESTADO DE LA COMPRA
if(isset($datos['idcompra'])&&isset($datos['idCI'])&&isset($datos['cantidad'])){
    $verifica = $objC->verificarProductos($datos);
    if(count($verifica)==0){ // significa que no hay ningun item del producto que supere el stock del mismo
        $objC->registrarProductos($datos);
        $r=$objC->finalizarCompra($datos['idcompra']);
        echo(json_encode($r));
    }// fin if 
    else{

        echo(json_encode($verifica));
    }// fin else
    
}// fin if 





?>