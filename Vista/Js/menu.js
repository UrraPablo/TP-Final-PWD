    /**
     * Con el ID del rol del usuario hace una peticion ajax que devuelve 
     * el menu segun su rol
     * @param {int} valor 
     */    
    function RealizaMenu(valor){
        var parametros = {
                "menurol" : valor
        };
        $.ajax({
                data:  parametros,
                url:   '../estructura/accionEstructura.php',
                type:  'post',
                success:  function (response) {
                        //console.log(response);
                        $("#resultadoMenu").html(response);
                }
        });
    };
