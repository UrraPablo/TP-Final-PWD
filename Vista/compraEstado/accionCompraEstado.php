<?php
    include_once '../../configuracion.php';
    //$Titulo = "Lista de Compras";
    //include_once '../estructura/headPrivado.php';
    $hoja = "Compras";
    

    $resp=false; 
    $objCompra=new AbmCompra();
    $listaObj = $objCompra->buscar(null);
    $datos=data_submitted();
    
    if(isset($datos['accion'])){
        if(($datos['accion']=='Cambiar')){
            $datos["idCompra"] = intval($datos["idCompra"]);
            $datos["idMarca"] = intval($datos["idMarca"]); 
            $datos["idTipo"] = intval($datos["idTipo"]);
            $datos["precio"] = floatval($datos["precio"]);
            var_dump($datos);
            if($objCompra->modificacion($datos)){
                $resp=true; 
            }// fin if 
        }// fin if
        if($datos['accion']=='Borrar'){
            if($objCompra->baja($datos)){
                $resp=true; 

            }// fin if 

        }// fin if 
        if($datos['accion']=='Nuevo'){
            //echo("<br> nuevo");
            $datos["idCompra"] = intval($datos["idCompra"]);
            $datos["idMarca"] = intval($datos["idMarca"]); 
            $datos["idTipo"] = intval($datos["idTipo"]);
            $datos["precio"] = floatval($datos["precio"]);
            if($objCompra->alta($datos)){
                $resp=true;
            }// fin if 

        }// fin if

        if($resp){
            $mensaje="La accion ".$datos['accion']."  se realizao correctamente " ;
        }
        else{
            //echo("mensaje error");
            $mensaje="Hubo un problema con la accion ".$datos['accion']." ";
            
        }

    }// fin if

    
?>
<!--
<div class="container">
<?php
//    echo($mensaje);
    ?>
</div>
<a href="indexCompra.php">Volver</a>

-->


<?php
//include_once("../estructura/footer.php");
?>