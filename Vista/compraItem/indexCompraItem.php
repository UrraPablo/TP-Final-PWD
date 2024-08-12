<?php
$Titulo = "Lista CompraItems";
include_once("../estructura/headerLibre.php");
include_once("../../configuracion.php");
$objAbmCompraItem = new AbmCompraItem();

$listaCompraItem = $objAbmCompraItem->buscar(null);
//var_dump($listaCompraItem);
?>	

<div class="container mt-3">
  <h2 style="text-align: center; color:dodgerblue;">Tabla Item de CompraItem</h2>
  <h5 style="text-align: left; color:dodgerblue;">Item CompraItems disponibles</h5>            
  <form action="editarCompraItem.php" method="post">
    <table class="table-striped">
        <tr>
            <th style="width:10%">Id</th>
            <th style="width:20%">Id Producto</th>
            <th style="width:20%">Producto</th>
            <th style="width:40%">Id CompraItem</th>
            <th style="width:20%">Cantidad</th>
        
        </tr>
        
            <?php if(count($listaCompraItem)>0){
                foreach($listaCompraItem as $CompraItem){?>
                    <tr>
                    <td> <?php echo($CompraItem->getId()) ?></td>
                    <td> <?php echo($CompraItem->getObjProducto()->getId())?></td>
                    <td> <?php echo($CompraItem->getObjProducto()->getNombre())?></td>
                    <td> <?php echo($CompraItem->getObjCompra()->getId())?></td>
                    <td> <?php echo($CompraItem->getCantidad())?></td>
                    
                    <td><a href="editarCompraItem.php?idCompraItem=<?php echo($CompraItem->getId()) ?>" class="btn btn-info">Editar</a></td>
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
