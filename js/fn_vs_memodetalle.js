    function deshabilitabotones(){
        document.getElementById('editar-memo').style.display = 'none';
        document.getElementById('actualizar-memo').style.display = 'none';
        document.getElementById('grabar-memo').style.display = 'none';        
    }
    function deshabilitaform(){
        $("#memoFecha").prop( "disabled", true );
        $("#memoNum").prop( "disabled", true );
        $("#memoAnio").prop( "disabled", true );
        $("#memoFechaRecep").prop( "disabled", true );
        $("#memoMateria").prop( "disabled", true );
        $("#memoNombreSol").prop( "disabled", true );
        $("#memoDeptoSol").prop( "disabled", true );
        $("#memoNombreDest").prop( "disabled", true );
        $("#memoDeptoDest").prop( "disabled", true );
        $("#memoCcosto").prop( "disabled", true );
        $("#memoCodCcosto").prop( "disabled", true );      
    }
    function habilitaform(){
        $("#memoFecha").prop( "disabled", false );
        $("#memoNum").prop( "disabled", false );
        $("#memoAnio").prop( "disabled", false );
        $("#memoFechaRecep").prop( "disabled", false );
        $("#memoMateria").prop( "disabled", false );
        $("#memoNombreSol").prop( "disabled", false );
        $("#memoDeptoSol").prop( "disabled", false );
        $("#memoNombreDest").prop( "disabled", false );
        $("#memoDeptoDest").prop( "disabled", false );
        $("#memoCcosto").prop( "disabled", false );
        $("#memoCodCcosto").prop( "disabled", false );      
    }    
    function limpiaFormMemo(){
        $('#formIngresoMemo')[0].reset();
        $("#listaArchivosMemo").html("");
        $("#archivoMemo").html("");
        //$("#linkres").text("");
        //$("#linkres").attr("href","");
        $('#memoNum').focus();
        $('#historial').hide();
    }

    function limpiaFormDetalle(){
        $('#formDetalleMemo')[0].reset();
        $('#memoDetDescripcion').focus();
    }

    function limpiaFormCompra(){
        $('#formDetalleCompra')[0].reset();
        $('#detCompraNombreProd').focus();        
    }

    function aniomemo(){
        var fecha = document.getElementById("memoFecha").value;
        var date = new Date(fecha.replace(/-+/g, '/')); 

        var anio = date.getFullYear();
        var mes = date.getMonth() < 9 ? "0"+(parseInt(date.getMonth())+1) : parseInt(date.getMonth())+1;
        var dia = date.getDate() < 10 ? "0"+ (parseInt(date.getDate())) : parseInt(date.getDate());
        var fechamin = anio + "-" + mes + "-" + dia;

        $('#memoAnio').val(anio);
        $('#memoFechaRecep').attr('min', fechamin);
        $('#memoFechaRecep').val(fechamin);
    }

    function validarFormulario(){
        var txtMemFecha = document.getElementById('memoFecha').value;
        console.log('fecha de input : '+txtMemFecha);
        var txtMemNum = document.getElementById('memoNum').value;
        var txtMemAnio = document.getElementById("memoAnio").value;
        var txtMemFechaRec = document.getElementById('memoFechaRecep').value;
        var txtMemMat = document.getElementById('memoMateria').value;
        var txtMemNomSol = document.getElementById('memoNombreSol').value;
        var selMemDptoSol = document.getElementById('memoDeptoSol').selectedIndex;
        var txtMemNomDest = document.getElementById('memoNombreDest').value;
        var selMemDptoDest = document.getElementById('memoDeptoDest').selectedIndex;
        //var selMemEst = document.getElementById('memoEstado').selectedIndex;

            //Test campo obligatorio
            //valida FECHA INGRESO MEMO
            if(txtMemFecha == null || txtMemFecha.length == 0 || /^\s+$/.test(txtMemFecha)){
                $('#memoFecha').parent().attr('class','form-group has-error');
                $('#memoFecha').parent().children('span').text('Debe ingresar fecha').show();
                document.getElementById('memoFecha').focus();
                return false;
            }else{
                if( validarFormatoFecha(txtMemFecha)){
                    if(existeFecha(txtMemFecha)){
                        $('#memoFecha').parent().attr('class','form-group has-success');
                        $('#memoFecha').parent().children('span').text('').hide();
                    }else{
                        $('#memoFecha').parent().attr('class','form-group has-error');
                        $('#memoFecha').parent().children('span').text('La fecha introducida no es valida.').show();
                        document.getElementById('memoFecha').focus();
                        return false;
                    }
                }else{
                    $('#memoFecha').parent().attr('class','form-group has-error');
                    $('#memoFecha').parent().children('span').text('El formato de la fecha es incorrecto.').show();
                    document.getElementById('memoFecha').focus();
                    return false;                
                }
            }
            // valida NUMERO DEL MEMO
            if(txtMemNum == null || txtMemNum.length == 0 || /^\s+$/.test(txtMemNum)){
                $('#memoNum').parent().attr('class','form-group has-error');
                $('#memoNum').parent().children('span').text('El campo Numero Memo no debe ir vacío o con espacios en blanco').show();
                document.getElementById('memoNum').focus();
                return false;                
            }else{
                $('#memoNum').parent().attr('class','form-group has-success');
                $('#memoNum').parent().children('span').text('').hide();
                //document.getElementById('memoNum').focus();
            }
            //valida AÑO INGRESO MEMO
            if( txtMemAnio == null || txtMemAnio.length == 0 || isNaN(txtMemAnio) ) {
                $('#memoAnio').parent().attr('class','form-group has-error');
                $('#memoAnio').parent().children('span').text('El campo Año no debe ir vacío o con espacios en blanco').show();
                //document.getElementById('memoAnio').focus();
                return false;                
            }else{
                $('#memoAnio').parent().attr('class','form-group has-success');
                $('#memoAnio').parent().children('span').text('').hide();
            }
            // valida FECHA RECEPCION MEMO
            if(txtMemFechaRec == null || txtMemFechaRec.length == 0 || /^\s+$/.test(txtMemFechaRec)){
                $('#memoFechaRecep').parent().attr('class','form-group has-error');
                $('#memoFechaRecep').parent().children('span').text('Debe ingresar fecha').show();
                document.getElementById('memoFechaRecep').focus();
                return false;
            }else{
                if( validarFormatoFecha(txtMemFechaRec)){
                    if(existeFecha(txtMemFechaRec)){
                        $('#memoFechaRecep').parent().attr('class','form-group has-success');
                        $('#memoFechaRecep').parent().children('span').text('').hide();
                    }else{
                        $('#memoFechaRecep').parent().attr('class','form-group has-error');
                        $('#memoFechaRecep').parent().children('span').text('La fecha introducida no es valida.').show();
                        document.getElementById('memoFechaRecep').focus();
                        return false;
                    }
                }else{
                    $('#memoFechaRecep').parent().attr('class','form-group has-error');
                    $('#memoFechaRecep').parent().children('span').text('El formato de la fecha es incorrecto.').show();
                    document.getElementById('memoFechaRecep').focus();
                    return false;                
                }
            }
            // valida MATERIA
            if(txtMemMat == null || txtMemMat.length == 0 || /^\s+$/.test(txtMemMat)){
                $('#memoMateria').parent().attr('class','form-group has-error');
                $('#memoMateria').parent().children('span').text('El campo Materia no debe ir vacío o con espacios en blanco').show();
                document.getElementById('memoMateria').focus();
                return false;
            }else{
                $('#memoMateria').parent().attr('class','form-group has-success');
                $('#memoMateria').parent().children('span').text('').hide();                
            }
            //valida NOMBRE SOLICITANTE
            if(txtMemNomSol == null || txtMemNomSol.length == 0 || /^\s+$/.test(txtMemNomSol)){
                $('#memoNombreSol').parent().attr('class','form-group has-error');
                $('#memoNombreSol').parent().children('span').text('El campo Nombre Solicitante no debe ir vacío o con espacios en blanco').show();
                document.getElementById('memoNombreSol').focus();
                return false;
            }else{
                $('#memoNombreSol').parent().attr('class','form-group has-success');
                $('#memoNombreSol').parent().children('span').text('').hide();
            }
            //valida DEPARTAMENTO SOLICITANTE
            if( selMemDptoSol == null || isNaN(selMemDptoSol) || selMemDptoSol == -1 ) {
                $('#memoDeptoSol').parent().attr('class','form-group has-error');
                $('#memoDeptoSol').parent().children('span').text('Debe seleccionar un Departamento o Unidad Solicitante').show();
                document.getElementById('memoDeptoSol').focus();
                return false;                
            }else{
                $('#memoDeptoSol').parent().attr('class','form-group has-success');
                $('#memoDeptoSol').parent().children('span').text('').hide();
            }
            //valida NOMBRE DESTINATARIO
            if(txtMemNomDest == null || txtMemNomDest.length == 0 || /^\s+$/.test(txtMemNomDest)){
                $('#memoNombreDest').parent().attr('class','form-group has-error');
                $('#memoNombreDest').parent().children('span').text('El campo Nombre Destinatario no debe ir vacío o con espacios en blanco').show();
                document.getElementById('memoNombreDest').focus();
                return false;                
            }else{
                $('#memoNombreDest').parent().attr('class','form-group has-success');
                $('#memoNombreDest').parent().children('span').text('').hide();
            }
            //valida DEPARTAMENTO DESTINATARIO
            if( selMemDptoDest == null || isNaN(selMemDptoDest) || selMemDptoDest == -1 ) {
                $('#memoDeptoDest').parent().attr('class','form-group has-error');
                $('#memoDeptoDest').parent().children('span').text('Debe seleccionar un Departamento o Unidad Destinatario').show();
                document.getElementById('memoDeptoDest').focus();
                return false; 
            }else{
                $('#memoDeptoDest').parent().attr('class','form-group has-success');
                $('#memoDeptoDest').parent().children('span').text('').hide();
            }
            //valida ESTADO
            /*if( selMemEst == null || isNaN(selMemEst) || selMemEst == -1 ) {
                $('#memoEstado').parent().attr('class','form-group has-error');
                $('#memoEstado').parent().children('span').text('El campo Estado no debe ir vacío o con espacios en blanco').show();
                document.getElementById('memoEstado').focus();
                return false;                 
            }else{
                $('#memoEstado').parent().attr('class','form-group has-success');
                $('#memoEstado').parent().children('span').text('').hide();
            }*/
            return true;
    }
    //Funcion que lista los deptos
    function getlistaDepto (){
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
            $("#memoDeptoSol").html("");
            $("#memoDeptoDest").html("");
            if ( console && console.log ) {
                console.log( " data success : "+ data.success 
                    + " \n data msg deptos : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
            $("#memoDeptoSol").append('<option value="">Seleccionar...</option>');
            $("#memoDeptoDest").append('<option value="">Seleccionar...</option>');
            for(var i=0; i<data.datos.length;i++){
                   // console.log('id: ' + data.datos[i].depto_id + ' nombre Depto: ' + data.datos[i].depto_nombre);
                   opcion = '<option value=' + data.datos[i].depto_id + '>' + data.datos[i].depto_nombre + '</option>';
                   $("#memoDeptoSol").append(opcion);
                   if(data.datos[i].depto_id==34){
                    opcion = '<option value=' + data.datos[i].depto_id + ' selected>' + data.datos[i].depto_nombre + '</option>';
                }
                $("#memoDeptoDest").append(opcion);
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
    //Funcion que lista los Centros de Costos
    function getlistaCcostos (){
        var datax = {
            "Accion":"listarmin"
        }
        $.ajax({
            data: datax, 
            type: "GET",
            dataType: "json", 
            url: "controllers/controllercentrocostos.php", 
        })
        .done(function( data, textStatus, jqXHR ) {
            $("#memoCcosto").html("");
            /*if ( console && console.log ) {
                console.log( " data success : "+ data.success 
                    + " \n data msg deptos : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }*/
            $("#memoCcosto").append('<option value="">Seleccionar...</option>');
            for(var i=0; i<data.datos.length;i++){
                // console.log('id: ' + data.datos[i].depto_id + ' nombre Depto: ' + data.datos[i].depto_nombre);
                opcion = '<option value=' + data.datos[i].ccosto_codigo + '>' + data.datos[i].ccosto_nombre + '</option>';
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
    //Funcion que lista los estado del memo
    function getlistaEstadosMemo (){
        var datax = {
            'Accion':'listar',
            'seccion':'2'
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
                    + " \n data msg memest : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
            for(var i=0; i<data.datos.length;i++){
                //console.log('id: ' + data.datos[i].memo_est_id + ' nombre EstadoMemo: ' + data.datos[i].memo_est_tipo);
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

    //funcion levanta modal y muestra  los datos del centro de costo cuando presion boton Ver/Editar, aca se puede mdificar si quiere
    function verMemo(memId){
        deshabilitabotones();
        //deshabilitaform();        
        //getlistaDep();
        var datay = {"memoId": memId,
                     "Accionmem":"obtener"
                    };
        $.ajax({
            data: datay, 
            type: "POST",
            dataType: "json", 
            url: "controllers/controllermemo.php",
        })
        .done(function(data,textStatus,jqXHR ) {
            if ( console && console.log ) {
                console.log( " data success : "+ data.success 
                    + " \n data msg : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
            $("#memoFecha").val(data.datos.mem_fecha);
            $("#memoNum").val(data.datos.mem_numero);
            $("#memoAnio").val(data.datos.mem_anio);
            $("#memoFechaRecep").val(data.datos.mem_fecha_recep);
            $("#memoMateria").val(data.datos.mem_materia);
            $("#memoNombreSol").val(data.datos.mem_nom_sol);
            $("#memoDeptoSol").val(data.datos.mem_depto_sol_id);
            $("#memoNombreDest").val(data.datos.mem_depto_dest_nom);
            $("#memoDeptoDest").val(data.datos.mem_depto_dest_id);
            $("#memoCcosto").val(data.datos.mem_cc_codigo);
            $("#memoCodCcosto").val(data.datos.memoCodCcosto);

            $('#historial').show();
            $("#listaHistorial").html(""); 
            var totalHistorial = data.datos.mem_estados.length;
            $("#totalHist").html("");
            $("#totalHist").html(totalHistorial);
            
            for(var i=0; i<data.datos.mem_estados.length;i++){
                console.log('id: ' + data.datos.mem_estados[i].estado_id + ' Estado Tipo: ' + data.datos.mem_estados[i].estado_tipo);
                
                fila = '<tr><td>'+ data.datos.mem_estados[i].estado_tipo + '</td>';
                fila += '<td>' + data.datos.mem_estados[i].observacion + '</td>';
                fila += '<td>' + data.datos.mem_estados[i].fecha + '</td>';
                fila += '</tr>';
                $("#listaHistorial").append(fila);
            }
            console.log('largo archivos ' + data.datos.mem_estados.length);
            $("#archivoMemo").html("");             
            for(var i=0; i<data.datos.mem_archivos.length;i++){
                console.log('id archivo : ' + data.datos.mem_archivos[i].memoarch_id + ' NOmbre archvo: ' + data.datos.mem_archivos[i].memoarch_name);
                
                if(data.datos.mem_archivos[i].memoarch_flag == 1){
                    fila2 = '<tr><td>'+ data.datos.mem_archivos[i].memoarch_name + '</td>';
                    fila2 += '<td>' + data.datos.mem_archivos[i].memoarch_size + '</td>';
                    fila2 += '</tr>';
                    $("#archivoMemo").append(fila2);
                }

            }
            deshabilitabotones();
            $('#editar-memo').show();
            $('#limpiar-memo').hide();
            

            /*$("#Accion").val(action);
            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                if (action === 'actualizar'){
                    modal.find('.modal-title-form').text('Actualizar Centro de Costo');
                    $('#guardar-cecosto').hide();                    
                    $('#actualizar-cecosto').show();   
                }else if (action === 'ver'){
                    modal.find('.modal-title-form').text('Datos Centro de Costo');
                    deshabilitabotones();
                    $('#editar-cecosto').show();   
                }

            });*/
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( " La solicitud ha fallado,  textStatus : " +  textStatus 
                    + " \n errorThrown : "+ errorThrown
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
        });
    }
    $(document).ready(function(){
        function inicio(){
            $(".help-block").hide();
            $('#historial').hide();
        }

        $("#memoFecha").focusout(function(){
            validafechaonline($(this));
        });
        $("#memoNum").focusout(function () {
            validatxtonline($(this));
        });        
        $("#memoFechaRecep").focusout(function(){
            validafechaonline($(this));
        });        
        $("#memoMateria").focusout(function () {
            validatxtonline($(this));
        });
        $("#memoNombreSol").focusout(function () {
            validatxtonline($(this));
        });
        $("#memoDeptoSol").focusout(function(){
            validaselectonline($(this));
        });        
        $("#memoNombreDest").focusout(function () {
            validatxtonline($(this));
        });
        $("#memoDeptoDest").focusout(function(){
            validaselectonline($(this));
        });
        $("#memoEstado").focusout(function(){
            validaselectonline($(this));
        });

        inicio();
        deshabilitabotones();
        getlistaDepto();
        getlistaCcostos();
        //getlistaEstadosMemo();
        if (typeof memId !== 'undefined'){
            verMemo(memId);
            deshabilitaform();
        }else{
            $('#grabar-memo').show();
        }
        
        //$('#agregar-det-memo').show();
        //$('#agregar-det-memo-compra').show();
        $('[data-toggle="tooltip"]').tooltip();

        $("#limpiar-memo").click(function(e){
            e.preventDefault();
            limpiaFormMemo();
        });
        $("#limpiar-archivo-memo").click(function(e){
            e.preventDefault();
            $('#memoFile').val(null);
            $("#archivoMemo").html("");
        });
        $("#limpiar-archivo").click(function(e){
            e.preventDefault();
            $('#memoFileList').val(null);
            $("#listaArchivosMemo").html("");
        });        

        function returnFileSize(number) {
            if(number < 1024) {
                return number + 'bytes';
            } else if(number > 1024 && number < 1048576) {
                return (number/1024).toFixed(1) + 'KB';
            } else if(number > 1048576) {
                return (number/1048576).toFixed(1) + 'MB';
            }
        }

        $("#memoFile").change(function() {
            $("#archivoMemo").html("");
            var archivos = document.getElementById("memoFile");//Creamos un objeto con el elemento que contiene los archivos: el campo input file, que tiene el id = 'archivos'
            var archivo = archivos.files; //Obtenemos los archivos seleccionados en el imput
            //console.log(archivo.length);
            if(archivo.length===0){
                $("#memoFileInfo").append("No ha seleccionado archivo para subir");
            }else{
                var nombre = archivo[0].name;
                var peso = returnFileSize(archivo[0].size);
                //console.log(nombre );
                var lista = `<tr>
                <td>${nombre}</td>
                <td>${peso}</td>
                </tr>`;
                $("#archivoMemo").append(lista);
            }
        });

        $("#memoFileList").change(function() {
            $("#listaArchivosMemo").html("");
            var archivos = document.getElementById("memoFileList");//Creamos un objeto con el elemento que contiene los archivos: el campo input file, que tiene el id = 'archivos'
            var archivo = archivos.files; //Obtenemos los archivos seleccionados en el imput
            if(archivo.length===0){
                $("#memoFileListInfo").append("No ha seleccionado archivos para subir");
            }else{

                for(i=0; i<archivo.length; i++){
                    var lista="<tr>";
                    lista += "<td>"+archivo[i].name+"</td>";
                    lista += "<td>"+returnFileSize(archivo[i].size)+"</td>";
                    /*lista += "<td><button type='button' id='quitarfile' class='close' onclick='quitafile(\'"+i+"\')'>&times;</button></td>";*/
                    lista += "</tr>";
                    $("#listaArchivosMemo").append(lista);                    
                }
            }
        });

        //funcion que graba datos basicos del memo para adquisiciones, recibios por la DAF
        $("#grabar-memo").click(function(e){
            e.preventDefault();
            if(validarFormulario()==true){
                //var datax = $("#formIngresoMemo").serializeArray();
                /*$.each(datax, function(i, field){
                    console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                });*/
                var $loader = $('.loader');
                var formData = new FormData(document.getElementById("formIngresoMemo"));
               /*  var x = document.getElementById("formIngresoMemo").acceptCharset;
                   console.log("charset : " + x);*/
                $.ajax({
                    data: formData, 
                    type: "POST",
                    dataType: "json", 
                    url: "controllers/controllermemo.php",
                    cache:false,
                    contentType:false,
                    processData:false,
                    beforeSend: function(){
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
                        });
                    });
                    limpiaFormMemo();
                })
                .fail(function( jqXHR, textStatus, errorThrown ) {
                    if ( console && console.log ) {
                        console.log( " La solicitud ha fallado,  textStatus : " +  textStatus 
                            + " \n errorThrown : "+ errorThrown
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }
                });
            }
        });

        // Funcion que busca numero de resolucion y devuelve url ubicacion
        /*var buscaRes = function (){
            var datax = $("#formBusquedaRes").serializeArray();
                /*$.each(datax, function(i, field){
                    console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                });*/
                /*$.ajax({
                    data: datax, 
                    type: "POST",
                    dataType: "json", 
                    url: "http://resoluciones2.umce.cl/controllers/controllerresoluciones.php", 
                })
                .done(function( data, textStatus, jqXHR ) {
                    if ( console && console.log ) {
                        console.log( " data success : "+ data.success 
                            + " \n data msg buscares : "+ data.message 
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }
                    if(data.total>0){
                        $("#linkres").text(data.datos[0].res_anio + "-" + data.datos[0].res_numero + " : " + data.datos[0].res_descripcion);  
                        $("#linkres").attr("href",data.datos[0].res_ruta);
                        $("#memoUrlRes").val(data.datos[0].res_ruta);
                        $('#buscaNumRes').val("");
                        $('#myModalBuscaRes').modal('hide');
                    }else{
                        $('#msgres').html('<div class="alert alert-warning" id="msgres" role="alert">NO existe Resolución</div>')
                    }

                })
                .fail(function( jqXHR, textStatus, errorThrown ) {
                    if ( console && console.log ) {
                        console.log( " La solicitud ha fallado,  textStatus : " +  textStatus 
                            + " \n errorThrown : "+ errorThrown
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }
                });
            };*/
/*        $("#buscar-res").on("click",function(e){
            e.preventDefault();
            numRes = $("#buscaNumRes").val().trim();
            //?Accion=buscar&buscaNumRes=2017-100002
            //if(validarFormulario()==true){
            if(numRes == null || numRes.length == 0 ){
                $('#msgres').html('<div class="alert alert-danger" id="msgres" role="alert">NO debe ir vacío o espacios en blanco</div>')
                document.getElementById('buscaNumRes').focus();
            }else{
                buscaRes();
            }
           // }
       });*/
/*        $("#buscaNumRes").on("keydown",function(e){
            if(e.which == 13){      
                e.preventDefault();
                 buscaRes();
            }
            if(e.which == 8){      
                $('#msgres').html(""); 
            }             
        });*/
/*        $("#buscaNumRes").on("click",function(e){
            $('#msgres').html(""); 
        });*/

        //si tiene numero memo Levanta modal nuevo detalle memo y graba el memo
        //$("#crea-detalle-memo").click(function(e){
        /*$("#formIngresoMemo").on('submit',function(e){
            e.preventDefault();
                var datax = $("#formIngresoMemo").serializeArray();
                $.each(datax, function(i, field){
                    console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                });            
            var valor = $('input:text[name=memoNum]').val();
            var valida=true;
            if( valor !=""){
                $("#memoNum").parent().attr("class","form-group");
                //GRABAR EN BASE DE DATOS TEMPORAL EL MEMO
                //valida=grabarMemo();
                //console.log(" graba ? "+ valida);
                if(valida==true){
                    limpiaFormDetalle();
                    $('#myModalDetalle').modal('show');
                }else{
                    $("#memoNum").parent().attr("class","form-group has-error");
                    $('#myModalLittle').modal('show');
                        $('#myModalLittle').on('shown.bs.modal', function () {
                            var modal2 = $(this);
                            modal2.find('.modal-title').text('Mensaje');
                            modal2.find('.msg').html('<b>Error al ingresar el memo</b>');  
                            $('#cerrarModalLittle').focus();
                    });
                }
                
            }else{
                $("#memoNum").parent().attr("class","form-group has-error");
                $('#myModalLittle').modal('show');
                    $('#myModalLittle').on('shown.bs.modal', function () {
                        var modal2 = $(this);
                        modal2.find('.modal-title').text('Mensaje');
                        modal2.find('.msg').html('<b>Debe indicar Numero de memo antes de agregar detalle</b>');  
                        $('#cerrarModalLittle').focus();
                });
            }
        });*/


        /*function grabarMemo(){
            var graba=false;
            console.log("valor graba definicion : "+ graba);
           /* if(validarFormulario()==true){
                $.ajax({
                    data: datax, 
                    type: "POST",
                    dataType: "json", 
                    url: "controllers/controllermemo.php", 
                })
                .done(function( data, textStatus, jqXHR ) {
                    if ( console && console.log ) {
                        console.log( " data success : "+ data.success 
                            + " \n data msg : "+ data.message 
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }
                    graba=data.success;
                    console.log("valor graba en el done : "+ graba);
                })
                .fail(function( jqXHR, textStatus, errorThrown ) {
                    if ( console && console.log ) {
                        console.log( " La solicitud ha fallado,  textStatus : " +  textStatus 
                            + " \n errorThrown : "+ errorThrown
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }
                    graba=fals;e
                    console.log("valor graba en el fail : "+ graba);
                });
            }
            console.log("valor graba : "+ graba);
            return graba
        } */       

    });  // Fin del Document ready