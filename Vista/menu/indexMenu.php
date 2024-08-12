<?php
$Titulo = "Lista Menu";
include_once("../estructura/headPrivado.php");
include_once("../../configuracion.php");

$objAbmMenuRol = new AbmMenuRol();
$listaMenuRol=$objAbmMenuRol->buscar(null);
$objRol = new AbmRol();
$listaRoles =$objRol->buscar(null);


?>	
<head>
  <link type="text/css" href="../css/menu.css" rel="stylesheet">
</head>

<div class="container mb-5">
  <h2 style="text-align: center; color:dodgerblue;">Lista de Menu</h2>   
  <button type="button" class="abrir btn btn-success">Asignar Nuevo Menu</button>
  <p class="avisoEliminar"></p>    
    <table class="table table-striped mb-5">
      <tr>
        <th style="width:10%">Id Menu</th>
        <th style="width:40%">Nombre</th>
        <th style="width:20%">Rol</th>
        <th style="width:20%">Descripcion</th>
        <th style="width:20%">Id Padre</th>
        <th style="width:20%">Habilitado</th>
        
      </tr>
      
      <?php if(count($listaMenuRol)>0){
        foreach($listaMenuRol as $menuRol){?>
                    <tr>
                      <td> <?php echo($menuRol->getObjMenu()->getId()) ?></td>
                      <td> <?php echo($menuRol->getObjMenu()->getNombre())?></td>
                      <td> <?php echo($menuRol->getObjRol()->getDescripcion())?></td>
                    <td> <?php echo($menuRol->getObjMenu()->getDescripcion())?></td>

                    <?php 
                    if($menuRol->getObjMenu()->getobjMenuPadre()==null){
                      ?>
                      <td>NULL</td>
                      <?php
                    }
                    else{
                      ?>
                      <td><?php echo($menuRol->getObjMenu()->getobjMenuPadre()->getId()) ?></td>
                      <?php

                    }// fin else
                    
                    ?>
                    
                    <?php 
                    if($menuRol->getObjMenu()->getDeshabilitado()==null || $menuRol->getObjMenu()->getDeshabilitado()=='0000-00-00 00:00:00'){
                      ?>
                      <td>SI</td>
                      <?php
                    }
                    else{
                      ?>
                      <td>NO</td>
                      <?php

                    }// fin else
                    
                    ?>
                      <td><a href="editarMenu.php?id=<?php echo($menuRol->getObjMenu()->getId()) ?>" class="btn btn-info">Editar</a></td>
                    <td><button class=" eliminarMenu btn btn-danger mx-2" value="<?php echo($menuRol->getObjMenu()->getId()) ?>">ELIMINAR</button></td>
                  </tr>
                <?php    
                }// fin for 
            } ?>
    </table>
</div>

<!--  SECCION DEL MODAL DE NUEVO ITEM  -->
  <section class="cartel hidden">
    <h2 class="tituloModal"> Nuevo Menu</h2>
    <i id='icono' class="bi bi-x-circle"></i>
    <form class="NuevoMenu">
      <input type="hidden" name='accion' value="Nuevo">
      <div class="controlForm">
        <label for="nombre">Nombre del Menu:</label><br>
        <input type="text" name="menombre"><br>
      </div>
      <div class="controlForm">
        <label for="nombre">Descripcion del Menu:</label><br>
        <input type="text" name="medescripcion"><br>  
      </div>
      <div class="controlForm">
        <label>¿Que rol usará dicho menu ?</label><br>
        <?php foreach($listaRoles as $unRol){
          ?>
          <input type="checkbox" name="rol[]" value="<?php echo($unRol->getId()) ?>">
          <label for="rol"><?php echo($unRol->getDescripcion()) ?></label><br>
          <?php
        } ?>
      </div>
      <button class="enviarItem btn btn-info">Crear Nuevo Menu</button>
    </form>
    <p class="avisoAsignacion"></p>
</section>
<div class="overlay hidden"></div>



<script> 
$(function(){
  // evento particular para agregar o no un submenu

  
  // cierra el evento si se hace click en NO 




  /** Esta funcion realiza un borrado logico del menu seleccionado  */
  function eliminarMenu(){
    //let btnELiminar = $('.eliminarMenu');
   // console.log(btnELiminar);
    $('.eliminarMenu').each(function (index, element) {
      // element == this
      element.addEventListener('click',function(e){
        e.preventDefault();
        let datos={accion:'Borrar',id:element.value};
        $.ajax({
          url:'accionMenu.php',
          method:'post',
          data:datos,
          success:function(r){
            console.log(r);
            $('.avisoEliminar').text('¡El item del menu fue eliminado exitosamente!')
            $('.avisoEliminar').css({
              'color':'green',
              'font-size':'30px'
            })
          },
          error:function(e){
            console.log(e.statusText);
          }

        })
      }); // fin event

    });// fin foreach




  }// fin function 

  eliminarMenu();

  /** Esta funcion manda los datos para crear un nuevo item del 
   * menu dinamico. 
   */
  function asignarMenu(){
    $('.enviarItem').on('click',function(e){
      //console.log('hola');
      e.preventDefault();
      let datosForm = $('.NuevoMenu').serialize();

      $.ajax({
        url:'accionMenu.php',
        method:'post',
        data:datosForm,
        success:function(res){
          console.log(res);
          if(res=='true'){
            $('.avisoAsignacion').text('El menu fue exitosamente añadido');
            $('.avisoAsignacion').css({
              'color':'green',
              'font-size':'20px'
            })

          }
        },
        error:function(e){
          console.log(e.statusText);
        }
      }); // fin ajax 



    });

  }// fin function 

  asignarMenu();

  /** Esta funcion crea un modal para el envio de datos 
   * para crear un nuevo menu
  */
  function modal(){
        
        const openModal=function(){
            $('.cartel').removeClass('hidden');
            $('.overlay').removeClass('hidden');
        };
        const cerrarModal=function(){
            $('.cartel').addClass('hidden');
            $('.overlay').addClass('hidden');
        }
        $('.abrir').on('click',openModal);

        $('#icono').click(cerrarModal);
        $('.overlay').click(cerrarModal);
  }// fin function 

  modal();

}); 

</script>

<?php
include_once("../estructura/footer.php");
?>
