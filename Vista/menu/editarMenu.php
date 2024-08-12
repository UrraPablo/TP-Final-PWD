<?php
include_once '../../configuracion.php';
$Titulo = "Menu";
include_once '../estructura/headPrivado.php';

$objMenu=new AbmMenu();
$datos=data_submitted();
$id = (int)$datos['id'];
$obj=null; 
if(isset($datos['id'])){
    $listaMenu=$objMenu->buscar(['idmenu'=>$id]);
    if(count($listaMenu)==1){
        $obj=$listaMenu[0];
    }// fin if 

}// fin if 
?>
<head>
  <link type="text/css" href="../css/menu.css" rel="stylesheet">
</head>

<?php  if($obj!=null){?>
    <div class="menu container mt-3">
        <h3> Modificacion de Datos</h3>
        <form class="formMenu"  method="post">
            <input type="hidden" name="accion" value="Cambiar">
            <div class="controlInput">
                <label for="idmenu" style="width:120px">Codigo ID:</label>
                <input type="number" name="idmenu" id="idmenu" readonly value="<?php echo($obj->getId()) ?>">

            </div>
            <div class="controlInput">
                <label for="menombre" style="width:120px">Nombre Menu:</label>
                <input type="text" name="menombre" id="menombre" value="<?php echo($obj->getNombre()) ?>">

            </div>
            <div class="controlInput">
                <label for="medescripcion" style="width:120px"> Descripcion:</label>
                <input type="text" name="medescripcion" id="medescripcion" value="<?php echo($obj->getDescripcion()) ?>">
                
            </div>
            <div class="controlInput">

                <label for="idpadre" style="width:120px"> Menu Padre:</label>
                <input type="text" name="idpadre" id="idpadre" value="<?php  echo($salida=$obj->getobjMenuPadre()!=null? $obj->getobjMenuPadre()->getId():'null' ) ?>">

            </div>
            
            <div class="controlInput">

                <label for="medeshabilitado" style="width:120px"> Habilitado:</label>
                <input type="radio" name="medeshabilitado" id="medeshabilitadoSI" value="SI">
                <label for="radioSi">SI</label>
                <input type="radio" name="medeshabilitado" id="medeshabilitadoNO" value="NO">
                <label for="radioNo">NO</label>
            </div>

            <div class="controlInput">
              <label for="titleSubmenu">¿Quiere incluir un submenu?
              </label><br>
              <input type="radio" name="submenu" id="si" value="SI">
              <label for="si">SI</label>    
              <input type="radio" name="submenu" id="no" value="NO" checked>
              <label for="no">NO</label>
              <div class="respuestaRadio hidden">
                <label for="subitem" class="nsItem">Nombre del Submenu</label><br>
                <input type="text" name="subitem" id="subitem"><br>
                <label for="subitemD" class="nsItem">Descripcion del Submenu</label><br>
                <input type="text" name="subitemD" id="subitemD">
              </div>    
            </div>


            <button class="cambiar btn btn-info">Cambiar</button> 
            </form>
            <p class="avisoEditarMenu"></p>
            
            
            <?php } else{
                echo("<p>No se encontro el campo que desea modificar </p>");     
            }
            ?>
    </div>
    <p class="volver">
        <a href="indexMenu.php" class="btn btn-secondary">Volver</a>
    </p>

    <script>
        $(function(){

            /** Esta funcion abre la animacion para agregar un submenu */
            function agregarSubmenu(){
                $("input[id='si']").on('click',function(){
                let activo = $(this).is(':checked');
                if(activo){
                    $('.respuestaRadio').removeClass('hidden');
                    //$("input[name='subitem']").prop('type','text');
      
                }// fin if 
            }); // fin  evento
            }// function 
            agregarSubmenu();

            /** Esta funcion cierra la animacion para agregar un submenu */
            function cerrarSubmenu(){
                $("input[id='no']").on('click',function(){
                let activo = $(this).is(':checked');
                if(activo){
                    $('.respuestaRadio').addClass('hidden');
                    //$("input[name='subitem']").prop('type','hidden');      
                }// fin if 
            }); // fin  evento
            }// fin function 

            cerrarSubmenu();

            $('.cambiar').on('click',function(e){
                e.preventDefault();
                let formData =$('.formMenu').serialize();
                console.log(formData);
                $.ajax({
                    url:'accionMenu.php',
                    method:'post',
                    data:formData,
                    success:function(r){
                        //console.log(JSON.parse(r).ok);
                        if(r){
                            $('.avisoEditarMenu').text('Se modifico correctamente los campos');
                            $('.avisoEditarMenu').css({
                                'color':'green',
                                'font-size':'20px'
                            });
                        }
                    },
                    error:function(er){
                        console.log(er.statusTex);
                    }
                });
            });
        });
    </script>            


    <?php
include_once("../estructura/footer.php");
?>