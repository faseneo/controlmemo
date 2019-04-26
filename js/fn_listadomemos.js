    var uid;
    var depto;
    var ultimoestado;

    function limpiaformcambioestado(){
        $('#formcambioestado')[0].reset();
        $("#memoOtroDepto").hide();
        $("#buscarDerivado").hide();
        $("#memoOtroDeptoNombre").hide();
        $('#memoEstadoce').focus();
    }
    // Funcion valida los datos del formulario del cambio de estado del memo
    function validarFormularioEstado(idestado){
        var selMemoEstado = document.getElementById('memoEstadoce').selectedIndex;
        var txtMemoObs = document.getElementById('memoObs').value;
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
            'depto':depto
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
            var inicio=0;var fin=0;
            // Ingresado ->  Anulado y Devuelto otro Depto
            if(ultimoestado==1) { 
                inicio = 2; fin=2 
                opcion = '<option value=' + data.datos[5].memo_est_id + '>' + data.datos[5].memo_est_tipo + '</option>';
                $("#memoEstadoce").append(opcion);                
            }
            //Recibido -> Anulado, Pendiente y Derivado
            if(ultimoestado==2) { inicio = 2; fin=4 }
            //Pendiente -> Archivado, Aprobado,  y rechazado
            if(ultimoestado==4) { inicio = 6; fin=8 }
            //Derivado -> Devuelto
            if(ultimoestado==5) { inicio = 5; fin=5; }
            // Devuelto -> Pendiente y Derivado
            if(ultimoestado==6) { inicio = 3; fin=4 }
            //Aprobado -> Derivado, derivado ppto
            if(ultimoestado==8) { //aprobado DAF
                inicio = 4; fin=4;
                opcion = '<option value=' + data.datos[10].memo_est_id + '>' + data.datos[10].memo_est_tipo + '</option>';
                $("#memoEstadoce").append(opcion);
            } 
            //Derivado ppto -> aprobado ppto, rechazado ppto
            if(ultimoestado==11) { inicio = 11; fin=12; }
            // aprobado ppto -> Derivado , derivado adqui.
            if(ultimoestado==12) { 
                inicio = 4; fin=4;
                opcion = '<option value=' + data.datos[13].memo_est_id + '>' + data.datos[13].memo_est_tipo + '</option>';
                $("#memoEstadoce").append(opcion);
            }
            //Rechazado o rechazado adqui -> respondido.
            if(ultimoestado==12 || ultimoestado==14) { inicio = 9; fin=9 }
                for(var i=inicio; i<=fin; i++){
                    console.log('id: ' + data.datos[i].memo_est_id + ' nombre EstadoMemo: ' + data.datos[i].memo_est_tipo);
                    opcion = '<option value=' + data.datos[i].memo_est_id + '>' + data.datos[i].memo_est_tipo + '</option>';
                    $("#memoEstadoce").append(opcion);
                }

            estadomarcado = $('#memoEstadoce').val()
            console.log('value memo estado  : ' + estadomarcado);
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
            if ( console && console.log ) {
               /* console.log( " data success : "+ data.success 
                    + " \n data msg deptos : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );*/
            }
            $("#memoDeptoSol").append('<option value="1">Todos...</option>');
            $("#memoDeptoDest").append('<option value="1">Todos...</option>');
            for(var i=0; i<data.datos.length;i++){
                   // console.log('id: ' + data.datos[i].depto_id + ' nombre Depto: ' + data.datos[i].depto_nombre);
                   opcion = '<option value=' + data.datos[i].depto_id + '>' + data.datos[i].depto_nombre + '</option>';
                   $("#memoDeptoSol").append(opcion);
                     if(data.datos[i].depto_id==depto){
                         opcion = '<option value=' + data.datos[i].depto_id + ' selected>' + data.datos[i].depto_nombre + '</option>';
                     }
                $("#memoDeptoDest").append(opcion);
            }
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
                'depto':depto
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
            var $loader = $('.loader');
            var datax = {
                "deptodesid":deptodesid,
                "deptosolid":deptosolid,
                "nump":pag,
                "idest":estado,
                "idusu":usuid,
                "anio":anio,
                "numdoc":numdoc,
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
                setTimeout($('#boxloader').hide(), 1000000);
                //$('#boxloader').hide();
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
                        /*fila += ' <a href="#" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>'*/
                        fila += ' <a href="#" class="btn btn-xs btn-info">Destinos <span class="glyphicon glyphicon-plus"></span></a>';
                        fila += '</td>';
                        fila += '</tr>';
                        $("#listamemos").append(fila);
                        //glyphicon .glyphicon-plus
                    }   
                    $(".tdcestmas").hide();                 
                }else{
                    $('#resultadofiltromsg').html("");
                    console.log('noooo tiene elementos');
                    $("#activacest").hide();
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
        $("#activacest").hide();
        $("#capacest").hide();
        $("#tdce").hide();
            $("#memoOtroDepto").hide();
            $("#buscarDerivado").hide();
            $("#memoOtroDeptoNombre").hide();

        $("body").tooltip({ selector: '[data-toggle=tooltip]' });
        getListadoEstadoMemos(depto);
        getListadoMemos(1,depto,0,1,uid,0);
        getlistaDepto();

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
        $("#memoEstado").change(function(e){
            e.preventDefault();
            validabusca();

            var idestado = document.getElementById("memoEstado").selectedIndex;
            var texto = $(this).find('option:selected').text();

            console.log('Console memoestado-------');
            console.log('estado: '+$('#memoEstado').val());
            console.log('usuid :'+ uid);
            console.log('texto :'+ texto);
            $("#estadoactual").html("Ultimo Estado : <b>" + texto + "</b>");
            if(idestado != 0){
                console.log('paso distinto cero');
                $("#activacest").show();
            }else{
                console.log('paso igual 0');
                $("#activacest").hide();
            }
            $("#capacest").hide();
            $("#tdce").hide();
            $(".tdcestmas").hide();
            
            //getListadoMemos($('#memoDeptoSol').val(),$('#memoDeptoDest').val(),$('#memoEstado').val(),1,uid,$('#memoAnio').val());
        });
        $("#activacest").click(function(e) {
            e.preventDefault();
            $("#capacest").show();
            $("#activacest").hide();
            $("#tdce").show();
            $(".tdcestmas").show();
        });
        $("#memoDeptoSol").change(function(e){
            e.preventDefault();
            var idestado = document.getElementById("memoDeptoSol").selectedIndex;
            console.log('Console depto SOlIC-------');
            console.log('deptoSol: ' + $('#memoDeptoSol').val());
            console.log('usuid :'+ uid);
            validabusca();
            //getListadoMemos($('#memoDeptoSol').val(),$('#memoDeptoDest').val(),$('#memoEstado').val(),1,uid,$('#memoAnio').val());
        });
        $("#memoDeptoDest").change(function(e){
            e.preventDefault();
            var idestado = document.getElementById("memoDeptoDest").selectedIndex;
            console.log('Console depto DEST-------');
            console.log('deptoDest: '+$('#memoDeptoDest').val());
            console.log('usuid :'+ uid);
            validabusca();
            //getListadoMemos($('#memoDeptoSol').val(),$('#memoDeptoDest').val(),$('#memoEstado').val(),1,uid,$('#memoAnio').val());
        });
        $("#memoAnio").change(function(e){
            e.preventDefault();
            var idestado = document.getElementById("memoAnio").selectedIndex;
            console.log('Console AÑO-------');
            console.log('anio: '+$('#memoAnio').val());
            console.log('usuid :'+ uid);
            validabusca();
            //getListadoMemos($('#memoDeptoSol').val(),$('#memoDeptoDest').val(),$('#memoEstado').val(),1,uid,$('#memoAnio').val());
        });
        $("#buscarnumdoc").click(function(e){
            e.preventDefault();
            var txtnumdoc = document.getElementById("numDoc").value;
            console.log('Console Num DOC-------');
            console.log('Num Doc: ' + $('#numDoc').val());
            console.log('usuid :' + uid);
            validabusca();
            //getListadoMemos($('#memoDeptoSol').val(),$('#memoDeptoDest').val(),$('#memoEstado').val(),1,uid,$('#memoAnio').val(),$('#numDoc').val());
        });
        $("#chekseltodos").on("click", function() {  
            $(".chknumest").prop("checked", this.checked);  
        });
        $(".chknumest").on("click", function() {  
            if ($(".case").length == $(".chknumest:checked").length) {  
                $("#chekseltodos").prop("checked", true);  
            } else {  
                $("#chekseltodos").prop("checked", false);  
            }  
        });
        $("#cestmodal").click(function(e) {
            e.preventDefault();
            $("#debeseleccionar").hide();
            $("#bodyestado").show();
            $("#footerestado").show();
            console.log();
            var selected = [];
                $(":checkbox[name=cestado]").each(function() {
                  if (this.checked) {
                    // agregas cada elemento.
                    selected.push($(this).val());
                  }
                });
                if (selected.length) {
                  /*$.ajax({
                    cache: false,
                    type: 'post',
                    dataType: 'json', // importante para que 
                    data: selected, // jQuery convierta el array a JSON
                    url: 'roles/paginas',
                    success: function(data) {
                      alert('datos enviados');
                    }
                  });*/
                  // esto es solo para demostrar el json,
                  // con fines didacticos
                  getlistaCambioEstadosMemo();
                  //alert(JSON.stringify(selected));
                  
                } else{
                    $("#debeseleccionar").show();
                    $("#debeseleccionar").html("<b>Debes seleccionar al menos una opción</b>");
                    $("#bodyestado").hide();
                    $("#footerestado").hide();
                    
                  //alert('Debes seleccionar al menos una opción.');
                }
        });

        $("#memoEstadoce").change(function(e){
            e.preventDefault();
            var posidestado = document.getElementById("memoEstadoce").selectedIndex;
            var idestado = $('#memoEstadoce').val();
            console.log('pos estado: ' + posidestado);
            console.log('estado: ' + idestado);
            if(idestado==5){
                $("#memoOtroDepto").show();
                $("#buscarDerivado").show();
                $("#memoOtroDeptoNombre").show();
            }else{
                $("#memoOtroDepto").hide();
                $("#buscarDerivado").hide();
                $("#memoOtroDeptoNombre").hide();
            }
        });

    });
    
    
    
    
    