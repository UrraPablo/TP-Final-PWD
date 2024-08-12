<?php
include_once '../../configuracion.php';
$Titulo = "Compras";
include_once '../estructura/headPrivado.php';

// MUESTRA TODAS LAS COMPRAS DE TODOS LOS USUARIOS
//$objAbmUsuario = new AbmUsuario();
$objCompraE=new AbmCompraEstado();
$listaCE = $objCompraE->buscar(['cefechafin'=>'null']);
//var_dump(count($listaCE));
?>

<?php  if(count($listaCE)!=0){?>
    <div class="container mt-3">
    <table class="table">
  <thead>
    <tr>
      <th scope="col">ID De Compra</th>
      <th scope="col">Nombre del Cliente</th>
      <th scope="col">Estado de Compra</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    foreach($listaCE as $unCE){
    ?>
        <tr>
        <th scope="row"><?php echo($unCE->getObjCompra()->getId()) ?></th>
        <td><?php echo($unCE->getObjCompra()->getUsuario()->getNombre()) ?></td>
        <td><?php echo($unCE->getObjCompraEstadoTipo()->getDescripcion()) ?></td>
        </tr>
    
    <?php
    }// fin for 
    ?>
  </tbody>
</table>

    
<?php } else{
        echo("<div class='alert alert-danger' role='alert'>
                No hay compras realizadas !
            </div>");     
    }// fin else
?>
    </div>
<?php
include_once("../estructura/footer.php");

?>