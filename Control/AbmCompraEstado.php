<?php

class AbmCompraEstado{

    
    /** METODOS DE LA CLASE */
    // METODO ABM QUE LLAMA A LOS METODOS CORRESPONDIENTES SEGUN SI SE DA DE ALTA
    // BAJA O MODIFICA
    /**@return boolean */
    public function abmCompraEstado($datos){
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
     * @return CompraEstado
     */
    private function cargarObjeto($datos){
        $obj=null; 
        //var_dump($datos);
        if(array_key_exists('idcompraestado',$datos) && array_key_exists('idcompra',$datos) 
        && array_key_exists('idcompraestadotipo',$datos) && array_key_exists('cefechaini',$datos) 
        && array_key_exists('cefechafin',$datos) ){
            //echo("entro al cargar obj");    
            // creo al obj compra
            $objC=new Compra();
            $objC->setId($datos['idcompra']); 
            $objC->cargar(); 
            
            // creo el obj compraestadotipo
            $objCET=new CompraEstadoTipo();
            $objCET->setId($datos['idcompraestadotipo']);
            $objCET->cargar();
        
            // creo al obj compra 
            $obj=new CompraEstado();
            $obj->setear($datos['idcompraestado'],$objC,$objCET,$datos['cefechaini'],$datos['cefechafin']);
               
        }// fin if 

        return $obj; 
    }// fin function 


    /**
     * Espera como parametro un array asociativo donde las claves coinciden  con los atributos 
     * @param array $datos
     * @return CompraEstado
     */
    private function cargarObjetoConClave($datos){
        $obj=null;
        if(isset($datos['idcompraestado'])){
            // creo al obj compra
            $objC=new Compra();
            $objC->setId($datos['idusario']);
            $objC->cargar();
            
            // creo al obj compraestadotipo
            $objCET=new CompraEstadoTipo();
            $objCET->setId($datos['idcompraestadotipo']);
            $objCET->cargar();

            // creo al obj compraEstado
            $obj=new CompraEstado();
            $obj->setear($datos['idcompraestado'],$objC,$objCET,$datos['cefechaini'],$datos['cefechafin']);

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
        
        //var_dump(isset($datos['cefechafin'])); // OJO!!!! isset si la variable es null, dará falso 
        if(array_key_exists('idcompraestado',$datos) && array_key_exists('idcompraestadotipo',$datos)
        && array_key_exists('idcompra',$datos) && array_key_exists('cefechaini',$datos) && array_key_exists('cefechafin',$datos)){
            $resp=true; 
        }
        
        return $resp;

    }// fin function 

    /**
     * METODO ALTA
     * @param array $datos
     * @return boolean
     */
    public function alta($datos){
        $resp=false;
        $datos['idcompraestado']=null;
        $objCompraEstado=$this->cargarObjeto($datos);
        if($objCompraEstado!=null && $objCompraEstado->insertar()){
            $resp=true;
        }// fin if 
        return $resp;

    }// fin function 

    /**
     * METODO ELIMINAR 
     * @param array $datos
     * @return boolean
     */
    public function baja($datos){
        $resp=false;
        if($this->setadosCamposClaves($datos)){
            $objCompraEstado=$this->cargarObjetoConClave($datos);
            if($objCompraEstado!=null && $objCompraEstado->eliminar()){
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
            $objCompraEstado=$this->cargarObjeto($datos);
            
            if($objCompraEstado!=null && $objCompraEstado->modificar()){
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
        $objCompraEstado=new CompraEstado();
        $where=" true ";
        if($param<>null){
            // Va preguntando si existe los campos de la tabla 
                if(isset($param['idcompraestado'])){ 
                    $where.=" and idcompraestado=".$param['idcompraestado'];
                }// fin if 
                if(isset($param['idcompra'])){// identifica si esta la clave (atributo de la tabla)
                    $where.=" and idcompra =".$param['idcompra'];
                }// fin if 
                if(isset($param['idcompraestadotipo'])){// identifica si esta la clave (atributo de la tabla)
                    $where.=" and idcompraestadotipo =".$param['idcompraestadotipo'];
                }// fin if 
                if(isset($param['cefechaini'])){// identifica si esta la clave (atributo de la tabla)
                    $where.=" and cefechaini ='".$param['cefechaini']."'";
                }// fin if 
                if(isset($param['cefechafin'])){// identifica si esta la clave (atributo de la tabla)
                    $where.=" and cefechafin ='".$param['cefechafin']."'";
                }// fin if  
        }// fin if
        $arreglo=$objCompraEstado->listar($where);
        //var_dump($where); 
        return $arreglo; 

    }// fin funcion    
    

   

}// fin clase 

?>