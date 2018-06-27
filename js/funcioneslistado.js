
 var getlistado = function (){
            var datax = {
                "Accion":"listar"
            }
            $.ajax({
                data: datax,  
                type: "GET",
                dataType: "json", 
                url: "controllers/controllermemoestado.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#memoEstado").html(""); 
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                    console.log('id: ' + data.datos[i].memo_est_id + ' nombre EstadoMemo: ' + data.datos[i].memo_est_tipo);
                    opcion = '<option value=' + data.datos[i].memo_est_id + '>' + data.datos[i].memo_est_tipo + '</option>';
                    $("#memoEstado").append(opcion);
                }

            })
            .fail(function( jqXHR, textStatus, errorThrown ) {
                if ( console && console.log ) {
                    console.log( " La solicitud getlista ha fallado,  textStatus : " +  textStatus 
                        + " \n errorThrown : "+ errorThrown
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
            });
        }

 var getlistaUsuario = function (){
            var datax = {
                "Accion":"listar"
            }
            $.ajax({
                data: datax,  
                type: "GET",
                dataType: "json", 
                url: "controllers/controllerusuario.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#usuario").html(""); 
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                    console.log('id: ' + data.datos[i].usu_id + ' nombre: ' + data.datos[i].usu_nombre);
                    opcion = '<option value=' + data.datos[i].usu_id + '>' + data.datos[i].usu_nombre + '</option>';
                    $("#usuario").append(opcion);
                }

            })
            .fail(function( jqXHR, textStatus, errorThrown ) {
                if ( console && console.log ) {
                    console.log( " La solicitud getlista ha fallado,  textStatus : " +  textStatus 
                        + " \n errorThrown : "+ errorThrown
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
            });
        }


getlistado();
getlistaUsuario();