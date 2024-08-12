<?php

class CompraItem{

    private $idItem;
    private $objProducto; 
    private $objCompra; 
    private $cantidad; 
    private $mensaje; 

    // CONSTRUCTOR 
    public function __construct(){
        $this->idItem=0;
        $this->objProducto=new Producto();
        $this->objCompra=new Compra();
        $this->mensaje=""; 
    }// fin constructor

    // METODO SETEAR 
    public function setear($id,$producto,$compra,$cant){
        $this->idItem=$id;
        $this->objProducto=$producto;
        $this->objCompra=$compra;
        $this->cantidad=$cant;

    }// fin metodo setear

    // METODOS GET
    public function getId(){
        return $this->idItem; 
    }// fin metodo get

    public function getObjProducto(){
        return $this->objProducto; 
    }// fin metodo get

    public function getObjCompra(){
        return $this->objCompra; 
    }// fin metodo get

    public function getMensaje(){
        return $this->mensaje; 
    }// fin metodo get

    public function getCantidad(){
        return $this->cantidad; 
    }// fin metodo get

    // METODOS SET 
    public function setId($id){
        $this->idItem=$id;
    }// fin metodo set

    public function setObjProducto($producto){
        $this->objProducto=$producto;
    }// fin metodo set

    public function setObjCompra($compra){
        $this->objCompra=$compra;
    }// fin metodo set

    public function setCantidad($cant){
        $this->cantidad=$cant;
    }// fin metodo set

    public function setMensaje($msj){
        $this->mensaje=$msj;
    }// fin metodo set

    /**METODO CARGAR 
     * @return boolean
     */
    public function cargar(){
        $salida=false; 
        $sql="SELECT * FROM compraitem WHERE idcompraitem=".$this->getId();
        $baseDatos=new BaseDatos();
        if($baseDatos->Iniciar()){// inicializa la conexion
            $salida=$baseDatos->Ejecutar($sql); 
            if($salida>-1){
                if($salida>0){
                    $salida=true; 
                    $R=$baseDatos->Registro(); // recupera los registros de la tabla  con la ID dada
                    $objC=new Compra(); // carga del obj con su id
                    $objC->setId($R['idcompra']);
                    $objC->cargar();
                    $objP=new Producto();
                    $objP->setId($R['idproducto']);
                    $objP->cargar();  
                    $this->setear($R['idcompraitem'],$objP,$objC,$R['cicantidad']);

                }// fin if 

            }// fin if


        }// fin if 
        else{
            $this->setMensaje("Error en la Tabla compraitem").$baseDatos->getError();
        }// fin else

        return $salida; 
    }// fin metodo cargar


    /**METODO INSERTAR 
     * Ingresa un registro en la tabla compra
     * @return boolean
     */
    public function insertar(){
        $salida=false; // inicializacion del valor de retorno
         
        $idProducto=$this->getObjProducto()->getId();
        $idCompra=$this->getObjCompra()->getId();
        $baseDatos=new BaseDatos();
        $sql="INSERT INTO compraitem (idproducto,idcompra,cicantidad)
        VALUES ($idProducto,$idCompra,".$this->getCantidad().");"; 
        if($baseDatos->Iniciar()){
            if($baseDatos->Ejecutar($sql)){
                $salida=true;

            }// fin if 
            else{
                $this->setMensaje("compraitem - > Insertar").$baseDatos->getError();
            }// fin else

        }// fin if 
        else{
            $this->setMensaje("compraitem - > Insertar").$baseDatos->getError();

        }// fin else

        return $salida; 


    }// fin function insertar 



    /**METODO MODIFICAR 
     * ACTUALIZA LOS DATOS EN LA TABLA COMPRAITEM SEGUN SU ID
     * @return boolean
     */
    public function modificar(){
        $salida=false;
        $idProducto=$this->getObjProducto()->getId();
        $idCompra=$this->getObjCompra()->getId();
        $baseDatos=new BaseDatos();
        $sql="UPDATE compraitem SET idproducto=$idProducto, idcompra=$idCompra, cicantidad=".$this->getCantidad()." WHERE idcompraitem=".$this->getId();
        if($baseDatos->Iniciar()){
            if($baseDatos->Ejecutar($sql)){
                $salida=true;

            }// fin if 
            else{
                $this->setMensaje("Tabla compraitem Modificar ").$baseDatos->getError();

            }// fin else


        } // fin if
        else{
            $this->setMensaje("Tabla compraitem Modificar ").$baseDatos->getError();

        } // fin else
        return $salida; 


    }// fin function modificar


     /**METODO ELIMINAR 
     * @return boolean
     */
    public function eliminar(){
        $salida=false;
        $sql="DELETE FROM compraitem WHERE idcompraitem=".$this->getId();
        $baseDatos=new BaseDatos();
        if($baseDatos->Iniciar()){
            if($baseDatos->Ejecutar($sql)){
                $salida=true;

            }// fin if
            else{
                $this->setMensaje("Tabla compraitem-> eliminar".$baseDatos->getError()); 
            }// fin else

        }// fin if
        else{
            $this->setMensaje("Tabla compraitem-> eliminar".$baseDatos->getError());
        }// fin else

        return $salida; 
    }// fin function eliminar


    /**
     * METODO LISTAR COMPRA 
     * DEVUELVE TODAS LAS COMPRAS DE LA BASE DE DATOS
     * @param string $parametro
     * @return array
     */
    public function listar($parametro=""){
        $arrayComprasItem=array();
        $baseDatos=new BaseDatos();
        $sql="SELECT * FROM compraitem";
        
        if($parametro!=""){
            $sql.=' WHERE'.$parametro;
        }// fin if 
        if($baseDatos->Iniciar()){
            $respuesta=$baseDatos->Ejecutar($sql);
            if($respuesta>-1){
                if($respuesta>0){
                // creo y cargo  obj usuario
                    while($row=$baseDatos->Registro()){
                    $objP=new Producto();
                    $objC=new Compra();

                    $objP->setId($row['idproducto']);
                    $objP->cargar();
                    $objC->setId($row['idcompra']);
                    $objC->cargar();     
                    // seteo el obj Compra
                    $objCompraI=new CompraItem();    
                    $objCompraI->setear($row['idcompraitem'],$objP,$objC,$row['cicantidad']);
                    array_push($arrayComprasItem,$objCompraI);   // opcion con this. Sino creo un obj y lo reemplazo por el this
                    }// fin while 
                }// fin if 
            }// fin if 
        }// fin if 
        return $arrayComprasItem; 
    }// fin function listar









}// fin clase 

?>