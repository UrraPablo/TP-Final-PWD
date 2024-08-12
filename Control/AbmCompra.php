<?php

class AbmCompra{

    /** METODOS DE LA CLASE */
    // METODO ABM QUE LLAMA A LOS METODOS CORRESPONDIENTES SEGUN SI SE DA DE ALTA
    // BAJA O MODIFICA
    /**@return boolean */
    public function abmCompra($datos){
        $resp = false;
        if($datos['accion']=='editar'){
            if($this->modificacion($datos)){
                $resp = true;
            }
        }
        if($datos['accion']=='borrar'){
            if($this->baja($datos)){
                $resp =true;
            }
        }
        if($datos['accion']=='nuevo'){
            if($this->alta($datos)){
                $resp =true;
            }
            
        }
        return $resp;

    }// fin metodo abmRol

    /**
     * Espera un Array asociativo y devuelve el obj de la tabla
     * @param array $datos
     * @return object
     */
    private function cargarObjeto($datos){
        $obj=null; 
        //echo("entro cragar objeto");
        if(array_key_exists('idcompra',$datos) && array_key_exists('cofecha',$datos) && array_key_exists('idusuario',$datos)){
            
            // creo al obj usuario
            $objU=new Usuario();
            $objU->setId($datos['idusuario']); 
            $objU->cargar(); 
            // creo al obj compra 
            $obj=new Compra();
            $obj->setear($datos['idcompra'],$datos['cofecha'],$objU);
            
        }// fin if 
        return $obj; 
    }// fin function 


    /**
     * Espera como parametro un array asociativo donde las claves coinciden  con los atributos 
     * @param array $datos
     * @return Compra
     */
    private function cargarObjetoConClave($datos){
        $obj=null;
        if(isset($datos['idcompra'])){
            // creo al obj usuario
            $objU=new Usuario();
            $objU->setId($datos['idusario']);
            $objU->cargar(); 

            $obj=new Compra();
            $obj->setear($datos['idcompra'],$datos['cofecha'],$objU);

        }// fin if 
        return $obj;

    }// fin function 

    /**
     * corrobora que dentro del array asociativo estan seteados los campos
     * @param array $datos
     * @return boolean
     */
    private function setadosCamposClaves($datos){
        $resp=false;
        if(isset($datos['idcompra']) && isset($datos['cofecha']) && isset($datos['idusuario'])){
            echo("entro isset");
            $resp=true;

        }// fin if 
        return $resp;

    }// fin function 

    /**
     * METODO ALTA
     * @param array $datos
     * @return boolean
     */
    public function alta($datos){
        $resp=false;
        $datos['idcompra']=null;
        $objCompra=$this->cargarObjeto($datos);
        if($objCompra!=null && $objCompra->insertar()){
            $resp=true;
        }// fin if 
        return $resp;

    }// fin function 

    /**
     * PERMITE ELIMINAR UN OBJ 
     * @param array $datos
     * @return boolean
     */
    public function baja($datos){
        $resp=false;
        if($this->setadosCamposClaves($datos)){
            $objCompra=$this->cargarObjetoConClave($datos);
            if($objCompra!=null && $objCompra->eliminar()){
                $resp=true;

            }// fin if 


        }// fin if 

        return $resp; 

    }// fin function 

    /**
     * MOFICAR 
     * @param array $datos
     * @return boolean
     */
    public function modificacion($datos){
        $resp=false;
        
        if($this->setadosCamposClaves($datos)){
            $objCompra=$this->cargarObjeto($datos);
            if($objCompra!=null && $objCompra->modificar()){
         
                $resp=true; 

            }// fin if 

        }// fin if 

        return $resp; 

    }// fin function 

 /**
     * METODO BUSCAR
     * Si el parametro es null, devolverá todos los registros de la tabla auto 
     * si se llena con los campos de la tabla devolverá el registro pedido
     * @param array $param
     * @return array
     */
    public function buscar ($param){
        $objCompra=new Compra();
        $where=" true ";
        if($param<>null){
            // Va preguntando si existe los campos de la tabla 
                if(isset($param['idcompra'])){
                    $where.=" and idcompra=".$param['idcompra'];
                }// fin if 
                if(isset($param['cofecha'])){// identifica si esta la clave (atributo de la tabla)
                    $where.="and cofecha ='".$param['cofecha']."'";
                }// fin if 
                if(isset($param['idusuario'])){// identifica si esta la clave (atributo de la tabla)
                    $where.=" and idusuario =".$param['idusuario'];
                }// fin if 
        }// fin if
        $arreglo=$objCompra->listar($where);
        return $arreglo; 

    }// fin funcion   

