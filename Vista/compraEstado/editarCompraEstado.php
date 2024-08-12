<?php
include_once '../../configuracion.php';
$Titulo = "Estados de Compras";
include_once '../estructura/headPrivado.php';

$objAbmCompra = new AbmCompra();
$listaCompra = $objAbmCompra->buscar(null);
$objAbmCompraEstadoTipo = new AbmCompraEstadoTipo();
$listaCompraEstadoTipo = $objAbmCompraEstadoTipo->buscar(null);

$objCompraEstado=new AbmCompraEstado();
$datos=data_submitted();
$obj=null; 
if(isset($datos['idCompra'])){
    $listaCompras=$objCompra->buscar($datos);
    if(count($listaCompras)==1){
        $obj=$listaCompras[0];
    }// fin if 

}// fin if 
?>

<?php  if($obj!=null){?>
    <div class="container mt-3">
        <form action="accionCompra.php" method="post">
            <label for="id" style="width:120px">Codigo ID</label>
            <input type="number" name="idCompra" id="idCompra" readonly value="<?php echo($obj->getidCompra()) ?>"><br>
            <label for="nombreCompra" style="width:120px"> Compra</label>
            <input type="text" name="nombreCompra" id="nombreCompra" value="<?php echo($obj->getnombreCompra()) ?>"><br>
            <label for="precio" style="width:120px"> Precio</label>
            <input type="text" name="precio" id="precio" value="<?php echo($obj->getprecio()) ?>"><br>
            <label for="Usuario" style="width:120px"> Id Usuario</label>
      
            <select id="idUsuario" name="idUsuario">
                <option value="<?php echo($obj->getobjUsuario()->getidUsuario())?>"><?php echo($obj->getobjUsuario()->getnombreUsuario()) ?></option>
                <?php foreach($listaUsuario as $Usuario){?>
                    <option value="<?php echo($Usuario->getIdUsuario()) ?>"> <?php echo ($Usuario->getnombreUsuario()); ?></option>
                    <?php } ?>      
                </select><br>
            <label for="Tipo" style="width:120px"> Id Tipo </label>

            <select id="idTipo" name="idTipo">
                <option value="<?php echo($obj->getobjTipo()->getIdTipo()) ?>"><?php echo($obj->getobjTipo()->getnombreTipo()) ?></option>
                <?php foreach($listaTipo as $tipo){?>
                    <option value="<?php echo($tipo->getIdTipo()) ?>"> <?php echo ($tipo->getnombreTipo()); ?></option>
                    <?php } ?>      
                </select><br>
            <br><br>
            <input type="submit" name="accion" id="borrar" class="btn btn-danger" value="Borrar">
            <input type="submit" name="accion" id="editar" class="btn btn-info" value="Cambiar">
            <a href="indexCompra.php" class="btn btn-secondary">Volver</a>
        </form>
    
<?php } else{
        echo("<p>No se encontro el campo que desea modificar </p>");     
    }
?>
    </div>
<?php
include_once("../estructura/footer.php");
//      <input type="text" name="idUsuario" id="idUsuario" value="<?php echo($obj->getobjUsuario()->getidUsuario()) ? >">
//<input type="text" name="idTipo" id="idTipo" value="<?php echo($obj->getobjTipo()->getIdTipo()) ? >">
?>