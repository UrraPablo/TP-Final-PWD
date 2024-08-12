<?php
include_once("../../configuracion.php");
$objSession = new Session();
$objAbmMenuRol = new AbmMenuRol();

$menu=""; // almacena todo el string de la barra de menu
$UsuarioNombre="";

if ($objSession->validar() && $objSession->permisos()) {    //&& $objSession->permisos()
  $menu = $objAbmMenuRol->menuPrincipal($objSession);
  $UsuarioRol = $objSession->getRolActual()->getDescripcion();
  $UsuarioNombre .=$objSession->getUsuario()->getNombre();
  $idUsuario=$objSession->getUsuario()->getId();
}else {
  //$objSession=new Session();
  $nombre='incognito';
  $pass='';
  $objSession->iniciar($nombre,$pass);
  $menu = $objAbmMenuRol->menuPrincipal($objSession);
  $UsuarioRol = $objSession->getRolActual()->getDescripcion();
  $UsuarioNombre .=$objSession->getUsuario()->getNombre();  
  header("Location: ../login/indexLogin.php");

}// fin if
//var_dump($menu);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--LINK BOOSTRAP -->
  <link rel="stylesheet" href="../librerias/bootstrap5/css/bootstrap.min.css">
  <!--LINK ICONOS BOOTSTRAP  -->
  <link rel="stylesheet" href="../librerias/node_modules/bootstrap-icons/font/bootstrap-icons.css">
  <!-- LINK CSS -->
  <link rel="stylesheet" type="text/css" href="../css/estilos.css">
  <link rel="stylesheet" href="../../node_modules/jquery-modal/jquery.modal.css">
  <!--LINK JS - BOOTSTRAP-->
  <script src="../librerias/bootstrap5/js/bootstrap.min.js"></script>

  <!--LINK JS - JQUERY-->
  <script src="../librerias/node_modules/jquery/dist/jquery.min.js"></script>
  <script src="../../node_modules/jquery-modal/jquery.modal.js"></script>
  <script src="../Js/menu.js"></script>
  <script src="../Js/inicio.js"></script>

</head>
 
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light p-2 fs-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Grupo N°5</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!--**********************************************************************************-->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#"><i  class="bi bi-github"></i></a>
        </li>
        
        <!-- ***************************Opciones del menu dinamico segun tipo de usuario **************************************  -->
        <ul class="navbar-nav" id="resultadoMenu">
          <?php echo($menu);?> 
        </ul>
      </ul>
      <!--*********************************************************************-->
    </div>
  </div>
  <div class="d-flex justify-content-end" style="list-style-type:none">
    <a class="nav-link "  href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
       <?php echo($UsuarioNombre=='incognito'?'':$UsuarioNombre)?></a>
  </div>
</nav>  