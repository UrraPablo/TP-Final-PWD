$(function () {

    const forms =$('.productForm');
    const botones =$('.botonProducto');
    rol=$('#rol').val();
    fecha=$('#fecha').val(); 
    id=$('#usuario').val();
    
    if(rol==('libre' || 'deposito')){
        $.each(botones,()=>{    // FORMA DE RECORERRLO CON JQUERY   $.each(array,(index,value)=>{codigo.......})
            botones.on('click',function(e){
                e.preventDefault();
                window.location.href='../login/indexLogin.php';
            })
        });
    }// fin if 
    else{
        for(const unForm of forms){
            unForm.addEventListener('click',(e)=>{
                e.preventDefault();
                let idP=unForm['idP'].value;
                let datos={idP:idP,idU:id};
                //let boton=unForm['boton'];
                
                
                $.ajax({
                    url:'../carrito/accionCarrito.php',
                    method:'POST',
                    data:datos,
                    success:function(r){  
                        console.log(r);
                        modal();
                    },            
                    error:function(er){
                        console.log(er.status);
                    }
                });
            })
        }// fin for 

    }// fin else

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

});// fin document ready