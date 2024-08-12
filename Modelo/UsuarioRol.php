<?php

class UsuarioRol{

    private $objUsuario; 
    private $objRol; 
    private $mensaje; 

    // CONSTRUCTOR 
    public function __construct(){
     
        $this->objRol=new Rol();
        $this->objUsuario=new Usuario();
    }// fin constructor 

    // METODO SETEAR 
    public function setear($objR,$objU){
        $this->setObjUsuario($objU);
        $this->setObjRol($objR);

    }// fin metodo setear

    // METODOS GET
    public function getObjUsuario(){
        return $this->objUsuario; 
    }// fin metodo get

    public function getObjRol(){
        return $this->objRol; 
    }// fin metodo get

    public function getMensaje(){
        return $this->mensaje; 
    }// fin metodo get

    // METODOS SET
    public function setObjUsuario($usuario){
        $this->objUsuario=$usuario;
    }// fin metodo set

    public function setObjRol($rol){
        $this->objRol=$rol;
    }// fin metodo set

    public function setMensaje($msj){
        $this->mensaje=$msj;
    }// fin metodo set

    // METODO SET CLAVE
    /**Setea los id de rol y usuario dados por parametro */
    public function setClave($idUsuario,$idRol){
        $this->getObjRol()->setId($idRol);
        $this->getObjUsuario()->setId($idUsuario);
    }// fin metodo setClave

    /**METODO CARGAR 
     * @return boolean
     */
    public function cargar(){
        $salida=false;
        $baseDatos=new BaseDatos();
        $sql="SELECT * FROM usuariorol WHERE idrol=".$this->getObjRol()->getId()." AND idusuario=".$this->getObjUsuario()->getId().";";
        if($baseDatos->Iniciar()){
            $salida=$baseDatos->Ejecutar($sql);
            if($salida>-1){
                if($salida>0){
                    $row=$baseDatos->Registro();
                    $objU=new Usuario();
                    $objU->setId($row['idusuario']);
                    $objU->cargar(); 
                    $objR=new Rol();
                    $objR->setId($row['idrol']);
                    $objR->cargar(); 
                    $this->setear($objR,$objU); 

                }// fin if 

            }// fin if 

        }// fin if 
        else{
            $this->setMensaje($baseDatos->getError());
        }// fin else

        return $salida; 

    }// fin metodo cargar 


    /** METODO INSERTAR 
     * Ingresa un registro en la base de datos 
     * @return boolean
     */
    public function insertar(){
        $salida=false; // inicializacion del valor de retorno
        $baseDatos=new BaseDatos();
        $sql="INSERT INTO usuariorol (idusuario, idrol) 
        VALUES (".$this->getObjUsuario()->getId().",".$this->getObjRol()->getId().");";
        //echo($sql);
        if($baseDatos->Iniciar()){
            if($baseDatos->Ejecutar($sql)){
                $salida=true;

            }// fin if 
            else{
                $this->setMensaje("menurol - > Insertar").$baseDatos->getError();
            }// fin else

        }// fin if 
        else{
            $this->setMensaje("menurol - > Insertar").$baseDatos->getError();

        }// fin else

        return $salida; 


    }// fin function insertar 




    /** METODO MODIFICAR
     * La clase usuarioROl al ser un entidad debil en el modelo , no puede modificar a usuario o rol 
     * @return boolean
     */
    public function modificar(){
        $salida=false;
        return $salida;
    }// fin metodo modificar

    /**METODO ELIMINAR 
     * @return boolean
     */
    public function eliminar(){
        $salida=false;
        $baseDatos=new BaseDatos();
        $sql="DELETE FROM usuariorol WHERE idrol=".$this->getObjRol()->getId()." AND idusuario=".$this->getObjUsuario()->getId().";";
        //echo($sql);
        if($baseDatos->Iniciar()){
            if($baseDatos->Ejecutar($sql)){
                $salida=true;
            }// fin if 
            else{
                $this->setMensaje("Usuario ->eliminar ".$baseDatos->getError()); 
            }// fin else

        }// fin if 
        else{
            $this->setMensaje("Usuario ->eliminar ".$baseDatos->getError()); 

        }// fin else

        return $salida; 


    }// fin metodo eliminar 


    /** METODO LISTAR 
     * @param string $parametro
     * @return array
     */
    public function listar($parametro=""){
        $arrayUsarioRol=array();
        $baseDatos=new BaseDatos();
        $salida = 0;
        $sql="SELECT * FROM usuariorol ";
        if($parametro!=""){
            $sql.=' WHERE '.$parametro; 
        }// fin if 
        if($baseDatos->Iniciar()){
            $salida=$baseDatos->Ejecutar($sql);
           // echo $sql;
           //var_dump($salida);
       
            if($salida>-1){
                if($salida>0){
                    while($row=$baseDatos->Registro()){
                        $obj=new UsuarioRol();
                        $obj->getObjUsuario()->setId($row['idusuario']);
                        $obj->getObjRol()->setId($row['idrol']);
                        $obj->cargar();
                        array_push($arrayUsarioRol,$obj); 
                    }// fin while 
                }// fin if 
            }// fin if
        }// fin if
        else{
            $this->setMensaje("Usuario -> listar: ".$baseDatos->getError());
        }// fin else
        return $arrayUsarioRol; 
    }// fin metodo listar 


}// fin clase 


?>