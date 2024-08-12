<?php
$titulo="Login";
include_once '../estructura/headPrivado.php'; 
//var_dump($objSession);
?>
 <main>
    <div class="container bg-white-50 d-flex justify-content-center mt-5">
        <form  class="row g-3 needs-validation" id='formLogin'>
        <input type="hidden" name="accion" id="accion" value="login">
            <div class="card" style="width: 18rem;">
                <img src="../imagenes/autenticacion.png" class="card-img-top" alt="foto login">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-center">Iniciar sesión</h5>
                    
                    <div class="col-md" id="name">
                        
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="fulanito"  required>

                    </div>
                    <div class="col-md" id="pass">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control mb-2" name="password" id="password"  required>
                        <span class="mt-3"><input type="checkbox" name="mostrar" id="mostrar">  Mostrar</span>

                    </div>

                    <div class="col-12 mt-3">
                        <button class="btn btn-primary" id="enviar" type="submit">Ingresar</button>
                        <a href="register.php" class="btn btn-secondary" id="registrarse">Registrarse</a>
                    </div>
                    
                </div>
            </div> 

            <div id="error"></div>
        </form>
    </div>
</main>

<script src="../Js/main.js"></script>
<script src="../librerias/node_modules/jquery-validation/dist/jquery.validate.min.js"></script>
<?php  
include_once '../estructura/footer.php';
?>