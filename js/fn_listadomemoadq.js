    var uid;
    var depto;
    //var ultimoestado;
    var rolid;

    var d = new Date();
    var day = d.getDate();
    var mesinicial = d.getMonth()+1;
    var anioinicial = d.getFullYear();

    var usuarios;

    function limpiaFormAsignaMem(){
        $('#formAsignaMem')[0].reset();
        $("#asignadif").val(2).prop('selected',true);
        $("#asignaprio").val(4).prop('selected',true);
        $('#asignausu').focus();        
    }
    // Funcion valida los datos del formulario en el modal de asginacion del memo, 
    function validarFormularioAsigna(){
        var selasigusu = document.getElementById('asignausu').selectedIndex;
        var selasigdif = document.getElementById('asignadif').selectedIndex;
        var selasgiprio = document.getElementById('asignaprio').selectedIndex;
        var txtasigObs = document.getElementById('asignaobs').value;
        //valida Usuario
        if( selasigusu == null || isNaN(selasigusu) || selasigusu == -1 || selasigusu == 0) {
            $('#asignausu').parent().attr('class','form-group has-error');
            $('#asignausu').parent().children('span').text('Debe seleccionar un Usuario').show();
            document.getElementById('asignausu').focus();
            return false;                
        }else{
            $('#asignausu').parent().attr('class','form-group has-success');
            $('#asignausu').parent().children('span').text('').hide();
        }
        //valida Dificultad
        if( selasigdif == null || isNaN(selasigdif) || selasigdif == -1) {
            $('#asignadif').parent().attr('class','form-group has-error');
            $('#asignadif').parent().children('span').text('Debe seleccionar dificultad').show();
            document.getElementById('asignadif').focus();
            return false;                
        }else{
            $('#asignadif').parent().attr('class','form-group has-success');
            $('#asignadif').parent().children('span').text('').hide();
        }
        //valida Prioridad
        if( selasgiprio == null || isNaN(selasgiprio) || selasgiprio == -1) {
            $('#asignaprio').parent().attr('class','form-group has-error');
            $('#asignaprio').parent().children('span').text('Debe seleccionar Prioridad').show();
            document.getElementById('asignaprio').focus();
            return false;                
        }else{
            $('#asignaprio').parent().attr('class','form-group has-success');
            $('#asignaprio').parent().children('span').text('').hide();
        }
        //Valida Observación
        if(txtasigObs == null || txtasigObs.length == 0 || /^\s+$/.test(txtasigObs)){
                $('#asignaobs').parent().attr('class','form-group has-error');
                $('#asignaobs').parent().children('span').text('El campo Observación no debe ir vacío o con espacios en blanco').show();
                document.getElementById('asignaobs').focus();
                return false;                
        }else{
                $('#asignaobs').parent().attr('class','form-group has-success');
                $('#asignaobs').parent().children('span').text('').hide();
        }        
        return true;
    }
    //funcion limpia algunos objetos del dom al inicio
    function inicio(){
        $('#resultadofiltromsg').html("");
        $("#resultadofiltro").hide();
    }
    //Listado estados del memo segun depto del usuario, OK funciona
    function getListadoEstadoMemos(){
            var datax = {
                "Accion":"listarmin",
                'depto':depto[0],
                'ultestado':0
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
                    opcion = '<option value=' + data.datos[i].memo_est_id + '>' + data.datos[i].memo_est_tipo + '</option>';
                    $("#memoEstado").append(opcion);
                }
                $("#memoEstado").selectpicker();
                $('#memoEstado').selectpicker('render');
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
    //Listado Deptos origenes del memo, OK funciona
    function getlistaDepto (){
        var datax = {
            "Accion":"listarmin"
        }
        $.ajax({
            data: datax, 
            type: "GET",
            dataType: "json", 
            url: "controllers/controllerdepartamento.php", 
        })
        .done(function( data, textStatus, jqXHR ) {
            $("#memoDeptoSol").html("");
            if ( console && console.log ) {
               /* console.log( " data success : "+ data.success 
                    + " \n data msg deptos : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );*/
            }
            $("#memoDeptoSol").append('<option value="1">Todos...</option>');
            for(var i=0; i<data.datos.length;i++){
                   // console.log('id: ' + data.datos[i].depto_id + ' nombre Depto: ' + data.datos[i].depto_nombre);
                   opcion = '<option value=' + data.datos[i].depto_id + '>' + data.datos[i].depto_nombre + '</option>';
                   $("#memoDeptoSol").append(opcion);
            }
            $("#memoDeptoSol").selectpicker();
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( " La solicitud getlistaDepto ha fallado,  textStatus : " +  textStatus 
                    + " \n errorThrown : "+ errorThrown
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
        });
    }
    //Listado dificultad de la asignacion, OK funciona
    function getListadoDificultad(){
            var datax = {
                "Accion":"listar",
            }
            $.ajax({
                data: datax,  
                type: "GET",
                dataType: "json", 
                url: "controllers/controllerasignadificultad.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#asignadif").html(""); 
                /*if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg estados memo : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }*/
                for(var i=0; i<data.datos.length;i++){
                   //console.log('id: '+data.datos[i].adificultad_id + ' nombre: '+data.datos[i].adificultad_texto);
                    opcion = '<option value=' + data.datos[i].adificultad_id + '>' + data.datos[i].adificultad_texto + '</option>';
                    $("#asignadif").append(opcion);
                }
                $("#asignadif").val(2).prop('selected',true);
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
    //Listado prioridad de la asignacion, OK funciona
    function getListadoPrioridad(){
            var datax = {
                "Accion":"listar",
            }
            $.ajax({
                data: datax,  
                type: "GET",
                dataType: "json", 
                url: "controllers/controllerasignaprioridad.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#asignaprio").html(""); 
                /*if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg estados memo : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }*/
                for(var i=0; i<data.datos.length;i++){
                   //console.log('id: '+data.datos[i].aprioridad_id + ' nombre: '+data.datos[i].aprioridad_texto);
                    opcion = '<option value=' + data.datos[i].aprioridad_id + '>' + data.datos[i].aprioridad_texto + '</option>';
                    $("#asignaprio").append(opcion);
                }
                $("#asignaprio").val(4).prop('selected',true);
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
    //Listado usuarios perfil analistas, OK funciona
    function getListadoUsuarios(){
            var datax = {
                "Accion":"listarxperfil",
                "perfilId":4
            }
            $.ajax({
                data: datax,  
                type: "GET",
                dataType: "json", 
                url: "controllers/controllerusuario.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#usuarioasigna").html(""); 
                $("#asignausu").html(""); 
                /*if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data usuarios msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }*/
                usuarios=data.datos;
                $("#usuarioasigna").append('<option value="0">Todos</option>');
                $("#asignausu").append('<option value="">Seleccione...</option>'); 
                for(var i=0; i<data.datos.length;i++){
                    //console.log('id: ' + data.datos[i].usu_id + ' nombre: ' + data.datos[i].usu_nombre);
                    opcion = '<option value=' + data.datos[i].usu_id + '>' + data.datos[i].usu_nombre + '</option>';
                    $("#usuarioasigna").append(opcion);
                    $("#asignausu").append(opcion);
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
    function paginador(total=0,deptosolid=1,deptodesid=1,estado=0,pag=1,usuid=0,anio=0,mes=0,usuasig=0){
            var cantidadMostrar = 10;  // total de numeros de paginas  a mostrar 
            var registroPorPagina = 10; //total registro por pagina, debe coincidir con el modelo.listar
            $("#paginador").html("");    
            $("#totalmemos").html("");
            $("#totalmemos").html(total);
                    if(total > registroPorPagina){
                        fnlista = "getListadoMemos";
                        pagina = drawpaginador(total,registroPorPagina,cantidadMostrar,fnlista,pag,deptosolid,deptodesid,estado,usuid,anio,mes,usuasig);
                        $("#paginador").html("");
                        $("#paginador").append(pagina);
                    }
    }
    // Funcion principal para listar los memos
    function getListadoMemos(deptosolid=1,deptodesid=1,estado=0,pag=1,usuid=0,anio=0,mes=0,numdoc=0,usuasig=0){
        inicio();
        var txtdptoSol='',txtusuasig='',txtestado='',txtanio='',txtmes='',textotitulo='';
        var deptousu;

        if(estado != 0){     txtestado = ' / ' + $("#memoEstado option:selected").text(); }
        if(deptosolid != 1){ txtdptoSol = ' / ' + $("#memoDeptoSol option:selected").text(); }
        if(usuasig != 0){    txtusuasig = ' / ' + $("#usuarioasigna option:selected").text(); }
        if(anio != 0){       txtanio = ' / ' + $("#memoAnio option:selected").text(); }
        if(mes != 0){        txtmes = ' / ' + $("#memoMes option:selected").text(); }

        var textotitulo='<b>Filtros ' + txtestado + txtdptoSol + txtusuasig + txtmes + txtanio + '</b>';
            $('#accord1').html(textotitulo);
        ultimoestado = estado;

        if (rolid==1){
            deptousu = 0;
        }else{
            deptousu = depto;
        }
        var $loader = $('.loader');
            var datax = {
                "deptosolid":deptosolid,
                "deptodesid":1,                
                "nump":pag,
                "idest":estado,
                "idusu":usuid,
                "anio":anio,
                "mes":mes,                
                "numdoc":numdoc,
                "dptoid":deptousu,
                "usuasigna":usuasig,
                "Accionmem":"listar"
            }
            $.ajax({
                data: datax,  
                type: "GET",
                dataType: "json", 
                url: "controllers/controllermemo.php", 
                beforeSend: function(){
                    $('#boxloader').show();
                }
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#listamemos").html(""); 
                $("#paginador").html("");
                $("#totalmemos").html("");
                if ( console && console.log ) {
                    /*console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );*/
                }
                //setTimeout($('#boxloader').hide(), 1000000);
                $('#boxloader').hide();
                incrementotest=0;
                txtcolor = '';
                //text-muted, .text-primary, .text-success, .text-info, .text-warning, y .text-danger
                if(data.datos.length>0){
                    //console.log('tiene elementos');
                    paginador(data.total, deptosolid, deptodesid,estado,pag,usuid,anio,mes);
                    for(var i=0; i<data.datos.length;i++){
                        var chek='<label class="checkbox-inline"><input class="chknumest" type="checkbox" value="'+data.datos[i].mem_id+'" name="cestado"></label>';
                        txtcolor = 'class="'+data.datos[i].mem_estado_colortxt + ' ' + data.datos[i].mem_estado_colorbg + '"';
                        //console.log('id: ' + data.datos[i].mem_id + ' numero memo: ' + data.datos[i].mem_numero);
                        var materia = data.datos[i].mem_materia.length > 50 ? data.datos[i].mem_materia.substr(0, 50)+'...' : data.datos[i].mem_materia;
                        var deptosol= data.datos[i].mem_depto_sol_nom.length > 30 ? data.datos[i].mem_depto_sol_nom.substr(0, 30)+'...' : data.datos[i].mem_depto_sol_nom;
                        incrementotest++;
                        fila = '<tr>';
                        fila += '<td class="tdcestmas">'+chek+'</td>';
                        fila += '<td>'+ data.datos[i].mem_anio + ' - ' + data.datos[i].mem_numero + '</td>';
                        fila += '<td>'+ data.datos[i].mem_fecha +'</td>';
                        //fila += '<td>'+ data.datos[i].mem_fecha_recep +'</td>';
                        fila += '<td><a href="#" data-toggle="tooltip" title="' + data.datos[i].mem_materia + '">'+ materia +'</a></td>';
                        fila += '<td><a href="#" data-toggle="tooltip" title="' + data.datos[i].mem_depto_sol_nom + '">' + deptosol  + '</a></td>'
                        //console.log('largo : ' + data.datos[i].mem_asigna_array.length);
                        var largoasigna = data.datos[i].mem_asigna_array.length;
                        var filaestado = '';
                        var filafechae = '';
                        if(largoasigna > 0 ){
                            //console.log('largho '+ largoasigna);
                            fila += '<td>';
                            for(var j=0; j<largoasigna; j++){
                                fila += '<a href="#" data-toggle="tooltip" title="Asignado :';
                                fila += data.datos[i].mem_asigna_array[j].asigna_usu_fecha + '">';
                                fila += data.datos[i].mem_asigna_array[j].asigna_usu_nom + '</a>';
                                fila += '<br>';
                                filaestado +=  data.datos[i].mem_asigna_array[j].asigna_usu_estado + '<br>';
                                filafechae +=  data.datos[i].mem_asigna_array[j].asigna_usu_fecha + '<br>';
                            }   
                            fila += '</td>';
                        }else{
                            var usuasigna = data.datos[i].mem_asigna_usu_nom==null ? '':data.datos[i].mem_asigna_usu_nom;//mem_asigna_usu_estado
                            filaestado = data.datos[i].mem_asigna_fecha==null ? '':data.datos[i].mem_asigna_fecha;
                            filafechae = data.datos[i].mem_asigna_usu_estado==null ? '':data.datos[i].mem_asigna_usu_estado;
                            fila += '<td>' + usuasigna + '</td>'
                        }
                        fila += '<td class="text-left">' + filafechae + '</td>';
                        fila += '<td class="text-left">' + filaestado + '</td>';
                        fila += '<td><p '+ txtcolor +' data-toggle="tooltip" title="Modificado el ' + data.datos[i].mem_estado_fecha_max + '"> &nbsp;&nbsp;' + data.datos[i].mem_estado_nom_max + '</p></td>'
                        fila += '<td class="text-left">'+data.datos[i].mem_estado_dias + '</td>';
                        
                        fila += '<td class="text-left"><a  href="vs_gestionmemo.php?memId=' + data.datos[i].mem_id + '"';
                        fila += ' class="btn btn-xs btn-success" ';
                        fila += ' role="button id="ver-memo"> ';
                        fila += 'Ver <span class="glyphicon glyphicon-eye-open"></span></a>';

                        fila += '</td>';
                        fila += '</tr>';
                        $("#listamemos").append(fila);
                    }   
                    $(".tdcestmas").hide();                 
                }else{
                    $('#resultadofiltromsg').html("");
                    console.log('noooo tiene elementos');
                    $("#activacest").hide();
                    $("#resultadofiltro").show();
                    $('#resultadofiltromsg').append(data.message);
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
    //funcion para trae datos del memo a mostrar en el modal, llama a funcion getUsuAsignaMemo(), OK funciona
    function datosMemoAsigna(memid,ultestado){
        var $loader = $('.loader');
        var datax = {
                    "Accionmem":"obtener",
                    "memoId":memid,
                    "depto":depto[0],
                    "uid":uid
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
                $("#memodpto").html(""); 
                /*if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }*/
                    $("#memoId").val(data.datos.mem_id);
                    $("#memoultest").val(ultestado);
                    $("#memonum").append('' + data.datos.mem_numero);
                    $("#memomat").append('' + data.datos.mem_materia); 
                    $("#memodpto").append('' + data.datos.mem_depto_sol_nom); 
                    getUsuAsignaMemo(memid);

            })
            .fail(function( jqXHR, textStatus, errorThrown ) {
                if ( console && console.log ) {
                    console.log( " La solicitud datosMemo ha fallado,  textStatus : " +  textStatus 
                        + " \n errorThrown : "+ errorThrown
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
            });            
    }
    //funcion trae asignaciones del memo para mostrar en el modal, OK funcion
    function getUsuAsignaMemo(memid){
        var datax = {
                    "Accion":"getasignamemo",
                    "memoId":memid
            }
            $.ajax({
                data: datax,  
                type: "GET",
                dataType: "json", 
                url: "controllers/controllerusuario.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#listusuasigna").html(""); 
                /*if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }*/
                if(data.datos.length>0){
                    for(var i=0; i<data.datos.length;i++){
                        fila = '<tr>';
                        fila += '<td>'+ data.datos[i].asigna_usu_fecha +'</td>';
                        fila += '<td>'+ data.datos[i].asigna_usu_nom +'</td>';
                        if(data.datos[i].asigna_usu_estado_id == 1){
                            fila += '<td class="text-danger">';
                        }else{
                            fila += '<td>';
                        }
                        fila += data.datos[i].asigna_usu_estado +'</td>';
                        fila += '<td>'+ data.datos[i].asigna_usu_dificultad +'</td>';
                        fila += '<td>'+ data.datos[i].asigna_usu_prioridad +'</td>';
                        fila += '</tr>';
                        $("#listusuasigna").append(fila);
                    }
                }
            })
            .fail(function( jqXHR, textStatus, errorThrown ) {
                if ( console && console.log ) {
                    console.log( " La solicitud datosMemo ha fallado,  textStatus : " +  textStatus 
                        + " \n errorThrown : "+ errorThrown
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
            });            
    }
    //FUNCION PRINCIPAL
    $(document).ready(function(){
        //$('[data-toggle="tooltip"]').tooltip();
        $("#titulolistado").hide();
        $("body").tooltip({ selector: '[data-toggle=tooltip]' });
        $('#memoAnio').val(0); //anioinicial
        $('#memoMes').val(0); //mesinicial

        getListadoEstadoMemos();
        getListadoUsuarios();
        getListadoDificultad();
        getListadoPrioridad();
        getlistaDepto();
        getListadoMemos(1,1,0,1,uid,0,0,0,uid);
        $("#tdce").hide();

        $("#limpiar-memo").click(function(e){
            e.preventDefault();
            limpiaFormAsignaMem();
        });
        // funcion que agrega analista al memo (asignación)
        $('#asigna').click(function(e){
            e.preventDefault();
            if(validarFormularioAsigna()==true){
                var inptuid = document.createElement('input');
                inptuid.type="hidden";
                inptuid.name="uId";
                inptuid.value=uid;
                document.formAsignaMem.appendChild(inptuid);
                var datax = $("#formAsignaMem").serializeArray();
                $.ajax({
                    data: datax,
                    type: "GET",
                    dataType: "json",
                    url: "controllers/controllerusuario.php",
                })
                .done(function( data, textStatus, jqXHR ) {
                    /*if ( console && console.log ) {
                        console.log( " data success : "+ data.success 
                            + " \n data usuarios msg : "+ data.message 
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }*/
                        //$('#myModalAsiganUsu').modal('hide');
                        $('#myModalLittle').modal('show');
                        $('#myModalLittle').on('shown.bs.modal', function () {
                            var modal2 = $(this);
                            modal2.find('.modal-title').text('Mensaje del Servidor');
                            modal2.find('.msg').text(data.message);  
                            $('#cerrarModalLittle').focus();
                        });
                    //listar usuarios asignado del memo
                    getUsuAsignaMemo($('#memoId').val());
                    //limpia formulario asignacion
                    limpiaFormAsignaMem(); 
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
        });
        //carga lstado de los memos al cerrarse el modal de asigna usuario
        $('#myModalAsiganUsu').on('hidden.bs.modal', function () {
            getListadoMemos(1,1,0,1,uid,0,0,0,0);
        });
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

        function validabusca(){
            var txtnumdoc = document.getElementById("numDoc").value;
            if(txtnumdoc != null && txtnumdoc.length != 0 && !(/^\s+$/.test(txtnumdoc)) ){
                var numdoc=txtnumdoc;//console.log('paso num correcto');
            }else{
                var numdoc=0; //console.log('paso num negado');
            }
            getListadoMemos($('#memoDeptoSol').val(),1,$('#memoEstado').val(),1,uid,$('#memoAnio').val(),$('#memoMes').val(),numdoc,$('#usuarioasigna').val());
        }
        
        /*++++++  agregar activar asignacion masiva y levantar modal ++++++++ */
        // funcion que carga en input hidden "nomanalista" el nombre del analista selecionado del select "asignausu"
        $("#asignausu").change(function(event) {
            $('#nomanalista').val($("#asignausu option:selected").text());
        });

        //funcion buscar y lista memos al cambiar el estado
        $("#memoEstado").change(function(e){
            e.preventDefault();
            validabusca();
            //var idestado = document.getElementById("memoEstado").selectedIndex;
            //console.log('memoEstado :  ' + $("#memoEstado").val());
            /*$("#ultimoEstado").val($("#memoEstado").val());
            var texto = $(this).find('option:selected').text();
            $("#estadoactual").html("Ultimo Estado : <b>" + texto + "</b>");*/
            /*if(idestado != 0){
                $("#activacest").show();
            }else{
                $("#activacest").hide();
            }
            $("#capacest").hide();
            $("#tdce").hide();*/
            //$(".tdcestmas").hide();
            //$("#cestmodal").hide();
        });

        // funcion buscar y lista memos al cambiar depto solicitante
        $("#memoDeptoSol").change(function(e){
            e.preventDefault();
            validabusca();
        });
        // funcion buscar y lista memos al cambiar depto destinatario
        $("#usuarioasigna").change(function(e){
            e.preventDefault();
            validabusca();
        });
        // funcion buscar y lista memos al cambiar año
        $("#memoAnio").change(function(e){
            e.preventDefault();
            validabusca();
        });

        $("#memoMes").change(function(e){
            e.preventDefault();
            validabusca();
        });

        // funcion buscar por numero de doc. 
        $("#buscarnumdoc").click(function(e){
            e.preventDefault();
            validabusca();
        });

        // funcion buscar por numero de doc. pero al presionar enter en el unput numDoc""
        $("#numDoc").keypress(function(event) {
            if (event.which == 13 ) {
                validabusca();
            }
        });        
    });