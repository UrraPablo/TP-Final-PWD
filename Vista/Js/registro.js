$(function(){

    function validarRegistro(){
        $('.Enviar').on('click',function(){

            $(".registroForm").validate({
                rules:{
                    nombre:{required:true},
                    password:{required:true,minlength:2},
                    email:{required:true, email:true}
                },
                messages:{
                    nombre:{
                        required:'Ingrese un nombre',                
                    },
                    password:{                
                        required:'Ingrese su password',
                        minlegth:'Minimo 2 caracteres'
                    },
                    email:{
                        required:'Ingrese su email',
                        email:'debe ser un email valido'
                    }
            
                },
                errorClass:'error-fail-alert',
                errorElement:"span",
                submitHandler:function(){
                    //form.submit();
                    $.ajax({
                        method:'post',
                        url:'../login/accionLogin.php',
                        data:{accion:'nuevo',usnombre:$('#nombre').val(),uspass:$('#pass').val(),usmail:$('#email').val()},
                        beforeSend:function(){
                            console.log('antes de enviar');
                        },
                        success: function(r){
                            console.log(r);
                            let estado = JSON.parse(r);
                            switch(estado.nuevo){
                                case 'ok':
                                    modal();
                                    
                                    break;
                                case 'nombreRepetido':
                                    $('#avisoRegister').text('El nombre y se encuentra en nuestra base de datos. Intente con otro');
                                    $('#avisoRegister').css({
                                        'color':'red',
                                        'position':'relative',
                                        'margin-left':'35%',

                                    });
                                    break;
                                case 'mailRepetido':
                                    $('#avisoRegister').text('El mail y se encuentra en nuestra base de datos. Intente con otro');
                                    $('#avisoRegister').css({
                                        'color':'red',
                                        'position':'relative',
                                        'margin-left':'35%',
                                    });
                                    break;
                                default:
                                    break;            

                            }// fin switch

                            //alert('datos enviados');
                        },
                        error:function(er){
                            console.log(er.Status.text);
                        }
                    })
                    
    
                }
            });

        });
    }// fin function 
    
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
        $('#icono').click(cerrarModal);
        $('.overlay').click(cerrarModal);
    }// fin function 
    
    validarRegistro();
    
    //registro()


});