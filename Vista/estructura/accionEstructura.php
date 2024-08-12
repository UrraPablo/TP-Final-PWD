<?php
include_once "../../configuracion.php";
$datos=data_submitted();


$session=new Session();
$objAbmMenuRol = new AbmMenuRol;
if(isset($datos['menurol'])){
    $session->setRol($datos['menurol']);
    $menu = $objAbmMenuRol->menuPrincipal($session);
    echo $menu;
}

?>