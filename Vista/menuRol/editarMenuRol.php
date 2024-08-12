<?php
include_once '../../configuracion.php';
$Titulo = "Menu Rol";
include_once '../estructura/headPrivado.php';

$objAbmMenu = new AbmMenu();
$listaMenu = $objAbmMenu->buscar(null);
$objAbmRol = new AbmRol();
$listaRol = $objAbmRol->buscar(null);


$objMenuRol=new AbmMenuRol();
$datos=data_submitted();
$obj=null; 
if(isset($datos['id'])){
    $listaMenuRol=$objMenuRol->buscar($datos);
    if(count($listaMenuRol)==1){
        $obj=$listaMenuRol[0];
    }// fin if 

}// fin if 
?>

<?php  if($obj!=null){?>
    <div class="container mt-3">
        <form action="accionMenuRol.php" method="post">
            <label for="id" style="width:120px">Usuario</label>
            <input type="number" name="idmenu" id="idmenu" readonly value="<?php echo($obj->getObjMenu()->getId()) ?>"><br>
            <input type="number" name="menuNombre" id="menuNombre" readonly value="<?php echo($obj->getObjMenu()->getId()) ?>"><br>
            <label for="nombreRol" style="width:120px"> Rol</label>
            <input type="text" name="niddol" id="idol" value="<?php echo($obj->getObjRol()->getId()) ?>"><br>
            <input type="text" name="nombreRol" id="nombreRol" value="<?php echo($obj->getObjRol()->getId()) ?>"><br>

            <select id="idrol" name="idrol">
                <option value="<?php echo($obj->getObjRol()->getId()) ?>"><?php echo($obj->getObjRol()->getId()) ?></option>
                <?php foreach($listaRol as $rol){?>
                    <option value="<?php echo($tipo->getId()) ?>"> <?php echo ($tipo->getNombre()); ?></option>
                    <?php } ?>      
                </select><br>
            <br><br>
            <input type="submit" name="accion" id="borrar" class="btn btn-danger" value="Borrar">
            <input type="submit" name="accion" id="editar" class="btn btn-info" value="Cambiar">
            <a href="indexMenuRol.php" class="btn btn-secondary">Volver</a>
        </form>
    
<?php } else{
        echo("<p>No se encontro el campo que desea modificar </p>");     
    }
?>
    </div>
<?php
include_once("../estructura/footer.php");

?>