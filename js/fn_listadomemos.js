    var uid;
    var depto;
    var ultimoestado;
    var rolid;

    document.onkeydown = function(){
        if(window.event){
            window.event.keyCode = 116;
        } 
        if(window.event && window.event.keyCode == 116){
            //getListadoMemos(1,1,0,1,uid,0);
            getlistaDepto();
        }
    } 
    function limpiaTodoformcambioestado(){
        $('#formcambioestado')[0].reset();
        $("#memoOtroDepto").hide();
        $("#memoOtroDeptoNombre").hide();
        $('#memoEstadoce').focus();
        
        $('#cestadomasivos')[0].reset();
        $("#capacest").hide();
        $("#tdce").hide();
        $(".tdcestmas").hide();
    }
    function limpiaformcambioestado(){
        $('#formcambioestado')[0].reset();
        $("#memoOtroDepto").hide();
        $("#memoOtroDeptoNombre").hide();
        $('#memoEstadoce').focus();
    }
    // Funcion valida los datos del formulario del cambio de estado del memo
    function validarFormularioEstado(idestado){
        var selMemoEstado = document.getElementById('memoEstadoce').selectedIndex;
        var selOtroDeptoId = document.getElementById('memoOtroDeptoId').selectedIndex;
        var txtMemoObs = document.getElementById('memoObs').value;
        var txtDeptoNom = document.getElementById('memoDeptoNombre').value;
        //valida Estado
        if( selMemoEstado == null || isNaN(selMemoEstado) || selMemoEstado == -1 ) {
            $('#memoEstadoce').parent().attr('class','form-group has-error');
            $('#memoEstadoce').parent().children('span').text('Debe seleccionar un Estado').show();
            document.getElementById('memoEstadoce').focus();
            return false;                
        }else{
            $('#memoEstadoce').parent().attr('class','form-group has-success');
            $('#memoEstadoce').parent().children('span').text('').hide();
        }
        console.log('estado para validar : '+idestado);
        //Valida nombre destinatario y id depto
        if(idestado==5 || idestado==11 || idestado==14){
            if(txtDeptoNom == null || txtDeptoNom.length == 0 || /^\s+$/.test(txtDeptoNom)){
                $('#memoDeptoNombre').parent().attr('class','form-group has-error');
                $('#memoDeptoNombre').parent().children('span').text('El campo Nombre Destinatario no debe ir vacío o con espacios en blanco').show();
                document.getElementById('memoDeptoNombre').focus();
                return false;                
            }else{
                $('#memoDeptoNombre').parent().attr('class','form-group has-success');
                $('#memoDeptoNombre').parent().children('span').text('').hide();
            }
            if(idestado==5){
                if( selOtroDeptoId == null || isNaN(selOtroDeptoId) || selOtroDeptoId == -1 || selOtroDeptoId == 0 ) {
                    $('#memoOtroDeptoId').parent().attr('class','form-group has-error');
                    $('#memoOtroDeptoId').parent().children('span').text('Debe seleccionar un Departamento o Unidad Destinatario').show();
                    //$('#msgerrordeptoid').text('Debe seleccionar un Departamento').show().attr('class','text-error');
                    document.getElementById('memoOtroDeptoId').focus();
                    return false;
                }else{
                    //$('#memoOtroDeptoId').parent().attr('class','form-group has-success');
                    $('#memoOtroDeptoId').parent().attr('class','form-group has-success-seldiv');
                    $('#msgerrordeptoid').parent().children('span').text('').hide();
                }
            }
            
        }
        //Valida Observación
        if(txtMemoObs == null || txtMemoObs.length == 0 || /^\s+$/.test(txtMemoObs)){
                $('#memoObs').parent().attr('class','form-group has-error');
                $('#memoObs').parent().children('span').text('El campo Observación no debe ir vacío o con espacios en blanco').show();
                document.getElementById('memoObs').focus();
                return false;                
        }else{
                $('#memoObs').parent().attr('class','form-group has-success');
                $('#memoObs').parent().children('span').text('').hide();
                //document.getElementById('memoNum').focus();
        }        
        return true;
    }
    //Funcion que lista los estado del memo
    function getlistaCambioEstadosMemo (){
        console.log('estado global : ' + ultimoestado);
        var datax = {
            'Accion':'listarmin',
            'depto':depto[0],
            'ultestado':ultimoestado
        }
        $.ajax({
            data: datax, 
            type: "GET",
            dataType: "json", 
            url: "controllers/controllermemoestado.php", 
        })
        .done(function( data, textStatus, jqXHR ) {
            $("#memoEstadoce").html("");
            /*if ( console && console.log ) {
                console.log( " data success : "+ data.success 
                    + " \n data msg memest : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }*/
            console.log('ultimoestado: ' + ultimoestado);
            var inicio=0;
            var fin=data.datos.length;
            if(fin){
                for(var i=inicio; i<fin; i++){
                    console.log('id: ' + data.datos[i].memo_est_id + ' nombre EstadoMemo: ' + data.datos[i].memo_est_tipo);
                    opcion = '<option value=' + data.datos[i].memo_est_id + '>' + data.datos[i].memo_est_tipo + '</option>';
                    $("#memoEstadoce").append(opcion);
                }
                //primero de la lista, inicio posicion + 1, valor del value
                $("#memoEstadoce").val(data.datos[0].memo_est_id); 
                estadomarcado = $('#memoEstadoce').val();
            }else{
                $("#debeseleccionar").show();
                $("#debeseleccionar").html("<b>El estado seleccionado es un estado terminal,no se puede cambiar este estado</b>");
                $("#bodyestado").hide();
                $("#footerestado").hide();
            }
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( " La solicitud getlistaCambioEstadosMemo ha fallado,  textStatus : " +  textStatus 
                    + " \n errorThrown : "+ errorThrown
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
        });
    }

    function inicio(){
        $('#resultadofiltromsg').html("");
        $("#resultadofiltro").hide();
    }

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
            $("#memoDeptoDest").html("");
            $("#memoOtroDeptoId").html("");
            if ( console && console.log ) {
               /* console.log( " data success : "+ data.success 
                    + " \n data msg deptos : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );*/
            }
            $("#memoDeptoSol").append('<option value="1">Todos...</option>');
            $("#memoDeptoDest").append('<option value="1">Todos...</option>');
            $("#memoOtroDeptoId").append('<option value="">Seleccionar...</option>');
            for(var i=0; i<data.datos.length;i++){
                   // console.log('id: ' + data.datos[i].depto_id + ' nombre Depto: ' + data.datos[i].depto_nombre);
                   opcion = '<option value=' + data.datos[i].depto_id + '>' + data.datos[i].depto_nombre + '</option>';
                   $("#memoDeptoSol").append(opcion);
                   $("#memoOtroDeptoId").append(opcion);
                     /*if(data.datos[i].depto_id==depto){
                         opcion = '<option value=' + data.datos[i].depto_id + ' selected>' + data.datos[i].depto_nombre + '</option>';
                     }*/
                $("#memoDeptoDest").append(opcion);
            }
            $("#memoDeptoDest").selectpicker();
            $("#memoDeptoSol").selectpicker();
            $("#memoOtroDeptoId").selectpicker();

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

    function getListadoEstadoMemos(depto){
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
    // Funcion para paginar lista de memos
    function paginador(total=0,deptosolid=1,deptodesid=1,estado=0,pag=1,usuid=0,anio=0){
        //getListadoMemos(deptosolid=1,deptodesid=1,estado=0,pag=1,usuid=0,anio=0)
        //paginador(pag,estado,usuid,data.total,depto);
            console.log('console log PAGINADOR------- ' );
            console.log('pag '+ pag );
            console.log('esta '+ estado);
            console.log('usuid '+ usuid);
            console.log('total '+ total);
            
            var cantidadMostrar = 10;  // total de numeros de paginas  a mostrar 
            var registroPorPagina = 10; //total registro por pagina, debe coincidir con el modelo.listar
            
            $("#paginador").html("");    
            $("#totalmemos").html("");
            $("#totalmemos").html(total);
                    if(total > registroPorPagina){
                        fnlista = "getListadoMemos";
                        pagina = drawpaginador(total,registroPorPagina,cantidadMostrar,fnlista,pag,deptosolid,deptodesid,estado,usuid,anio);
                        $("#paginador").html("");
                        $("#paginador").append(pagina);
                    }
    }
    // Funcion principal para listar los memos
    /* ver una funcion que vaya a contar y vuelva si no llamar a listado memos*/
    function getListadoMemos(deptosolid=1,deptodesid=1,estado=0,pag=1,usuid=0,anio=0,numdoc=0){
        inicio();
        var deptousu;
        /*console.log('console log LISTADO MEMO ------- ' );
        console.log('Usuario ' + usuid);
        console.log('pagina ' + pag);
        console.log('estado ' + estado);
        console.log('DeptoDes ' + deptodesid);
        console.log('Deptosol ' + deptosolid);
        console.log('Año ' + anio);
        console.log('NumDoc ' + numdoc);*/
            //paginador(pag,estado,usuid);
        ultimoestado = estado;
        console.log('ult.estado : ' + ultimoestado);

        if (rolid==1){
            deptousu = 0;
        }else{
            deptousu = depto;
        }
            var $loader = $('.loader');
            var datax = {
                "deptodesid":deptodesid,
                "deptosolid":deptosolid,
                "nump":pag,
                "idest":estado,
                "idusu":usuid,
                "anio":anio,
                "numdoc":numdoc,
                "dptoid":deptousu,
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
                //$('#ModalCargando').modal('hide');
                //setTimeout($('#boxloader').hide(), 1000000);
                $('#boxloader').hide();
                incrementotest=0;
                txtcolor = '';
                //text-muted, .text-primary, .text-success, .text-info, .text-warning, y .text-danger
                if(data.datos.length>0){
                    //console.log('tiene elementos');
                    paginador(data.total, deptosolid, deptodesid,estado,pag,usuid,anio);
                    for(var i=0; i<data.datos.length;i++){
                        var chek='<label class="checkbox-inline"><input class="chknumest" type="checkbox" value="'+data.datos[i].mem_id+'" name="cestado"></label>';
                        txtcolor = 'class="'+data.datos[i].mem_estado_colortxt + ' ' + data.datos[i].mem_estado_colorbg + '"';
                        //console.log('id: ' + data.datos[i].mem_id + ' numero memo: ' + data.datos[i].mem_numero);
                        var materia = data.datos[i].mem_materia.length > 50 ? data.datos[i].mem_materia.substr(0, 50)+'...' : data.datos[i].mem_materia;
                        var deptosol= data.datos[i].mem_depto_sol_nom.length > 30 ? data.datos[i].mem_depto_sol_nom.substr(0, 30)+'...' : data.datos[i].mem_depto_sol_nom;
                        var deptodes= data.datos[i].mem_depto_dest_nom.length > 30 ? data.datos[i].mem_depto_dest_nom.substr(0, 30)+'...' : data.datos[i].mem_depto_dest_nom;
                        incrementotest++;
                        fila = '<tr>';
                        fila += '<td class="tdcestmas">'+chek+'</td>';
                        fila += '<td>'+ data.datos[i].mem_anio + ' - ' + data.datos[i].mem_numero + '</td>';
                        fila += '<td>'+ data.datos[i].mem_fecha +'</td>';
                        fila += '<td>'+ data.datos[i].mem_fecha_recep +'</td>';
                        fila += '<td><a href="#" data-toggle="tooltip" title="' + data.datos[i].mem_materia + '">'+ materia +'</a></td>';
                        fila += '<td><a href="#" data-toggle="tooltip" title="' + data.datos[i].mem_depto_sol_nom + '">' + deptosol  + '</a></td>'
                        fila += '<td><a href="#" data-toggle="tooltip" title="' + data.datos[i].mem_depto_dest_nom + '">' + deptodes  + '</a></td>'
                        fila += '<td><p '+ txtcolor +' data-toggle="tooltip" title="Modificado el ' + data.datos[i].mem_estado_fecha_max + '"> &nbsp;&nbsp;' + data.datos[i].mem_estado_nom_max + '</p></td>'
                        fila += '<td class="text-left">'+data.datos[i].mem_estado_dias + '</td>';
                        fila += '<td class="text-left"><a  href="vs_datosmemo.php?memId=' + data.datos[i].mem_id + '"';
                        fila += ' class="btn btn-xs btn-success" ';
                        fila += ' role="button id="ver-memo"> ';
                        fila += 'Ver <span class="glyphicon glyphicon-eye-open"></span></a>';
                        fila += ' <a href="#" class="btn btn-xs btn-info" data-id="' + data.datos[i].mem_id + '" data-toggle="modal" data-target="#myModalDestino">Destinos <span class="glyphicon glyphicon-map-marker"></span></a>';
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
    //Funcion que lista los derivador del memo
    function getlistaHistorialDeriv(memId){
        var datax = {"Accionmem":"listarderiv",
                     "memoId": memId
                    };
        $.ajax({
            data: datax, 
            type: "GET",
            dataType: "json", 
            url: "controllers/controllermemo.php", 
        })
        .done(function( data, textStatus, jqXHR ) {
            /*if ( console && console.log ) {
                console.log( " data success getlistaHistorialDeriv : "+ data.success 
                    + " \n data msg deptos : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }*/
            $("#listaHistorialDeriv").html(""); 
            var totalHistorialDev = data.datos.length;
            $("#totalDeriva").html("");
            $("#totaltotalDerivaObs").html(totalHistorialDev);
            console.log('Total Derivados : '+totalHistorialDev);

            j=data.datos.length;
            classactual="id='actualDestino'";
            for(var i=0; i<data.datos.length;i++){
                //console.log('id: ' + data.datos[i].memder_id + ' DervTipo: ' + data.datos[i].memder_deptonom);
                if(i==0){
                    fila = '<tr ' + classactual+ ' >';
                }else{
                    fila = '<tr>';
                }
                fila += '<td>' + (j) +' - ' +data.datos[i].memder_deptocorto + '</td>';
                fila += '<td>' + data.datos[i].memder_fecha + '</td>';
                fila += '</tr>';
                $("#listaHistorialDeriv").append(fila);
                j--;
            }
            
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( " La solicitud getlistaHistorialDeriv ha fallado,  textStatus : " +  textStatus 
                    + " \n errorThrown : "+ errorThrown
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
        });
    }
    //principal
    $(document).ready(function(){
        //$('[data-toggle="tooltip"]').tooltip();
        getListadoEstadoMemos(depto);
        getlistaDepto();
        getListadoMemos(1,1,0,1,uid,0);

        $("#titulolistado").hide();
        $("#activacest").hide();
        $("#capacest").hide();
        $("#tdce").hide();
            $("#memoOtroDepto").hide();
            $("#memoOtroDeptoNombre").hide();

        $("body").tooltip({ selector: '[data-toggle=tooltip]' });

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
        // funcion que 
        function validabusca(){
            var txtnumdoc = document.getElementById("numDoc").value;
            console.log('Funcion valida busca -------');
            console.log('Num Doc: ' + $('#numDoc').val());
            console.log('usuid :' + uid);
            console.log('test ' + !(/^\s+$/.test(txtnumdoc)));
            if(txtnumdoc != null && txtnumdoc.length != 0 && !(/^\s+$/.test(txtnumdoc)) ){
                var numdoc=txtnumdoc;//console.log('paso num correcto');
            }else{
                var numdoc=0; //console.log('paso num negado');
            }
            getListadoMemos($('#memoDeptoSol').val(),$('#memoDeptoDest').val(),$('#memoEstado').val(),1,uid,$('#memoAnio').val(),numdoc);
        }
        // funcion buscar y lista doc. memos al cambiar estado
        $("#memoEstado").change(function(e){
            e.preventDefault();
            validabusca();
            var idestado = document.getElementById("memoEstado").selectedIndex;
            var texto = $(this).find('option:selected').text();
            $("#estadoactual").html("Ultimo Estado : <b>" + texto + "</b>");
            if(idestado != 0){
                $("#activacest").show();
            }else{
                $("#activacest").hide();
            }
            $("#capacest").hide();
            $("#tdce").hide();
            $(".tdcestmas").hide();
            //$("#cestmodal").hide();
            
            //getListadoMemos($('#memoDeptoSol').val(),$('#memoDeptoDest').val(),$('#memoEstado').val(),1,uid,$('#memoAnio').val());
        });
        // funcion activa el cambio estado masivo de documentos o memos
        $("#activacest").click(function(e) {
            e.preventDefault();
            $("#chekseltodos").prop("checked", false);
            $("#capacest").show();
            $("#activacest").hide();
            $("#tdce").show();
            $(".tdcestmas").show();
        });
        // funcion buscar y lista memos al cambiar depto solicitante
        $("#memoDeptoSol").change(function(e){
            e.preventDefault();
            validabusca();
        });
        // funcion buscar y lista memos al cambiar depto destinatario
        $("#memoDeptoDest").change(function(e){
            e.preventDefault();
            validabusca();
        });
        // funcion buscar y lista memos al cambiar año
        $("#memoAnio").change(function(e){
            e.preventDefault();
            validabusca();
        });
        // funcion buscar por numero de doc. 
        $("#buscarnumdoc").click(function(e){
            e.preventDefault();
            validabusca();
        });

        $("#numDoc").keypress(function(event) {
            if (event.which == 13 ) {
                validabusca();
            }
        }); 
        // funcion al hacer click checkea todos los doc. de lista ya filtrados
        $("#chekseltodos").on("click", function() {  
            $(".chknumest").prop("checked", this.checked);  
        });
        // funcion que marca check de algunos de los doc. listados y filtrados
        $(".chknumest").on("click", function() {  
            if ($(".case").length == $(".chknumest:checked").length) {  
                $("#chekseltodos").prop("checked", true);  
            } else {  
                $("#chekseltodos").prop("checked", false);  
            }
        });
        // Levanta modal para cambiar estados masivos de los doc. listados, valida que este al menos uno marcado
        $("#cestmodal").click(function(e) {
            e.preventDefault();
            limpiaformcambioestado();
            $("#debeseleccionar").hide();
            $("#bodyestado").show();
            $("#footerestado").show();
            var selected = [];
                $(":checkbox[name=cestado]").each(function() {
                    if (this.checked) {
                        // agregas cada elemento.
                        selected.push($(this).val());
                    }
                });
                if (selected.length) {
                    getlistaCambioEstadosMemo();
                }else{
                    $("#debeseleccionar").show();
                    $("#debeseleccionar").html("<b>Debes seleccionar al menos una opción</b>");
                    $("#bodyestado").hide();
                    $("#footerestado").hide();
                }
        });
        // funcion lista estados posibles en modal cambia estado
        $("#memoEstadoce").change(function(e){
            e.preventDefault();
            var posidestado = document.getElementById("memoEstadoce").selectedIndex;
            var idestado = $('#memoEstadoce').val();
            console.log('pos estado: ' + posidestado);
            console.log('estado: ' + idestado);
            if(idestado == 5 || idestado == 35){
                $("#memoOtroDepto").show();
                $("#memoOtroDeptoNombre").show();
            }else if(idestado == 11 || idestado == 14){
                $("#memoOtroDeptoNombre").show();
                $("#memoOtroDepto").hide();
            }else{
                $("#memoOtroDepto").hide();
                $("#memoOtroDeptoNombre").hide();
            }
        });
        //Funcion que graba el cambio de estado en el modal cambia estado
        $("#grabar-estado").click(function(e){
            e.preventDefault();
            var inptuid = document.createElement('input');
            inptuid.type="hidden";
            inptuid.name="uId";
            inptuid.value=uid;
            document.formcambioestado.appendChild(inptuid);


            var selected = [];
                $(":checkbox[name=cestado]").each(function() {
                    if (this.checked) {
                        // agregas cada elemento.
                        selected.push($(this).val());
                    }
                });
            var inptmemid = document.createElement('input');
                inptmemid.type="hidden";
                inptmemid.name="memosId";
                inptmemid.value=selected;
                document.formcambioestado.appendChild(inptmemid);

            var idestado = $('#memoEstadoce').val();
            console.log('seleccion estado :'+idestado);

            if(validarFormularioEstado(idestado)==true){
                var datax = $("#formcambioestado").serializeArray();
                $.each(datax, function(i, field){
                    console.log("contenido del form ESTADO = "+ field.name + ":" + field.value + " ");
                });
                var $loader = $('.loader');
                var formData = new FormData(document.getElementById("formcambioestado"));
                $.ajax({
                    data: formData, 
                    type: "POST",
                    dataType: "json", 
                    url: "controllers/controllermemoestado.php",
                    cache:false,
                    contentType:false,
                    processData:false,
                    beforeSend: function(){
                        $('#myModalEstado').modal('hide');
                        $('#ModalCargando').modal('show');
                        $('#ModalCargando').on('shown.bs.modal', function () {
                            $loader.show();
                        });
                    }                    
                })
                .done(function( data, textStatus, jqXHR ) {
                    if ( console && console.log ) {
                        console.log( " data success : "+ data.success 
                            + " \n data msg buscares : "+ data.message 
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }

                    $('#ModalCargando').modal('hide');
                    $('#ModalCargando').on('hidden.bs.modal', function () {
                        $('#myModalLittle').modal('show');
                        $('#myModalLittle').on('shown.bs.modal', function () {
                            var modal2 = $(this);
                            modal2.find('.modal-title').text('Mensaje');
                            modal2.find('.msg').text(data.message);
                            $('#cerrarModalLittle').focus();
                            $("#capacest").hide();
                            limpiaTodoformcambioestado();
                            getListadoMemos(1,1,0,1,uid,0);
                            //getListadoEstadoMemos(depto);
                            //getlistaDepto();
                            $('#memoEstado').selectpicker('val', 0);
                            $("#memoDeptoSol").selectpicker('val', 1);
                            $("#memoDeptoDest").selectpicker('val', 1);
                            $("#memoAnio").selectpicker('val', 0);

                        });
                    });
                    
                })
                .fail(function( jqXHR, textStatus, errorThrown ) {
                    if ( console && console.log ) {
                        console.log( " La solicitud GRABA ESTADO ha fallado,  textStatus : " +  textStatus 
                            + " \n errorThrown : "+ errorThrown
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }
                });
            }
            document.formcambioestado.removeChild(inptuid);
            document.formcambioestado.removeChild(inptmemid);
        });

        $('#myModalDestino').on('shown.bs.modal', function (e) {
            $("#listaHistorialDeriv").html(""); 
            var id = $(e.relatedTarget).data().id;
            getlistaHistorialDeriv(id);
                $('#cerrarModalLittle').focus();
        });
    });