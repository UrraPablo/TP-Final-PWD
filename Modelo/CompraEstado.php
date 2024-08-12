<?php

class CompraEstado{
    private $idCompraEstado;
    private $objCompra;
    private $objCompraEstadoTipo;
    private $fechaInicio;
    private $fechaFin;
    private $mensaje; 

    // CONSTRUCTOR 
    public function __construct()
    {
        $this->idCompraEstado=0;
        $this->objCompra=new Compra();
        $this->objCompraEstadoTipo=new CompraEstadoTipo();
        $this->fechaInicio="";
        $this->fechaFin="";
    }// fin metodo constructor
    
    // METODO SETEAR 
    public function setear($id,$compra,$compraEstado,$fechaInicio,$fechaFin){
        $this->idCompraEstado=$id;
        $this->objCompra=$compra;
        $this->objCompraEstadoTipo=$compraEstado;
        $this->fechaInicio=$fechaInicio;
        $this->fechaFin=$fechaFin;
        
    }// fin metodo setear

    // METODOS GET
    public function getId(){
        return $this->idCompraEstado;
    }// fin metodo get

    public function getObjCompra(){
        return $this->objCompra;
    }// fin metodo get

    public function getObjCompraEstadoTipo(){
        return $this->objCompraEstadoTipo;
    }// fin metodo get

    public function getFechaInicio(){
        return $this->fechaInicio;
    }// fin metodo get

    public function getFechaFin(){
        return $this->fechaFin;
    }// fin metodo get

    public function getMensaje(){
        return $this->mensaje; 
    }// fin metodo get


    // METODOS SET
    public function setId($id){
        $this->idCompraEstado=$id;
    }// fin metodo set

    public function setObjCompra($compra){
        $this->objCompra=$compra;
    }// fin metodo set

    public function setObjCompraEstadoTipo($id){
        $this->idCompraEstado=$id;
    }// fin metodo set

    public function setFechaInicio($fini){
        $this->fechaInicio=$fini;
    }// fin metodo set

    public function setFechaFin($fechaFin){
        $this->fechaFin=$fechaFin;
    }// fin metodo set

    public function setMensaje($msj){
        $this->mensaje=$msj;
    }// fin metodo set



    /** METODO CARGAR 
     * @return boolean
     */
    public function cargar(){
        $salida=false;
        $sql="SELECT * FROM compraestado WHERE idcompraestado=".$this->getId();
        $baseDatos=new BaseDatos();
        if($baseDatos->Iniciar()){// inicializa la conexion
            $salida=$baseDatos->Ejecutar($sql); 
            if($salida>-1){
                if($salida>0){
                    $salida=true; 
                    $R=$baseDatos->Registro(); // recupera los registros de la tabla  con la ID dada
                    $objCE=new CompraEstado(); // carga del obj con su id
                    $objCE->setId($R['idcompraestado']);
                    $objCE->cargar();
                    $objC=new Compra();
                    $objC->setId($R['idcompra']);
                    $objC->cargar();
                    $objCET=new CompraEstadoTipo();
                    $objCET->setId($R['idcompraestadotiop']);
                    $objCET->cargar();  
                    $this->setear($R['idcompraestado'],$objC,$objCET,$R['cefechaini'],$R['cefechafin']);

                }// fin if 

            }// fin if

        }// fin if 
        else{
            $this->setMensaje("Error en la Tabla compraestado").$baseDatos->getError();
        }// fin else

        return $salida; 
    }// fin metodo cargar

