<?php

    class AbmMenuRol{

    /**
     * Espera como parametro un arreglo asociativo donde 
     * las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return object
     */
    private function cargarObjeto($param){
        $obj = null;
           
        if( array_key_exists('idmenu',$param) and array_key_exists('idrol',$param)){
            $objMenu=new Menu();
            $objRol=new Rol();
            $objMenu->setId($param['idmenu']);
            $objRol->setId($param['idrol']);
            $objMenu->cargar();
            $objRol->cargar();
            $obj =new MenuRol();
            $obj->setear($objMenu,$objRol);
        }
        return $obj;
    }// fin metodo

        /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return object
     */
    private function cargarObjetoConClave($param)
    {
        $objMenuRol = null;
        //print_R ($param);
        if (isset($param['idmenu']) && isset($param['idrol'])) {
            $objMenuRol = new MenuRol();
            $objMenu=new Menu();
            $objRol = new Rol();
            $objMenu->setId($param['idmenu']);
            $objMenu->cargar();
            $objRol->setId($param['idrol']);
            $objRol->cargar();
            $objMenuRol->setear($objMenu, $objRol);
        }
        return $objMenuRol;
    }

    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */

     private function seteadosCamposClaves($param){
         $resp = false;
         if (isset($param['idmenu']) && isset($param['idrol']));
         $resp = true;
         return $resp;
     }// fin metodo

    
    /**
     *
     * @param array $param
     */
    public function alta($param){
        //  echo "entramos a alta";
        $resp = false;
        $objMenuRol = $this->cargarObjeto($param);
        // verEstructura($elObjtAuto);
        //print_r($objMenuRol);
        if ($objMenuRol != null) {
            if ($objMenuRol->insertar()) {
                $resp = true;
            }
        }
        return $resp;
    } // fin metodo    


    /**
     * permite eliminar un objeto
     * @param array $param
     * @return boolean
     */

     public function baja($param)
     {
         //verEstructura($param);
         $resp = false;
         if ($this->seteadosCamposClaves($param)){
             $objMenuRol = $this->cargarObjetoConClave($param);
             if ($objMenuRol != null and $objMenuRol->eliminar()) {
                 $resp = true;
             }
         }
         return $resp;
    }// fin metodo 


    
     /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param)
    {
        //echo "Estoy en modificacion";
        //print_R($param);
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objMenuRol = $this->cargarObjeto($param);
            if ($objMenuRol != null and $objMenuRol->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }// fin metodo 


    /**
     * permite buscar un objeto
     * @param array $param
     * @return array
     */

     public function buscar($param){
         $where = " true ";
         if ($param <> NULL) {
             if (isset($param['idmenu'])){
             $where .= " and idmenu=" . $param['idmenu'] ;
             }
             if (isset($param['idrol'])){
             $where .= " and idrol =" . $param['idrol'] ;
             }
         }// fin if

         //echo('<br>'.$where.'<br>');
         $objMenuRol=new MenuRol();
         $arreglo = $objMenuRol->listar($where);
         return $arreglo;
    }// fin metodo

    /** Esta funcion arma el menu de manera dinamica 
     * @param obj session 
     * @return string
     */
    function menuPrincipal($objSession){
        $menu = "";    
        $opcionRol = '<li class="nav-item dropdown"style="list-style-type:none" ><a class="nav-link dropdown-toggle" href="#" role="button" 
         data-bs-toggle="dropdown" aria-expanded="false">Rol</a><ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
        $listaRol=$objSession->getRol();
        
        // recorre segun los distintos roles que tiene el usuario (Adm - deposito - cliente). 
        foreach($listaRol as $rol){      
          $opcionRol .= '<li><a href="javascript:;" onclick="RealizaMenu('.$rol->getId().');return false;" class="dropdown-item" > '
          .$rol->getDescripcion().'</a></li>'; 
        }
        
        // GENERACION DEL MENU DINAMICO 
        $param['idrol'] = $objSession->getRolActual()->getId(); // obtiene el rol actual 
        $listaMenuRol=$this->buscar($param);
        $listaPadre=array();
        $listaHijos=array();
        
        // Nomenclatura de navbar con submenu 'HIJO' o sin submenu 'PADRE' 
        $Li=['padre'=>'<li class="nav-item" style="list-style-type:none">','hijo'=>'<li class="nav-item dropdown" style="list-style-type:none">'];

        // ALMACENA TODOS LOS MENUS QUE TENGA UN ROL DADO 
        foreach($listaMenuRol as $obj){
            if($obj->getObjMenu()->getDeshabilitado()==null || $obj->getObjMenu()->getDeshabilitado()=='0000-00-00 00:00:00'){ // verifica si esta habilitado o no 
                if($obj->getObjMenu()->getobjMenuPadre()==null){
                  
                  array_push($listaPadre,$obj->getObjMenu());
                }// fin if
                else{
                    array_push($listaHijos,$obj->getObjMenu());                
                }// fin else

            }// fin if 
        }// fin for

        $A=array();
        $P=[];
        $k=0; // contador 
        $temp='';
        
        foreach($listaPadre as $padre){
            foreach($listaHijos as $hijo){
                if($padre->getId()==$hijo->getobjMenuPadre()->getId()){
                    $nombre=$hijo->getNombre();
                    $url=$hijo->getDescripcion();
                    $nombrePadre=$hijo->getobjMenuPadre()->getNombre();
                    $A[$nombre][0]=$nombre; // array multidimensional [asociativo][indexado] que contiene los nombre de los submenus
                    $A[$nombre][1]=$url;     // las url y el padre de cada submenu. 
                    $A[$nombre][2]=$nombrePadre;
                    if($temp!=$nombrePadre){
                        $P[$k]=$nombrePadre;
                        $k++;
                        $temp=$nombrePadre;

                    }// fin if 
                }// fin
            }// fin for     
        }// fin for 

        $K=array_keys($A); // array de claves de A
        $cantKeys=count($K);
        // Objetivo => Al array multidimensional lo desgloso en funcion de la cantidad de veces que se repite el nombre del menu padre
        
        for ($i=0; $i<count($P); $i++){ // Recorre el array que contiene los nonmbres de los menu con submenu
            $l=[];
            for($k=0;$k<$cantKeys;$k++){ // recorrido del array multidimensional separando por cada array con su clave
                $T=$A[$K[$k]]; // array temporal 
                while(array_search($P[$i],$T)){  // busca si el array T posee el nombre del menu Padre 
                    array_push($l,$A[$K[$k]][0]);  // guardo el nombre del submenu y su url
                    array_push($l,$A[$K[$k]][1]);
                    $T=[];
                }// fin while 
            }// fin for 

            $menu.=$Li['hijo']; // Nomenclatura para armar el navbar con submenus en BOOTSTRAP
            $menu.='<a class="nav-link dropdown-toggle" href="#"  id="navbarDropdown" role="button" 
            data-bs-toggle="dropdown" aria-expanded="false">';
            $menu.=$P[$i];
            $menu.='</a>';
            $menu.='<ul class="dropdown-menu" aria-labelledby="navbarDropdown">';

            for($w=0;$w<count($l);$w+=2){ // ARmado del menu dinamico con submenus
                $menu.='<li><a class="dropdown-item" href='.$l[$w+1].'>'.$l[$w].'</a></li>';
            }// fin for 
            $menu.='</ul></li>';
        }// fin for 

        
        // Armando del navbar sin submenus 
        foreach($listaPadre as $unPadre){
            if(!is_int(array_search($unPadre->getNombre(),$P))){
                $menu.=$Li['padre'];
                $menu.='<a class="nav-link" href='.$unPadre->getDescripcion().'>';
                $menu.=$unPadre->getNombre();
                $menu.='</a></li>';
            }// fin if 
        }// fin for          
        
        $menu .= $opcionRol.'</ul></li>';
        
        return $menu;
      }// fin function    


}// fin AbmMenuRol

?>
