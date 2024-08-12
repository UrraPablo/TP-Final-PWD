<?php header('Content-Type: text/html; charset=utf-8');
header ("Cache-Control: no-cache, must-revalidate ");
date_default_timezone_set('America/Argentina/Buenos_Aires');
/////////////////////////////
// CONFIGURACION APP//
/////////////////////////////

$PROYECTO ='TP-Final-PWD';

//variable que almacena el directorio del proyecto
$ROOT =$_SERVER['DOCUMENT_ROOT']."/".$PROYECTO."/";
//var_dump($ROOT);

include_once($ROOT.'util/funciones.php');


// Variable que define la pagina de autenticacion del proyecto
//$INICIO = "Location:http://".$_SERVER['HTTP_HOST']."/$PROYECTO/vista/login/indexLogin.php";

// variable que define la pagina principal del proyecto (menu principal)
$PRINCIPAL = "Location:http://".$_SERVER['HTTP_HOST']."/$PROYECTO/Vista/inicio/inicioIndex.php";


$GLOBALS['ROOT']=$ROOT;

?>
