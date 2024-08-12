<?php
    include_once '../../configuracion.php';
    include_once "../estructura/headPrivado.php";
    $Titulo="Lista Compra Cliente y estado";
    // Muestra los productos de la compra seleccionada con sus detalles 
    $datos=data_submitted(); // envia el id de la compra por url desde indexCompraCliente
    $objCompraItem=new AbmCompraItem();
    $listaCompraItem=$objCompraItem->buscar($datos);
?>
<h1>Lista de Productos</h1>
<div class="container mt-5">
    <table class="table table-hover  justify-content-center">
    <thead>
        <tr>
        <th scope="col">Número</th>
        <th scope="col">Nombre</th>
        <th scope="col">Cantidad</th>
        </tr>
    </thead>
    <tbody>
        <?php if(count($listaCompraItem)>0){
            for($i=0;$i<count($listaCompraItem);$i++){
                ?>
                <tr>
                <th> <?php echo($listaCompraItem[$i]->getObjProducto()->getId()) ?></th>
                <th> <?php echo($listaCompraItem[$i]->getObjProducto()->getNombre()) ?></th>
                <?php if($listaCompraItem[$i]->getCantidad()>0){?>
                    <th> <?php echo($listaCompraItem[$i]->getCantidad()) ?>✔</th>
                <?php }else{ ?>
                <td>❌Producto Cancelado</td>
                </tr>
            <?php }}
            }else{?>
            <td colspan="3">
                <div class="alert alert-danger" role="alert">
                    Usted no tiene compras realizadas hasta el momento
                </div>
            </td>
            <?php } ?>
    </tbody>
    </table>
    <div><a href="indexCompraCliente.php" class="btn btn-secondary">Atrás</a></div>
</div>
<?php
    include_once "../estructura/footer.php";
?>