    /**METODO INSERTAR 
     * Ingresa un registro en la tabla compra
     * @return boolean
     */
    public function insertar(){
        $salida=false; // inicializacion del valor de retorno
        $baseDatos=new BaseDatos();
        $idCompra=$this->getObjCompra()->getId();
        $idCompraEstadoTipo=$this->getObjCompraEstadoTipo()->getId();
        $sql="INSERT INTO compraestado (idcompra,idcompraestadotipo,cefechaini,cefechafin)
        VALUES ($idCompra,$idCompraEstadoTipo,'".$this->getFechaInicio()."','".$this->getFechaFin()."');"; 
        if($baseDatos->Iniciar()){
            if($baseDatos->Ejecutar($sql)){
                $salida=true;

            }// fin if 
            else{
                $this->setMensaje("compraestado - > Insertar").$baseDatos->getError();
            }// fin else

        }// fin if 
        else{
            $this->setMensaje("compraestado - > Insertar").$baseDatos->getError();

        }// fin else

        return $salida; 


    }// fin function insertar 

    /**METODO MODIFICAR 
     * ACTUALIZA LOS DATOS EN LA TABLA COMPRA SEGUN SU ID
     * @return boolean
     */
    public function modificar(){
        $salida=false;
        $idCompra=$this->getObjCompra()->getId();
        $idCompraEstadoTipo=$this->getObjCompraEstadoTipo()->getId();
        $baseDatos=new BaseDatos();

        $sql="UPDATE compraestado SET idcompra=$idCompra, idcompraestadotipo=$idCompraEstadoTipo, cefechaini='".$this->getFechaInicio()."', cefechafin='".$this->getFechaFin()."' WHERE idcompraestado=".$this->getId();

        if($baseDatos->Iniciar()){
            if($baseDatos->Ejecutar($sql)){
                $salida=true;

            }// fin if 
            else{
                $this->setMensaje("Tabla compraestado Modificar ").$baseDatos->getError();

            }// fin else


        } // fin if
        else{
            $this->setMensaje("Tabla compraestado Modificar ").$baseDatos->getError();

        } // fin else

        return $salida; 


    }// fin function modificar

    /**METODO ELIMINAR 
     * @return boolean
     */
    public function eliminar(){
        $salida=false;
        $sql="DELETE FROM compraestado WHERE idcompraestado=".$this->getId();
        $baseDatos=new BaseDatos();
        if($baseDatos->Iniciar()){
            if($baseDatos->Ejecutar($sql)){
                $salida=true;

            }// fin if
            else{
                $this->setMensaje("Tabla compraestado-> eliminar".$baseDatos->getError()); 
            }// fin else

        }// fin if
        else{
            $this->setMensaje("Tabla compraestado-> eliminar".$baseDatos->getError());
        }// fin else

        return $salida; 
    }// fin function eliminar

    /**
     * METODO LISTAR COMPRA 
     * DEVUELVE TODAS LAS COMPRAS DE LA BASE DE DATOS
     * @param parametro
     * @return array
     */
    public function listar($parametro=""){
        $arrayComprasEstados=array();
        $baseDatos=new BaseDatos();
        $sql="SELECT * FROM compraestado";
        if($parametro!=""){
            $sql.=' WHERE'.$parametro;
        }// fin if 
        if($baseDatos->Iniciar()){
            $respuesta=$baseDatos->Ejecutar($sql);
            if($respuesta>-1){
                if($respuesta>0){
                // creo y cargo  obj usuario
                    while($row=$baseDatos->Registro()){
                    // seteo el obj Compra
                    $objC=new Compra();
                    $objC->setId($row['idcompra']);
                    $objC->cargar();     
                    // compra estadotipo
                    $objCET=new CompraEstadoTipo();
                    $objCET->setId($row['idcompraestadotipo']);
                    $objCET->cargar();
                    // setea obj compra estado 
                    $objCompraEstado=new CompraEstado();    
                    $objCompraEstado->setear($row['idcompraestado'],$objC,$objCET,$row['cefechaini'],$row['cefechafin']);
                    array_push($arrayComprasEstados,$objCompraEstado);   // opcion con this. Sino creo un obj y lo reemplazo por el this
                    }// fin while 
                }// fin if 
            }// fin if 
        }// fin if 
        return $arrayComprasEstados; 
    }// fin function listar






}// fin clase 


?>