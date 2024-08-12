<?php
    include_once '../../configuracion.php';


    $resp=false; 
    $objMenu=new AbmMenu();
    $objMenuRol=new AbmMenuRol();
    $objRol=new AbmRol();
    $datos=data_submitted();
    
    if(isset($datos['accion'])){
        if(($datos['accion']=='Cambiar')){
            $resp=false;
            $datos["idmenu"] = intval($datos["idmenu"]);
            //$unMenu=$objMenu->buscar($datos['idmenu'])[0];
            $datos["idpadre"] =$datos["idpadre"]=='null'?'null':(int)$datos['idpadre'];
            $datos["medeshabilitado"] =$datos["medeshabilitado"]=='SI'?null:date("Y-m-d H:i:s");
            var_dump($datos['medeshabilitado']);

            if($datos['submenu']=='SI'){
                $datos['medescripcion']='';
                if($objMenu->modificacion($datos)){
                     $resp=true; 
                }// fin if 
                var_dump($resp);
                if($resp){
                    $datosNuevo['menombre']=$datos['subitem'];
                    $datosNuevo['medescripcion']=$datos['subitemD'];
                    $datosNuevo['idpadre']=$datos['idmenu'];
                    $datosNuevo['medeshabilitado']=null;
                    //$objMenu->alta($datosNuevo);

                    // busco el objmenu recien creado
                    $menuCreado =$objMenu->buscar(['idpadre'=>$datos['idmenu']]);
                    $ultimo=count($menuCreado)-1;
                    //var_dump($ultimo);
                    $idMenu = $menuCreado[$ultimo]->getId();
                    $listaMenuRoles=$objMenuRol->buscar(['idmenu'=>$datos['idmenu']]);
                    //var_dump($idMenu);

                    // Asignacion de los roles a submenu (por defecto son los mismos que del menu padre)
                    foreach($listaMenuRoles as $unMenuRol){
                        $idRol = $unMenuRol->getObjRol()->getId();
                        //var_dump($idRol);
                        $objMenuRol->alta(['idmenu'=>$idMenu,'idrol'=>$idRol]);

                    }// fin for

                }// fin if 


            }// fin if 
            else{
                if($objMenu->modificacion($datos)){
                    $resp=true; 
                }// fin if 

            }// fin else

            echo(json_encode($resp));
        }// fin if


        if($datos['accion']=='Borrar'){
            $id=(int)$datos['id'];
            $unMenu=$objMenu->buscar(['idmenu'=>$id])[0];
            $nombre=$unMenu->getNombre();
            $descripcion=$unMenu->getDescripcion();
            $habilitado=$unMenu->getDeshabilitado();
            if($unMenu->getobjMenuPadre()==null){
                $idPadre=null;
            }// fin if 
            else{
                $idPadre=$unMenu->getobjMenuPadre()->getId();
            }// fin else
            $datosMenu['idmenu']=$id;
            $datosMenu['menombre']=$nombre;
            $datosMenu['medescripcion']=$descripcion;
            $datosMenu['medeshabilitado']=date("Y-m-d H:i:s");
            $datosMenu['idPadre']=$idPadre;
           $salida=$objMenu->modificacion($datosMenu);
            if($salida){
                $mensaje['eliminar']=true;
                
            }
            else{
                $mensaje['eliminar']=false;

            }
             echo(json_encode($mensaje));

        }// fin if 


        if($datos['accion']=='Nuevo'){
            $resp=false;
            $datos['idpadre']='null';
            $datos['medeshabilitado']='null';
            if($objMenu->alta($datos)){
                $resp=true;
            }// fin if  
            if($resp){
                $menu=$objMenu->buscar(['medescripcion'=>$datos['medescripcion']])[0];
                $idMenu = $menu->getId();
                // asignacion del nuevo menu con los roles
                foreach($datos['rol'] as $valor){
                    $idRol = (int)$valor;
                    $objMenuRol->alta(['idmenu'=>$idMenu,'idrol'=>$idRol]);
                } // fin for 
            }
            echo(json_encode($resp));


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