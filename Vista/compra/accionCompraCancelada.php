<?php
    include_once '../../configuracion.php';
 
    $objCompra=new AbmCompra();
    $datos=data_submitted();
    $cont=0;
    foreach($datos['idIs'] as $id){
        $iditem=(int)$id;
        // va guardando las respuestas cada item almacenado
        if($objCompra->itemCancelado($iditem)){
            $cont++;
        }
    }//fin for
    var_dump($cont);
    var_dump(count($datos['idIs']));


    if($cont==count($datos['idIs'])){

        $salida = $objCompra->cancelarCompra((int)$datos['idcompra']);
        if($salida){
            $mensaje='compra cancelada';
        }//fin if 
        else{
            $mensaje='no se pudo cambiar el estado de la compra';
        }// fin else
    } // fin if 
    else{
        $mensaje='No se pudo cancelar todos los items ';
    }

    echo(json_encode($mensaje));

?>