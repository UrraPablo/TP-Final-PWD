<?php
    include_once "../estructura/headPrivado.php";
?>
<head>
  <link type='text/css' rel='stylesheet' href='../css/modal.css'> 
</head>
<div class="register container col-md-3 bg-light">
    <div class="registro card p-2 m5">
    <h2 class="mt-5 mb-4 text-center" id="tituloRegistro">Formulario de Registro</h2>
    <form class="registroForm">
      <div class="form-group">
      <label for="nombre">Nombre:</label>
      <input type="text" class="form-control" id="nombre" name="nombre" required>
      <span></span>
    </div>
    <div class="form-group">
      <label for="pass">Contraseña:</label>
      <input type="password" class="form-control" id="pass" name="pass" required>
      <span></span>
    </div>
    <div class="form-group">
      <label for="email">Correo Electrónico:</label>
      <input type="email" class="form-control" id="email" name="email" required>
      <span></span>
    </div>
    <input type="text" hidden id="accion" name="accion" value="nuevo">
    <button type="submit" class="Enviar btn btn-primary btn-block mt-3">Enviar</button>
    <a href="indexLogin.php" class="btn btn-secondary mt-3">Átras</a>
  </form> 
  </div>
  <p id='avisoRegister'></p>
</div>

<!--SECCION DE MODAL -->
<!-- Modal -->
<section class="cartel hidden">
    <div class="tituloModal">
        <h4 id="titulo">Compra</h4>
        <i id='icono' class="bi bi-x-circle"></i>
    </div>

    <div class="contenidoModal">
      <p id="contenido"> Su registro se realizó <strong style="color:green">Correctamente</strong> 
         Dirigaje a <strong style="font-size:20px">ingresar</strong> para comenzar a comprar.            
    </p>
    </div>

    <div class="footerModal">
       <p id="pieModal"> Tus mejores marcas aca en <strong style="color:brown">WESH-WESH</strong> </p> 
    </div>
</section>
<div class="overlay hidden"></div>


<script src="../Js/registro.js"></script>
<script src="../librerias/node_modules/jquery-validation/dist/jquery.validate.min.js"></script>
<?php  
include_once '../estructura/footer.php';
?>