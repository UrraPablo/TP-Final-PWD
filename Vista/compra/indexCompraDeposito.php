<?php
    include_once '../../configuracion.php';
    include_once '../estructura/headPrivado.php';
// objCE = obj compra estado
// objCI = obj compra item
// oblCET = obj compra estado tipo
$objCE=new AbmCompraEstado();
$objCI=new AbmCompraItem();
$objCET=new AbmCompraEstadoTipo();
$dato['idcompraestadotipo']=2;
$dato['cefechafin']='null';
$listaObjCE=$objCE->buscar($dato);


?>

<main class="container mb-3">
    <div class="container mt-3">
        <h3 class="text-center">Listado de Compras para ser enviadas</h3>
    <table class="table table-striped table-bordered mt-5">
        <thead>
            <tr>
            <th scope="col" class="h5 fw-bolder"> ID Compra</th>
            <th scope="col" class="h5 fw-bolder">Estado</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        if(count($listaObjCE)>0){
            foreach($listaObjCE as $unaCE){
                $idcompra=$unaCE->getObjCompra()->getId();
                ?>
                <tr>
                <th scope="row" class="h5 fw-bolder"><?php echo($idcompra) ?></th>
                <td class="h5"><?php echo($unaCE->getObjCompraEstadoTipo()->getDescripcion()); ?></td>
                <td class="h5"><button type="button" id="<?php echo($idcompra) ?>" class="btn btn-info productos"><a class="text-dark" href="verProductos.php?idcompra=<?php echo($idcompra);?>">Ver Productos</a></button></td>
                </tr>
                <?php

            }// fin for

        }// fin if 
        else{
            ?>
            <div class="alert alert-danger">
                No hay compras para ser enviadas. 
            </div>
            <?php 
        }
        ?>
            
        </tbody>
</table>
    </div>
</main>    

<script>
    /** 
    $(document).ready(function(){
        let botones=$('.productos');
            
            // recorrer los botones - identificar a cual se le hizo click y enviar el idcompra a verProductos
           //console.log(botones[1].getAttribute('id'));
           for(var i=0; i<botones.length;i++){
            botones[i].addEventListener('click',function(e){
                e.preventDefault();
                let id=this.getAttribute('id');
                $.ajax({
                    url:'verProductos.php',
                    method:'POST',
                    data:{idcompra:id},
                    success:function(){
                        //location.href='verProductos.php';
                        console.log(id);
                    }
                });
                
            });
                
            

           }
        });
        */

</script>

<?php
include_once '../estructura/footer.php';
?>