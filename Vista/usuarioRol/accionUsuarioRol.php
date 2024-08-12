<?php
include_once '../../configuracion.php';
$objRolUsuario=new AbmUsuarioRol();
$objUsuario = new AbmUsuario();
$objRol = new AbmRol();
$datos = data_submitted();
if(isset($datos)){
    if($datos['accion']=='asignar'){
        $rolNombre = $objRol->buscar(['rodescripcion'=>$datos['rodescripcion']]);
        $idRol = $rolNombre[0]->getId();
        $nombreRol = $rolNombre[0]->getDescripcion();
        $usuarioNombre = $objUsuario->buscar(['usnombre'=>$datos['usnombre']]);
        $idU = $usuarioNombre[0]->getId();

        // buscar si que no se repita el rol elegido
        $rolRepetido = $objRolUsuario->RolRepetido($idU,$nombreRol); 
        if(!$rolRepetido){
            $objRolUsuario->alta(['idusuario'=>$idU,'idrol'=>$idRol]);
        }// fin if 
                
        echo(json_encode($rolRepetido));
        
    }// fin if 
    
    // seccion borrar rol en la tabla usuario rol
    if($datos['accion']=='borrar'){
        $idu=(int)$datos['idusuario'];
        $idrol=(int)$datos['idrol'];
        $respuesta = $objRolUsuario->baja(['idusuario'=>$idu,'idrol'=>$idrol]);
        if($respuesta){
            echo(json_encode($respuesta));
        }// fin if  

    }// fin if
}// fin if 

?>