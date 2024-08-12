<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$id["idrol"]=$data["idrol"];
if (isset($data['idrol'])){
    $objC = new AbmRol();
    $rol=$objC->buscar($id);
    $data["rodescripcion"]=$rol[0]->getDescripcion();
    $respuesta = $objC->modificacion($data);
    if (!$respuesta){
        $mensaje = " La accion  HABILITACION No pudo concretarse";
    }
}

$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
   
    $retorno['errorMsg']=$mensaje;

}
    echo json_encode($retorno);
?>