<?php
include_once '../../configuracion.php';
$Titulo = "Tipos de estados de compras";
include_once '../estructura/headPrivado.php';


$objCompraET=new AbmCompraEstadoTipo();
$datos=data_submitted();
$obj=null; 
if(isset($datos['Id'])){
    $listaCompraET=$objCompraET->buscar($datos);
    if(count($listaCompraET)==1){
        $obj=$listaCompraET[0];
    }// fin if 

}// fin if 
?>

<?php  if($obj!=null){?>
    <div class="container mt-3">
        <form action="accionCompraEstadoTipo.php" method="post">
            <label for="id" style="width:120px">Codigo ID</label>
            <input type="number" name="Id" id="Id" readonly value="<?php echo($obj->getId()) ?>"><br>
            <label for="cetdescripcion" style="width:120px"> Descripcion</label>
            <input type="text" name="cetdescripcion" id="cetdescripcion" value="<?php echo($obj->getDescripcion()) ?>"><br>
            <label for="cetdetalle" style="width:120px"> Detalle</label>
            <input type="text" name="cetdetalle" id="cetdetalle" value="<?php echo($obj->getDetalle()) ?>"><br>
           
            <br><br>
            <input type="submit" name="accion" id="borrar" class="btn btn-danger" value="Borrar">
            <input type="submit" name="accion" id="editar" class="btn btn-info" value="Cambiar">
            <a href="indexCompraEstadoTipo.php" class="btn btn-secondary">Volver</a>
        </form>
    
<?php } else{
        echo("<p>No se encontro el campo que desea modificar </p>");     
    }
?>
    </div>
<?php
include_once("../estructura/footer.php");
?>