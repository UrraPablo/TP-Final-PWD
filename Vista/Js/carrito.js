$(function(){

    // interaccion de la pagina carrito.php FRONTEND
    function sumar(valor){ 
        valor = valor+1;
        return valor;
    }// fin function 

    function verificarStock(stock,cantidad){
        return salida=(cantidad<stock)?true:false;
    }// fin function 

    function negativo(cantidad){
        return salida = (cantidad<=1)?true:false;
    }// fin function

    function resta (valor){
        valor = valor-1;
        return valor;
    }// fin function


    function asignarCantidad(){
        let items = $('.cantidadP');
        let subTotal =0;
        //let precioDefecto=0;
        for(let i=0;i<items.length;i++){
            let precio =Number($('.valorPrecio')[i].value);
            // CALCULO POR DEFECTO DEL PRECIO CANTIDAD=1
            subTotal = precio+subTotal;
            mostrarPrecio(subTotal); 


            // SUMA CANTIDAD DE LOS PRODUCTOS 
            items[i].childNodes[1].addEventListener('click',function(e){
                e.preventDefault();
                let valorActual=Number(items[i].childNodes[3].value);
                let stock =items[i].childNodes[3].max;

                let hayStock = verificarStock(stock,valorActual);
                if(hayStock){
                    let cant = sumar(valorActual);
                    items[i].childNodes[3].value=cant;
                    subTotal =precio+subTotal;
                    mostrarPrecio(subTotal);     
                }// fin if 
                else{
                    items[i].childNodes[3].value=valorActual;

                }// fin else
            });// eventListener para sumar
            
            // RESTA CANTIDAD DE PRODUCTOS 
            items[i].childNodes[5].addEventListener('click',function(e){
                e.preventDefault();
                let valorActual=Number(items[i].childNodes[3].value);
                let esNegativo = negativo(valorActual);
                if(esNegativo){
                    items[i].childNodes[3].value=valorActual;
                }// fin if 
                else{
                    let cant = resta(valorActual);
                    items[i].childNodes[3].value=cant;
                    subTotal = -precio+subTotal;
                    mostrarPrecio(subTotal);
                }// fin else
            });// eventListener para restar
        }// fin for 
    }// fin function  AsignarCantidad
    asignarCantidad();
    
    function mostrarPrecio(suma){
        $('#tituloPrecio').text(suma.toFixed(2));
    }// fin function 


    /**
     * ESTA PARTE SE ENCARGA DE AGREGAR LA CANTIDAD DESEADA O ELIMINAR EL PRODUCTO DEL CARRITO
     * EL MISMO ES UN BORRADO LOGICO EN ITEM CON CANTIDAD IGUAL A 0
     * 
     * 
     */
    function eliminarItem(){
        let btnEliminar = $('.eliminarItem');
        
        btnEliminar.each(function(index,element){
            element.addEventListener('click',function(e){
                let cantidad =this.previousElementSibling.children[2].childNodes[3].value ;
                let precio = this.previousElementSibling.children[1].children[2].childNodes[1].value;
                // DESCUENTO DEL PRECIO DE COMPRA   
                var descontar = Number(precio)*Number(cantidad);
                var precioAterior = Number($('#tituloPrecio').text());
                var precioActual =precioAterior-descontar;
                let dato={idItem:Number(this.id)};
                let elementoAEliminar=this.parentElement;
                $.ajax({
                    method:'get',
                    url:'../carrito/accionCarritoFinalizado.php',
                    data:dato,
                    success:function(res){
                        console.log(res);
                        $('#tituloPrecio').text(precioActual.toFixed(2));
                        elementoAEliminar.remove();
                    },// fin function
                    error:function(er){
                        console,log(er.status);
                    }// fin function error


                });// fin ajax 

            });
        })
    }// fin function 

    eliminarItem();
    
    // CAMBIO DE ESTADO DE LA COMPRA
    /**
     * 2° AL HACER CLICK EN COMPRAR TENGO QUE PASAR AL ESTADO A PAGADO Y VERIFICAR QUE EL STOCK EN BD SEA MAYOR A CERO ANTES DE 
     * PASAR DE CAMBIO DE ESTADO (MOSTRAR EL MENSAJE EN FUNCION AL PRODUCTO QUE QUEDARIA CON STOCK <=0)
     */ 
    
    function confirmarCompra(){
        let idcompra=Number($('input[name=idcompra]').val());
        $('.comprar').on('click',function(e){
            e.preventDefault();
            let cantidadItems=$('.itemCarrito').length;
            if(cantidadItems==0){
                $('<p>',{
                    class:'avisoCompraSP',
                    text:'La compra no tiene productos',
                }).css({
                    'color':'red',
                    'margin-left':'150px',
                    'font-size':'50px'
                }).appendTo('.contenedorPrincipal');
            }// fin if
            else{
                const id=[];
                const cantidad=[];
                $('.eliminarItem').each(function(index,element){
                   id.push(Number(element.id)); 
                });
                $('.inputCantidad').each(function(i,e){
                    cantidad.push(Number(e.value));
                });
                //Llamado a accionCarritoFinalizado
                $.ajax({
                    method:'post',
                    url:'../carrito/accionCarritoFinalizado.php',
                    data:{'idcompra':idcompra,'idCI':id,'cantidad':cantidad},
                    success:function(res){
                        //let salida = JSON.parse(res);
                        //console.log(salida);
                        console.log(res);
                        //console.log(res=='{"resultado":true}');
                        if(res){
                            $('.contenedorPrincipal').remove();
                            modal();
                            
                        }// fin if 
                        else{
                            let id;
                            // obtener los ids de los productos en el carrito
                            $('.eliminarItem').each(function(){
                                id=$(this).attr('id');
                                if(res.includes(id)){
                                    $('<p>',{
                                        class:'productoST',
                                        text:'Este producto NO tiene stock suficiente. Seleccione otro producto.'
                                    }).css({
                                        'color':'red',
                                        'font-size':'15px'
                                    }).appendTo($(this).prev()); 
    
                                }// fin 
                            });

                        }// fin else
    
                    },//fin function
                    error:function(er){
                        console.log(er.status);
                    } // fin function 
                });// fin ajax

            }// fin else

            
        });
        
    }// fin function
    confirmarCompra();


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


});