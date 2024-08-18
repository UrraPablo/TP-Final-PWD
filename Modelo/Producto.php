<?php


class Producto{

    private $idProducto;
    private $nombre; 
    private $detalle; 
    private $cantStock; 
    private $precio; 
    private $imagen;
    private $mensaje; 

    // METODO CONSTRUCTOR 
    public function __construct()
    {

        $this->idProducto=0;
        $this->nombre=""; 
        $this->detalle="";
        $this->cantStock=0; 
        $this->mensaje=""; 
        $this->precio=0;
        $this->imagen="";  
    }// fin metodo constructor 

    // METODO SETEAR 
    public function setear ($id,$nombre,$detalle,$stock,$precio,$img){
        $this->idProducto=$id;
        $this->nombre=$nombre;
        $this->detalle=$detalle;
        $this->setStock($stock); 
        $this->precio=$precio; 
        $this->imagen=$img;

    }// fin metodo setear 

    // METODOS GET
    public function getId(){
        return $this->idProducto; 
    }// fin metodo get

    public function getNombre(){
        return $this->nombre; 
    }// fin metodo get

    public function getDetalle(){
        return $this->detalle; 
    }// fin metodo get

    public function getStock(){
        return $this->cantStock; 
    }// fin metodo get

   public function getImagen(){
       return $this->imagen; 
    }// fin metodo get

    public function getMensaje(){
        return $this->mensaje; 
    }

    public function getPrecio(){
        return $this->precio; 
    }
    

    // METODOS SET
    public function setId($id){
        $this->idProducto=$id;
    }// fin metodo set

    public function setNombre($name){
        $this->nombre=$name;
    }// fin metodo set

    public function setDetalle($detalle){
        $this->detalle=$detalle;
    }// fin metodo set

    public function setStock($cant){
        $this->cantStock=$cant;
    }// fin metodo set

    public function setImagen($img){
        $this->imagen=$img;
    }// fin metodo set

    public function setMensaje($msj){
        $this->mensaje=$msj;
    }// fin metodo set

    public function setPrecio($cash){
        $this->precio=$cash;
    }// fin metodo set


    /**METODO CARGAR 
     * @return boolean
     */
    public function cargar(){
        $salida=false;
        $baseDatos=new BaseDatos();
        $sql="SELECT * FROM producto WHERE idproducto=".$this->getId();
        if($baseDatos->Iniciar()){// inicializa la conexion
            $salida=$baseDatos->Ejecutar($sql); 
            if($salida>-1){
                if($salida>0){
                    $salida=true; 
                    $R=$baseDatos->Registro(); // recupera los registros de la tabla  con la ID dada
                    
                    $this->setear($R['idproducto'],$R['pronombre'],$R['prodetalle'],$R['procantstock'],$R['precio'],$R['imagen']);

                }// fin if 

            }// fin if


        }// fin if 
        else{
            $this->setMensaje("Error en la Tabla producto").$baseDatos->getError();
        }// fin else

        return $salida; 

    }// fin function 

    /** METODO INSERTAR 
     * Ingresa un registro en la base de datos 
     * @return boolean
     */
    public function insertar(){
        $salida=false; // inicializacion del valor de retorno
        //$id=$this->getId();
        $baseDatos=new BaseDatos();
        
        $sql="INSERT INTO producto (pronombre,prodetalle,procantstock,precio,imagen)
        VALUES ('".$this->getNombre()."','".$this->getDetalle()."',".$this->getStock().",".$this->getPrecio().",'".$this->getImagen()."');"; 
        if($baseDatos->Iniciar()){
            if($baseDatos->Ejecutar($sql)){
                $salida=true;

            }// fin if 
            else{
                $this->setMensaje("producto - > Insertar").$baseDatos->getError();
            }// fin else

        }// fin if 
        else{
            $this->setMensaje("producto - > Insertar").$baseDatos->getError();

        }// fin else
        
        return $salida; 


    }// fin function insertar 

    /**
     * METODO MODIFICAR
     * @return boolean
     */
    public function modificar(){
        $salida=false;
        $baseDatos=new BaseDatos();
        $sql="UPDATE producto SET pronombre='".$this->getNombre()."', prodetalle='".$this->getDetalle()."', 
        procantstock=".$this->getStock().", precio=".$this->getPrecio().", imagen='".$this->getImagen()."'  WHERE idproducto=".$this->getId();
        if($baseDatos->Iniciar()){
            if($baseDatos->Ejecutar($sql)){
                $salida=true;

            }// fin if 
            else{
                $this->setMensaje("Tabla producto Modificar ").$baseDatos->getError();

            }// fin else


        } // fin if
        else{
            $this->setMensaje("Tabla producto Modificar ").$baseDatos->getError();

        } // fin else

        return $salida; 


    }// fin function modificar

    /**
     * METODO ELIMINAR 
     * @return boolean
     */
    public function eliminar(){
        $salida=false;
        $baseDatos=new BaseDatos();
        $sql="DELETE FROM producto WHERE idproducto=".$this->getId();
        if($baseDatos->Iniciar()){
            if($baseDatos->Ejecutar($sql)){
                $salida=true;

            }// fin if
            else{
                $this->setMensaje("Tabla producto-> eliminar".$baseDatos->getError()); 
            }// fin else

        }// fin if
        else{
            $this->setMensaje("Tabla producto-> eliminar".$baseDatos->getError());
        }// fin else

        return $salida; 
    }// fin function eliminar


    /**
     * METODO LISTAR 
     * DEVUELVE TODOS LOS USUARIOS EN LA BASE DE DATOS
     * @param string $parametro
     * @return array 
     */
    public function listar($parametro=""){
        $arrayProductos=array();
        $baseDatos=new BaseDatos();
        $sql="SELECT * FROM producto ";
        //
        if($parametro!=""){
            $sql.=' WHERE '.$parametro;
        }// fin if 
        if($baseDatos->Iniciar()){
            $respuesta=$baseDatos->Ejecutar($sql);
            if($respuesta>-1){
                if($respuesta>0){
                    
                    while($row=$baseDatos->Registro()){
                    $obj=new Producto();

                    $obj->setear($row['idproducto'],$row['pronombre'],$row['prodetalle'],$row['procantstock'],$row['precio'],$row['imagen']);
                     
                    array_push($arrayProductos,$obj); 
                    //var_dump($row['procantstock']);
                    //var_dump($obj->getStock());  
                    }// fin while 


                }// fin if 
            }// fin if 
        }// fin if 
        return $arrayProductos; 
    }// fin function listar


}// fin clase 

?>