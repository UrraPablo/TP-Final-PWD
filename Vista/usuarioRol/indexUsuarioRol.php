<?php
$Titulo = "Lista Usuariorols";
include_once("../estructura/headPrivado.php");
$objAbmUsuariorol = new AbmUsuariorol();
$objUsuario=new AbmUsuario();
$objRol = new AbmRol();
$Roles = $objRol->buscar(null);
$listaUsuario=$objUsuario->buscar(null);
$listaUsuariorol = $objAbmUsuariorol->buscar(null);
//var_dump($listaRolesUsuario);
?>	
<head>
    <link type="text/css" rel="stylesheet" href="../css/usuarioRol.css">
</head>


<section class="container mt-5 mb-5 p-3">
  <div class="cartelAviso">
    
  </div>

  <div class="asignarRol mb-3">
    <button class="Asignar btn btn-info">Asignar Nuevo Rol</button>
  </div>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombre</th>
      <th scope="col">Rol</th>
    </tr>
  </thead>
  <tbody>
      <?php
        foreach($listaUsuario as $unUsuario){
          $id = $unUsuario->getId();
          $roles = $objAbmUsuariorol->buscar(['idusuario'=>$id]);
          $nombre =$roles[0]->getObjUsuario()->getNombre();
          foreach($roles as $unRol){
            $idRol = $unRol->getObjRol()->getId();
            $descripcion = $unRol->getObjRol()->getDescripcion();
          ?>
          <tr class="datosRolUsuario">
            <th class="idusuario" scope="row" value="<?php echo($id); ?>"> <?php echo($id); ?> </th>
            <td class="nombreUsuario"> <?php echo($nombre); ?> </td>
            <td class="rolDescripcion"> <?php echo($descripcion); ?> </td>
            <td class="eliminar"> <button class="botonEliminar btn btn-danger" value="<?php echo($idRol); ?>">Eliminar</button> </td>

          </tr>  
          <span id="avisoEliminar"></span>
          <?php

          }// fin for 
        }// fin for
      ?>

  </tbody>
</table>


<!--SECCION DE MODAL -->
<!-- Modal -->
<section class="cartel hidden">
    <div class="tituloModal">
        <h4 id="titulo">Asignar Nuevo Rol</h4>
    </div>

    <div class="contenidoModal">
      <form action="" method="post">
        <div class="nombreUsuario">
          <label for="nombre">Elija un Usuario: </label>
          <select name="nombre" id="nombre">
            <?php foreach($listaUsuario as $usuario){
              ?>

                <option value="<?php echo($usuario->getNombre()); ?>"><?php echo($usuario->getNombre()); ?></option>
              <?php

            } ?>
          </select>
        </div>
        <div class="rolUsuario">
          <label for="rol">Elija un Rol: </label>
            <select name="rol" id="rol">
                <?php 
                  foreach($Roles as $rol){
                    ?>
                      <option value="<?php echo($rol->getDescripcion()) ?>"><?php echo($rol->getDescripcion()) ?></option>
                    <?php
                  }
                ?>
            </select>

        </div>
      </form>
    </div>

    <div class="footerModal">
       <button class="btn btn-info" id="pieModal"> Asignar rol</button> 
    </div>
</section>
<div class="overlay hidden"></div>


</section>


<script>
  $(function(){
    // BOTON PARA ABRIR EL MODAL PARA ASIGNAR EL NUEVO ROL 
    $('.Asignar').on('click',function(){
      modal();
    });

    // EVENTO PARA ASIGAR NUEVO ROL 
    $('#pieModal').on('click',asignarRol); 
    // ENVIO DE DATOS PARA ASIGNAR EL NUEVO ROL
    function asignarRol(){
      let nombre = $('#nombre').val();
      let rol = $('#rol').val();
      //console.log("Su nombre es : "+nombre+"  y su ro es : "+rol);
      let datos = {'usnombre':nombre,'rodescripcion':rol,'accion':'asignar'};
      
      $.ajax({
        url:'accionUsuarioRol.php',
        method:'post',
        data:datos,
        success: function(res){
          console.log(res);
          if(res=='false'){
            $('.cartelAviso').text('Se asigno el rol: '+rol+' al usuario: ' +nombre);
            $('.cartelAviso').css({
              'color':'green',
              'font-size':'20px',
              'font-family':'Arial,Helvetica,sans-serif'
            });
            
          }
          else{
            $('.cartelAviso').text('El usuario  : '+nombre+ '  ya tiene este rol : '+ rol);
            $('.cartelAviso').css({
              'color':'red',
              'font-size':'20px',
              'font-weight':'bolder'
            });

          }
        },// fin function
        error:function(er){
          console.log(er.statusText);
        }

      }); // fin ajax 
    }// fin function 

    // MODAL 
    function modal(){
        
        const openModal=function(){
            $('.cartel').removeClass('hidden');
            $('.overlay').removeClass('hidden');
        };
        const cerrarModal=function(){
            $('.cartel').addClass('hidden');
            $('.overlay').addClass('hidden');
        }

        //$('.Abrir').click(openModal);
        //boton.addEventListener('click',openModal);
        openModal();
        $('#pieModal').click(cerrarModal);
    }// fin function 

    // evento eliminar rol
    let botonesEliminar=$('.botonEliminar');
    botonesEliminar.each(function(index,element){
      element.addEventListener('click',function(e){
        e.preventDefault();
        //console.log(element.parentElement.nextSibling.parentElement.childNodes[1].textContent);
        let idU=element.parentElement.nextSibling.parentElement.childNodes[1].textContent;
        let idrol = element.value;
        borrarRol(idU,idrol);

      })
    });
    

    // ELIMINACION PARA BORARR UN ROL A UN USUARIO
    function borrarRol(idu,idrol){
      let param ={'idusuario':idu,'idrol':idrol,'accion':'borrar'};
      $.ajax({
        url:'accionUsuarioRol.php',
        method:'post',
        data:param,
        success:function(res){
          console.log(res);
          if(res=='false'){
            $('.avisoEliminar').text('No se pudo eliminar el rol');
            $('.avisoEliminar').css('color','red');

          }// fin if
          else{
             $('.cartelAviso').text('Se elimino el rol correcatamente');
             $('.cartelAviso').css({
              'color':'green',
              'font-size':'40px'
             }); 
          }// fin else 
        },// fin function
        error:function(er){
          console.log(er.statusText);
        }// fin function
      }); // fin ajax
    }// fin function 


  });
</script>

<?php
include_once("../estructura/footer.php");
?>