    /**Esta funcion verifica si esta creada la compra al momento de llenar los pordutos 
     * al carrito
     * @param int idC => id del usuario 
     * @return boolean
     */
    public function crearCarrito($idU){
        $dato['idusuario']=(int)$idU;
        $objCE=new AbmCompraEstado();
        //$objCI=new AbmCompraItem();
        $comprasUsuario=$this->buscar($dato);
        $respuesta['habilitado']=false;
        // PREGUNTA SI EL USUARIO TIENE COMPRAS EFECTUADAS 
        if(count($comprasUsuario)!=0){
            foreach($comprasUsuario as $unCompra){
                // PREGUNTA SI LAS COMPRA QUE TIENE ESTAN EN ESTADO INICIADO
                $data['idcompra']=$unCompra->getId();
                var_dump($data['idcompra']);
                $data['idcompraestadotipo']=1;
                $data['cefechafin']='null';
                $compra=$objCE->buscar($data);
                if(count($compra)!=0){
                    // PREGUNTA SI LAS COMPRAR INICIADAS TIENE ALGUN PRODUCTO
                    $respuesta['habilitado']=true;
                    $respuesta['idcompra']=$unCompra->getId();
  
                    
                }// fin if

            }// fin for 

        }// fin if
        return $respuesta;

    }// fin function 

    
    /** Inicializa la compra y compraestado  */
    /**
     * @param int idU (id del usuario)
     * @param int idP (id del producto)
     * @return boolean
     */
    public function crearCompra($idU,$idP){
        // Datos iniciales por defecto para la compra iniciada 
        $fechaHoy=date("Y-m-d H:i:s"); $salida=false;
        $datosCompra['idusuario']=$idU;
        $datosCompra['cofecha']=$fechaHoy;
        $respuesta=$this->alta($datosCompra); // da de alta a la compra
        
        
        if($respuesta){
            // Crea el obj compra estado con el estado de la compra iniciado
            $compraBuscada = $this->buscar($datosCompra)[0];
            $datosCE['idcompra'] = $compraBuscada->getId(); // id Compra creada
            $datosCE['cefechaini']=$fechaHoy;
            $datosCE['cefechafin']='null';
            $datosCE['idcompraestadotipo']=1;
            // Crea el OBJ compra estado relacionada a la compra recien creada
            $objCE=new AbmCompraEstado();

            $usuario =$this->buscar(['idcompra'=>$datosCE['idcompra']])[0];
            $nombreUsuario =$usuario->getUsuario()->getNombre();
            //var_dump($nombreUsuario);
            $respuestaCE=$objCE->alta($datosCE);
            $objMail = new Mailer($nombreUsuario,'jpablo.urra@est.fi.uncoma.edu.ar'); 
            if($respuestaCE){
                $objMail->mandarMail($datosCE['idcompra']);
                $salidaCargarCarrito=$this->cargarCarrito($datosCE['idcompra'],$idP);
                $salida=($respuestaCE && $salidaCargarCarrito)?true:false;
            }
            

         }// fin if
         return $salida; 


    }// fin function 

    /**
     * Cargar Carrito
     * Añade los productos seleccionado por el usuario al carrito
     * @param int idC  (id de la compra)
     * @param int idP  (id del producto)
     * 
     */
    public function cargarCarrito($idC,$idP){
        // Llama al obj compra item para cargar los productos
        $objCItem=new AbmCompraItem();
        $salida=false;
        //$respuesta=$this->crearCarrito($idU);
        //if($respuesta){
        //}// fin if
        $datosCI['idproducto']=(int)$idP;
        $datosCI['idcompra']=(int)$idC;
        $productoItem=$objCItem->buscar($datosCI);// busca si ya hay productos en compra item
        if(count($productoItem)==0){
            // ingreso el nuevo producto a compra compraItem
            $datosCI['cicantidad']=1; // cantidad por defecto
            $res=$objCItem->alta($datosCI);
            $salida=$res?true:false;
        }// fin if 
        else{ // Ya se encuentra el producto en compra item 
            //$cantidad = $productoItem[0]->getCantidad();
            $datosCI['cicantidad'] =1;//$cantidad;
            $datosCI['idcompraitem']=$productoItem[0]->getId();
            $resp=$objCItem->modificacion($datosCI);
            $salida=$resp?true:false;            

        }// fin else
        
        return $salida; 

    }// fin function 


