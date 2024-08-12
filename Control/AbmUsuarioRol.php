<?php

class AbmUsuarioRol
{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto


    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return UsuarioRol
     */

    private function cargarObjeto($param)
    {
        $objUsuarioRol = null;
        $objRol = null;
        $objUsuario = null;
        if (array_key_exists('idrol', $param) && array_key_exists('idusuario', $param)) {
            $objRol = new Rol();
            $objRol->setId($param['idrol']);
            $objRol->cargar();
            $objUsuario = new Usuario();
            $objUsuario->setId($param['idusuario']);
            $objUsuario->cargar();
            $objUsuarioRol = new UsuarioRol();
            $objUsuarioRol->setear($objRol, $objUsuario);
        }
        return $objUsuarioRol;
    }
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return UsuarioRol
     */
    private function cargarObjetoConClave($param)
    {
        $objUsuarioRol = null;
        //print_R ($param);
        if (isset($param['idusuario']) && isset($param['idrol'])) {
            $objUsuarioRol = new UsuarioRol();
            $objUsuario=new Usuario();
            $objUsuario->setId($param['idusuario']);
            $objUsuario->cargar();
            $objRol=new Rol();
            $objRol->setId($param['idrol']);
            $objRol->cargar();
            $objUsuarioRol->setear($objRol, $objUsuario);
        }
        return $objUsuarioRol;
    }


    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */

    private function seteadosCamposClaves($param)
    {

        $resp = false;
        if (isset($param['idusuario']) && isset($param['idrol']));
        $resp = true;
        return $resp;
    }// fin metodo

    /**
     *
     * @param array $param
     * @return boolean
     */
    public function alta($param)
    {
        //  echo "entramos a alta";
        $resp = false;
        $objUsuarioRol = $this->cargarObjeto($param);
        if ($objUsuarioRol != null) {
            if ($objUsuarioRol->insertar()) {
                $resp = true;
            }
        }
        return $resp;
    }// fin metodo 

    /**
     * permite eliminar un objeto
     * @param array $param
     * @return boolean
     */

    public function baja($param)
    {
        //verEstructura($param);
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objUsuarioRol = $this->cargarObjetoConClave($param);
            if ($objUsuarioRol != null and $objUsuarioRol->eliminar()) {
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
    public function modificacion($param)
    {
        //echo "Estoy en modificacion";
        //print_R($param);
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objUsuarioRol = $this->cargarObjeto($param);
            if ($objUsuarioRol != null and $objUsuarioRol->modificar()) {
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

    public function buscar($param)
    {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idusuario']))
            $where .= " and idusuario = " . $param['idusuario'] ;
            if (isset($param['idrol']))
            $where .= " and idrol = " . $param['idrol'] ;
        }
        $objUserRol=new UsuarioRol();
        $arreglo = $objUserRol->listar($where);
        return $arreglo;
    }


    /**
     * Esta funccion busca que no se repita el nuevo rol asignado del usuario
     * @param int idUusario
     * @param string rol
     * @return boolean
     */
    public function RolRepetido($id,$nombreRol){
        $res = false;

        $rolesUsuario = $this->buscar(['idusuario'=>$id]);

        foreach($rolesUsuario as $unRol){
            if($unRol->getObjRol()->getDescripcion()==$nombreRol){
                $res = true;

            }// fin if 
            
        }// fin for 

        return $res; 
    }// fin function 
   
}// fin clase AbmUsuarioRol
