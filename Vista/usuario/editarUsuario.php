<?php
$Titulo = "Compras";
include_once '../../configuracion.php';
include_once '../estructura/headPrivado.php';


//$objUsuario=new AbmUsuario();
$obj=$objSession->getUsuario();

?>
<head>
    <link type="text/css" rel="stylesheet" href="../css/formUsuario.css">
</head>
<div class="container">
    <div class="row">

<?php  if($obj!=null){?>
    <div class="form col-8 mb-3">
        <h2>Datos del Usuario </h2>
        <form class="formUsuario">
            <label for="id" style="width:120px">Codigo ID</label>
            <input type="number" name="idusuario" id="idusuario" readonly value="<?php echo($obj->getId()) ?>"><br>
            <label for="nombreUsuario" style="width:120px">Usuario</label>
            <input type="text" name="usnombre" id="usnombre" value="<?php echo($obj->getNombre()) ?>"><br>
            <label for="mail" style="width:120px">Mail</label>
            <input type="text" name="usmail" id="usmail" value="<?php echo($obj->getMail()) ?>"><br>
            <input type="submit" name="accion" id="Borrar" class="borrar btn btn-danger" value="Borrar">
            <input type="submit" name="accion" id="editar" class="editar btn btn-info" value="Cambiar">
        </form>
    
<?php } else{
        echo("<p>No se encontro el campo que desea modificar </p>");     
    }
    ?>
    </div>
        <div class="col-4">
            <div id='subP'>
                <h4>Cambio de Password</h4>
                <aside class="container d-flex justify-content-center" id="formPassword">
                    <form id="passForm">
                        <label for="password" class="control-label">Nueva Contraseña:</label>
                        <input type="password" id="password" name="password" required>
                        <br>
                        <label for="confirmPassword" class="control-label">Confirmar Contraseña:</label>
                        <input type="password" id="confirmPassword" name="confirmPassword" required>
                        <br>
                        <button type="click" class="confirmar btn btn-info">Confirmar</button>
                    </form>
                </aside>

            </div>

        </div>

</div>
    </div>
    <p id='aviso'></p>
    
    <button class="btn-password btn btn-info" id="cambiarPassword">Cambiar Password</button>











<script>
    $(function (){
        // cambio de mail o nombre del usuario 
        $('.editar').on('click',(e)=>{
            e.preventDefault();
            let datos={
                usnombre:$('#usnombre').val(),
                usmail:$('#usmail').val(),
                idusuario:$('#idusuario').val(),
                accion:'Cambiar'
            };
            $.ajax({
                type: "method",
                method:'post',
                url: "./accionUsuario.php",
                data: datos,
                success: function (response){
                    let r = JSON.parse(response);
                    console.log(r.cambio);
                    switch (r.cambio){
                        case 'nombreRepetido':
                            $('#aviso').text('El nombre elegido ya se encuentra en la base de datos ');
                            $('#aviso').css({
                                'color':'red',
                                'font-size':'20px',
                                'position':'relative',
                                'margin-left':'300px'
                            });
                            break;
                        case 'mailRepetido':
                            $('#aviso').text('El mail elegido ya se encuentra en la base de datos ');
                            $('#aviso').css({
                                'color':'red',
                                'font-size':'20px',
                                'position':'relative',
                                'margin-left':'300px'
                            });
                            break;
                        case 'valido':
                            $('#aviso').text('Los cambios se guardaron correctamente ');
                            $('#aviso').css({
                                'color':'green',
                                'font-size':'20px',
                                'position':'relative',
                                'margin-left':'300px'
                            });
                            break;
                        default:
                            $('#aviso').text('NO ha hecho ningun cambio ');
                            $('#aviso').css({
                                'color':'red',
                                'font-size':'20px',
                                'position':'relative',
                                'margin-left':'300px'
                            });
                            break;        

                    }// fin switch

                },
                error:function(er){
                    console.log(er.statusText);
                }
            });// fin ajax 

            });// fin eventClik EDITAR 

            // BAJA POR PARTE DEL USUARIO
        $('.borrar').on('click',function(e){
                e.preventDefault();
                let datos={'idusuario':$('#idusuario').val(),'accion':'Borrar'};
                console.log(datos);
                $.ajax({
                    typed:'method',
                    url:'./accionUsuario.php',
                    method:'post',
                    data:datos,
                    success:function(r){
                        console.log(r);
                        location.href='../login/indexLogin.php';

                    },
                    error:function(er){
                        console.log(er);
                    }


                });// fin ajax 

        });// fin eventClik Borrar


        /**Esta funcion realiza la confirmacion del cambio
         * de password del usuario
         */
        $('.confirmar').on('click',function(e){
            e.preventDefault();
            let pass1 = $('#password').val();
            let pass2 = $('#confirmPassword').val();
            if(pass1!=pass2){
                $('#aviso').text('Los password deben ser iguales');
                $('#aviso').css({
                                'color':'red',
                                'font-size':'20px',
                                'position':'relative',
                                'margin-left':'300px'
                            });

            }// fin if 
            else{
                $.ajax({
                    url:'./accionUsuario.php',
                    method:'post',
                    data:{'pass':pass1,'accion':'cambioPass','idusuario':$('#idusuario').val()},
                    success:function(r){
                        console.log(r);
                        $('#aviso').text('La contraseña fue cambiada exitosamente');
                        $('#aviso').css({
                            'color':'green',
                            'font-size':'20px',
                            'position':'relative',
                            'margin-left':'300px'
                        });
                        $('#subP').hide();



                    },
                    error:function(er){
                        console.log(er);
                    }
                }); // fin ajax
            }
            console.log(pass1);
            console.log(pass2);

        });
                

        // modal del formulario
        // function CerrarForm(){
        //     var span = document.getElementsByClassName("confirmar")[0];
        //     // Cerrar el modal al hacer clic en el botón de cerrar
        //     span.onclick = function() {
        //         modal.style.display = "none";
        //     }    
        // }// fin  cerrarForm

        function AbrirForm(){
                var modal = document.getElementById("subP");
                    var btn = document.getElementById("cambiarPassword");

                    // Mostrar el modal al hacer clic en el botón
                    btn.onclick = function() {
                        modal.style.display = "contents";
                    }

        }// fin function modal 
        AbrirForm();

    }); 

</script>

<?php
include_once("../estructura/footer.php");
?>