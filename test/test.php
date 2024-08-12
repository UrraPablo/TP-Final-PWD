<?php
include_once '../configuracion.php';

//----------- prueba de alta y modificacion ------------------------------
// MENU 
/**  
$datos['idmenu']=1;
$datos['menombre']='adm';//date('Y-m-d H:i:s');
$datos['medescripcion']='../adm/test.php';
$datos['idpadre']=0;
$datos['medeshabilitado']=null;//date('Y-m-d H:i:s');
$objMenu=new AbmMenu();
$objMenu->modificacion($datos);
echo("<br>----Hecho----<br>");
*/

// USUARIO
 
//$datos['idusuario']=7;
$datos['usnombre']='pepe';
$datos['uspass']=md5('123');
//$datos['usmail']='sofi@gmail.com';
$datos['usdeshabilitado']=null;//date('Y-m-d H:i:s');
$objUsuario=new AbmUsuario();
$objUsuario->buscar($datos);
var_dump($objUsuario);
echo("<br>----Hecho usuario ----<br>");


// ROL
/** 
$datos['idrol']=1;
$datos['rodescripcion']='administrador';
$objUsuario=new AbmRol();
$objUsuario->modificacion($datos);
echo("<br>----Hecho rol ----<br>");
*/

// COMPRA 
 
//$datos['idcompra']=5;
//$datos['cofecha']=null;//date('Y-m-d H:i:s');
/** 
$datos['idusuario']=1;
$objCompra=new AbmCompra();   // NOTA:  LA FUNCION MODIFICAR DE COMPRA NO FUNCIONA PORQUE EL METODO SETAERCAMPOCLAVES DA FALSO
$compras=$objCompra->buscar($datos);
echo("compras hachas por el mismo usuario <br>");
//var_dump($compras);
foreach($compras as $un){
    echo("Nombre:  ".$un->getUsuario()->getNombre()."<br>");
    echo("ID:  ".$un->getId()."<br>");
}
//echo("<br>----Hecho compra ----<br>");
*/


//PRODUCTO 
//$datos['idproducto']=1;
 /** 
$datos['pronombre']="jdjdhdd";//date('Y-m-d H:i:s');
$datos['prodetalle']="ksjsh";
$datos['procantstock']=999;
$objProducto=new AbmProducto();
$objProducto->alta($datos);
echo("<br>----Hecho producto ----<br>");
*/

// MENUROL
/** 
$datos['idrol']=1;//date('Y-m-d H:i:s');
$datos['idmenu']=2;
$objMenuRol=new AbmMenuRol();
$objMenuRol->modificacion($datos);  // NO SE USA LOS MOETODOS DE MODIFICACION EN LAS TABLAS CON ENTIDADES DEBILES MENUROL - USUARIOROL - 
echo("<br>----Hecho menurol ----<br>");
*/

// USUARIOROL
/** 
$datos['idrol']=1;//date('Y-m-d H:i:s');
$datos['idusuario']=1;
$objUserRol=new AbmUsuarioRol();
$objUserRol->alta($datos);  // NO SE USA LOS MOETODOS DE MODIFICACION EN LAS TABLAS CON ENTIDADES DEBILES MENUROL - USUARIOROL - 
echo("<br>----Hecho usuariorol ----<br>");
*/

// COMPRA ESTADO TIPO
/** 
$datos['idcompraestadotipo']=1;//date('Y-m-d H:i:s');
$datos['cetdescripcion']="muchas compras ";
$datos['cetdetalle']=" todo caro";
$objCompEst=new AbmCompraEstadoTipo();
$objCompEst->modificacion($datos);

echo("<br>----Hecho compraestadotipo ----<br>");
*/

// COMPRA ESTADO 
/** 
$datos['idcompraestado']=1;
$datos['idcompraestadotipo']=1;
$datos['idcompra']=7;
$datos['cefechaini']=null;//date('Y-m-d H:i:s');
$datos['cefechafin']=null;//date('Y-m-d H:i:s');
$objCE=new AbmCompraEstado();
$objCE->modificacion($datos);


echo("<br>----Hecho compraestado ----<br>");
*/

// COMPRA ITEM 
/** 
$datos['idcompraitem']=1;
$datos['idcompra']=5;
$datos['idproducto']=1;
$datos['cicantidad']=789565;
$objCI=new AbmCompraItem();
$objCI->modificacion($datos);
echo("<br>----Hecho compra item ----<br>");
*/


/***************** MOSTRAR LOS PRODUCTOS COMPRDOS POR EL USUARIO ************************** */
// COMO OBTENER EL HISTORIAL DE COMPRAS DE UN USUARIO
/** 
echo("COMPRAS DEL USUARIO CON ID 3 <br>");
$datosU['idusuario']=3;
$datosC['idcompra']=3;
// con estos 2 id se puede obtener los productos de la compra el los estados de la compra
$objCompraItem=new AbmCompraItem();
$objCompra=new AbmCompra();
$objCompraEstado=new AbmCompraEstado();


$listaItemComprados=$objCompraItem->buscar($datosC);

echo("<br> PRODUCTOS DE LA  COMPRA ID:".$datosC['idcompra']."<br>");
foreach($listaItemComprados as $item){
    echo("<br>".$item->getObjProducto()->getNombre()."<br>");
    echo("<br>".$item->getObjProducto()->getDetalle()."<br>");

}// fin for 

$listaEstados=$objCompraEstado->buscar($datosC);
echo("ESTADOS DE LA COMPRA CON ID: ".$datosC['idcompra']."<br>");
foreach($listaEstados as $estado){
    echo("<br>".$estado->getObjCompraEstadoTipo()->getDescripcion()."<br>");

}// fin for 

echo(" COMPRAS HECHAS POR EL USUARIO CON ID :".$datosU['idusuario']."<br>");
$listaComras=$objCompra->buscar($datosU);
foreach($listaComras as $compra){
    echo("<br>".$compra->getCoFecha()."<br>");

}// fin for 

*/













?>