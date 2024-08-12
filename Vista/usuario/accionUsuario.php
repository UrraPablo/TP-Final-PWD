<?php
    include_once '../../configuracion.php';
   

    $resp=false; 
    $objUsuario=new AbmUsuario();
    $datos=data_submitted();

    // CAMBIOS DE LOS DATOS DEL USUARIO 
    if(isset($datos['accion'])){
        if(($datos['accion']=='Cambiar')){
            $mensaje=[];
            $id=(int)$datos['idusuario'];
            $usuario=$objUsuario->buscar(['idusuario'=>$id])[0];
            $datos['usdeshabilitado'] = $usuario->getDeshabilitado();
            $datos["uspass"] =$usuario->getPassword();
            $mailRepetido=$objUsuario->mailRepetido($datos['usmail'],$id);
            $nombreRepetido=$objUsuario->nombreRepetido($datos['usnombre'],$id);

            if($mailRepetido){
                    $mensaje['cambio']='mailRepetido';
            }// fin if 
            
            if($nombreRepetido){
                $mensaje['cambio']='nombreRepetido';
            }// fin if 
            
            if(!$mailRepetido && !$nombreRepetido){
                if($objUsuario->modificacion($datos)){
                     $mensaje['cambio']='valido';
                }// fin if 
            }// fin if 

            echo(json_encode($mensaje));
        }// fin if


        // // BORRADO DEL USUARIO 
        if($datos['accion']=='Borrar'){
            $id=(int)$datos['idusuario'];
            $usuario=$objUsuario->buscar(['idusuario'=>$id])[0];
            $datos['idusuario']=$usuario->getId();
            $datos['usmail']=$usuario->getMail();
            $datos['usnombre']=$usuario->getNombre();
            $datos["usdeshabilitado"] =date("Y-m-d H:i:s");// Borrador logico del usuario 
            $datos["uspass"] =$usuario->getPassword();
            //var_dump($datos);
            if($objUsuario->modificacion($datos)){
                $resp=true; 
                echo(json_encode($resp));
            }// fin if 
        }// fin if 

        if($datos['accion']=='cambioPass'){

            $password=$datos['pass'];
            $id=(int)$datos['idusuario'];
            $usuario=$objUsuario->buscar(['idusuario'=>$id])[0];
            $datosU['idusuario']=$id;
            $datosU['usnombre']=$usuario->getNombre();
            $datosU['uspass']=md5($password);
            $datosU['usmail']=$usuario->getMail();
            $datosU['usdeshabilitado']=$usuario->getDeshabilitado();
            $objUsuario->modificacion($datosU);
            echo(json_encode(true));
        }// fin if 



    }// fin if

    
?>
