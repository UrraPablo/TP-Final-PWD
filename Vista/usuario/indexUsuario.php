<?php
$Titulo = "Lista Compras";
include_once ("../../configuracion.php");
include_once("../estructura/headPrivado.php");
$objAbmUsuario = new AbmUsuario();

$listaUsuario = $objAbmUsuario->buscar(null);
//var_dump($listaUsuario);
?>	

<div class="container mt-3">
  <h2 style="text-align: center; color:dodgerblue;">Tabla Usuarios</h2>            
  <form action="editarCompra.php" method="post">
    <table class="table-striped">
        <tr>
            <th style="width:10%">Id</th>
            <th style="width:30%">Nombre</th>
            <th style="width:30%">Mail</th>
            <th style="width:30%">Habilitado</th>
        
        </tr>
        
            <?php if(count($listaUsuario)>0){
                foreach($listaUsuario as $usuario){?>
                    <tr>
                    <td> <?php echo($usuario->getId()) ?></td>
                    <td> <?php echo($usuario->getNombre())?></td>
                    <td> <?php echo($usuario->getMail())?></td>

                     <td> <?php if ($usuario->getDeshabilitado() ==="0000-00-00 00:00:00") echo "Si";
                     else echo "No";?></td>
                    
                    <td><a href="editarUsuario.php?idusuario=<?php echo($usuario->getId()) ?>" class="btn btn-info">Editar</a></td>
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
