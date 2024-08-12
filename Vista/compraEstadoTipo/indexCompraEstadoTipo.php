<?php
$Titulo = "Lista Estados de Compra";
include_once("../estructura/headerLibre.php");
$objAbmCompraEstadoTipo = new AbmCompraEstadoTipo();

$listaCompraEstadoTipo = $objAbmCompraEstadoTipo->buscar(null);

?>	

<div class="container mt-3">
  <h2 style="text-align: center; color:dodgerblue;">Tabla CompraEstadoTipo</h2>
  <h5 style="text-align: left; color:dodgerblue;">CompraEstadoTipos disponibles</h5>            
  <form action="editarCompraEstadoTipo.php" method="post">
    <table class="table-striped">
        <tr>
            <th style="width:10%">Id</th>
            <th style="width:40%">Descripcion</th>
            <th style="width:40%">Detalle</th>

        
        </tr>
        
            <?php if(count($listaCompraEstadoTipo)>0){
                foreach($listaCompraEstadoTipo as $CompraEstadoTipo){?>
                    <tr>
                    <td> <?php echo($CompraEstadoTipo->getId()) ?></td>
                    <td> <?php echo($CompraEstadoTipo->getDescripcion())?></td>
                    <td> <?php echo($CompraEstadoTipo->getDetalle())?></td>
                                    
                    <td><a href="editarCompraEstadoTipo.php?Id=<?php echo($CompraEstadoTipo->getId()) ?>" class="btn btn-info">Editar</a></td>
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
