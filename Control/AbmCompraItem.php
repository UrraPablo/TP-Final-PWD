<?php

class AbmCompraItem{

    /** METODOS DE LA CLASE */
    // METODO ABM QUE LLAMA A LOS METODOS CORRESPONDIENTES SEGUN SI SE DA DE ALTA
    // BAJA O MODIFICA
    /**@return boolean */
    public function abmCompraItem($datos){
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
     * @return CompraItem
     */
    private function cargarObjeto($datos){
        $obj=null; 
        
        if(array_key_exists('idcompraitem',$datos) && array_key_exists('idproducto',$datos) 
        && array_key_exists('idcompra',$datos) && array_key_exists('cicantidad',$datos)){
            
            // creo un obj producto
            $objP=new Producto();
            $objP->setId($datos['idproducto']);
            $objP->cargar(); 

            // creo al obj compra 
            $objC=new Compra();
            $objC->setId($datos['idcompra']);
            $objC->cargar(); 

            // seteo al obj compraItem
            $obj=new CompraItem();
            $obj->setear($datos['idcompraitem'],$objP,$objC,$datos['cicantidad']);
            
        }// fin if 
        return $obj; 
    }// fin function 


    /**
     * Espera como parametro un array asociativo donde las claves coinciden  con los atributos 
     * @param array $datos
     * @return CompraItem
     */
    private function cargarObjetoConClave($datos){
        $obj=null;
        if(isset($datos['idcompraitem'])){
            // creo un obj producto
            $objP=new Producto();
            $objP->setId($datos['idproducto']);
            $objP->cargar(); 

            // creo al obj compra 
            $objC=new Compra();
            $objC->setId($datos['idcompra']);
            $objC->cargar(); 

            // seteo al obj compraItem
            $obj=new CompraItem();
            $obj->setear($datos['idcompraitem'],$objP,$objC,$datos['cicantidad']);
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
        if(isset($datos['idcompraitem'],$datos['idproducto'],$datos['idcompra'],$datos['cicantidad'])){
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
        $datos['idcompraitem']=null;
        $objCI=$this->cargarObjeto($datos);
        if($objCI!=null && $objCI->insertar()){
            $resp=true;

        }// fin if 
        return $resp;

    }// fin function 


    /**
     * PERMITE ELIMINAR UN OBJ AUTO
     * @param array $datos
     * @return boolean
     */
    public function baja($datos){
        $resp=false;
        if($this->setadosCamposClaves($datos)){
            $objCI=$this->cargarObjetoConClave($datos);
            if($objCI!=null && $objCI->eliminar()){
                $resp=true;

            }// fin if 


        }// fin if 

        return $resp; 

    }// fin function 

    /**
     * MOFICAR EL OBJ AUTO
     * @param array $datos
     * @return boolean
     */
    public function modificacion($datos){
        $resp=false;
        if($this->setadosCamposClaves($datos)){
            $objCI=$this->cargarObjeto($datos);
            
            if($objCI!=null && $objCI->modificar()){
                $resp=true; 
            }// fin if 

        }// fin if 
        //var_dump($resp);
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
        $objCI=new CompraItem();
        $where=" true ";
        //var_dump($param);
        if($param<>null){
            // Va preguntando si existe los campos de la tabla 
                if(isset($param['idcompraitem'])){  
                    $where.=" and idcompraitem =".$param['idcompraitem'];
                }// fin if     
                if(isset($param['idproducto'])){// identifica si esta la clave (atributo de la tabla)
                    $where.=" and idproducto =".$param['idproducto'];
                }// fin if 
                if(isset($param['idcompra'])){// identifica si esta la clave (atributo de la tabla)
                    $where.=" and idcompra =".$param['idcompra'];
                }// fin if 
                if(isset($param['cicantidad'])){// identifica si esta la clave (atributo de la tabla)
                    $where.=" and cicantidad =".$param['cicantidad'];
                }// fin if 
        }// fin if
        $arreglo=$objCI->listar($where);
       // var_dump($where); 
        return $arreglo; 

    }// fin funcion     

}// fin clase 

?>