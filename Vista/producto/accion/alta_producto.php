<?php 
include_once "../../../configuracion.php";
$data = data_submitted();
$imagen =$_FILES['imagen']['tmp_name'];
$nombreImagen =strtolower($_FILES['imagen']['name']); 
$tamanio =$_FILES['imagen']['size'];
$extension = strtolower(pathinfo($nombreImagen,PATHINFO_EXTENSION));
//var_dump($extension);
$directorio='../../imagenes/'.$nombreImagen;
$data['imagen']='../imagenes/'.$nombreImagen;
 //var_dump($_SERVER['SCRIPT_NAME']);
// echo(json_encode($nombreImagen));

$respuesta = false;
if (isset($data['idproducto']) && isset($data['pronombre']) &&isset($data['precio'])
 && isset($data['prodetalle']) && isset($data['procantstock'])){
// comprobacion de la extension de un imagen
    if($extension=='jpg' || $extension=='jpeg' || $extension=='png' || $extension=='svg'){
        //echo('entro al tipo de etension');
        if(move_uploaded_file($imagen,$directorio)){
           // echo('<br> acepto el cambio de directorio de la imagen');
            $objC = new AbmProducto();
            $respuesta = $objC->alta($data);
            if (!$respuesta){
                $mensaje = " La accion  ALTA No pudo concretarse";  
            }// fin if 

        }// fin if 
    }// fin if 
}// fin if 

$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
    $retorno['errorMsg']=$mensaje;
}
var_dump($retorno);
 echo json_encode($retorno);
?>