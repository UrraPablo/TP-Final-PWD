<?php
$Titulo = "Lista";
include_once("../estructura/headPrivado.php");
$objAbmMenuRol = new AbmMenurol();

$listaMenuRol= $objAbmMenuRol->buscar(null);

?>	

<div class="container mt-3">
  <h2 style="text-align: center; color:dodgerblue;">Tabla</h2>
  <h5 style="text-align: left; color:dodgerblue;">Menu y rol</h5>            
  <form action="editarMenuRol.php" method="post">
    <table class="table-striped">
        <tr>
            <th style="width:10%">Id menu</th>
            <th style="width:40%">Id Rol</th>
        </tr>
        
            <?php if(count($listaMenuRol)>0){
                foreach($listaMenuRol as $MenuRol){?>
                    <tr>
                    <td> <?php echo($MenuRol->getObjMenu()->getId()) ?></td>
                    <td> <?php echo($MenuRol->getObjMenu()->getNombre()) ?></td>
                    <td> <?php echo($MenuRol->getObjRol()->getId())?></td>
                    <td> <?php echo($MenuRol->getObjRol()->getNombre())?></td>
                    <td><a href="editarMenuRol.php?id=<?php echo($MenuRol->getObjUsuario()->getId()) ?>" class="btn btn-info">Editar</a></td>
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
