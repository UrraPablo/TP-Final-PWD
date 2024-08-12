<?php
    include_once '../../configuracion.php';

    $resp=false; 
    $objMenuRol=new AbmMenuRol();
    $listaObj = $objMenuRol->buscar(null);
    $datos=data_submitted();
    
    if(isset($datos['accion'])){
        if(($datos['accion']=='Cambiar')){
            $datos["idusuario"] = intval($datos["idusuario"]);
            $datos["idrol"] = intval($datos["idrol"]); 
            if($objMenuRol->modificacion($datos)){
                $resp=true; 
            }// fin if 
        }// fin if
        if($datos['accion']=='Borrar'){
            if($objMenuRol->baja($datos)){
                $resp=true; 

            }// fin if 

        }// fin if 
        if($datos['accion']=='Nuevo'){
            //echo("<br> nuevo");
            $datos["idusuario"] = intval($datos["idusuario"]);
            $datos["idrol"] = intval($datos["idrol"]); 
            if($objMenuRol->alta($datos)){
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
<a href="indexMenuRol.php">Volver</a>

<?php
include_once("../estructura/footer.php");
?>