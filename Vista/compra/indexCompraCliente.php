<?php
    $Titulo="Lista Compra Cliente y estado";
    include_once "../estructura/headPrivado.php";
    
    // Este script muestra las compras realizadas por el cliente, con su estado correspondiente 
    // el detalle se muestra en otro archivo.

    $objUsuario=$objSession->getUsuario();
    $objAbmCompraEstado=new AbmCompraEstado();
    $objAbmCompra=new AbmCompra();
    // $i=0;
    $dato["idusuario"]=$objUsuario->getId();
    $listaCompraCliente=$objAbmCompra->buscar($dato);
    $listaObjCompraEstado=[];
    // Este bucle guarda las compras (listaObjCompraEstado) con su ultimo estado 
    for($i=0;$i<count($listaCompraCliente);$i++){
        $compra["idcompra"]=$listaCompraCliente[$i]->getId();
        $compra["cefechafin"]="null";
        $listaObjCompraEstado[$i]=$objAbmCompraEstado->buscar($compra);
        //var_dump($listaObjCompraEstado[$i]);
    }
    //var_dump($listaObjCompraEstado[1]);
    
    // Muestra en forma de tabla las compras - el enlace para ver los detalles - el estado de la compra
?>
<div class="container mt-5">
    <table class="table table-hover  justify-content-center">
    <thead>
        <tr>
        <th scope="col">Número de Compra</th>
        <th scope="col">Detalles de la compra</th>
        <th scope="col">Estado de la compra</th>
        </tr>
    </thead>
    <tbody>
        <?php if(count($listaObjCompraEstado)>0 && $listaObjCompraEstado!=null){
            for($i=0;$i<count($listaObjCompraEstado);$i++){?>
                <tr>
                <th> <?php echo($listaObjCompraEstado[$i][0]->getObjCompra()->getId()) ?></th>
                <td><form action="../compra/verDetalles.php" method="post">
                    <input type="hidden" name="idcompra" Value="<?php echo($listaObjCompraEstado[$i][0]->getObjCompra()->getId()) ?>">
                    <button class="btn btn-info" type="submit">Ver Detalle</button>
                    </form>
                </td>
                <td> <?php echo($listaObjCompraEstado[$i][0]->getObjCompraEstadoTipo()->getDescripcion())?></td>
                </tr>
            <?php }
            }else{?>
            <td colspan="3">
                <div class="alert alert-danger" role="alert">
                    Usted no tiene compras realizadas hasta el momento
                </div>
            </td>
            <?php } ?>
    </tbody>
    </table>
</div>

<script>


</script>
<?php
    include_once "../estructura/footer.php";
?>