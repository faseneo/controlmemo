    var depto;
    var ultimoestado=1;
    var ultimoorden=1;
    var uid;
    var memId;
    function returnFileSize(number) {
            if(number < 1024) {
                return number + 'bytes';
            } else if(number > 1024 && number < 1048576) {
                return (number/1024).toFixed(1) + ' KB';
            } else if(number > 1048576) {
                return (number/1048576).toFixed(1) + ' MB';
            }
    }

    function deshabilitabotones(){
        document.getElementById('editar-memo').style.display = 'none';
        document.getElementById('actualizar-memo').style.display = 'none';
        document.getElementById('grabar-memo').style.display = 'none';        
        document.getElementById('agregar-det-memo').style.display = 'none';
        document.getElementById('cancelar-memo').style.display = 'none';
        //document.getElementById('editar-archivos').style.display = 'none';
        //document.getElementById('cancelar-archivos').style.display = 'none';
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
        //$("#memoCcosto").prop( "disabled", true );
        //$("#memoCodigoCC").prop( "disabled", true );
    }

    function habilitaform(){
        //$("#memoFecha").prop( "disabled", false );
        //$("#memoNum").prop( "disabled", false );
        //$("#memoAnio").prop( "disabled", false );
        //$("#memoFechaRecep").prop( "disabled", false );
        $("#memoMateria").prop( "disabled", false );
        $("#memoNombreSol").prop( "disabled", false );
        $("#memoDeptoSol").prop( "disabled", false );
        $("#memoNombreDest").prop( "disabled", false );
        $("#memoDeptoDest").prop( "disabled", false );
    }

    function limpiaFormMemo(){
        $('#formIngresoMemo')[0].reset();
        $("#listaArchivosMemo").html("");
        $("#archivoMemo").html("");
        $('#memoFecha').val(fechaActual());
        $('#memoAnio').val(anioActual());
        //$("#linkres").text("");
        //$("#linkres").attr("href","");
        //memoNum
        //$('#memoFecha').focus();
        $('#paneles').hide();
        $("#listaHistorial").html("");
        $("#verarchivoMemo").html("");
        $("#verlistaArchivosMemo").html("");
    }
    
    function limpiaformcambioestado(){
        $('#formcambioestado')[0].reset();
        $("#memoOtroDepto").hide();
        $("#buscarDerivado").hide();
        $("#memoOtroDeptoNombre").hide();
        $('#memoEstado').focus();
    }
    function limpiaformobservacion(){
        $('#formobservacion')[0].reset();
        $('#memobsTexto').focus();
    }    
    function limpiaFormDetalle(){
        $('#formDetalleMemo')[0].reset();
        $('#memoDetDescripcion').focus();
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
        var txtMemFechaRec = document.getElementById('memoFechaRecep').value;
        var txtMemMat = document.getElementById('memoMateria').value;
        var txtMemNomSol = document.getElementById('memoNombreSol').value;
        var selMemDptoSol = document.getElementById('memoDeptoSol').selectedIndex;
        var txtMemNomDest = document.getElementById('memoNombreDest').value;
        var selMemDptoDest = document.getElementById('memoDeptoDest').selectedIndex;
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

        /*if(idestado==8 || idestado==9){
            console.log('paso 8');
            var txtCodigoCC = document.getElementById('memoCodigoCC').value;
            var txtFechaCDP = document.getElementById('memoFechaCDP').value;
            //Valida Observación
            if(txtCodigoCC == null || txtCodigoCC.length == 0 || /^\s+$/.test(txtCodigoCC)){
                    $('#memoCodigoCC').parent().attr('class','form-group has-error');
                    $('#memoCodigoCC').parent().children('span').text('El campo Codigo Centro de Costo no debe ir vacío o con espacios en blanco').show();
                    document.getElementById('memoCodigoCC').focus();
                    return false;                
            }else{
                    $('#memoCodigoCC').parent().attr('class','form-group has-success');
                    $('#memoCodigoCC').parent().children('span').text('').hide();
                    //document.getElementById('memoNum').focus();
            }
            //valida FECHA DEL CDP
            if(txtFechaCDP == null || txtFechaCDP.length == 0 || /^\s+$/.test(txtFechaCDP)){
                $('#memoFechaCDP').parent().attr('class','form-group has-error');
                $('#memoFechaCDP').parent().children('span').text('Debe ingresar fecha').show();
                document.getElementById('memoFechaCDP').focus();
                return false;
            }else{
                if( validarFormatoFecha(txtFechaCDP)){
                    if(existeFecha(txtFechaCDP)){
                        $('#memoFechaCDP').parent().attr('class','form-group has-success');
                        $('#memoFechaCDP').parent().children('span').text('').hide();
                    }else{
                        $('#memoFechaCDP').parent().attr('class','form-group has-error');
                        $('#memoFechaCDP').parent().children('span').text('La fecha introducida no es valida.').show();
                        document.getElementById('memoFechaCDP').focus();
                        return false;
                    }
                }else{
                    $('#memoFechaCDP').parent().attr('class','form-group has-error');
                    $('#memoFechaCDP').parent().children('span').text('El formato de la fecha es incorrecto.').show();
                    document.getElementById('memoFechaCDP').focus();
                    return false;                
                }
            }            
        }*/
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
    // Funcion valida los datos del formulario del cambio de estado del memo
    function validarFormularioObservacion(){
        var txtMemoOtroObs = document.getElementById('memobsTexto').value;
        //Valida Observación
        if(txtMemoOtroObs == null || txtMemoOtroObs.length == 0 || /^\s+$/.test(txtMemoOtroObs)){
                $('#memobsTexto').parent().attr('class','form-group has-error');
                $('#memobsTexto').parent().children('span').text('El campo Observación no debe ir vacío o con espacios en blanco').show();
                document.getElementById('memobsTexto').focus();
                return false;                
        }else{
                $('#memobsTexto').parent().attr('class','form-group has-success');
                $('#memobsTexto').parent().children('span').text('').hide();
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
            $("#memoOtroDeptoId").html("");
            if ( console && console.log ) {
               /* console.log( " data success : "+ data.success 
                    + " \n data msg deptos : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );*/
            }
            $("#memoDeptoSol").append('<option value="">Seleccionar...</option>');
            $("#memoDeptoDest").append('<option value="">Seleccionar...</option>');
            $("#memoOtroDeptoId").append('<option value="">Seleccionar...</option>');
            for(var i=0; i<data.datos.length;i++){
                   // console.log('id: ' + data.datos[i].depto_id + ' nombre Depto: ' + data.datos[i].depto_nombre);
                opcion = '<option value=' + data.datos[i].depto_id + '>' + data.datos[i].depto_nombre + '</option>';
                $("#memoDeptoSol").append(opcion);
                $("#memoOtroDeptoId").append(opcion);
                    if(data.datos[i].depto_id==9){
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
                console.log( " La solicitud getlistaCcostos ha fallado,  textStatus : " +  textStatus 
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
                $("#memoEstado").append(opcion);                
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
                $("#memoEstado").append(opcion);
            } 
            //Derivado ppto -> aprobado ppto, rechazado ppto
            if(ultimoestado==11) { inicio = 11; fin=12; }
            // aprobado ppto -> Derivado , derivado adqui.
            if(ultimoestado==12) { 
                inicio = 4; fin=4;
                opcion = '<option value=' + data.datos[13].memo_est_id + '>' + data.datos[13].memo_est_tipo + '</option>';
                $("#memoEstado").append(opcion);
            }
            //Rechazado o rechazado adqui -> respondido.
            if(ultimoestado==12 || ultimoestado==14) { inicio = 9; fin=9 }
            //if(ultimoestado==11) { inicio = 1; fin=2 }
                                   
                for(var i=inicio; i<=fin; i++){
                    console.log('id: ' + data.datos[i].memo_est_id + ' nombre EstadoMemo: ' + data.datos[i].memo_est_tipo);
                    opcion = '<option value=' + data.datos[i].memo_est_id + '>' + data.datos[i].memo_est_tipo + '</option>';
                    $("#memoEstado").append(opcion);
                }

            estadomarcado = $('#memoEstado').val()
            console.log('value memo estado  : ' + estadomarcado);
            /*if(estadomarcado == 8 || estadomarcado==9){
                $("#memoFechaCDPDiv").show();
                $("#memoCodigoCCDiv").show();
                $("#memoNombreCCDiv").show();
                $("#memoFechaCDP").attr("required", true);
                $("#memoCodigoCC").attr("required", true);
            }*/
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
    //Funcion que lista el historial de Estados del memo
    function getlistaHistorialEstado (memId,depto){
        var datax = {"Accionmem":"listarestmemo",
                     "memoId": memId,
                     "depto":depto
                    };
        $.ajax({
            data: datax, 
            type: "GET",
            dataType: "json", 
            url: "controllers/controllermemo.php", 
        })
        .done(function( data, textStatus, jqXHR ) {
            /*if ( console && console.log ) {
                console.log( " data success getlistaHistorialEstado : "+ data.success 
                    + " \n data msg deptos : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }*/
            $("#listaHistorial").html(""); 
            var totalHistorial = data.datos.length;
            $("#totalHist").html("");
            $("#totalHist").html(totalHistorial);

            console.log('Total Estados : '+totalHistorial);
            ultimoestadotipo="";
            classactual="id='actualEstado'";
            for(var i=0; i<totalHistorial; i++){
                //console.log('id: ' + data.datos[i].estado_id + ' Estado Tipo: ' + data.datos[i].estado_tipo);
                if(i==0){
                    fila = '<tr ' + classactual+ ' >';
                }else{
                    fila = '<tr>';
                }
                fila += '<td>'+ data.datos[i].estado_tipo + '</td>';
                fila += '<td>' + data.datos[i].observacion + '</td>';
                fila += '<td>' + data.datos[i].fecha + '</td>';
                fila += '<td data-toggle="tooltip" title="' + data.datos[i].user_nom + '">' + data.datos[i].user + '</td>';
                fila += '</tr>';
                $("#listaHistorial").append(fila);
            }

            ultimoestado = data.datos[0].estado_id;
            ultimoestadotipo = data.datos[0].estado_tipo;
            $("#estadoactual").html("Ultimo Estado : <b>" + ultimoestadotipo + "</b>");
            deshabilitabotones();
            $('#limpiar-memo').hide();
            if(depto==87){
                $("#agregar-det-memo").show();
                document.getElementById('agregar-det-memo').setAttribute('href','vs_detallememo.php?memId='+data.datos.mem_id);
            }else if(depto==9){
                //console.log('paso por depto 9');
                if(ultimoestado==1 || ultimoestado==2){
                    $('#editar-memo').show();
                }
                //if(ultimoestado == 2 || ultimoestado == 4 || ultimoestado == 5 ||  ultimoestado == 9 || ultimoestado == 11){
                if(ultimoestado==3 || ultimoestado==7 || ultimoestado==10 || ultimoestado==14){
                    $("#cambiaestado").hide();
                }else{
                    $("#cambiaestado").show();
                    getlistaEstadosMemo(ultimoorden);
                }
            }

        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( " La solicitud getlistaHistorialEstado ha fallado,  textStatus : " +  textStatus 
                    + " \n errorThrown : "+ errorThrown
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
        });
    }
    //Funcion que lista el historial de Estados del memo
    function getlistaHistorialObs(memId){
        var datax = {"Accion":"listar",
                     "memobsMemid": memId
                    };
        $.ajax({
            data: datax, 
            type: "GET",
            dataType: "json", 
            url: "controllers/controllermemoobservacion.php", 
        })
        .done(function( data, textStatus, jqXHR ) {
            /*if ( console && console.log ) {
                console.log( " data success getlistaHistorialObs : "+ data.success 
                    + " \n data msg deptos : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }*/
            $("#listaHistorialObs").html(""); 
            var totalHistorialObs = data.datos.length;
            $("#totalObs").html("");
            $("#totalObs").html(totalHistorialObs);
            console.log('Total Observaciones : '+totalHistorialObs);
            
            for(var i=0; i<data.datos.length;i++){
                //console.log('id: ' + data.datos[i].memoobs_id + ' Estado Tipo: ' + data.datos[i].memoobs_texto);
                fila = '<tr><td>'+ data.datos[i].memoobs_texto + '</td>';
                fila += '<td>' + data.datos[i].memoobs_fecha + '</td>';
                fila += '<td>' + data.datos[i].memoobs_usu_nom + '</td>';
                fila += '</tr>';
                $("#listaHistorialObs").append(fila);
            }
            
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( " La solicitud getlistaHistorialObs ha fallado,  textStatus : " +  textStatus 
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
    //Funcion que lista Los archivos adjuntos del Memo
    function getlistaArchivos (memId){
        var datax = {"Accion":"listar",
                     "memoid": memId
                    };
        $.ajax({
            data: datax, 
            type: "GET",
            dataType: "json", 
            url: "controllers/controllermemoarchivo.php", 
        })
        .done(function( data, textStatus, jqXHR ) {
            /*if ( console && console.log ) {
                console.log( " data success getlistaArchivos : "+ data.success 
                    + " \n data msg deptos : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }*/
            var totalanexos=data.datos.length;
            $("#totalArch").html(totalanexos);
            //Lista archivos del memo
            console.log('Total Archivos ' + data.datos.length);
            $("#verarchivoMemo").html("");
            $("#verlistaArchivosMemo").html("");

            for(var i=0; i<data.datos.length;i++){
                //console.log('id archivo : ' + data.datos[i].memoarch_id + ' Nombre archvo: ' + data.datos[i].memoarch_name);
                if(data.datos[i].memoarch_flag == 1){
                    $("#msgarchivomemo").show();
                    fila2 = '<tr><td><a href="'+data.datos[i].memoarch_url+'" target="_blank">'+ data.datos[i].memoarch_name + '</a></td>';
                    fila2 += '<td>' + returnFileSize(data.datos[i].memoarch_size)+'</td>';
                    fila2 += '</tr>';
                    $("#verarchivoMemo").append(fila2);
                }else{
                    fila3 = '<tr><td><a href="'+data.datos[i].memoarch_url+'" target="_blank">'+ data.datos[i].memoarch_name + '</a></td>';
                    fila3 += '<td>' + returnFileSize(data.datos[i].memoarch_size) + '</td>';
                    fila3 += '</tr>';
                    $("#verlistaArchivosMemo").append(fila3);
                }
            }
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( " La solicitud getlistaarchivos ha fallado,  textStatus : " +  textStatus 
                    + " \n errorThrown : "+ errorThrown
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
        });
    }    
    //funcion levanta modal y muestra  los datos del centro de costo cuando presion boton Ver/Editar, aca se puede mdificar si quiere
    function verMemo(memId,depto){
        deshabilitabotones();
        var datay = {"memoId": memId,
                     "Accionmem":"obtener",
                     "depto":depto
                    };
        $.ajax({
            data: datay, 
            type: "POST",
            dataType: "json", 
            url: "controllers/controllermemo.php",
        })
        .done(function(data,textStatus,jqXHR ) {
            $('#titulo').text('Datos del Memo');
            /*if ( console && console.log ) {
                console.log( " data success : "+ data.success 
                    + " \n data msg : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }*/
            $("#memoId").val(data.datos.mem_id);
            $("#memoFecha").val(data.datos.mem_fecha);
            $("#memoNum").val(data.datos.mem_numero);
            $("#memoAnio").val(data.datos.mem_anio);
            $("#memoFechaRecep").val(data.datos.mem_fecha_recep);
            $("#memoMateria").val(data.datos.mem_materia);
            $("#memoNombreSol").val(data.datos.mem_nom_sol);
            $("#memoDeptoSol").val(data.datos.mem_depto_sol_id);
            $("#memoNombreDest").val(data.datos.mem_nom_dest);
            $("#memoDeptoDest").val(data.datos.mem_depto_dest_id);

            if(data.datos.mem_cc_codigo!=0){
                $("#datosCcostos").hide();
                $("#verCodigoCC").val(data.datos.mem_cc_codigo);
                $("#verFechaCDP").val(data.datos.mem_fecha_cdp);
                $("#verNombreCC").val(data.datos.mem_nom_cc);
            }
            //$("#meId").val(memId);
            //$("#uId").val(uid);
                $('#paneles').show();
                $('#accordion0').hide();
                $('#panel-heading').hide();
                $('#buscarDS').hide();
                $('#buscarDD').hide();
            getlistaHistorialEstado(data.datos.mem_id,depto);
            getlistaArchivos(data.datos.mem_id);
            getlistaHistorialObs(data.datos.mem_id);
            getlistaHistorialDeriv(data.datos.mem_id);
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( " La solicitud MEMO ha fallado,  textStatus : " +  textStatus 
                    + " \n errorThrown : "+ errorThrown
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
        });
    }
    $(document).ready(function(){
        $("#memoOtroDeptoId").selectpicker();
        $('#memoFecha').val(fechaActual());
        $('#memoAnio').val(anioActual());

        $('#memoBuscaDepto').keypress(function () {
            var valthis = $(this).val().toLowerCase();
            var num = 0;
            $('select#memoDeptoSol>option').each(function () {
                var text = $(this).text().toLowerCase();
                if(text.indexOf(valthis) !== -1){
                    $(this).show(); $(this).prop('selected',true);
                }else{
                    $(this).hide();
                }
            });
        });

        $('#memoBuscaDeptoD').keypress(function () {
            var valthis = $(this).val().toLowerCase();
            var num = 0;
            $('select#memoDeptoDest>option').each(function () {
                var text = $(this).text().toLowerCase();
                if(text.indexOf(valthis) !== -1){
                    $(this).show(); $(this).prop('selected',true);
                }else{
                    $(this).hide();
                }
            });
        });

        $('#memoBuscaDeptoDer').keypress(function () {
            var valthis = $(this).val().toLowerCase();
            var num = 0;
            $('select#memoOtroDeptoId>option').each(function () {
                var text = $(this).text().toLowerCase();
                if(text.indexOf(valthis) !== -1){
                    $(this).show(); $(this).prop('selected',true);
                }else{
                    $(this).hide();
                }
            });
        });        

        function inicio(){
            $(".help-block").hide();
            $('#paneles').hide();
            $("#cambiaestado").hide();
            $("#agregar-det-memo").hide();
            /*$("#memoFechaCDPDiv").hide();
            $("#memoCodigoCCDiv").hide();
            $("#memoNombreCCDiv").hide();*/
            $("#datosCcostos").hide();
            $("#memoOtroDepto").hide();
            $("#buscarDerivado").hide();
            $("#memoOtroDeptoNombre").hide();
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
        
        if (typeof memId !== 'undefined'){
            verMemo(memId, depto);
            //getlistaCcostos();
            deshabilitaform();
            $("#msgarchivomemo").hide();
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

        $("#agrega-archivo").click(function(e){
            $('#addmemoFile').val(null);
            $("#addarchivoMemo").html("");
            $("#addmemoFileInfo").hide();
            $("#grabar-archivomemo").hide();
            //$("#msgarchivomemo").hide();
        });

        $("#agrega-archivo-otros").click(function(e){
            $('#addmemoFileList').val(null);
            $("#addarchivoMemoList").html("");
            $("#addmemoFileListInfo").hide();
            $("#grabar-otrosarchivomemo").hide();
            //$("#msgarchivomemo").hide();
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
        // Funcion cuando se agrega el memo escaneado
        $("#addmemoFile").change(function() {
            $("#addarchivoMemo").html("");
            //Creamos un objeto con el elemento que contiene los archivos: el campo input file, que tiene el id = 'archivos'
            var archivos = document.getElementById("addmemoFile");
            //Obtenemos los archivos seleccionados en el imput
            var archivo = archivos.files; 
            //console.log(archivo.length);
            if(archivo.length===0){
                console.log('paso por nada');
                $("#addmemoFileInfo").show();
                $("#addmemoFileInfo").append("No ha seleccionado archivo para subir");
                $("#grabar-archivomemo").hide();
            }else{
                console.log('paso por algo');
                $("#grabar-archivomemo").show();
                $("#addmemoFileInfo").hide();
                var nombre = archivo[0].name;
                var peso = returnFileSize(archivo[0].size);
                var lista = `<tr>
                <td>${nombre}</td>
                <td>${peso}</td>
                </tr>`;
                $("#addarchivoMemo").append(lista);
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
        $("#addmemoFileList").change(function() {
            $("#addarchivoMemoList").html("");
            var archivos = document.getElementById("addmemoFileList");//Creamos un objeto con el elemento que contiene los archivos: el campo input file, que tiene el id = 'archivos'
            var archivo = archivos.files; //Obtenemos los archivos seleccionados en el imput
            if(archivo.length===0){
                $("#addmemoFileListInfo").show();
                $("#addmemoFileListInfo").append("No ha seleccionado archivos para subir");
                $("#grabar-otrosarchivomemo").hide();
            }else{
                $("#grabar-otrosarchivomemo").show();
                $("#addmemoFileListInfo").hide();
                for(i=0; i<archivo.length; i++){
                    var lista="<tr>";
                    lista += "<td>"+archivo[i].name+"</td>";
                    lista += "<td>"+returnFileSize(archivo[i].size)+"</td>";
                    /*lista += "<td><button type='button' id='quitarfile' class='close' onclick='quitafile(\'"+i+"\')'>&times;</button></td>";*/
                    lista += "</tr>";
                    $("#addarchivoMemoList").append(lista);                    
                }
            }
        });        
        //funcion cuando cambia el select de estado del memo
        $("#memoEstado").change(function(e){
            e.preventDefault();
            var posidestado = document.getElementById("memoEstado").selectedIndex;
            var idestado = $('#memoEstado').val();
            console.log('pos estado: ' + posidestado);
            console.log('estado: ' + idestado);
            if(idestado==5){
                $("#memoOtroDepto").show();
                //$("#buscarDerivado").show();
                $("#memoOtroDeptoNombre").show();
            }else if(idestado==11 || idestado==14){
                $("#memoOtroDeptoNombre").show();
                $("#memoOtroDepto").hide();
            }else{
                $("#memoOtroDepto").hide();
                //$("#buscarDerivado").hide();
                $("#memoOtroDeptoNombre").hide();
            }
        });

        $("#cambiaestado").click(function(e) {
            e.preventDefault();
            limpiaformcambioestado();
            var posidestado = document.getElementById("memoEstado").selectedIndex;
            var idestado = $('#memoEstado').val();
            console.log('estado id : ' + idestado);

            if(idestado==11 || idestado==14){
                $("#memoOtroDeptoNombre").show();
                $("#memoOtroDepto").hide();
            }else{
                $("#memoOtroDeptoNombre").hide();
                $("#memoOtroDepto").hide();
            }
        });

        //funcion que graba datos basicos del memo para adquisiciones, recibios por la DAF
        $("#grabar-memo").click(function(e){
            e.preventDefault();
            if(validarFormulario()==true){
                var inpt = document.createElement('INPUT');
                inpt.type="hidden";
                inpt.name="uid";
                inpt.id="uid";
                inpt.value=uid;
                document.formIngresoMemo.appendChild(inpt);
                var inpt2 = document.createElement('INPUT');
                inpt2.type="hidden";
                inpt2.name="tiporeg";
                inpt2.id="tiporeg";
                inpt2.value="recepcion";
                document.formIngresoMemo.appendChild(inpt2);
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
        // funcion que actualiza solo algunos datos del memo
        $("#actualizar-memo").click(function(e){
            e.preventDefault();
            if(validarFormulario()==true){
                //var datax = $("#formIngresoMemo").serializeArray();
                /*$.each(datax, function(i, field){
                    console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                });*/
                var $loader = $('.loader');
                var formData = new FormData(document.getElementById("formIngresoMemo"));
                $.ajax({
                    data: formData, 
                    type: "POST",
                    dataType: "json", 
                    url: "controllers/controllermemo.php",
                    cache:false,
                    contentType:false,
                    processData:false
                    /*beforeSend: function(){
                        $('#ModalCargando').modal('show');
                        $('#ModalCargando').on('shown.bs.modal', function () {
                            $loader.show();
                        });
                    }*/                    
                })
                .done(function( data, textStatus, jqXHR ) {
                    if ( console && console.log ) {
                        console.log( " data success : "+ data.success 
                            + " \n data msg buscares : "+ data.message 
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }
                    console.log('recibe respuesta');
                    /*$('#ModalCargando').modal('hide');
                    $('#ModalCargando').on('hidden.bs.modal', function () {*/
                        $('#myModalLittle').modal('show');
                        $('#myModalLittle').on('shown.bs.modal', function () {
                            console.log('entra a abrir modal msg');
                            //deshabilitaform();
                            $(this).restauraverdatos();
                            var modal2 = $(this);
                            modal2.find('.modal-title').text('Mensaje');
                            modal2.find('.msg').text(data.message);
                            $('#cerrarModalLittle').focus();
                        });
                    //});
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
        //funcion que graba cambios de estados del memo
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
                            limpiaformcambioestado();
                            getlistaHistorialEstado(memId,depto);
                            getlistaHistorialDeriv(memId);
                            if(depto==9){
                                if(ultimoestado==1 || ultimoestado==2){
                                    $("#editar-memo").hide();
                                }
                                //if(ultimoestado==2 || ultimoestado==5 || ultimoestado==10 || ultimoestado==11){
                                if(ultimoestado==3 || ultimoestado==7 || ultimoestado==10 || ultimoestado==14){
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
        //funcion que graba las observaciones al memo
        $("#grabar-addobs").click(function(e){
            e.preventDefault();
            var inptuid = document.createElement('input');
            inptuid.type="hidden";
            inptuid.name="memobsUsuid";
            inptuid.value=uid;
            document.formobservacion.appendChild(inptuid);

            var inptmemid = document.createElement('input');
            inptmemid.type="hidden";
            inptmemid.name="memobsMemid";
            inptmemid.value=memId;
            document.formobservacion.appendChild(inptmemid);

            if(validarFormularioObservacion()==true){
                var datax = $("#formobservacion").serializeArray();
                $.each(datax, function(i, field){
                    console.log("contenido del form observacion = "+ field.name + ":" + field.value + " ");
                });
                var $loader = $('.loader');
                var formData = new FormData(document.getElementById("formobservacion"));
                $.ajax({
                    data: formData, 
                    type: "POST",
                    dataType: "json", 
                    url: "controllers/controllermemoobservacion.php",
                    cache:false,
                    contentType:false,
                    processData:false,
                    beforeSend: function(){
                        $('#myModalObsMemo').modal('hide');
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
                            limpiaformobservacion();
                            getlistaHistorialObs(memId);
                        });
                    });
                    
                })
                .fail(function( jqXHR, textStatus, errorThrown ) {
                    limpiaformobservacion();
                    if ( console && console.log ) {
                        console.log( " La solicitud GRABA ESTADO ha fallado,  textStatus : " +  textStatus 
                            + " \n errorThrown : "+ errorThrown
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }
                });
            }
        });        
        //funcion que graba el archivo del memo tiempo posterior a su ingreso 
        $("#grabar-archivomemo").click(function(e){
            e.preventDefault();
            var inptuid = document.createElement('input');
            inptuid.type="hidden";inptuid.name="uId";inptuid.value=uid;
            document.formarchivomemo.appendChild(inptuid);

            var inptmemid = document.createElement('input');
            inptmemid.type="hidden";inptmemid.name="meId";inptmemid.value=memId;
            document.formarchivomemo.appendChild(inptmemid);

            var inptmemid = document.createElement('input');
            inptmemid.type="hidden";inptmemid.name="meAnio";inptmemid.value=$("#memoAnio").val();;
            document.formarchivomemo.appendChild(inptmemid);

            var inptmemid = document.createElement('input');
            inptmemid.type="hidden";inptmemid.name="meNum";inptmemid.value=$("#memoNum").val();;
            document.formarchivomemo.appendChild(inptmemid);

            /* var idestado = $('#memoEstado').val();
            console.log('seleccion estado :'+idestado);*/
            
                var datax = $("#formarchivomemo").serializeArray();
                /*$.each(datax, function(i, field){
                    console.log("contenido del form FILES = "+ field.name + ":" + field.value + " ");
                });*/
                var $loader = $('.loader');
                var formData = new FormData(document.getElementById("formarchivomemo"));
                console.log(formData);
                $.ajax({
                    data: formData, 
                    type: "POST",
                    dataType: "json", 
                    url: "controllers/controllermemoarchivo.php",
                    cache:false,
                    contentType:false,
                    processData:false,
                    beforeSend: function(){
                        $('#myModalArchivoMemo').modal('hide');
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
                    getlistaArchivos(memId);
                })
                .fail(function( jqXHR, textStatus, errorThrown ) {
                    if ( console && console.log ) {
                        console.log( " La solicitud GRABA ESTADO ha fallado,  textStatus : " +  textStatus 
                            + " \n errorThrown : "+ errorThrown
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }
                });
        });
        //funcion que graba el archivo del memo tiempo posterior a su ingreso 
        $("#grabar-otrosarchivomemo").click(function(e){
            e.preventDefault();
            var inptuid = document.createElement('input');
            inptuid.type="hidden";inptuid.name="uId";inptuid.value=uid;
            document.formarchivomemootros.appendChild(inptuid);

            var inptmemid = document.createElement('input');
            inptmemid.type="hidden";inptmemid.name="meId";inptmemid.value=memId;
            document.formarchivomemootros.appendChild(inptmemid);

            var inptmemid = document.createElement('input');
            inptmemid.type="hidden";inptmemid.name="meAnio";inptmemid.value=$("#memoAnio").val();;
            document.formarchivomemootros.appendChild(inptmemid);

            var inptmemid = document.createElement('input');
            inptmemid.type="hidden";inptmemid.name="meNum";inptmemid.value=$("#memoNum").val();;
            document.formarchivomemootros.appendChild(inptmemid);

                var datax = $("#formarchivomemootros").serializeArray();
                /*$.each(datax, function(i, field){
                    console.log("contenido del form FILES = "+ field.name + ":" + field.value + " ");
                });*/
                var $loader = $('.loader');
                var formData = new FormData(document.getElementById("formarchivomemootros"));
                console.log(formData);
                $.ajax({
                    data: formData, 
                    type: "POST",
                    dataType: "json", 
                    url: "controllers/controllermemoarchivo.php",
                    cache:false,
                    contentType:false,
                    processData:false,
                    beforeSend: function(){
                        $('#myModalArchivoOtros').modal('hide');
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
                    getlistaArchivos(memId);
                })
                .fail(function( jqXHR, textStatus, errorThrown ) {
                    if ( console && console.log ) {
                        console.log( " La solicitud GRABA ESTADO ha fallado,  textStatus : " +  textStatus 
                            + " \n errorThrown : "+ errorThrown
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }
                });
        });

        //Boton para editar cierto campos del memo
        $("#editar-memo").click(function(e){
            e.preventDefault();//titulo
            $('#titulo').text('Edita Memo');
            habilitaform();
            deshabilitabotones();
            $("#cambiaestado").hide();
            $('#actualizar-memo').show();
            $('#cancelar-memo').show();
            $("#Accionmem").val("actualizar");
        });
        //funcion global restaura ver datos del memo
        $(function(){
            $.fn.restauraverdatos = function(){
                $('#titulo').text('Datos del Memo');
                deshabilitaform();
                deshabilitabotones();
                $("#cambiaestado").show();
                $("#editar-memo").show();
                $('#actualizar-memo').hide();
                $("#Accionmem").val("");
            }
         })
        //Boton para cancelar la edicion del memo
        $("#cancelar-memo").click(function(e){
            e.preventDefault();//titulo
            $(this).restauraverdatos();
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
            /*$("#buscar-res").on("click",function(e){
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
            /*$("#buscaNumRes").on("keydown",function(e){
                if(e.which == 13){      
                    e.preventDefault();
                     buscaRes();
                }
                if(e.which == 8){      
                    $('#msgres').html(""); 
                }             
            });*/
            /*$("#buscaNumRes").on("click",function(e){
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
    });  // Fin del Document ready