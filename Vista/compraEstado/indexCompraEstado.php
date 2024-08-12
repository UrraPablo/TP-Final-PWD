<?php
$Titulo = "Lista Compras";
include_once("../estructura/headerLibre.php");
$objAbmCompraEstado = new AbmCompraEstado();

$listaCompraEstado = $objAbmCompraEstado->buscar(null);

?>	

<div class="container mt-3">
  <h2 style="text-align: center; color:dodgerblue;">Tabla Compra</h2>
  <h5 style="text-align: left; color:dodgerblue;">Estados Compras disponibles</h5>            
  <form action="editarCompraEstado.php" method="post">
    <table class="table-striped">
        <tr>
            <th style="width:10%">IdCompraEstado</th>
            <th style="width:40%">Id Compra</th>
            <th style="width:10%">IdCompraEstadoTipo</th>
            <th style="width:20%">Fecha</th>
            <th style="width:20%">Fecha</th>
        
        </tr>
        
            <?php if(count($listaCompraEstado)>0){
                foreach($listaCompraEstado as $CompraEstado){?>
                    <tr>
                    <td> <?php echo($CompraEstado->getId()) ?></td>
                    <td> <?php echo($CompraEstado->getObjCompra()->getId()) ?></td>
                    <td> <?php echo($CompraEstado->getObjCompraEstadoTipo()->getDescripcion())?></td>
                    <td> <?php echo($CompraEstado->getFechaInicio())?></td>
                    <td> <?php echo($CompraEstado->getFechaFin())?></td>
                    
                    <td><a href="editarCompra.php?idCompra=<?php echo($CompraEstado->getObjCompra()->getId()) ?>" class="btn btn-info">Editar</a></td>
                </tr>
                <?php    
                }// fin for 
            } ?>
    </table>
  </form>

</div>


<script src="../js/funciones.js"></script>
<?php
include_once("../estructura/footer.php");
?>
