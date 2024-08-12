<?php

class MenuRol{
    private $objMenu; 
    private $objRol; 
    private $mensaje; 

    // CONSTRUCTOR 
    public function __construct(){
        $this->objMenu=new Menu();
        $this->objRol=new Rol();
    }// fin constructor 

    // METODO SETEAR 
    public function setear($objM,$objR){
        $this->setObjMenu($objM);
        $this->setObjRol($objR);

    }// fin metodo setear

    // METODOS GET
    public function getObjMenu(){
        return $this->objMenu; 
    }// fin metodo get

    public function getObjRol(){
        return $this->objRol; 
    }// fin metodo get

    public function getMensaje(){
        return $this->mensaje; 
    }// fin metodo get

    // METODOS SET
    public function setObjMenu($menu){
        $this->objMenu=$menu;
    }// fin metodo set

    public function setObjRol($rol){
        $this->objRol=$rol;
    }// fin metodo set

    public function setMensaje($msj){
        $this->mensaje=$msj;
    }// fin metodo set



    /**METODO CARGAR 
     * @return boolean
     */
    public function cargar(){
        $salida=false;
        $baseDatos=new BaseDatos();
        $sql="SELECT * FROM menurol WHERE idmenu=".$this->getObjMenu()->getId()." AND idrol=".$this->getObjRol()->getId().";";
        if($baseDatos->Iniciar()){
            $salida=$baseDatos->Ejecutar($sql);
            if($salida>-1){
                if($salida>0){
                    $row=$baseDatos->Registro();
                    $objM=new Menu();
                    $objM->setId($row['idmenu']);
                    $objM->cargar(); 
                    $objR=new Rol();
                    $objR->setId($row['idrol']);
                    $objR->cargar(); 
                    $this->setear($objM,$objR); 

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
        $sql="INSERT INTO menurol (idmenu, idrol) VALUES (".$this->getObjMenu()->getId().",".$this->getObjRol()->getId().");";
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
        $sql="DELETE FROM menurol WHERE idmenu=".$this->getObjMenu()->getId()." AND idrol=".$this->getObjRol()->getId()."";
        //echo($sql);
        if($baseDatos->Iniciar()){
            if($baseDatos->Ejecutar($sql)){
                $salida=true;
            }// fin if 
            else{
                $this->setMensaje("Menu ->eliminar ".$baseDatos->getError()); 
            }// fin else

        }// fin if 
        else{
            $this->setMensaje("Menu ->eliminar ".$baseDatos->getError()); 

        }// fin else

        return $salida; 


    }// fin metodo eliminar 


    /** METODO LISTAR 
     * @param $parametro
     * @return array
     */
    public function listar($parametro=""){
        $arrayUusarioRol=array();
        $baseDatos=new BaseDatos();
        $sql="SELECT * FROM menurol";
        if($parametro!=""){
            $sql.=' WHERE '.$parametro; 
        }// fin if 
        //var_dump($parametro);
        if($baseDatos->Iniciar()){
            $salida=$baseDatos->Ejecutar($sql);
            if($salida>-1){
                if($salida>0){
                    while($row=$baseDatos->Registro()){
                        $obj=new MenuRol();
                        $obj->getObjMenu()->setId($row['idmenu']);
                        $obj->getObjRol()->setId($row['idrol']);
                        $obj->cargar();
                        array_push($arrayUusarioRol,$obj); 

                    }// fin while 
                }// fin if 

            }// fin if

        }// fin if
        else{
            $this->setMensaje("Menu -> listar: ".$baseDatos->getError());
        }// fin else

        return $arrayUusarioRol; 
    }// fin metodo listar 


}// fin clase 


?>