    /** Esta funcion verifica las cantidades de los 
     *  productos supera  el stock de los mismos 
     * @param array (id compra - ids de compraitem - cantidades de compra item)
     * @return mixed
     */
    public function verificarProductos($datos){
        $objCI = new AbmCompraItem();
        $resultados=[];

        for($i=0; $i<count($datos['idCI']);$i++){
            $id=$datos['idCI'][$i];
            $unItem=$objCI->buscar(['idcompraitem'=>$id])[0];
            $stock = $unItem->getObjProducto()->getStock();
            $cant=$datos['cantidad'][$i];
            $cant=(int)$cant;

            if($cant>$stock){ // guarda los idtem que superan el stock del producto
                array_push($resultados,$datos['idCI'][$i]);
            }// fin if

        }// fin for

        return $resultados;
    }// fin function 

    /**
     * Esta funcion recorre los item comprados y modifica el
     * stock de los productos
     * @param array  
     */
    public function registrarProductos($datos){
        $objCI=new AbmCompraItem();
        
        for($i=0;$i<count($datos['idCI']);$i++){
            $id=$datos['idCI'][$i];
            $id=(int)$id;
            $unItem = $objCI->buscar(['idcompraitem'=>$id])[0];

            // seteo la cantidad del Item
            $param['idcompraitem']=$id;
            $param['idcompra']=(int)$datos['idcompra'];
            $param['idproducto']=(int)$unItem->getObjProducto()->getId();
            $param['cicantidad']=(int)$datos['cantidad'][$i];
            // seteo de datos en la BD de compra item 
            $objCI->modificacion($param);
            // llama a actualizar la cantidad de stock del producto
            $this->actualizarProductosComprados($param['idproducto'],$param['cicantidad']);

        }// fin for     

    }// fin function

        /**
     * modifica la cantidad de productos comprados descontando el stock
     * @param int id (del producto)
     * @param int (cantidad del item que se descuenta del stock del producto)
     */
    public function actualizarProductosComprados($id,$cant){
        $objP=new AbmProducto();
        $unP = $objP->buscar(['idproducto'=>$id])[0];

        $stock = $unP->getStock();
        $cantidad =$cant;
        $datosP['idproducto']=$unP->getId();
        $datosP['pronombre']=$unP->getNombre();
        $datosP['prodetalle']=$unP->getDetalle();
        $datosP['procantstock']=($stock-$cantidad);
        $datosP['precio']=$unP->getPrecio();
        $datosP['imagen']=$unP->getImagen();
        $objP->modificacion($datosP);

    }// fin function 

    /**
     * Esta funcion modifica la fecha fin de la compra iniciada 
     * y cambia es estado de la compra a pagado
     * @param int idC (id de la compra)
     */
    public function finalizarCompra($idC){
        $objCE = new AbmCompraEstado();
        $usuario =$this->buscar(['idcompra'=>$idC])[0];
        $nombreUsuario =$usuario->getUsuario()->getNombre();
        $objMail = new Mailer($nombreUsuario,'jpablo.urra@est.fi.uncoma.edu.ar'); 
        $dato['idcompra']=$idC;
        $compraEstadoInicial = $objCE->buscar(['idcompra'=>$idC,'idcompraestadotipo'=>1])[0];
        // MODIFICAR LA FECHA FIN DE LA COMPRA INICIADA
        $datos['idcompra']=$idC;
        $datos['idcompraestadotipo']=1;
        $datos['idcompraestado']=$compraEstadoInicial->getId();
        $datos['cefechaini']=$compraEstadoInicial->getFechaInicio();
        $datos['cefechafin']=date("Y-m-d H:i:s");
        $respuesta=$objCE->modificacion($datos);
        if($respuesta){
            // CAMBIO DEL ESTADO DE LA COMPRA 
            $datosCE['idcompra']=$idC;
            $datosCE['idcompraestadotipo']=2;
            $datosCE['cefechaini']=$datos['cefechafin'];
            $datosCE['cefechafin']='null';
            $res=$objCE->alta($datosCE);
            $objMail->mandarMail($idC);
        }// fin if 
    

        return ($res)?true:false;

    }// fin function 



