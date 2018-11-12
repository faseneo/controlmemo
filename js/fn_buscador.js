    var usuarios;
    
/*    function inicio(){
        $('#resultadofiltromsg').html("");
        $("#resultadofiltro").hide();
    }*/
        function inicio(){
            $('#titulolistado').html("");
            $("#resultadofiltro").hide();
            $("#resultadomemo").hide();
        }

    // Funcion para paginar lista de memos
    function paginador(pag,estado=0,usuid=0,total=0){
            var cantidadMostrar = 10;  // total de numeros de paginas  a mostrar 
            var registroPorPagina = 10; //total registro por pagina, debe coincidir con el modelo.listar
            var datax = {
                        "Accionmem":"contar",
                        "idest":estado,
                        "idusu":usuid
                }
            $("#paginador").html("");    
            $("#totalmemos").html("");
            $("#totalmemos").html(total);
                    if(total > registroPorPagina){
                        fnlista = "getListadoMemos";
                        pagina = drawpaginador(pag,data.total,registroPorPagina,cantidadMostrar,fnlista);
                        $("#paginador").html("");
                        $("#paginador").append(pagina);
                    }
                /*$.ajax({
                        data: datax, 
                        type: "GET",
                        dataType: "json", 
                        url: "controllers/controllermemo.php",
                })
                .done(function( data, textStatus, jqXHR ) {
                        if ( console && console.log ) {
                            console.log( " data success gettotal : "+ data.success 
                                        + " \n data totalmemos msg : "+ data.message 
                                        + " \n textStatus : " + textStatus
                                        + " \n jqXHR.status : " + jqXHR.status );
                        }
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
                });*/
    }

    /*function buscaestado(){
        var posicion = document.getElementById("memoEstado").selectedIndex;
        console.log(posicion);
        console.log(posicion.val());
    }*/

    //funcion para traedatos memo
    /*function datosMemoAsigna(memid){
        var $loader = $('.loader');
        var datax = {
                    "memoId":memid,
                    "Accionmem":"obtener"
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
                $('#ModalCargando').modal('hide');
                $("#memonum").html(""); 
                $("#memomat").html(""); 
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                    $("#memoId").val(data.datos.mem_id);
                    $("#memonum").append('<b>Numero Memo:</b> ' + data.datos.mem_numero);
                    $("#memomat").append('<b>Materia :</b>' + data.datos.mem_materia); 
            })
            .fail(function( jqXHR, textStatus, errorThrown ) {
                if ( console && console.log ) {
                    console.log( " La solicitud datosMemo ha fallado,  textStatus : " +  textStatus 
                        + " \n errorThrown : "+ errorThrown
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
            });            
    }*/
    // Funcion principal para listar los memos
    /* ver una funcion que vaya a contar y vuelva si no llamar a listado memos*/
    function getListadoMemos(pag,estado=0,usuid=0,secid=0){
        //inicio();

            //paginador(pag,estado,usuid);
            var $loader = $('.loader');
            var datax = {
                "nump":pag,
                "idest":estado,
                "idusu":usuid,
                "idsec":secid,
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
                    //console.log('tiene elementos');
                    paginador(pag,estado,usuid,data.total);
                    for(var i=0; i<data.datos.length;i++){
                        //console.log('id: ' + data.datos[i].mem_id + ' numero memo: ' + data.datos[i].mem_numero);
                        var materia = data.datos[i].mem_materia.length > 50 ? data.datos[i].mem_materia.substr(0, 50)+'...' : data.datos[i].mem_materia;
                        var depto=    data.datos[i].mem_depto_dest_nom.length > 30 ? data.datos[i].mem_depto_dest_nom.substr(0, 30)+'...' : data.datos[i].mem_depto_dest_nom;

                        incrementotest++;
                        fila = '<tr><td>'+ data.datos[i].mem_anio + '-' + data.datos[i].mem_numero + '</td>';
                        fila += '<td>'+ data.datos[i].mem_fecha +'</td>';
                        fila += '<td><a href="#" data-toggle="tooltip" title="' + data.datos[i].mem_materia + '">'+ materia +'</a></td>';
                        fila += '<td><a href="#" data-toggle="tooltip" title="' + data.datos[i].mem_depto_dest_nom + '">' + depto  + '</a></td>'
                        
                        fila += '<td><a href="#" data-toggle="tooltip" title="' + data.datos[i].mem_estado_fechamod + '">' + data.datos[i].mem_estado_nombre + '</a></td>'

                        fila += '<td><button id="ver-memo" type="button" ';
                        fila += 'class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal"';
                        fila += ' onclick="verMemo(\'ver\',\'' + data.datos[i].mem_id + '\')">';
                        /*fila += ' <button id="delete-language-modal" name="delete-language-modal" type="button" ';
                        fila += 'class="btn btn-xs btn-danger" data-toggle="modal" data-target="#myModalDelete" ';
                        fila += 'onclick="deleteAnular(\''+ data.datos[i].mem_id +'\',\'' + data.datos[i].mem_anio +'\',\''
                                + data.datos[i].mem_materia +'\')">';
                        fila += 'Anular</button>';*/
                        if(data.datos[i].mem_estado_id!=5){
                            fila += 'Ver / Editar</button>';
                            fila += ' <button id="Asignar" type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#myModalAsiganUsu"';
                            fila += ' onclick="datosMemoAsigna(' + data.datos[i].mem_id + ')" >Asignar</button></td>';
                        }else{
                            fila += '&nbsp;&nbsp;Ver&nbsp;&nbsp;</button></td>';
                        }

                        fila += '</tr>';
                        $("#listamemos").append(fila);
                    }                    
                }else{
                    $('#resultadofiltromsg').html("");
                    console.log('noooo tiene elementos');
                    $("#resultadofiltro").show();
                    $('#resultadofiltromsg').append(data.message);
                    //fila = '<tr><td colspan="8">'+data.message+'</td><tr>';
                    //$("#listamemos").append(fila);
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
        inicio();
        //$('[data-toggle="tooltip"]').tooltip();
        $("#titulolistado").hide();
        $("body").tooltip({ selector: '[data-toggle=tooltip]' });
        /*getListadoEstadoMemos();
        getListadoSecciones();
        getListadoUsuarios();
        getListadoUsuariosxrol();
        getListadoDificultad();
        getListadoPrioridad();
        getListadoMemos(1,0,0,0);*/

        
        //ordena solo datos de tabla en pagina actual
        $('.orden').click(function(e) {
            e.preventDefault();
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
        //Cambia nombre del rol segun usuario
        $("#usuario").change(function(e){
            e.preventDefault();
            var posicion = document.getElementById("usuario").selectedIndex;
            if(posicion==0){
                nomrol='n/a';
                $('#titulolistado').hide();
                $('#nombreusu').html("");
                $('#estadousu').html("");
                $('#rolUsuario').val('n/a');

            }else{
                nomrol=usuarios[posicion-1]['usu_rol_nombre'];
                nombreUsuario = usuarios[posicion-1]['usu_nombre'];
                $('#rolUsuario').val(nomrol);
                $('#titulolistado').show();
                $('#nombreusu').html(nombreUsuario);
                //$('#estadousu').html($('#memoEstado').val());
            }
            //getListadoEstadoMemos();
            console.log('estado select : '+$('#memoEstado').val());
            console.log('usuid select :'+$('#usuario').val());
            getListadoMemos(1,$('#memoEstado').val(),$('#usuario').val(),$('#memoSeccion').val());
        });

        $("#memoEstado").change(function(e){
            e.preventDefault();
            var idestado = document.getElementById("memoEstado").selectedIndex;
            console.log('estado: '+$('#memoEstado').val());
            console.log('usuid :'+$('#usuario').val());
            //console.log('estado id : ' + idestado);
            getListadoMemos(1,$('#memoEstado').val(),$('#usuario').val(),$('#memoSeccion').val());
        });
        $("#memoSeccion").change(function(e){
            e.preventDefault();
            var idseccion = document.getElementById("memoSeccion").selectedIndex;
            console.log('SECCION: '+$('#memoSeccion').val());
            console.log('usuid :'+$('#usuario').val());
            //console.log('estado id : ' + idestado);
            getListadoMemos(1,$('#memoEstado').val(),$('#usuario').val(),$('#memoSeccion').val());
        });        
    });