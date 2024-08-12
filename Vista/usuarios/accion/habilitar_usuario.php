<?php
include_once "../../../configuracion.php";
$data = data_submitted();
$id["idusuario"]=$data["idusuario"];
if (isset($data['idusuario'])){
    $objC = new AbmUsuario();
    $usuario=$objC->buscar($id);
    $data["usnombre"]=$usuario[0]->getNombre();
    $data["uspass"]=$usuario[0]->getPassword();
    $data["usmail"]=$usuario[0]->getMail();
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $data["usdeshabilitado"]="0000-00-00 00:00:00";
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