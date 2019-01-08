    var usuarios;
    var sec;

    function inicio(){
        $('#resultadofiltromsg').html("");
        $("#resultadofiltro").hide();
    }
    function getListadoEstadoMemos(sec){
        console.log('sec : '+sec);
            var datax = {
                "Accion":"listarmin",
                'seccion':sec
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
                $("#memoEstado").append('<option value="0">Todos</option>');
                for(var i=0; i<data.datos.length;i++){
                   //console.log('id: ' + data.datos[i].memo_est_id + ' nombre EstadoMemo: ' + data.datos[i].memo_est_tipo);
                    opcion = '<option value=' + data.datos[i].memo_est_id + '>' + data.datos[i].memo_est_seccion_nombre + ' - ' + data.datos[i].memo_est_tipo + '</option>';
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

    // Funcion principal para listar los memos
    /* ver una funcion que vaya a contar y vuelva si no llamar a listado memos*/
    function getListadoMemos(secid=1,estado=0,pag,usuid=0){
        inicio();
        console.log('Usuario ' + usuid);
        console.log('pagina ' + pag);
        console.log('estado ' + estado);
        console.log('SECCION ' + secid);
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
                        fila += '<td><a href="vs_ingresomemo.php?memId=' + data.datos[i].mem_id + '" data-toggle="tooltip" title="' + data.datos[i].mem_materia + '">'+ materia +'</a></td>';
                        fila += '<td><a href="#" data-toggle="tooltip" title="' + data.datos[i].mem_depto_dest_nom + '">' + depto  + '</a></td>'
                        
                        fila += '<td><a href="#" data-toggle="tooltip" title="' + data.datos[i].mem_estado_fechamod + '">' + data.datos[i].mem_estado_nombre + '</a></td>'

                        fila += '<td><button id="ver-memo" type="button" ';
                        fila += 'class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal"';
                        fila += ' onclick="verMemo(\'ver\',\'' + data.datos[i].mem_id + '\')">';
                        fila += 'Ver / Editar</button>';
                        /*fila += ' <button id="delete-language-modal" name="delete-language-modal" type="button" ';
                        fila += 'class="btn btn-xs btn-danger" data-toggle="modal" data-target="#myModalDelete" ';
                        fila += 'onclick="deleteAnular(\''+ data.datos[i].mem_id +'\',\'' + data.datos[i].mem_anio +'\',\''
                                + data.datos[i].mem_materia +'\')">';
                        fila += 'Anular</button>';*/
                       /* if(data.datos[i].mem_estado_id!=5){*/
                          /*  
                            fila += ' <button id="Asignar" type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#myModalAsiganUsu"';
                            fila += ' onclick="datosMemoAsigna(' + data.datos[i].mem_id + ')" >Asignar</button></td>';*/
                        //}else{
                            //fila += '&nbsp;&nbsp;Ver&nbsp;&nbsp;</button></td>';
                        //}

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
        //$('[data-toggle="tooltip"]').tooltip();
        $("#titulolistado").hide();
        $("body").tooltip({ selector: '[data-toggle=tooltip]' });
        getListadoEstadoMemos(sec);
        getListadoMemos(sec,0,1,0);

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

        $("#memoEstado").change(function(e){
            e.preventDefault();
            var idestado = document.getElementById("memoEstado").selectedIndex;
            console.log('estado: '+$('#memoEstado').val());
            console.log('usuid :'+$('#usuario').val());
            //console.log('estado id : ' + idestado);
            getListadoMemos(sec,$('#memoEstado').val(),1,0);
        });
    });