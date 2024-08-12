<?php
  include_once("../../configuracion.php");
  $_SESSION["iduser"] = "1";
  $_SESSION["idrol"] = "2";
  /*$objAbmMenu = new AbmMenu();
  $listaMenu = $objAbmMenu->buscar(null);
  $objAbmRol = new AbmRol();
  $listaRol = $objAbmRol->buscar(null);*/
  $objMenuRol=new AbmMenuRol();
  $param["idrol"] =  $_SESSION["idrol"];
  $listaMenuRol = $objMenuRol->buscar($param);
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

  
  <!--LINK JS - BOOTSTRAP-->
  <script src="../librerias/bootstrap5/js/bootstrap.min.js"></script>

    <!--LINK JS - JQUERY-->
    <script src="../librerias/node_modules/jquery/dist/jquery.min.js"></script>

</head>
<?php 
/*
  // Parte de verificacion de permisos 
  $objSession=new Session();
  $respuesta=$objSession->validar();
  if($respuesta){
    // pregunta que rol tiene el usuario para mostrar la
    // informacion en funcion de su rol 



  }// fin if 
  else{
    // Manda al usuario no validado al login (faltaria la carpeta login)
    header("Location: ../usuario/index.php");
  }// fin else*/
?>

<body>
  <nav class="navbar navbar-expand-lg bg-light p-2 fs-3">
    <div class="container-fluid">
      <a class="navbar-brand" id="pagina-principal" href="../estructura/principal.php">Grupo N°5</a>

      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav"> 
          <!--DROPDOWN TP1 -->

<?php          
      foreach ($listaMenuRol as $key => $objMenuRol){
        echo $objMenuRol->getObjMenu()->getNombre();
          $menu = '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button"  data-bs-toggle="dropdown" aria-expanded="false">';
          $menu .= $objMenuRol->getObjMenu()->getNombre() . "</a>";
          $menu .= '<ul class="dropdown-menu">';
            foreach ($listaMenuRol as $key => $value){
              $menu .= '<li><a class="dropdown-item" href="'. $value->getObjMenu()->getDescripcion(). '">'.$value->getObjMenu()->getNombre().'</a></li>';
            }
          }
          $menu .= "</ul></li>";
      echo $menu;
?>



        </ul>
      </div>
    </div>

  </nav>
