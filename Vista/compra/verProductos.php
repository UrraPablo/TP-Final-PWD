<?php
include_once '../../configuracion.php';
include_once '../estructura/headPrivado.php';

// Muestra las compras con el estado pagado, para luego ser enviadas
//. Solo lo puede ver el deposito o el adm

$datos=data_submitted();
$objCI=new AbmCompraItem();
$listaItemDeCompra=$objCI->buscar($datos); // devuelve un array de obj ite con el id compra dado
// objCI => obj compra item
$idcompra=$listaItemDeCompra[0]->getObjCompra()->getId();
$cont = 0;
for($k=0; $k<count($listaItemDeCompra);$k++){
  if($listaItemDeCompra[$k]->getCantidad()>0){
    $cont++;

  }// fin oif
}// fin for 
if(isset($datos['idcompra'])){
  ?>
  <head>
    <link type="text/css" rel="styleSheet" href="../css/carrito.css">
  </head>
  <!--Tabla de productos pagados -->
    <div class="container mt-5">
      <div class="titulos d-flex flex-row justify-content-between">
        <h3 class="tituloIdCompra"> ID Compra: <?php echo($idcompra);?>
        <button class="compra btn btn-info mx-5" id="<?php echo($datos['idcompra']) ?>">Enviar Compra</button>
        </h3>
        <h3 class="cancelacion"> Cancelacion:
        <button class="cancelarCompra btn btn-danger mx-3" id="<?php echo($datos['idcompra']) ?>">Cancelar Compra</button>
        </h3>
      </div>
    <table class="table">
        <thead>
            <tr>
            <th scope="col" class="fs-4">Id Item</th>
            <th scope="col" class="fs-4">Nombre</th>
            <th scope="col" class="fs-4">Cantidad</th>
            </tr>
        </thead>
        <tbody>
            <?php if($cont>0){
                foreach($listaItemDeCompra as $unItem){
                  if($unItem->getCantidad()>0){
                    ?>
                      <tr>
                      <th scope="row" class="idItem fs-5" value="<?php echo($unItem->getId());?>"><?php echo($unItem->getId());?></th>
                      <td class="fs-5"><?php echo($unItem->getObjProducto()->getNombre()); ?></td>
                      <td class="fs-5"><?php echo($unItem->getCantidad()); ?></td>
                      <td id="respuesta">
                      
                      <button class="btn btn-danger cancelar" id="<?php echo($unItem->getId())?>">Cancelar</button>
                      </td>
                      </tr>

                    <?php

                  }// fin if 
                ?>
                <?php
                }// fin for 
                
            }// fin if 
            else{
                ?>
                
            <div class="alert alert-danger">
                No hay productos para enviar. 
                <?php
                  echo("<script>
                    $('.compra').hide();
                  </script>");
                ?>
            </div>
            <?php

            } // fin else?>

        </tbody>
</table>


<!--MODAL-->
<!--SECCION DE MODAL -->
<section class="cartel hidden">
    <div class="tituloModal">
        <h4 id="titulo">Compra</h4>
        <i id='icono' class="bi bi-x-circle"></i>
    </div>

    <div class="contenidoModal">
      <p id="contenido"> Compra  <strong style="color:green">En estado ENVIADO.</strong> 
                     Listo para despachar. 
    </p>
    </div>

    <div class="footerModal">
       <p id="pieModal"> Tus mejores marcas aca en <strong style="color:brown">WESH-WESH</strong> </p> 
    </div>
</section>
<div class="overlay hidden"></div>

</div>


<div class="container">
   <button type="button" class="btn btn-info"><a href="indexCompraDeposito.php" class="fw-bolder">Volver</a></button> 
</div>
  <?php  

}// fin if
else{
    echo("Algo salio mal");
}// fin else
?>

<script>
    $(document).ready(function(){
        let botonesCancelar=$(".cancelar");
        //console.log(botonesCancelar);
        for (let i=0;i<botonesCancelar.length;i++){
            let boton=botonesCancelar[i];
                boton.addEventListener('click',function(e){
                e.preventDefault();
                let iditem=Number(this.getAttribute('id'));
                //console.log(iditem);
                $.ajax({
                    url:'accionCompraEnviada.php',
                    method:'POST',
                    data:{idcompraitem:iditem},
                    success:function(r){
                    console.log(r);
                    let par = document.createElement("span");
                    par.className="text-danger";
                    const text=document.createTextNode("Producto Cancelado");
                    par.appendChild(text);
                    const padre=boton.parentElement;
                    padre.appendChild(par);
                    boton.remove();

                    //innerHTML='<span class="text-danger">Producto Cancelado</span>';            
                    }
                });
            });

        }// fin for 

        // Llamado al idcompra 
        $('.compra').on('click',function(){
            let compra=Number(this.getAttribute('id'));
            console.log(typeof(compra));
            $.ajax({
                url:'accionCompraEnviada.php',
                method:'POST',
                data:{idcompra:compra},
                success:function(r){
                    console.log(r);
                    modal();
                    
                }, // fin function 
                error: function(er){
                  console.log(er.Status);
                } // fin function    

            });
        });

        // MODAL DE AVISO  
      function modal(){
        
        const openModal=function(){
            $('.cartel').removeClass('hidden');
            $('.overlay').removeClass('hidden');
        };
        const cerrarModal=function(){
            $('.cartel').addClass('hidden');
            $('.overlay').addClass('hidden');
            window.location.href='indexCompraDeposito.php';
        }
        openModal();
        $('#icono').click(cerrarModal);
        $('.overlay').click(cerrarModal);
    }// fin function 

    /**
     * Cancelacion total de la compra
     */
    function cancelar(){
      let id=$('.cancelarCompra').attr('id');
      let idItems=[];
      let items = $('.idItem');
      for(item of items){
        idItems.push(item.getAttribute('value'));
      }// fin for

      $('.cancelarCompra').on('click',()=>{
        $.ajax({
          method:'post',
          url:'./accionCompraCancelada.php',
          data:{idcompra:id,idIs:idItems},
          success:function($res){
            $('#contenido').text('La compra fue cancelada correctamente');
            $('#contenido').css(['color','fontSize'],['red','20px']);
            modal();
            console.log($res);

          },// fin function 
          error:function(er){
            console.log(er.Status)
          }
        });
      });

    }// fin function 
    cancelar();

    });
</script>

<?php
include_once '../estructura/footer.php';
?>