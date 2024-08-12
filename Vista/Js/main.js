//************* PAGE: INDEXLOGIN.PHP *************************
$(function () {
    
    
    $("#formLogin").validate({
        rules:{
            nombre:{required:true},
            password:{required:true,minlength:2}
        },
        messages:{
            nombre:{
                required:'Ingrese un nombre',                
            },
            password:{                
                required:'Ingrese su password',
                minlegth:'Minimo 2 caracteres'
            }
        },
        errorClass:'error-fail-alert',

        submitHandler:function(){
            //form.submit();
            $.ajax({
                type:'POST',
                url:'../login/accionLogin.php',
                data:{'nombre':$("#nombre").val(),'password':$("#password").val(),'accion':$("#accion").val()},
                success:function(r){
                    let resp=JSON.parse(r);
                    //console.log(resp.respuesta);
                    if(resp.respuesta==false){
                        $("#error").text('Usted no esta registrado');
                        $("#error").css('color','red');
                    }// fin if 
                    else{
                        console.log("entro");
                        location.href='../grilla/indexGrilla.php';
                    }// fin else
                },
                error:function(error){
                    console.log(error);

                }                
            });
        }


    });

 /******************************  PAGE: INDEXLOGIN.PHP **************************************** */
    // Muestra el contenido del password
    let mostrar=document.forms["formLogin"]["mostrar"];
    mostrar.addEventListener('click',function(){
        if(mostrar.checked){
            $('#password').attr('type','text');
        }// fin if
        else{
            $('#password').attr('type','password');
        }
    });






});// fin ready document

