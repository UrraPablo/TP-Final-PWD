<?php 

class Menu{
    // ver el ejemplo de menus dinamicos 
    // ATRIBUTOS 
    private $idMenu;
    private $nombreMenu; 
    private $descripcionMenu;
    private $objMenuPadre;
    private $deshabilitado;
    private $mensaje; 

    // CONSTRUCTOR 
    public function __construct()
    {
        $this->idMenu="";
        $this->nombreMenu="";
        $this->descripcionMenu="";
        $this->objMenuPadre = null;
        $this->deshabilitado="";
        $this->mensaje="";

    }// fin constructor 

    // METODO SETEAR 
    public function setear($idMenu,$nombre,$descrip,$objMenu,$deshab){
        $this->idMenu=$idMenu;
        $this->nombreMenu=$nombre;
        $this->descripcionMenu=$descrip;
        $this->objMenuPadre=$objMenu;
        $this->deshabilitado=$deshab;

    }// fin metodo setear

    // METODOS GET
    public function getId(){
        return $this->idMenu;
    }// fin metodo get

    public function getNombre(){
        return $this->nombreMenu;
    }// fin metodo get

    public function getDescripcion(){
        return $this->descripcionMenu;
    }// fin metodo get

    public function getobjMenuPadre(){
        return $this->objMenuPadre;
    }// fin metodo get

    public function getDeshabilitado(){
        return $this->deshabilitado;
    }// fin metodo get

    public function getMensaje(){
        return $this->mensaje;
    }// fin metodo get


    // METODOS SET
    public function setId($id){
        $this->idMenu=$id;
    }// fin metodo set

    public function setNombre($menu){
        $this->nombreMenu=$menu;
    }// fin metodo set

    public function setDescripcion($descr){
        $this->descripcionMenu=$descr;
    }// fin metodo set

    public function setobjMenuPadre($padre){
        $this->objMenuPadre=$padre;
    }// fin metodo set

    public function setDeshabilitado($desh){
        $this->deshabilitado=$desh;
    }// fin metodo set

    public function setMensaje($msj){
        $this->mensaje=$msj;
    }// fin metodo set



    /**
     * METOD CARGAR 
     * CARGA EL OBJ MENU EN CASO QUE SE ENCUENTRE EN LA BASE DE DATOS
     * SINO DEVUELVE FALSO
     * @return boolean
     */
    public function cargar(){
        $salida=false; // inicializacion del valor de retorno
        $sql = "SELECT * FROM menu WHERE idmenu=".$this->getId();
        $baseDatos=new BaseDatos();
        if($baseDatos->Iniciar()){// inicializa la conexion
            $salida=$baseDatos->Ejecutar($sql); 
            if($salida>-1){
                if($salida>0){
                    $salida=true; 
                    $objMenu=null;
                    $R=$baseDatos->Registro(); // recupera los registros de la tabla  con la ID dada
                    if($R['idpadre']!= null){
                        $objMenu=new Menu();
                        $objMenu->setId($R['idpadre']);
                        $objMenu->cargar();
                        
                    }// fin if 

                    $this->setear($R['idmenu'],$R['menombre'],$R['medescripcion'],$objMenu,$R['medeshabilitado']);

                }// fin if 

            }// fin if


        }// fin if 
        else{
            $this->setMensaje("Error en la Tabla menu").$baseDatos->getError();
        }// fin else

        return $salida; 
    }// fin metodo cargar 


