<?php
include_once '../../configuracion.php';
include_once '../estructura/headPrivado.php';
/********************************************************************************************* */
$objCI = new AbmCompraItem();
$objCE=new AbmCompraEstado();
// busco la compra con estado iniciado 
// relaciono los items de la compra con ese estado 

$compraIniciada=$objCE->buscar(['idcompraestadotipo'=>1,'cefechafin'=>'null']);
if(count($compraIniciada)==0){
    ?>
    <div class="alert alert-danger" role="alert">
     NO ha iniciado ninguna compra. Haga click en un producto para iniciar la compra 
    </div>
    <?php

}// fin if 
else{
    $idCompra=$compraIniciada[0]->getObjCompra()->getId();
    $itemsCompraIniciada=$objCI->buscar(['idcompra'=>$idCompra]);
    ?>
<head>
    <!-- LINK CSS PARA CARRITO -->
  <link rel="stylesheet" type="text/css" href="../css/carrito.css">
</head>
<input type="hidden" name="idcompra" value="<?php echo($idCompra) ?>">
<section class="contenedorPrincipal mb-5 p-2">
    <div class="container">
        <div class="row">
            <div class="col-8">
                <h2>Listado de productos</h2>
                <!--  RECORRIDO DE LOS PRODUCTOS AGREGADOS AL CARRITO   -->
                <?php foreach($itemsCompraIniciada as $unItem){
                    if($unItem->getCantidad()>0){    
                    ?>
                    <div class="itemCarrito">
                   
                        <div class="descripcion row d-flex flex-row">
                            <div class="imagenP col-2">
                                <img class="fotoProducto" src="<?php echo($unItem->getObjProducto()->getImagen());?>" alt="fotoProducto" >
                            </div>
                            <div class="datosP col-7">
                                <p class="nombre">nombre: <?php echo($unItem->getObjProducto()->getNombre())?> </p>
                                <p class="detalle">detalle: <?php echo($unItem->getObjProducto()->getDetalle())?></p>
                                <p class="precio">Precio: $ <input type="number" class="valorPrecio" value="<?php echo($unItem->getObjProducto()->getPrecio())?>"></p>
                        
                            </div>
                            <div class="cantidadP col-3 d-flex justify-content-center align-items-center">
                                <button class="botonSuma" name="suma" type="button">+</button>
                                <input type="number" class="inputCantidad" name="cantidad" value="1"  min='1' max='<?php echo($unItem->getObjProducto()->getStock())?>'>
                                <button class="botonResta" name="resta" type="button">-</button>
                                
                        
                            </div>
                        
                        </div>
                        <button class="eliminarItem btn btn-danger mb-2" id='<?php echo($unItem->getId()) ?>' type="button">Eliminar</button>
                    </div>
                    <?php
                    }// fin if 
                    }// fin for  ?>
            </div>
            <aside class="precioTotal col-4">
                <h2 id="titulo">Precio de la compra</h2>
                <span id="signoPrecio">$</span>
                <h3 id="tituloPrecio"> 0</h3>
                <button type="button" class="comprar btn btn-success mt-5">Comprar</button>

            </aside>
        </div>
    </div>
</section>

<!--SECCION DE MODAL -->
<!-- Modal -->
<section class="cartel hidden">
    <div class="tituloModal">
        <h4 id="titulo">Compra</h4>
        <i id='icono' class="bi bi-x-circle"></i>
    </div>

    <div class="contenidoModal">
      <p id="contenido"> La compra fue procesada <strong style="color:green">Correctamente</strong> 
         Pronto le notificaremos el envio de la misma.            
    </p>
    </div>

    <div class="footerModal">
       <p id="pieModal"> Tus mejores marcas aca en <strong style="color:brown">WESH-WESH</strong> </p> 
    </div>
</section>
<div class="overlay hidden"></div>

<?php
}// fin else
?>

<script src="../Js/carrito.js"></script>

<?php
include_once '../estructura/footer.php';
?>