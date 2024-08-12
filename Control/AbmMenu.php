<?php

class AbmMenu{

    /**
     * Espera como parametro un arreglo asociativo donde 
     * las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Menu
     */
    private function cargarObjeto($param){
        $obj = null;
           
        if( array_key_exists('idmenu',$param) and array_key_exists('medeshabilitado',$param) and array_key_exists('menombre',$param) and array_key_exists('medescripcion',$param) ){
            $obj = new Menu();
            $objmenu = null;
            if (isset($param['idpadre'])){
                $objmenu = new Menu();
                $objmenu->setId($param['idpadre']);
                $objmenu->cargar();
                
            }
            // if(!isset($param['medeshabilitado'])){
            //     $param['medeshabilitado']=null;
            // }else{
            //     echo('entro');
            //     $param['medeshabilitado']= date("Y-m-d H:i:s");
            // }
            $obj->setear($param['idmenu'], $param['menombre'],$param['medescripcion'],$objmenu,$param['medeshabilitado']); 
        }
        return $obj;
    }// fin metodo
    
    /**
     * Espera como parametro un arreglo asociativo donde las 
     * claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Menu
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        
        if( isset($param['idmenu']) ){
            $obj = new Menu();
            $obj->setId($param['idmenu']);
        }
        return $obj;
    }
    
    
    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    
    private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['idmenu']))
            $resp = true;
        return $resp;
    }
    
    /**
     * METODO ALTA
     * @param array $param
     * @return boolean
     */
    public function alta($param){
        $resp = false;
        $param['idmenu'] =null;
        $param['medeshabilitado'] = null;
        $ObjMenu = $this->cargarObjeto($param);
//        verEstructura($elObjtTabla);
        if ($ObjMenu!=null and $ObjMenu->insertar()){
            $resp = true;
        }
      return $resp;
     
    }
    /**
     * permite eliminar un objeto 
     * @param array $param
     * @return boolean
     */
    public function baja($param){
        $resp = false;
      
        if ($this->seteadosCamposClaves($param)){
            $ObjMenu = $this->cargarObjetoConClave($param);
            if ($ObjMenu!=null and $ObjMenu->eliminar()){
                $resp = true;
            }
        }
        
        return $resp;
    }
    
    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param){
       
        $resp = false;
        
        if ($this->seteadosCamposClaves($param)){
            $ObjMenu = $this->cargarObjeto($param);
            
            //var_dump($ObjMenu->modificar());
            if($ObjMenu!=null and $ObjMenu->modificar()){
                //echo("Entro al modificar");
                $resp = true;
            }
        }
        return $resp;
    }
    
    /**
     * permite buscar un objeto
     * @param array $param
     * @return array
     */
    public function buscar($param){
        $objMenus=new Menu(); 
        $where = " true ";
        if ($param<>NULL){
            if  (isset($param['idmenu'])){
                $where.=" and idmenu =".$param['idmenu'];
            }// fin if
            if  (isset($param['menombre'])){ 
                $where.=" and menombre ='".$param['menombre']."'";
            }// fin if
            if(isset($param['idpadre'])){
                $where.=" and idpadre =".$param['idpadre'];
            }// fin if
            if(isset($param['medescripcion'])){
                //echo('entro');
                $where.=" and medescripcion ='".$param['medescripcion']."'";
            }// fin if 
            if(array_key_exists('medeshabilitado', $param)){
                $where.=" and medeshabilitado ='".$param['medeshabilitado']."'";
            }// fin if 
        }// fin if 
        $arreglo =$objMenus->listar($where);  
        return $arreglo;
    }// fin metodo buscar 

 

 
}// fin clase 

?>