    /** METODO INSERTAR 
     * Ingresa un registro en la base de datos 
     * @return boolean
     */
    public function insertar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="INSERT INTO menu( menombre ,  medescripcion ,  idpadre ,  medeshabilitado)  ";
        $sql.="VALUES('".$this->getNombre()."','".$this->getDescripcion()."',";
        if ($this->getobjMenuPadre() != null) // pregunta si el menu no esl nulo
            $sql.= " ".$this->getobjMenuPadre()->getId().",";
        else
            $sql.=" null, ";
        if ($this->getDeshabilitado()!=null)
            $sql.= "'".$this->getDeshabilitado()."'";
        else 
            $sql.=" null ";
        $sql.= ");";
     // echo $sql;
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setId($elid);
                $resp = true;
            } else {
                $this->setMensaje("Menu->insertar: ".$base->getError()[2]);
            }
        } else {
            $this->setMensaje("Menu->insertar: ".$base->getError()[2]);
        }
        return $resp;
    }


     /**
     * METODO MODIFICAR
     * @return boolean
     */
    public function modificar(){
        $salida=false;
        $baseDatos=new BaseDatos();
        $sql="UPDATE menu SET menombre='".$this->getNombre()."', medescripcion='".$this->getDescripcion()."'";
        if($this->getobjMenuPadre()!=null){
            $sql.=" , idpadre = ".$this->getobjMenuPadre()->getId();
            
        }// fin if 
        else{
            $sql.=", idpadre=null ";
        }// fin else 
        if($this->getDeshabilitado()!=null){
            $sql.=", medeshabilitado='".$this->getDeshabilitado()."'";

        }// fin if 
        else{
            $sql.=", medeshabilitado='".null."'";
        }// fin else
        $sql.=" WHERE idmenu = ".$this->getId();
        //echo($sql);
        
        if($baseDatos->Iniciar()){
            //echo($sql);
            if($baseDatos->Ejecutar($sql)){
                $salida=true;

            }// fin if 
            else{
                $this->setMensaje("Tabla menu Modificar ").$baseDatos->getError();

            }// fin else


        } // fin if
        else{
            $this->setMensaje("Tabla menu Modificar ").$baseDatos->getError();

        } // fin else
        //
        //var_dump($salida);

        return $salida; 


    }// fin function modificar


     /**
     * METODO ELIMINAR (BORARDO LOGICO)
     * @return boolean
     */
    public function eliminar(){
        $salida=false;
        $sql="UPDATE menu SET medeshabilitado = NULL WHERE idmenu = ".$this->getId();
        $baseDatos=new BaseDatos();
        if($baseDatos->Iniciar()){
            if($baseDatos->Ejecutar($sql)){
                $salida=true;

            }// fin if
            else{
                $this->setMensaje("Tabla menu-> eliminar".$baseDatos->getError()); 
            }// fin else

        }// fin if
        else{
            $this->setMensaje("Tabla menu-> eliminar".$baseDatos->getError());
        }// fin else

        return $salida; 
    }// fin function eliminar


     /**
     * METODO LISTAR 
     * DEVUELVE TODOS LOS USUARIOS EN LA BASE DE DATOS
     * @param $parametro
     * @return array 
     */
    public function listar($parametro=""){
        $arrayMenus=array();
        $baseDatos=new BaseDatos();
        $sql="SELECT * FROM menu";
        //var_dump($parametro);
        if($parametro!=""){
            $sql.=' WHERE'.$parametro;
        }// fin if 
        if($baseDatos->Iniciar()){
           
            $respuesta=$baseDatos->Ejecutar($sql);
            if($respuesta>-1){
                if($respuesta>0){
                    
                    while($row=$baseDatos->Registro()){
                    $obj=new Menu();
                    $objPadre=null;
                    if($row['idpadre']!=null){
                        $objPadre=new Menu(); 
                        $objPadre->setId($row['idpadre']);
                        $objPadre->cargar(); 
                        // echo($objPadre->getId());
                    } // fin if 
                    $obj->setear($row['idmenu'],$row['menombre'],$row['medescripcion'],$objPadre,$row['medeshabilitado']);
                    array_push($arrayMenus,$obj);   
                    }// fin while 


                }// fin if 
            }// fin if 
        }// fin if 
        return $arrayMenus; 
    }// fin function listar


}// fin clase 

?>