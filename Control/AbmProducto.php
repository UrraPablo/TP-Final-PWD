<?php

class AbmProducto{

    /** METODOS DE LA CLASE */
    // METODO ABM QUE LLAMA A LOS METODOS CORRESPONDIENTES SEGUN SI SE DA DE ALTA
    // BAJA O MODIFICA
    /**@return boolean */
    public function abm($datos){
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
     * @return Producto
     */
    private function cargarObjeto($datos){
        $obj=null; 
        
        if(array_key_exists('idproducto',$datos) && array_key_exists('pronombre',$datos) 
        && array_key_exists('prodetalle',$datos) && array_key_exists('procantstock',$datos)
        && array_key_exists('precio',$datos) && array_key_exists('imagen',$datos)){
            
            $obj=new Producto();
            $obj->setear($datos['idproducto'],$datos['pronombre'],$datos['prodetalle'],$datos['procantstock'],$datos['precio'],$datos['imagen']);
            
        }// fin if 
        return $obj; 
    }// fin function 


    /**
     * Espera como parametro un array asociativo donde las claves coinciden  con los atributos 
     * @param array $datos
     * @return Producto
     */
    private function cargarObjetoConClave($datos){
        $obj=null;
        if(isset($datos['idproducto'])){
            $obj=new Producto();
            $obj->setear($datos['idproducto'],$datos['pronombre'],$datos['prodetalle'],$datos['procantstock'],$datos['precio'],$datos['imagen']);

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
        if(isset($datos['idproducto'],$datos['pronombre'],$datos['prodetalle'],$datos['procantstock'],$datos['precio'],$datos['imagen'])){
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
        $datos['idproducto']=null;
        $objProducto=$this->cargarObjeto($datos);
        if($objProducto!=null && $objProducto->insertar()){
            $resp=true;

        }// fin if 
        return $resp;

    }// fin function 


    /**
     * METDO ELIMINAR
     * @param array $datos
     * @return boolean
     */
    public function baja($datos){
        $resp=false;
        if($this->setadosCamposClaves($datos)){
            $objProducto=$this->cargarObjetoConClave($datos);
            if($objProducto!=null && $objProducto->eliminar()){
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
            $objProducto=$this->cargarObjeto($datos);
            if($objProducto!=null && $objProducto->modificar()){
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
        $objProducto=new Producto();
        $where=" true ";
        if($param<>null){
            // Va preguntando si existe los campos de la tabla 
                if(isset($param['idproducto'])){ 
                $where.=" and idproducto = ".$param['idproducto'];
                }// fin if 
                if(isset($param['pronombre'])){// identifica si esta la clave (atributo de la tabla)
                    $where.=" and pronombre ='".$param['pronombre']."'";
                }// fin if 
                if(isset($param['prodetalle'])){// identifica si esta la clave (atributo de la tabla)
                    $where.=" and prodetalle ='".$param['prodetalle']."'";
                }// fin if 
                if(isset($param['procantstock'])){// identifica si esta la clave (atributo de la tabla)
                    $where.=" and procantstock =".$param['procantstock'];
                }// fin if 
                if(isset($param['precio'])){// identifica si esta la clave (atributo de la tabla)
                    $where.=" and precio =".$param['precio']."";
                }// fin if 
                if(isset($param['imagen'])){// identifica si esta la clave (atributo de la tabla)
                    $where.=" and imagen ='".$param['imagen']."'";
                }// fin if 
        }// fin if
        $arreglo=$objProducto->listar($where);
        return $arreglo; 

    }// fin funcion   
    


}// fin clase 

?>