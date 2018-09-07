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
                /*if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg estados memo : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }*/
                for(var i=0; i<data.datos.length;i++){
                   //console.log('id: ' + data.datos[i].memo_est_id + ' nombre EstadoMemo: ' + data.datos[i].memo_est_tipo);
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
                /*if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data usuarios msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }*/
                usuarios=data.datos;
                for(var i=0; i<data.datos.length;i++){
                    //console.log('id: ' + data.datos[i].usu_id + ' nombre: ' + data.datos[i].usu_nombre);
                    //opcion = '<option value=' + data.datos[i].usu_id + '>' + data.datos[i].usu_nombre + ' - '+ data.datos[i].usu_rol_nombre + '</option>';
                    opcion = '<option value=' + data.datos[i].usu_id + '>' + data.datos[i].usu_nombre + '</option>';
                    $("#usuario").append(opcion);
                    nomrolusu=usuarios[0]['usu_rol_nombre'];
                    $('#rolUsuario').val(nomrolusu);
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

    // Funcion para paginar lista de memos
    function paginador(pag,estado=0){
            var cantidadMostrar = 10;  // total de numeros de paginas  a mostrar 
            var registroPorPagina = 10; //total registro por pagina, debe coincidir con el modelo.listar
            var datax = {
                        "Accionmem":"contar",
                        "idest":estado
                }
            $("#paginador").html("");    
            $("#totalmemos").html("");
                $.ajax({
                        data: datax, 
                        type: "GET",
                        dataType: "json", 
                        url: "controllers/controllermemo.php",
                })
                .done(function( data, textStatus, jqXHR ) {
                        /*if ( console && console.log ) {
                            console.log( " data success gettotal : "+ data.success 
                                        + " \n data totalmemos msg : "+ data.message 
                                        + " \n textStatus : " + textStatus
                                        + " \n jqXHR.status : " + jqXHR.status );
                        }*/
                    $("#paginador").html("");                        
                    $("#totalmemos").html(data.total);
                    if(data.total > registroPorPagina){
                        fnlista = "getListadoMemos";
                        pagina = drawpaginador(pag,data.total,registroPorPagina,cantidadMostrar,fnlista);
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
    function buscaestado(){
        var posicion = document.getElementById("memoEstado").selectedIndex;
        console.log(posicion);
        console.log(posicion.val());
    }
    // Funcion principal para listar los memos
    /* ver una funcion que vaya a contar y vuelva si no llamar a listado memos*/
    function getListadoMemos(pag,estado=0){
            paginador(pag,estado);
            var $loader = $('.loader');
            var datax = {
                "nump":pag,
                "idest":estado,
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
                incrementotest=0;
                if(data.datos.length>0){
                    console.log('tiene elementos');
                    for(var i=0; i<data.datos.length;i++){
                        console.log('id: ' + data.datos[i].mem_id + ' numero memo: ' + data.datos[i].mem_numero);
                        incrementotest++;
                        fila = '<tr><td>'+ data.datos[i].mem_anio + '-' + data.datos[i].mem_numero + '</td>';
                        fila += '<td>'+ data.datos[i].mem_fecha +'</td>';
                        fila += '<td>'+ data.datos[i].mem_materia +'</td>';
                        fila += '<td>'+ '123' + data.datos[i].mem_id +'</td>';
                        fila += '<td>'+ '2018-1007' + data.datos[i].mem_id + '</td>';
                        fila += '<td>'+ 'OC-123' + data.datos[i].mem_id + '</td>';
                        fila += '<td>'+ data.datos[i].mem_estado_nombre +'</td>';
                        fila += '<td><button id="ver-memo" type="button" ';
                        fila += 'class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal"';
                        fila += ' onclick="verMemo(\'ver\',\'' + data.datos[i].mem_id + '\')">';
                        fila += 'Ver / Editar</button>';
                        /*fila += ' <button id="delete-language-modal" name="delete-language-modal" type="button" ';
                        fila += 'class="btn btn-xs btn-danger" data-toggle="modal" data-target="#myModalDelete" ';
                        fila += 'onclick="deleteAnular(\''+ data.datos[i].mem_id +'\',\'' + data.datos[i].mem_anio +'\',\''
                                + data.datos[i].mem_materia +'\')">';
                        fila += 'Anular</button>';*/
                        fila += ' <button id="Asignar" type="button" class="btn btn-xs btn-primary" >Asignar</button></td>';
                        fila += '</tr>';
                        $("#listamemos").append(fila);
                    }                    
                }else{
                    console.log('noooo tiene elementos');
                    fila = '<tr><td colspan="8">'+data.message+'</td><tr>';
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
        $('.orden').click(function() {
            var table = $(this).parents('table').eq(0);
            var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()));
            this.asc = !this.asc;
            if (!this.asc) {
                rows = rows.reverse();
            }
            for (var i = 0; i < rows.length; i++) {
                table.append(rows[i]);
            }
            setIcon($(this), this.asc);
        });
        $("#usuario").change(function(){
            /* var posicion = document.getElementById("usuario").selectedIndex;
            op=document.getElementById("usuario").options;
            console.log(op[posicion].text);
            $('#rolUsuario').val(op[posicion].text);*/
            var posicion = document.getElementById("usuario").selectedIndex;
            nomrol=usuarios[posicion]['usu_rol_nombre'];
            $('#rolUsuario').val(nomrol);
        });

        $("#memoEstado").change(function(){
            var idestado = document.getElementById("memoEstado").selectedIndex;
            console.log($('#memoEstado').val());
            //console.log('estado id : ' + idestado);
            getListadoMemos(1,$('#memoEstado').val());
        });

    });