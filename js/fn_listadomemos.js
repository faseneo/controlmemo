    var usuarios;

    function getListadoEstadoMemos(){
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
                    console.log( " La solicitud getlistaEstados ha fallado,  textStatus : " +  textStatus 
                        + " \n errorThrown : "+ errorThrown
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
            });
    }

    function getListadoUsuarios(){
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
                usuarios=data.datos;
                console.log(usuarios);
                for(var i=0; i<data.datos.length;i++){
                    console.log('id: ' + data.datos[i].usu_id + ' nombre: ' + data.datos[i].usu_nombre);
                    //opcion = '<option value=' + data.datos[i].usu_id + '>' + data.datos[i].usu_nombre + ' - '+ data.datos[i].usu_rol_nombre + '</option>';
                    opcion = '<option value=' + data.datos[i].usu_id + '>' + data.datos[i].usu_nombre + '</option>';
                    $("#usuario").append(opcion);
                    algo=usuarios[0]['usu_rol_nombre'];
                    $('#rolUsuario').val(algo);
                }

            })
            .fail(function( jqXHR, textStatus, errorThrown ) {
                if ( console && console.log ) {
                    console.log( " La solicitud getlistaUsuarios ha fallado,  textStatus : " +  textStatus 
                        + " \n errorThrown : "+ errorThrown
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
            });
    }

    function rolusu(){
        //var valor = document.getElementById("usuario").value;
        var posicion = document.getElementById("usuario").selectedIndex;
        algo=usuarios[posicion]['usu_rol_nombre'];
        $('#rolUsuario').val(algo);
    }

    function paginador(pag){
            var cantidadMostrar = 10;  // total de numeros de paginas  a mostrar 
            var registroPorPagina = 10; //total registro por pagina, debe coincidir con el modelo.listar
            var compag = pag;
            console.log("------------------------------------------");
            console.log("pagina : "+ compag);
                    var datax = {
                        "Accionmem":"contar"
                    }
                    $.ajax({
                        data: datax, 
                        type: "GET",
                        dataType: "json", 
                        url: "controllers/controllermemo.php",
                    })
                    .done(function( data, textStatus, jqXHR ) {
                       $("#paginador").html("");
                        if ( console && console.log ) {
                            console.log( " data success gettotal : "+ data.success 
                                        + " \n data msg : "+ data.message 
                                        + " \n textStatus : " + textStatus
                                        + " \n jqXHR.status : " + jqXHR.status );
                        }
                        if(data.total > registroPorPagina){
                                console.log("Total de registros :"+ data.total);
                            // calcula total numero de paginas segun totalregistro dividos por numero de reg. por pagina.
                            totalPag = Math.ceil(data.total/registroPorPagina);
                                console.log("total paginas : "+totalPag);

                            //calcula incremento para boton siguiente
                            IncrimentNum =((compag +1)<=totalPag) ? (compag +1) : 1;
                                console.log("incremento: "+IncrimentNum);
                            //calcula decremento  para boton anterior
                            DecrementNum =(compag -1) < 1 ?  1 : (compag -1);
                                console.log("decremento: "+DecrementNum);
                            if(totalPag<cantidadMostrar){
                                cantidadMostrar=totalPag;
                            }
                            // valida primera pagina y deshabilita anterior
                            if(pag == 1 ){
                                pagina = "<li class='disabled'><a href='#'><span aria-hidden='true'>&laquo;</span></a></li>";
                            }else{
                                pagina = "<li><a href='#' onclick='getListadoMemos(" + DecrementNum + ")'><span aria-hidden='true'>&laquo;</span></a></li>";
                            }
                            console.log("calculo ceil : " + (Math.ceil(cantidadMostrar/2)-1));
                            //valida y calcula desde hasta para paginador segun pagina actual
                            desde=compag-(Math.ceil(cantidadMostrar/2)-1); //42 - 4   => ((10/2)-1) 
                            hasta=compag+(Math.ceil(cantidadMostrar/2)); //42 + 5   => ((10/2)-1)
                            console.log("desde ceil: "+desde);
                            console.log("hasta ceil: "+hasta);                       
                            //valida desde si menor a 1 y hasta menor a cantidadMostrar (siempre mostrar diez numeros de paginas)
                            desde = (desde < 1) ? 1 : desde;
                            hasta = (hasta < cantidadMostrar) ? cantidadMostrar : hasta;

                            console.log("desde : " + desde);
                            console.log("hasta : " + hasta);

                            // valida y calcula ultimas 10 paginas del paginador
                            desde = (hasta > totalPag) ? totalPag - (cantidadMostrar-1) : desde;
                            hasta = (hasta > totalPag) ? totalPag : hasta;
                            
                            console.log("desde fin : " + desde);
                            console.log("hasta fin : " + hasta);
                            // dibuja  numeros de paginas en paginador
                            for(i=desde; i<= hasta; i++){
                                //Se valida la paginacion total de registros
                                if(i <= totalPag){
                                    //Validamos la pag activo
                                    if(i==compag){
                                        pagina+="<li class='active'><a href='#'>"+i+"</a></li>";
                                    }else {
                                        pagina += "<li><a href='#' onclick='getListadoMemos("+i+")'>"+i+"</a></li>";
                                    }
                                }
                            }
                            console.log(pagina);
                            // valida ultima pagina y deshabilita siguiente
                            if(pag == totalPag ){
                                pagina += "<li class='disabled'><a href='#'><span aria-hidden='true'>&raquo;</span></a></li>";
                            }else{
                                pagina+= "<li><a href='#' onclick='getListadoMemos(" + IncrimentNum + ")'><span aria-hidden='true'>&raquo;</span></a></li>";
                            }
                             $("#paginador").html("");
                             $("#paginador").append(pagina);
                        }
                    })
                    .fail(function( jqXHR, textStatus, errorThrown ) {
                        if ( console && console.log ) {
                            console.log( " La solicitud getcuenta ha fallado,  textStatus : " +  textStatus 
                                        + " \n errorThrown : "+ errorThrown
                                        + " \n textStatus : " + textStatus
                                        + " \n jqXHR.status : " + jqXHR.status );
                        }
                    });
    }

    function getListadoMemos(pag){
            paginador(pag);
            var datax = {
                "nump":pag,
                "Accionmem":"listar"
            }
            $.ajax({
                data: datax,  
                type: "GET",
                dataType: "json", 
                url: "controllers/controllermemo.php", 
                beforeSend: function(){
                        $('#ModalCargando').modal('show');
                        $('#ModalCargando').on('shown.bs.modal', function () {
                            $loader.show();
                        });
                    }
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#listamemos").html(""); 
                if ( console && console.log ) {
                    /*console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );*/
                }
                $('#ModalCargando').modal('hide');
                for(var i=0; i<data.datos.length;i++){
                    console.log('id: ' + data.datos[i].mem_id + ' numero memo: ' + data.datos[i].mem_numero);
                    fila = '<tr><td>'+ data.datos[i].mem_anio + '-' + data.datos[i].mem_numero + '</td>';
                    fila += '<td>'+ data.datos[i].mem_fecha +'</td>';
                    fila += '<td>'+ data.datos[i].mem_materia +'</td>';
                    fila += '<td>'+ '123' +'</td>';
                    fila += '<td>'+ '2018-100700' +'</td>';
                    fila += '<td>'+ 'OC-123' +'</td>';
                    fila += '<td><button id="ver-memo" type="button" '
                    fila += 'class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal"'
                    fila += ' onclick="verMemo(\'ver\',\'' + data.datos[i].mem_id + '\')">';
                    fila += 'Ver / Editar</button>';
                    fila += ' <button id="delete-language-modal" name="delete-language-modal" type="button" ';
                    fila += 'class="btn btn-xs btn-danger" data-toggle="modal" data-target="#myModalDelete" ';
                    fila += 'onclick="deleteAnular(\''+ data.datos[i].mem_id +'\',\'' + data.datos[i].mem_anio +'\',\''
                            + data.datos[i].mem_materia +'\')">';
                    fila += 'Anular</button>';
                    fila += ' <button id="Asignar" type="button" class="btn btn-xs btn-primary" >Asignar</button></td>';
                    fila += '</tr>';
                    $("#listamemos").append(fila);
                }

            })
            .fail(function( jqXHR, textStatus, errorThrown ) {
                if ( console && console.log ) {
                    console.log( " La solicitud getListadoMemos ha fallado,  textStatus : " +  textStatus 
                        + " \n errorThrown : "+ errorThrown
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
            });
    }

    $(document).ready(function(){
        getListadoEstadoMemos();
        getListadoUsuarios();
        getListadoMemos(1);
    });