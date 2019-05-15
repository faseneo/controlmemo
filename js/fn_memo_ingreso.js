    var depto;
    var ultimoestado=1;
    var ultimoorden=1;
    var uid;
    var memId;
    
    function inicio(){
        $(".help-block").hide();
        $("#cambiaestado").hide();
    }    
    document.onkeydown = function(){
        if(window.event){
            window.event.keyCode = 116;
        } 
        if(window.event && window.event.keyCode == 116){
            getlistaDepto();
        }
    }
    function returnFileSize(number) {
            if(number < 1024) {
                return number + 'bytes';
            } else if(number > 1024 && number < 1048576) {
                return (number/1024).toFixed(1) + ' KB';
            } else if(number > 1048576) {
                return (number/1048576).toFixed(1) + ' MB';
            }
    }
    
    function limpiaFormMemo(){
        $('#formIngresoMemo')[0].reset();
        $("#listaArchivosMemo").html("");
        $("#archivoMemo").html("");
        $('#memoFecha').val(fechaActual());
        $('#memoAnio').val(anioActual());
         getlistaDepto();
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
    // Funcion valida los datos del formulario del memo
    function validarFormulario(){
        var txtMemFecha = document.getElementById('memoFecha').value;
        console.log('fecha de input : '+txtMemFecha);
        var txtMemNum = document.getElementById('memoNum').value;
        var txtMemAnio = document.getElementById("memoAnio").value;
        var txtMemMat = document.getElementById('memoMateria').value;
        var txtMemNomSol = document.getElementById('memoNombreSol').value;
        var selMemDptoSol = document.getElementById('memoDeptoSol').selectedIndex;
        console.log('index seleccion sol. : ' +selMemDptoSol);
        console.log('seleccion sol.  val : ' +$('#memoDeptoSol').val());
        var txtMemNomDest = document.getElementById('memoNombreDest').value;
        var selMemDptoDest = document.getElementById('memoDeptoDest').selectedIndex;

        console.log('index seleccion dest. : ' +selMemDptoDest);
        console.log('seleccion dest.  val : ' +$('#memoDeptoDest').val());

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
            if( selMemDptoSol == null || isNaN(selMemDptoSol) || selMemDptoSol == -1 || selMemDptoSol == 0) {
                $('#memoDeptoSol').parent().attr('class','form-group has-error');
                $('#memoDeptoSol').parent().children('span').text('Debe seleccionar un Departamento o Unidad Solicitante').show();
                document.getElementById('memoDeptoSol').focus();
                return false;                
            }else{
                $('#memoDeptoSol').parent().attr('class','form-group has-success-seldiv');
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
            if( selMemDptoDest == null || isNaN(selMemDptoDest) || selMemDptoDest == -1 || selMemDptoDest == 0 ) {
                $('#memoDeptoDest').parent().attr('class','form-group has-error');
                $('#memoDeptoDest').parent().children('span').text('Debe seleccionar un Departamento o Unidad Destinatario').show();
                document.getElementById('memoDeptoDest').focus();
                return false; 
            }else{
                $('#memoDeptoDest').parent().attr('class','form-group has-success-seldiv');
                $('#memoDeptoDest').parent().children('span').text('').hide();
            }
            return true;
    }
    // Funcion valida los datos del formulario del cambio de estado del memo
    function validarFormularioEstado(idestado){
        var selMemoEstado = document.getElementById('memoEstado').selectedIndex;
        var txtMemoObs = document.getElementById('memoObs').value;
        //valida Estado
        if( selMemoEstado == null || isNaN(selMemoEstado) || selMemoEstado == -1 ) {
            $('#memoEstado').parent().attr('class','form-group has-error');
            $('#memoEstado').parent().children('span').text('Debe seleccionar un Estado').show();
            document.getElementById('memoEstado').focus();
            return false;                
        }else{
            $('#memoEstado').parent().attr('class','form-group has-success');
            $('#memoEstado').parent().children('span').text('').hide();
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
    //Funcion que lista los deptos
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
            $("#memoDeptoSol").append('<option value="0">Seleccionar...</option>');
            $("#memoDeptoDest").append('<option value="0">Seleccionar...</option>');
            for(var i=0; i<data.datos.length;i++){
                   // console.log('id: ' + data.datos[i].depto_id + ' nombre Depto: ' + data.datos[i].depto_nombre);
                    opcion = '<option value=' + data.datos[i].depto_id + '>' + data.datos[i].depto_nombre + '</option>';
                $("#memoDeptoDest").append(opcion);    
                $("#memoDeptoSol").append(opcion);
            }
            $("#memoDeptoDest").selectpicker();
            $("#memoDeptoSol").selectpicker();

            /*$('.selectpicker').selectpicker({
                  style: 'btn-default'
            });*/

            $("#memoDeptoSol").selectpicker('val', '9');
            $("#memoDeptoSol").selectpicker('render');
            $("#memoDeptoDest").selectpicker('render');  
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
    //Funcion que lista los estado del memo
    function getlistaEstadosMemo (ultestado){
        console.log('estado funcion : ' + ultestado);
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
            $("#memoEstado").html("");
            if ( console && console.log ) {
                console.log( " data success : "+ data.success 
                    + " \n data msg memest : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
            console.log('ultimoestado: ' + ultimoestado);
            var inicio=0;var fin=0;

            if(ultimoestado==1) { inicio = ultimoestado; fin=3 }
            if(ultimoestado==3) { inicio = 4; fin=5 }
            if(ultimoestado==6) { inicio = 6; fin=6 }
            if(ultimoestado==7) { inicio = 7; fin=8 }
            if(ultimoestado==10 || ultimoestado==12) { inicio = 10; fin=10 }
            //if(ultimoestado==11) { inicio = 1; fin=2 }
                for(var i=inicio; i<=fin; i++){
                    console.log('id: ' + data.datos[i].memo_est_id + ' nombre EstadoMemo: ' + data.datos[i].memo_est_tipo);
                    opcion = '<option value=' + data.datos[i].memo_est_id + '>' + data.datos[i].memo_est_tipo + '</option>';
                    $("#memoEstado").append(opcion);
                }
            estadomarcado = $('#memoEstado').val()
            console.log('value memo estado  : ' + estadomarcado);
            if(estadomarcado == 8 || estadomarcado==9){
                $("#memoFechaCDPDiv").show();
                $("#memoCodigoCCDiv").show();
                $("#memoNombreCCDiv").show();
                $("#memoFechaCDP").attr("required", true);
                $("#memoCodigoCC").attr("required", true);
            }
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( " La solicitud getlistaEstadosMemo ha fallado,  textStatus : " +  textStatus 
                    + " \n errorThrown : "+ errorThrown
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
        });
    }

    $(document).ready(function(){
        inicio();
        getlistaDepto();

        $('#memoFecha').val(fechaActual());
        $('#memoAnio').val(anioActual());

        $("#memoFecha").focusout(function(){
            validafechaonline($(this));
        });
        $("#memoNum").focusout(function () {
            validatxtonline($(this));
        });        
        /*$("#memoFechaRecep").focusout(function(){
            validafechaonline($(this));
        });*/        
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

        // Funcion cuando se agrega el memo escaneado
        $("#memoFile").change(function() {
            $("#archivoMemo").html("");
            var archivos = document.getElementById("memoFile");//Creamos un objeto con el elemento que contiene los archivos: el campo input file, que tiene el id = 'archivos'
            var archivo = archivos.files; //Obtenemos los archivos seleccionados en el imput
            //console.log(archivo.length);
            if(archivo.length===0){
                $("#memoFileInfo").show();
                $("#memoFileInfo").append("No ha seleccionado archivo para subir");
            }else{
                $("#memoFileInfo").hide();
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
      
        // Funcion cuando se agrega otros archivos al memo
        $("#memoFileList").change(function() {
            $("#listaArchivosMemo").html("");
            var archivos = document.getElementById("memoFileList");//Creamos un objeto con el elemento que contiene los archivos: el campo input file, que tiene el id = 'archivos'
            var archivo = archivos.files; //Obtenemos los archivos seleccionados en el imput
            if(archivo.length===0){
                $("#memoFileListInfo").show();
                $("#memoFileListInfo").append("No ha seleccionado archivos para subir");
            }else{
                $("#memoFileListInfo").hide();
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
                if(document.getElementById('uid') == null){
                    var inpt = document.createElement('INPUT');
                    inpt.type="hidden";
                    inpt.name="uid";
                    inpt.id="uid";
                    inpt.value=uid;
                    document.formIngresoMemo.appendChild(inpt);
                }
                if(document.getElementById('tiporeg') == null){
                    var inpt2 = document.createElement('INPUT');
                    inpt2.type="hidden";
                    inpt2.name="tiporeg";
                    inpt2.id="tiporeg";
                    inpt2.value="ingreso";
                    document.formIngresoMemo.appendChild(inpt2);                
                }
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
                    limpiaFormMemo();
                    $("#memoDeptoSol").selectpicker('render');
                    $("#memoDeptoDest").selectpicker('render');
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
                })
                .fail(function( jqXHR, textStatus, errorThrown ) {
                    if ( console && console.log ) {
                        console.log( " La solicitud GRABA MEMO ha fallado,  textStatus : " +  textStatus 
                            + " \n errorThrown : "+ errorThrown
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }
                });
            }
        });

        //funcion que graba datos basicos del memo para adquisiciones, recibios por la DAF
        $("#grabar-estado").click(function(e){
            e.preventDefault();
            var inptuid = document.createElement('input');
            inptuid.type="hidden";
            inptuid.name="uId";
            inptuid.value=uid;
            document.formcambioestado.appendChild(inptuid);

            var inptmemid = document.createElement('input');
            inptmemid.type="hidden";
            inptmemid.name="meId";
            inptmemid.value=memId;
            document.formcambioestado.appendChild(inptmemid);

            var idestado = $('#memoEstado').val();
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
                            //limpiaformcambioestado();
                            //getlistaHistorialEstado(memId,depto);
                            if(depto==9){
                                if(ultimoestado==1){
                                    //$("#editar-memo").hide();
                                }
                                if(ultimoestado==2 || ultimoestado==4 || ultimoestado==6 || ultimoestado==8 || ultimoestado==9 || ultimoestado==11){
                                    $("#cambiaestado").hide();
                                }else{
                                    getlistaEstadosMemo(ultimoestado);
                                }
                            }
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
        });
    });  // Fin del Document ready