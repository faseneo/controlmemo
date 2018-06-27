        var getlistaDepto = function (){
            var datax = {
                "Accion":"listar"
            }
            $.ajax({
                data: datax, 
                type: "GET",
                dataType: "json", 
                url: "controllers/controllerdepartamento.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#memoDepto").html("");
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                $("#memoDepto").append('<option value="0">Seleccionar...</option>');
                for(var i=0; i<data.datos.length;i++){
                    console.log('id: ' + data.datos[i].depto_id + ' nombre Depto: ' + data.datos[i].depto_nombre);
                    opcion = '<option value=' + data.datos[i].depto_id + '>' + data.datos[i].depto_nombre + '</option>';
                    $("#memoDepto").append(opcion);
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

        var getlistaCecosto = function (){
            var datax = {
                "Accion":"listar"
            }
            $.ajax({
                data: datax, 
                type: "GET",
                dataType: "json", 
                url: "controllers/controllercentrocostos.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#memoCcosto").html("");
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                //$.each(data.datos[i], function(k, v) { console.log(k + ' : ' + v); });
                $("#memoCcosto").append('<option value="0">Seleccionar...</option>');
                for(var i=0; i<data.datos.length;i++){
                    console.log('id: '+data.datos[i].ccosto_id + ' nombre CeCosto: '+data.datos[i].ccosto_nombre);
                    opcion = '<option value='+ data.datos[i].ccosto_id +'>'+data.datos[i].ccosto_nombre+'</option>';
                    $("#memoCcosto").append(opcion);
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

        var getlistaProcedCompra = function (){
            var datax = {
                "Accion":"listar"
            }
            $.ajax({
                data: datax, 
                type: "GET",
                dataType: "json", 
                url: "controllers/controllerprocedimientocompra.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#memoDetPcompra").html("");
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                    console.log('id: ' + data.datos[i].proc_comp_id + ' nombre EstadoMemo: ' + data.datos[i].proc_comp_tipo);
                    opcion = '<option value=' + data.datos[i].proc_comp_id + '>' + data.datos[i].proc_comp_tipo + '</option>';
                    $("#memoDetPcompra").append(opcion);
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

        var getlistaProveedores = function (){
            var datax = {
                "Accion":"listar"
            }
            $.ajax({
                data: datax, 
                type: "GET",
                dataType: "json", 
                url: "controllers/controllerproveedor.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#memoDetProveedor").html("");
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                    console.log('id: ' + data.datos[i].prov_id + ' nombre EstadoMemo: ' + data.datos[i].prov_nombre);
                    opcion = '<option value=' + data.datos[i].prov_id + '>' + data.datos[i].prov_nombre + '</option>';
                    $("#memoDetProveedor").append(opcion);
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


getlistaDepto();
getlistaCecosto();
getlistaProcedCompra();
getlistaProveedores();
getlistado();
getlistaUsuario();