<?php

class AbmUsuario{
    
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
     * @return Usuario
     */
    private function cargarObjeto($datos){
        $obj=null; 
        if(array_key_exists('idusuario',$datos) && array_key_exists('usnombre',$datos) 
        && array_key_exists('uspass',$datos) && array_key_exists('usmail',$datos) && array_key_exists('usdeshabilitado',$datos)){
            $obj=new Usuario();
            $obj->setear($datos['idusuario'],$datos['usnombre'],$datos['uspass'],$datos['usmail'],$datos['usdeshabilitado']);
            
        }// fin if 
        return $obj; 
        
    }// fin function 


    /**
     * Espera como parametro un array asociativo donde las claves coinciden  con los atributos 
     * @param array $datos
     * @return Usuario
     */
    private function cargarObjetoConClave($datos){
        $obj=null;
        if(isset($datos['idusuario'])){
            $obj=new Usuario();
            $obj->setear($datos['idusuario'],$datos['usnombre'],$datos['uspass'],$datos['usmail'],$datos['usdeshabilitado']);

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
        if(isset($datos['idusuario']) && isset($datos['usnombre']) && isset($datos['uspass']) && isset($datos['usmail']) && array_key_exists('usdeshabilitado',$datos)){
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
        $datos['idusuario'] =null;
        $datos['usdeshabilitado'] =null;
        $objUsuario=$this->cargarObjeto($datos);
        
        if($objUsuario!=null && $objUsuario->insertar()){
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
            $objUsuario=$this->cargarObjetoConClave($datos);
            if($objUsuario!=null && $objUsuario->eliminar()){
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
            $objUsuario=$this->cargarObjeto($datos);
            if($objUsuario!=null && $objUsuario->modificar()){
                
                $resp=true; 

            }// fin if 

        }// fin if 
//        var_dump($resp);
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
        $where=" true ";
        //var_dump($param);
        if($param<>null){
            // Va preguntando si existe los campos de la tabla 
            if(isset($param['idusuario'])){
                $where.=" and idusuario = ".$param['idusuario'];
            } 
            if(isset($param['usnombre'])){// identifica si esta la clave (atributo de la tabla)
                $where.=" and usnombre ='".$param['usnombre']."'";
            }// fin if 
            if(isset($param['uspass'])){// identifica si esta la clave (atributo de la tabla)
                $where.=" and uspass ='".$param['uspass']."'";
            }// fin if 
            if(isset($param['usmail'])){// identifica si esta la clave (atributo de la tabla)
                $where.=" and usmail ='".$param['usmail']."'";
            }// fin if 
            if(isset($param['usdeshabilitado'])){// identifica si esta la clave (atributo de la tabla)
                $where.=" and usdeshabilitado ='".$param['usdeshabilitado']."'";
            }// fin if 
                
            // fin if 
        }// fin if
        $objUsuario=new Usuario();
        //echo($where);
        $arreglo=$objUsuario->listar($where);
        //var_dump(count($arreglo));
        return $arreglo; 

    }// fin funcion    
    
    
    /**
     * ESTA FUNCION VERIFICA LA NO REPITENCIA DEL MAIL
     * @param string
     * @return boolean
     */
    public function mailRepetido($mail,$idU){
        $usuarios = $this->buscar(null);
        $mailRepetido = false;

        foreach($usuarios as $unUsuario){
            if($idU!=$unUsuario->getId()){
                if($mail==$unUsuario->getMail()){
                    $mailRepetido=true;
                }// fin if 
            }// fin if 

        }// fin for 

        return $mailRepetido;

    }// fin function 

    /**
     * ESTA FUNCION VERIFICA LA NO REPITENCIA EL NOMBRE DEL USUARIO
     * @param string
     * @param int 
     * @return boolean
     */
    public function nombreRepetido($nombre,$idU){
        $usuarios = $this->buscar(null);
        $nombreRepetido = false;

        foreach($usuarios as $unUsuario){
            if($idU!=$unUsuario->getId()){
                if($nombre==$unUsuario->getNombre()){
                    $nombreRepetido=true;
                }// fin if
            }// fin if 

        }// fin for 

        return $nombreRepetido;
    }// fin function 

}// fin clase 

?>