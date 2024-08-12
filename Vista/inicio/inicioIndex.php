<?php
include '../../configuracion.php';
include_once "../estructura/headPrivado.php";

$ruta= '../imagenes/ropa'; // recupera la imagenes de presentacion para hacer el carrusel
$imagenesPresentacion=glob($ruta.'*{jpg,jpeg,png}',GLOB_BRACE);

?>
<head>
  <link type="text/css" rel="stylesheet" href="../css/inicio.css">
</head>
<section class="principal">
  <h2>Tus mejores marcas en ropa deportiva y urbano</h2>
  <div class="container carrusel">
    <div class="carrusel-items">
    <?php 
      foreach($imagenesPresentacion as $unaImagen){ ?>
            <figure class="items">
              <img class='imagenesPrincipales' src="<?php echo($unaImagen) ?>" alt="fotos principales">
            </figure>
            
            <?php 
      }
      ?>
    </div>
  </div>

</section>

<?php
include_once "../estructura/footer.php";
?>