    /**
     * Esta funcion devuelve la cantidad
     * del producto al stock 
     * @param int (idItem)
     * @return boolean
     */
    public function itemCancelado($idItem){
        $objCI = new AbmCompraItem();
        $objP=new AbmProducto();
        
        // llamado al obj item
        $unItem = $objCI->buscar(['idcompraitem'=>$idItem])[0];
        $datos['idcompraitem']=$idItem;
        $datos['idproducto']=$unItem->getObjProducto()->getId();
        $datos['idcompra']=$unItem->getObjCompra()->getId();
        
        // modificacion del stock del producto 
        $producto=$objP->buscar(['idproducto'=>$datos['idproducto']])[0];
        $stockNuevo = intval($unItem->getCantidad())+intval($producto->getStock());
        $datos['cicantidad']=0; // borrado logico 
        
        $salidaCI = $objCI->modificacion($datos); // modificacion del item 
        
        $datosP['idproducto']=$datos['idproducto'];
        $datosP['procantstock']=$stockNuevo;
        $datosP['pronombre']=$producto->getNombre();
        $datosP['prodetalle']=$producto->getDetalle();
        $datosP['precio']=$producto->getPrecio();
        $datosP['imagen']=$producto->getImagen();
        
        $salidaP = $objP->modificacion($datosP);

        return($salidaCI && $salidaP)?true:false;

    }// fin function 

    /**
     * Esta funcion cambia el estado de la compra 
     * a enviada 
     * @param int idCompra
     * @return boolean
     */
    public function compraEnviada($idC){
        $objCE = new AbmCompraEstado();
        $usuario =$this->buscar(['idcompra'=>$idC])[0];
        $nombreUsuario =$usuario->getUsuario()->getNombre();
        $objMail = new Mailer($nombreUsuario,'jpablo.urra@est.fi.uncoma.edu.ar'); 

        $ultimaCompraEstado = $objCE->buscar(['idcompra'=>$idC,'idcompraestadotipo'=>2])[0];
        $param['idcompra']=$idC;
        $param['idcompraestadotipo']=2;
        $param['cefechaini'] = $ultimaCompraEstado->getFechaInicio();
        $param['cefechafin']=date('Y-m-d H:i:s');
        $param['idcompraestado']=$ultimaCompraEstado->getId();

        $res= $objCE->modificacion($param);

        //Cambio al nuevo estado de la compra
        $datos['idcompraestadotipo']=3;
        $datos['idcompra']=$idC;
        $datos['cefechaini']=$param['cefechafin'];
        $datos['cefechafin']='null';
        $resAlta = $objCE->alta($datos);
        $objMail->mandarMail($idC);

        return ($res&&$resAlta)?true:false;

    }// fin function 

    /**
     * esta funcion cambia el estado de la compra a cancelado
     * @param int idC
     * @return boolean
     */
    public function cancelarCompra($id){
        $objCE=new AbmCompraEstado();
        $usuario =$this->buscar(['idcompra'=>$id])[0];
        $nombreUsuario =$usuario->getUsuario()->getNombre();
        $objMail = new Mailer($nombreUsuario,'jpablo.urra@est.fi.uncoma.edu.ar'); 

        $ultimaCE=$objCE->buscar(['idcompra'=>$id,'cefechafin'=>'null'])[0];
        $param['idcompraestado']=$ultimaCE->getId();
        $param['idcompra']=$id;
        $param['cefechaini']=$ultimaCE->getFechaInicio();
        $param['idcompraestadotipo']=$ultimaCE->getObjCompraEstadoTipo()->getId();
        $param['cefechafin']=date('Y-m-d H:i:s');

        $res = $objCE->modificacion($param);
        // ALta al cambio de estado cancelado
        $param['cefechaini']=$param['cefechafin'];
        $param['cefechafin']='null'; 
        $param['idcompraestadotipo']=4;

        $salida = $objCE->alta($param);
        $objMail->mandarMail($id);

        return ($salida && $res)?true:false;

    }// fin function 



}// fin clase AbmCmpra
