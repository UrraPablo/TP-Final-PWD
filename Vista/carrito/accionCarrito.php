<?php
include_once '../../configuracion.php';
$objCompra=new AbmCompra();

$datos=data_submitted();

if(isset($datos)){
    $respuesta=$objCompra->crearCarrito($datos['idU']);
    //var_dump($respuesta['habilitado']);
    if($respuesta['habilitado']){
        //Ya hay un carrito iniciado
        $cargarProducto=$objCompra->cargarCarrito($respuesta['idcompra'],$datos['idP']);
        if($cargarProducto){
            $mensaje['productoAgregado']=true;
        }// fin if 
        else{
            $mensaje['productoAgregado']='Este producto ya esta cargado en el carrito';
        }// fin else
    }// fin if
    else{
        // se crea el carrito
        if($objCompra->crearCompra((int)$datos['idU'],(int)$datos['idP'])){
            $mensaje['compraCreada']=true;

        }// fin if 
        else{
            $mensaje['compraCreada']='Hubo problemas al crear la compra';

        }

    }// fin else
    echo(json_encode($mensaje));
}// fin if