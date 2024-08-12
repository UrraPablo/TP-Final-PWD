<?php
    include_once '../../configuracion.php';
    

    $resp=false; 
    $objCompra=new AbmCompra();
    $datos=data_submitted();
    
    if(isset($datos['accion'])){
        if(($datos['accion']=='Cambiar')){
            $datos["idcompra"] = intval($datos["idCompra"]);
            $datos["cofecha"] = $datos["fechaCompra"]; 
            $datos["idusuario"] = intval($datos["idUsuario"]);
            if($objCompra->modificacion($datos)){
                $resp=true; 
            }
        }

        
        if($datos['accion']=='Nuevo'){
            //$datos["idCompra"] = intval($datos["idCompra"]);
            $datos["cofecha"] = $datos["fechaCompra"]; 
            $datos["idusuario"] = intval($datos["idUsuario"]);
            if($objCompra->alta($datos)){
                $resp=true;
            }// fin if 
        

        }// fin if

        if($resp){
            $respuesta=['resp'=>$resp];
            echo(json_encode($respuesta));
            $mensaje="La accion ".$datos['accion']."  se realizao correctamente " ;
        }
        else{
            $respuesta=['resp'=>$resp];
            echo(json_encode($respuesta));
            //echo("mensaje error");
            $mensaje="Hubo un problema con la accion ".$datos['accion']." ";
            
        }

    }// fin if

    
?>
