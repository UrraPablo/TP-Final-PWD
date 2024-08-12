<?php
class Session
{

    public function __construct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start(); // Inicia la sessión 
        }
    } // fin metodo constructor 



    /** METODO INICIAR 
     * @param $nombreUsuario string
     * @param $pws string
     * @return boolean
     */
    public function iniciar($nombreUsuario, $pws)
    {
        $resp = false;
        $objAbmUsuario = new AbmUsuario();
        $datos['usnombre'] = $nombreUsuario;
        $datos['uspass'] = $pws;
        //$datos['usdeshabilitado'] = null;
        $listaUsuario = $objAbmUsuario->buscar($datos);
       //var_dump($listaUsuario[0]->getDeshabilitado());
        if (count($listaUsuario) >= 1){
            if ($this->activa()) {
                    $_SESSION['idUser'] = $listaUsuario[0]->getId(); // guarda el Id del usuario en la session
                    $listarol = $this->getRol();
                    $_SESSION['idRol'] = ($listarol[0]->getId());
                    $resp = true;
            } // fin if 
        } // fin if 
        return $resp;
    } // fin metodo iniciar 



    /** METODO VALIDAR
     * valida la session actual, si tiene usuario y pws válidos
     * @return boolean
     */
    public function validar()
    {
        $salida = false;
        if (isset($_SESSION['idUser']) && $this->activa()) { // pregunta si esta seteado el id del usuario para validarlo
            $salida = true;
        } // fin if 
        return $salida;
    } // fin metodo validar

    /** METODO ACTIVA
     * @return boolean
     */
    public function activa()
    {
        $salida = false;
        if (session_status() === PHP_SESSION_ACTIVE) {
            $salida = true; // la session esta activa 
        } // fin if 

        return $salida;
    } // fin metodo activa

    /** METODO GET-USUARIO 
     * @return Usuario
     */
    public function getUsuario()
    {
        $objAbmUsuario = new AbmUsuario();
        $consulta = ['idusuario' => $_SESSION['idUser']]; // pregunto si el usuario con 
        // esa session esta registrado. Lo busco en la BD
        $usuarios = $objAbmUsuario->buscar($consulta);
        if (count($usuarios) >= 1) {
            $usuarioRegistrado = $usuarios[0];
        } // fin if 
        return $usuarioRegistrado;
    } // fin metodo getUsuario

    /** METODO GETROL
     * @return array
     */
    public function getRol()
    {
        $listaRoles = array();
        $objRolesUsuarios = null;
        $i = 0;
        if ($this->getUsuario() != null) {
            $userLog = $this->getUsuario(); // almacena el obj usuario  
            $datos['idusuario'] = $userLog->getId(); // guarda el id de usuario 
            $objRolUsuario = new AbmUsuarioRol();
            $objRolesUsuarios = $objRolUsuario->buscar($datos); // busca en la tabla usuarioRol los roles que coincide con el id del usuario

            foreach ($objRolesUsuarios as $objRolUsuario) {
                array_push($listaRoles, $objRolUsuario->getObjRol());
            }
        } // fin if 
        return $listaRoles;  // puede devolver una lista de usuarios con distintos roles o un solo usuario con un unico rol
    } // fin metodo getRol

    /** METODO CERRAR 
     * @return boolean
     */
    public function cerrar()
    {
        $resp = session_destroy();
        return $resp;
    } // fin metodo cerrar

    /** METODO SETROL
     * @param int
     */
    public function setRol($param)
    {
        $_SESSION["idRol"] = $param;
    }
    /** METODO SETROL
     * @return Rol
     */
    public function getRolActual()
    {
        $objAbmRol = New AbmRol;
        $param['idrol'] = $_SESSION["idRol"];
        $listaObj = $objAbmRol->buscar($param);
        return $listaObj[0];
    }

    /**
     * METODO permisos de headPrivado
     * @return boolean
     */
    public function permisos(){
        $objAbmMenuRol = new AbmMenuRol();
        $resp = false;
        $url = $_SERVER['SCRIPT_NAME'];
        $url = strchr($url, "Vista");
        $url = str_replace("Vista", "..", $url);
        //echo($url);
        $param['idrol'] = $this->getRolActual()->getId();
        
        
        $listaAbmMenuRol = $objAbmMenuRol->buscar($param);
        //var_dump($listaAbmMenuRol);
        foreach ($listaAbmMenuRol as $obj){
            // echo('<br>'.$url.'<br>');
            if ($obj->getObjMenu()->getDescripcion() == $url) {
                $resp = true;
            }// fin if 
        }// fin for
        //var_dump($resp);
        return $resp;
    }

    // fin clase Session 
}
