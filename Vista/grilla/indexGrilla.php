<?php
include_once '../../configuracion.php';
include_once '../estructura/headPrivado.php';
$title='Listado de Productos';
$objProducto = new AbmProducto();
$listaProductos = $objProducto->buscar(null);

?>
<!--ID USUARIO CON SU ROL -->
<input id="usuario" type="hidden" value="<?php echo($idUsuario);?>">
<input id="rol" type="hidden" value="<?php echo($UsuarioRol);?>">

<!--SECCION DE MODAL -->
<!-- Modal -->
<section class="cartel hidden">
    <div class="tituloModal">
        <h4 id="titulo">Compra</h4>
        <i id='icono' class="bi bi-x-circle"></i>
    </div>

    <div class="contenidoModal">
      <p id="contenido">Su producto ya fue agregado al carrito. Dirijase a <strong style="color:chocolate">Carrito</strong> para cambiar su cantidad
        o eliminar el producto.
    </p>
    </div>

    <div class="footerModal">
       <p id="pieModal"> Tus mejores marcas aca en <strong style="color:brown">WESH-WESH</strong> </p> 
    </div>
</section>
<div class="overlay hidden"></div>

<!--SECCION DE GRILLA DE PRODUCTOS -->
<div class="d-flex flex-wrap pb-5 justify-content-center mb-3">

  <?php
    foreach ($listaProductos as $unProducto) {
      ?>
        <div class="productos card m-3 justify-content-between" style="width: 18rem; max-height:400px;">
          <img src="<?php echo($unProducto->getImagen()); ?>" class="card-img" style="max-height:200px;object-fit:contain" alt="foto producto">
          <div class="card-body d-flex flex-column justify-content-end" style="max-height:200px">
            <h5 class="card-title"><?php echo ($unProducto->getNombre()) ?></h5>
            <p class="card-text"> <?php echo ($unProducto->getDetalle()) ?> </p>
            <p class="card-text"> <?php echo ("$" . $unProducto->getPrecio()) ?> </p>
            <form class="productForm">
              <input class="idProductos" name="idP" type="hidden" value="<?php echo($unProducto->getId());?>">
              <button type="submit" name="boton" class="botonProducto btn btn-success">Comprar </button>
              <span></span>
            </form>
          </div>
        </div>
  <?php
    //$count++;
  } //fin for 
  ?>
</div>



<script>
  // borra el boton de comprar productos si su rol es deposito
  let rol = $('#rol').val();
  console.log(rol);
  if(rol == 'deposito'){
    $('.botonProducto').each(function(){
      $(this).remove();
    })
  }// fin if 

</script>

<script src="../Js/grilla.js"></script>
<script>
  
</script>
<?php
include_once "../estructura/footer.php"; ?>
