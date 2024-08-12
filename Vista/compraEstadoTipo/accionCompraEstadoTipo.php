<?php
    include_once '../../configuracion.php';
    $Titulo = "Lista de ComprasET";
    include_once '../estructura/headPrivado.php';


    $resp=false; 
    $objCompraET=new AbmCompraEstadoTipo();
    $listaObj = $objCompraET->buscar(null);
    $datos=data_submitted();
    
    if(isset($datos['accion'])){
        if(($datos['accion']=='Cambiar')){
            $dato["idcompraestadotipo"] = intval($datos["Id"]);
            $dato["cetdescripcion"] = $datos["cetdescripcion"]; 
            $dato["cetdetalle"] = $datos["cetdetalle"];
            if($objCompraET->modificacion($dato)){
                $resp=true; 
            }// fin if 
        }// fin if

        if($datos['accion']=='Nuevo'){

            $dato["idCompraestadotipo"] = intval($datos["Id"]);
            $dato["cetdescripcion"] = $datos["cetdescripcion"]; 
            $dato["cetdetalle"] = $datos["cetdetalle"];
            if($objCompraET->alta($dato)){
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

<div class="container">
    <?php
    echo($mensaje);
    ?>
</div>
<a href="indexCompraEstadoTipo.php">Volver</a>

<?php
include_once("../estructura/footer.php");
?>