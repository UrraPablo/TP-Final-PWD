<?php
include_once "../../../configuracion.php";
$objRolUsuario=new AbmUsuarioRol();
$objRol=new AbmRol();
$objMenuRol=new AbmMenuRol();
$data = data_submitted();
$mensaje=[];
if(isset($data['idrol'])){

    $idRol=(int)$data["idrol"];
    $usuarios = $objRolUsuario->buscar(['idrol'=>$idRol]); // todos los usuario con ese rol. 
    //var_dump($usuarios[0]->getObjUsuario()->getId());
    // recupero los id del usuario con ese rol 
    $bajasUsuario=0;
    
    if(count($usuarios)!=0){
        foreach($usuarios as $unU){
            $id=$unU->getObjUsuario()->getId();
            if($objRolUsuario->baja(['idusuario'=>$id,'idrol'=>$idRol])){
                $bajasUsuario++;
            }// fin if 
        }// fin for 

    }// fin if
    else{
        $mensaje['bajaUsuario']='sinUsuario';
    } // fin else

    //var_dump($bajasUsuario);
    $bajasMenu = 0; 
    // Busca los items menu con ese rol 
    $menusRol = $objMenuRol->buscar(['idrol'=>$idRol]);
    //var_dump(count($menusRol));
    if(count($menusRol)!=0){
            //echo('entro');
            // llamo a a menu rol para saber que parte del menu esta afetado a ese rol
            foreach($menusRol as $unMenuRol){
                $idMenu = $unMenuRol->getObjMenu()->getId();
                if($objMenuRol->baja(['idmenu'=>$idMenu,'idrol'=>$idRol])){
                    $bajasMenu++;
                }// fin if 
            }// fin for 

    }// fin if
    else{
        $mensaje['bajaRol']='sinRol';
    } 
    //var_dump($bajasMenu);
        $objRol->baja(['idrol'=>$idRol]);
        $mensaje['bajaUR']='ok';


    echo(json_encode($mensaje));
}// fin if
?>