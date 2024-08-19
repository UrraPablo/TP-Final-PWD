<?php
include_once '../../configuracion.php';


$datos=data_submitted();
//$v=json_encode($datos); // convierte el array asociativo en un JSON
//echo $v; // envia los datos a indexLogin con formato JSON

// Validacion del usuario para ingresar a la compra 

if($datos['accion']=='login'){
    $resp=false;
    $datos['password']=md5($datos['password']);
    $session=new Session();
    $salida=$session->iniciar($datos['nombre'],$datos['password']);
    //var_dump($salida);
    if($salida){
        $habilitado = $session->getUsuario()->getDeshabilitado();
        if($habilitado==null || $habilitado=='null' || $habilitado=='0000-00-00 00:00:00'){
            $resp=true;
        }
    }
    echo(json_encode(['respuesta'=>$resp]));
}// fin if 

 
if($datos['accion']=="cerrar"){
    $session=new Session();
    $resp=$session->cerrar();
    
    if($resp){
        header("Location: ../inicio/inicioIndex.php");
    }// fin if
}// fin 



// ACCIONES RELACIONADAS CON LA PAGINA REGISTRER 
if($datos['accion']=='nuevo'){
    $objAbmUsuario=new AbmUsuario();
    $objUR =new AbmUsuarioRol;
    $idCliente = 3; // se asigna el id del cliente por defecto
    $mensaje=[];
    $datos['uspass']=md5($datos['uspass']);
    $id = -100; // como es nuevo que no se repita el iD del usuario
    $mailRepetido = $objAbmUsuario->mailRepetido($datos['usmail'],$id);
    $nombreRepetido = $objAbmUsuario->nombreRepetido($datos['usnombre'],$id);
    
    // VALIDACION DE NO REPITENCIA DEL NOMBRE Y MAIL
    if(!$mailRepetido){
        if(!$nombreRepetido){
            $mensaje["nuevo"]='ok';
           $res = $objAbmUsuario->alta($datos);
            if($res){
                $usuarioNuevo = $objAbmUsuario->buscar(['usmail'=>$datos['usmail']])[0];
                $objUR->alta(['idusuario'=>$usuarioNuevo->getId(),'idrol'=>$idCliente]);

            }// fin if 
        }// fin if 
        else{
            $mensaje['nuevo']='nombreRepetido';

        }// fin else
    }// fin if 
    else{
        $mensaje['nuevo']='mailRepetido';
    }// fin else

    echo(json_encode($mensaje));
}// fin if 

?>


