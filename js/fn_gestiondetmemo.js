    var depto;
    var ultimoestado=1;
    var ultimoorden=1;
    var uid;
    var medetId;
    var memId;
    var rolid;
    function returnFileSize(number) {
            if(number < 1024) {
                return number + 'bytes';
            } else if(number > 1024 && number < 1048576) {
                return (number/1024).toFixed(1) + ' KB';
            } else if(number > 1048576) {
                return (number/1048576).toFixed(1) + ' MB';
            }
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
    function limpiaformcdp(){
        $('#formcdp')[0].reset();
        $("#CCostoId").selectpicker('render');
        $('#FechaCDP').focus();
    } 
    function limpiaFormDetalle(){
        $('#formDetalleMemo')[0].reset();
        $('#memoDetDescripcion').focus();
    }
    function limpiaFormAsignaMem(){
        $('#formAsignaMem')[0].reset();
        $("#asignadif").val(2).prop('selected',true);
        $("#asignaprio").val(4).prop('selected',true);
        $('#asignausu').focus();        
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
        //console.log('fecha de input : '+txtMemFecha);
        var txtMemNum = document.getElementById('memoNum').value;
        var txtMemAnio = document.getElementById("memoAnio").value;
        var txtMemFechaRec = document.getElementById('memoFechaRecep').value;
        var txtMemMat = document.getElementById('memoMateria').value;
        var txtMemNomSol = document.getElementById('memoNombreSol').value;
        //var selMemDptoSol = document.getElementById('memoDeptoSol').selectedIndex;
        var txtMemNomDest = document.getElementById('memoNombreDest').value;
        //var selMemDptoDest = document.getElementById('memoDeptoDest').selectedIndex;
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
           /* if( selMemDptoSol == null || isNaN(selMemDptoSol) || selMemDptoSol == -1 ) {
                $('#memoDeptoSol').parent().attr('class','form-group has-error');
                $('#memoDeptoSol').parent().children('span').text('Debe seleccionar un Departamento o Unidad Solicitante').show();
                document.getElementById('memoDeptoSol').focus();
                return false;                
            }else{
                $('#memoDeptoSol').parent().attr('class','form-group has-success');
                $('#memoDeptoSol').parent().children('span').text('').hide();
            }*/
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
            /*if( selMemDptoDest == null || isNaN(selMemDptoDest) || selMemDptoDest == -1 ) {
                $('#memoDeptoDest').parent().attr('class','form-group has-error');
                $('#memoDeptoDest').parent().children('span').text('Debe seleccionar un Departamento o Unidad Destinatario').show();
                document.getElementById('memoDeptoDest').focus();
                return false; 
            }else{
                $('#memoDeptoDest').parent().attr('class','form-group has-success');
                $('#memoDeptoDest').parent().children('span').text('').hide();
            }*/
            return true;
    }
    // Funcion valida los datos del formulario del cambio de estado del memo
    function validarFormularioEstado(idestado){
        var selMemoEstado = document.getElementById('memoEstado').selectedIndex;
        var selOtroDeptoId = document.getElementById('memoOtroDeptoId').selectedIndex;
        var txtMemoObs = document.getElementById('memoObs').value;
        var txtDeptoNom = document.getElementById('memoDeptoNombre').value;
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
                    //$('#memoOtroDeptoId').parent().attr('class','form-group has-error');
                    //$('#msgerrordeptoid').text('Debe seleccionar un Departamento').show().attr('class','text-danger');
                    $('#memoOtroDeptoId').parent().attr('class','form-group has-error');
                    $('#memoOtroDeptoId').parent().children('span').text('Debe seleccionar un Departamento o Unidad Destinatario').show();
                    document.getElementById('memoOtroDeptoId').focus();
                    return false;
                }else{
                    //$('#memoOtroDeptoId').parent().attr('class','form-group has-success');
                    //$('#msgerrordeptoid').text('').hide();
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
    // Funcion valida los datos del CDP, fecha, codigo ccosto
    function validarFormularioCDP(){
        var txtFechaCDP = document.getElementById('FechaCDP').value;
        var txtnumCDP = document.getElementById('numeroCDP').value;
        var selCodigoCC = document.getElementById('CCostoId').selectedIndex;
            // valida FECHA RECEPCION MEMO
            if(txtFechaCDP == null || txtFechaCDP.length == 0 || /^\s+$/.test(txtFechaCDP)){
                $('#FechaCDP').parent().attr('class','form-group has-error');
                $('#FechaCDP').parent().children('span').text('Debe ingresar fecha').show();
                document.getElementById('FechaCDP').focus();
                return false;
            }else{
                if( validarFormatoFecha(txtFechaCDP)){
                    if(existeFecha(txtFechaCDP)){
                        $('#FechaCDP').parent().attr('class','form-group has-success');
                        $('#FechaCDP').parent().children('span').text('').hide();
                    }else{
                        $('#FechaCDP').parent().attr('class','form-group has-error');
                        $('#FechaCDP').parent().children('span').text('La fecha introducida no es valida.').show();
                        document.getElementById('FechaCDP').focus();
                        return false;
                    }
                }else{
                    $('#memoFechaRecep').parent().attr('class','form-group has-error');
                    $('#memoFechaRecep').parent().children('span').text('El formato de la fecha es incorrecto.').show();
                    document.getElementById('memoFechaRecep').focus();
                    return false;                
                }
            }
            //valida numero del CDP
            if(txtnumCDP == null || txtnumCDP.length == 0 || /^\s+$/.test(txtnumCDP)){
                $('#numeroCDP').parent().attr('class','form-group has-error');
                $('#numeroCDP').parent().children('span').text('El campo Numero CDP no debe ir vacío o con espacios en blanco').show();
                document.getElementById('numeroCDP').focus();
                return false;                
            }else{
                $('#numeroCDP').parent().attr('class','form-group has-success');
                $('#numeroCDP').parent().children('span').text('').hide();
            }
            //valida select con codigo del centro de costo
            if( selCodigoCC == null || isNaN(selCodigoCC) || selCodigoCC == -1 || selCodigoCC == 0) {
                $('#CCostoId').parent().attr('class','form-group has-error');
                $('#CCostoId').parent().children('span').text('Debe seleccionar un Centro de Costo').show();
                document.getElementById('CCostoId').focus();
                return false;                
            }else{
                $('#CCostoId').parent().attr('class','form-group has-success');
                $('#CCostoId').parent().children('span').text('').hide();
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
    /*--------------------------------------------------------------------------*/
    //funcion trae asignaciones del memo para mostrar en el modal, OK funcion
    function getlistaUsuAsignaMemo(memid){
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
                /*if ( console && console.log ) {
                    console.log( " data success asignados : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }*/                
                $("#listusuasigna").html(""); 
                var totalUsu = data.datos.length;
                $("#totalUsu").html("");
                $("#totalUsu").html(totalUsu);
                if(data.datos.length>0){
                    $("#listadoasigna").show();
                    $("#resultasigna").hide();
                    for(var i=0; i<data.datos.length;i++){
                        fila = '<tr>';
                        fila += '<td>'+ data.datos[i].asigna_usu_fecha +'</td>';
                        fila += '<td>'+ data.datos[i].asigna_usu_nom +'</td>';
                        fila += '<td>'+ data.datos[i].asigna_usu_coment +'</td>';
                        if(data.datos[i].asigna_usu_estado_id == 1){
                            fila += '<td class="text-danger">';
                        }else{
                            fila += '<td>';
                        }
                        fila += data.datos[i].asigna_usu_estado +'</td>';
                        fila += '<td>'+ data.datos[i].asigna_usu_fecha_mod +'</td>';
                        fila += '<td>'+ data.datos[i].asigna_usu_dificultad +'</td>';
                        fila += '<td>'+ data.datos[i].asigna_usu_prioridad +'</td>';
                        fila += '</tr>';
                        $("#listusuasigna").append(fila);
                        if(data.datos[i].asigna_usu_uid==uid){
                            $("#agregar-det-memo").show();
                            $('#agregarcdp').show();
                            $('#agrega-res').show();
                        }

                    }
                }else{
                    $('#resultasignamsg').html("");
                    $("#resultasigna").show();
                    $('#resultasignamsg').append(data.message);
                }
            })
            .fail(function( jqXHR, textStatus, errorThrown ) {
                if ( console && console.log ) {
                    console.log( " La solicitud asignados ha fallado,  textStatus : " +  textStatus 
                        + " \n errorThrown : "+ errorThrown
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
            });            
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
            $("#memoOtroDeptoId").html("");
                /*if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg deptos : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }*/
            $("#memoOtroDeptoId").append('<option value="0">Seleccionar...</option>');
            for(var i=0; i<data.datos.length;i++){
                   // console.log('id: ' + data.datos[i].depto_id + ' nombre Depto: ' + data.datos[i].depto_nombre);
                opcion = '<option value=' + data.datos[i].depto_id + '>' + data.datos[i].depto_nombre + '</option>';
                $("#memoOtroDeptoId").append(opcion);
            }
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
            $("#CCostoId").html("");
            /*if ( console && console.log ) {
                console.log( " data success : "+ data.success 
                    + " \n data msg deptos : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }*/
            $("#CCostoId").append('<option value="0">Seleccionar...</option>');
            for(var i=0; i<data.datos.length;i++){
                // console.log('id: ' + data.datos[i].depto_id + ' nombre Depto: ' + data.datos[i].depto_nombre);
                opcion = '<option value=' + data.datos[i].ccosto_codigo + '>' + data.datos[i].ccosto_codigo + ' - ' + data.datos[i].ccosto_nombre + '</option>';
                $("#CCostoId").append(opcion);
            }
            $("#CCostoId").selectpicker();
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
        //console.log('estado funcion : ' + ultestado);
        //console.log('estado global : ' + ultimoestado);
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
            $("#memoEstado").html("");
            /*if ( console && console.log ) {
                console.log( " data success : "+ data.success 
                    + " \n data msg memest : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }*/
            //console.log('ultimoestado: ' + ultimoestado);
            var inicio=0;var fin=data.datos.length;

                //console.log('estado posibles: ');
                for(var i=inicio; i<fin; i++){
                    //console.log('id: ' + data.datos[i].memo_est_id + ' nombre EstadoMemo: ' + data.datos[i].memo_est_tipo);
                    opcion = '<option value=' + data.datos[i].memo_est_id + '>' + data.datos[i].memo_est_tipo + '</option>';
                    $("#memoEstado").append(opcion);
                }
                //primero de la lista, inicio posicion + 1, valor del value
                $("#memoEstado").val(data.datos[0].memo_est_id);

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
        //console.log(depto);
        var datax = {"Accionmem":"listarestmemo",
                     "memoId": memId,
                     "depto":depto[0]
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

            //console.log('Total Estados : '+totalHistorial);
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
            //usar este estado para generalizar las vistas de estos botones
            //queda pendiente esta modificacion (09072019 fsegovia)
            ultimoestadogenid = data.datos[0].estado_gen_id;
            //console.log('ultimo estado generico : '+ultimoestadogenid);
            ultimoestado = data.datos[0].estado_id;
            $("#ultimoEstado").val(ultimoestado);
            $("#memoultest").val(ultimoestado);
            ultimoestadotipo = data.datos[0].estado_tipo;
            $("#estadoactual").html("Ultimo Estado : <b>" + ultimoestadotipo + "</b>");
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
    function getlistaHistorialDetalles(memId){
        var datax = {"Accion":"listar",
                     "memoId": memId
                    };
        $.ajax({
            data: datax, 
            type: "GET",
            dataType: "json", 
            url: "controllers/controllermemodetalle.php", 
        })
        .done(function( data, textStatus, jqXHR ) {
            /*if ( console && console.log ) {
                console.log( " data success getlistaHistorialDetalles : "+ data.success 
                    + " \n data msg deptos : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }*/
            $("#listaHistorialDet").html(""); 
            var totalHistorialDet = data.datos.length;
            $("#totalDet").html("");
            $("#totalDet").html(totalHistorialDet);
           // console.log('Total HistorialDet : '+totalHistorialDet);
            if(data.datos.length>0){
                $("#listadodet").show();
                $("#resultdet").hide();
                for(var i=0; i<data.datos.length;i++){
                    //console.log('id: ' + data.datos[i].memoobs_id + ' Estado Tipo: ' + data.datos[i].memoobs_texto);
                    fila = '<tr><td>'+ data.datos[i].memo_detalle_detmemocc + '</td>';
                    fila += '<td>' + data.datos[i].memo_detalle_procompra_nom + '</td>';
                    fila += '<td>' + data.datos[i].memo_detalle_num_oc_chc + '</td>';
                    fila += '<td>' + data.datos[i].memo_detalle_num_oc_sac + '</td>';
                    fila += '<td>' + new Intl.NumberFormat("es-CL", {style: "currency", currency: "CLP"}).format(data.datos[i].memo_detalle_monto_total) + '</td>';
                    fila += '<td>' + data.datos[i].memo_detalle_proveedor_nom + '</td>';
                    fila += '<td>' + data.datos[i].memo_detalle_fecha + '</td>';
                    //fila += '<td>' + data.datos[i].memo_detalle_estado_nom + '</td>';
                    fila += '<td><a href="#" data-toggle="tooltip" title="' + data.datos[i].memo_detalle_estado_fecha + '">'+data.datos[i].memo_detalle_estado_nom +'</a></td>';
                    fila += '<td>' + data.datos[i].memo_detalle_usu_nom + '</td>';
					fila += '<td class="text-left"><a  href="vs_gestiondetmemo.php?medetId=' + data.datos[i].memo_detalle_id + '"';
                    fila += ' class="btn btn-xs btn-success" role="button id="ver-memo"> Ver</a>';
                    fila += '</td>';
                    fila += '</tr>';
                    $("#listaHistorialDet").append(fila);
                }
            }else{
                $('#resultdetmsg').html("");
                $("#resultdet").show();
                $('#resultdetmsg').append("Memo sin Detalles agregados");
            }
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( " La solicitud  getlistaHistorialDetalles ha fallado,  textStatus : " +  textStatus 
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
            //console.log('Total Observaciones : '+totalHistorialObs);
            if(data.datos.length>0){
                $("#listadoobs").show();
                $("#resultobs").hide();
                for(var i=0; i<data.datos.length;i++){
                    //console.log('id: ' + data.datos[i].memoobs_id + ' Estado Tipo: ' + data.datos[i].memoobs_texto);
                    fila = '<tr><td>'+ data.datos[i].memoobs_texto + '</td>';
                    fila += '<td>' + data.datos[i].memoobs_fecha + '</td>';
                    fila += '<td>' + data.datos[i].memoobs_usu_nom + '</td>';
                    fila += '</tr>';
                    $("#listaHistorialObs").append(fila);
                }
            }else{
                $('#resultobsmsg').html("");
                $("#resultobs").show();
                $('#resultobsmsg').append(data.message);
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
            $("#totalDeriva").html(totalHistorialDev);
            //console.log('Total Derivados : '+totalHistorialDev);

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
            //console.log('Total Archivos ' + data.datos.length);
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
    //Funcion que lista las resoluciones agregadas al memo
    /* TERMINAR */
    function getlistaResoluciones (memid){
        var datax = {
            'Accion':'listarmin',
            'memId': memid,
        }
        $.ajax({
            data: datax, 
            type: "GET",
            dataType: "json", 
            url: "controllers/controllermemoresolucion.php", 
        })
        .done(function( data, textStatus, jqXHR ) {
            /*if ( console && console.log ) {
                console.log( " data success : "+ data.success 
                    + " \n data msg memest : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }*/
            $("#listaHistorialRes").html("");
            var totalHistorialRes = data.datos.length;
            $("#totalRes").html("");
            $("#totalRes").html(totalHistorialRes);
            if(data.datos.length>0){
                $("#listadores").show();
                $("#resultres").hide();
                for(var i=0; i < totalHistorialRes; i++){
                    fila = '<tr>';
                    fila += '<td>'+ data.datos[i].mem_asoc_resanio +' - ' + data.datos[i].mem_asoc_resnum + '</td>';
                    fila += '<td><a target="_blank" href="' + data.datos[i].mem_asoc_resurl + '">' + data.datos[i].mem_asoc_resurl + '</a></td>';
                    fila += '<td>' + data.datos[i].mem_asoc_resfecha + '</td>';
                    fila += '</tr>';
                    $("#listaHistorialRes").append(fila);
                }
            }else{
                $('#resultresmsg').html("");
                $("#resultres").show();
                $('#resultresmsg').append(data.message);
            }
                //primero de la lista, inicio posicion + 1, valor del value
                //$("#memoEstado").val(data.datos[0].memo_est_id);
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( " La solicitud getlistaResoluciones ha fallado,  textStatus : " +  textStatus 
                    + " \n errorThrown : "+ errorThrown
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
        });
    }
    //funcion que lista los CDP del memo
    function getlistamemoCDP (memid){
        var datax = {
            'Accion':'listarcdp',
            'memId': memid,
        }
        $.ajax({
            data: datax, 
            type: "GET",
            dataType: "json", 
            url: "controllers/controllermemocdp.php", 
        })
        .done(function( data, textStatus, jqXHR ) {
            /*if ( console && console.log ) {
                console.log( " data success : "+ data.success 
                    + " \n data msg memest : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }*/
            $("#listacdp").html("");
            var totalCDP = data.datos.length;
            $("#totalCdp").html("");
            $("#totalCdp").html(totalCDP);
            if(data.datos.length>0){
                $("#listadocdp").show();
                $("#resultcdp").hide();
                $("#detmemocc").html("");
                for(var i=0; i < totalCDP; i++){
                    fila = '<tr>';
                    fila += '<td>'+ data.datos[i].memocdp_fecha + '</td>';
                    fila += '<td>'+ data.datos[i].memocdp_num + '</td>';
                    fila += '<td>'+ data.datos[i].memocdp_cod_cc + '</td>';
                    fila += '<td>'+ data.datos[i].memocdp_nom_cc + '</td>';
                    fila += '<td>'+ data.datos[i].memocdp_obs + '</td>';
                    fila += '</tr>';
                    $("#listacdp").append(fila);
                    opcion = '<option value=' + data.datos[i].memocdp_cod_cc + '>' + data.datos[i].memocdp_cod_cc + ' - ' + data.datos[i].memocdp_nom_cc + '</option>';
                    $("#detmemocc").append(opcion);
                }
                $("#detmemocc").selectpicker();
            }else{
                $('#resultcdpmsg').html("");
                $("#resultcdp").show();
                $('#resultcdpmsg').append(data.message);
            }
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( " La solicitud getlistamemoCDP ha fallado,  textStatus : " +  textStatus 
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
                $("#asignausu").html(""); 
                /*if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data usuarios msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }*/
                usuarios=data.datos;
                $("#asignausu").append('<option value="">Seleccione...</option>'); 
                for(var i=0; i<data.datos.length;i++){
                    //console.log('id: ' + data.datos[i].usu_id + ' nombre: ' + data.datos[i].usu_nombre);
                    opcion = '<option value=' + data.datos[i].usu_id + '>' + data.datos[i].usu_nombre + '</option>';
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
    //Listado proveedores    getListadoProveedores
    function getListadoProveedores(){
            var datax = {
                "Accion":"listar"
            }
            $.ajax({
                data: datax, 
                type: "GET",
                dataType: "json", 
                url: "controllers/controllerproveedor.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#detmemoprov").html("");
                /* if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }*/
                $("#detmemoprov").append('<option value="">Seleccione...</option>'); 
                for(var i=0; i<data.datos.length;i++){
                    opcion = '<option value=' + data.datos[i].prov_id + '>' + data.datos[i].prov_rut+ '-' + data.datos[i].prov_nombre + '</option>';
                    $("#detmemoprov").append(opcion);                                
                }
                $("#detmemoprov").selectpicker();

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
    //Listado procedimiento de compra, OK funciona
    function getListadoProceCompra(){
            var datax = {
                "Accion":"listar"
            }
            $.ajax({
                data: datax, 
                type: "GET",
                dataType: "json", 
                url: "controllers/controllerprocedimientocompra.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#detmemoprocompra").html("");
                /* if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }*/
                $("#detmemoprocompra").append('<option value="">Seleccione...</option>'); 
                for(var i=0; i<data.datos.length;i++){
                    opcion = '<option value=' + data.datos[i].proc_comp_id + '>' + data.datos[i].proc_comp_tipo + '</option>';
                    $("#detmemoprocompra").append(opcion);                                
                }
                $("#detmemoprocompra").selectpicker();

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
    //funcion levanta modal y muestra  los datos del centro de costo cuando presion boton Ver/Editar, aca se puede mdificar si quiere
    function verMemo(memoId,depto){
        var datay = {"memoId": memoId,
                     "Accionmem":"obtener",
                     "depto":depto,
                     "uid":uid
                    };
        $.ajax({
            data: datay, 
            type: "POST",
            dataType: "json", 
            url: "controllers/controllermemo.php",
        })
        .done(function(data,textStatus,jqXHR ) {
            //$('#titulo').text('Gestión Memo');
            /*if ( console && console.log ) {
                console.log( " data success : "+ data.success 
                    + " \n data msg : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }*/
            $("#memnum").text(data.datos.mem_id);
            $("#memfec").text(data.datos.mem_fecha);
            $("#memmat").text(data.datos.mem_materia);
            $("#memnsol").text(data.datos.mem_nom_sol);
            $("#memdsol").text(data.datos.mem_depto_sol_nom);

            /*$("#memoId").val(data.datos.mem_id);
            $("#memoFecha").val(data.datos.mem_fecha);
            $("#memoNum").val(data.datos.mem_numero);
            $("#memoAnio").val(data.datos.mem_anio);
            $("#memoFechaRecep").val(data.datos.mem_fecha_recep);
            $("#memoMateria").val(data.datos.mem_materia);
            $("#memoNombreSol").val(data.datos.mem_nom_sol);
            $("#memoDeptoSol").val(data.datos.mem_depto_sol_nom);
            $("#memoNombreDest").val(data.datos.mem_nom_dest);
            $("#memoDeptoDest").val(data.datos.mem_depto_dest_nom);

                $('#paneles').show();
                $('#panel-heading').hide();
                $('#buscarDS').hide();
                $('#buscarDD').hide();
            $("#memoId").val(data.datos.mem_id);
            $("#memocpdId").val(data.datos.mem_id);

            $("#detmemId").val(data.datos.mem_id);
            $("#detmemonum").val(data.datos.mem_numero);*/
           
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

    //funcion levanta modal y muestra  los datos del centro de costo cuando presion boton Ver/Editar, aca se puede mdificar si quiere
    function verdetMemo(medetId){
        var datay = {"memodetId": medetId,
                     "Accion":"obtener"
                    };
        $.ajax({
            data: datay, 
            type: "POST",
            dataType: "json", 
            url: "controllers/controllermemodetalle.php",
        })
        .done(function(data,textStatus,jqXHR ) {
            //$('#titulo').text('Gestión Memo');
            /*if ( console && console.log ) {
                console.log( " data success : "+ data.success 
                    + " \n data msg : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }*/
            
            //$("#memnum").val(data.datos.mem_id);

            /*$("#memoId").val(data.datos.mem_id);
            $("#memoFecha").val(data.datos.mem_fecha);
            $("#memoNum").val(data.datos.mem_numero);
            $("#memoAnio").val(data.datos.mem_anio);
            $("#memoFechaRecep").val(data.datos.mem_fecha_recep);
            $("#memoMateria").val(data.datos.mem_materia);
            $("#memoNombreSol").val(data.datos.mem_nom_sol);
            $("#memoDeptoSol").val(data.datos.mem_depto_sol_nom);
            $("#memoNombreDest").val(data.datos.mem_nom_dest);
            $("#memoDeptoDest").val(data.datos.mem_depto_dest_nom);

                $('#paneles').show();
                $('#panel-heading').hide();
                $('#buscarDS').hide();
                $('#buscarDD').hide();
            $("#memoId").val(data.datos.mem_id);
            $("#memocpdId").val(data.datos.mem_id);

            $("#detmemId").val(data.datos.mem_id);
            $("#detmemonum").val(data.datos.mem_numero);*/
            console.log('memodi '+data.memo_detalle_memo_id);
            verMemo(data.datos.memo_detalle_memo_id,depto);

            /*getlistaHistorialDetalles(data.datos.mem_id);
            getlistaHistorialEstado(data.datos.mem_id,depto); // tiene log
            getlistaArchivos(data.datos.mem_id);  //  
            getlistaHistorialObs(data.datos.mem_id); //
            getlistaHistorialDeriv(data.datos.mem_id); // tiene log
            getlistaResoluciones(data.datos.mem_id); //
            getlistaUsuAsignaMemo(data.datos.mem_id);
            getlistamemoCDP(data.datos.mem_id);*/
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

    function inicio(){
            $(".help-block").hide();
            $('#paneles').hide();
            $("#cambiaestado").hide();
            
            $("#listadodet").hide();
            $("#resultdet").hide();

            $("#memoOtroDepto").hide();
            $("#memoOtroDeptoNombre").hide();

            $("#agregar-det-memo").hide();

            $('#agregarcdp').hide();
            $('#agrega-res').hide()
            ;
            $("#msgaddcdp").hide();

            $("#listadocdp").hide();
            $("#resultcdp").hide();

            $("#listadoobs").hide();
            $("#resultobs").hide();

            $("#listadores").hide();
            $("#resultres").hide();
            $("#listadoasigna").hide();
            $("#resultasigna").hide();

            $('#asignar').hide();
    }

    $(document).ready(function(){
        $('#memoFecha').val(fechaActual());
        $('#memoAnio').val(anioActual());

        //inicio();
        //getlistaDepto();
        //Aqui llega variable externa por URL via GET
        
        if (typeof medetId !== 'undefined'){
        	console.log(medetId);
            verdetMemo(medetId);

            //getlistaCcostos();
            deshabilitaform();
            $("#msgarchivomemo").hide();
        }else{
        	console.log(medetId);
            $('#grabar-memo').show();
        }


        if(rolid==2){
            //console.log('paso rol '+rolid);
            $('#asignar').show();
        }

        $('[data-toggle="tooltip"]').tooltip();

        $("#memoEstado").focusout(function(){
            validaselectonline($(this));
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

        // Funcion agrega el memo escaneado
        $("#addmemoFile").change(function() {
            $("#addarchivoMemo").html("");
            //Creamos un objeto con el elemento que contiene los archivos: el campo input file, que tiene el id = 'archivos'
            var archivos = document.getElementById("addmemoFile");
            //Obtenemos los archivos seleccionados en el imput
            var archivo = archivos.files; 
            //console.log(archivo.length);
            if(archivo.length===0){
                //console.log('paso por nada');
                $("#addmemoFileInfo").show();
                $("#addmemoFileInfo").append("No ha seleccionado archivo para subir");
                $("#grabar-archivomemo").hide();
            }else{
                //console.log('paso por algo');
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
            //console.log('pos estado: ' + posidestado);
            //console.log('estado: ' + idestado);
            if(idestado==5 || idestado==35){
                $("#memoOtroDepto").show();
                $("#memoOtroDeptoNombre").show();
                if(ultimoestado==1 || ultimoestado==31){
                    $("#memoDeptoNombre").val(document.getElementById('memoNombreDest').value);
                    //$("#memoOtroDeptoId").selectpicker('val',document.getElementById('memoDeptoDest').value );
                }
            }else if(idestado==11 || idestado==14){
                $("#memoOtroDeptoNombre").show();
                $("#memoOtroDepto").hide();
            }else{
                $("#memoOtroDepto").hide();
                $("#memoOtroDeptoNombre").hide();
            }
        });
        $("#detmemoprov").change(function(e){
            //$('#detmemoprovrut').val($("#detmemoprov option:selected").text());
        });
        //funcion que valida boton "agregar-det-memo" se se agrego CDP
        $("#agregar-det-memo").click(function(e) {
            e.preventDefault();
            getListadoProceCompra();
            getListadoProveedores();
            //console.log('total centro costos : '+document.formdetallememo.detmemocc.length);
            if(document.formdetallememo.detmemocc.length>0){
                $("#msgaddcdp").hide();    
            }else{
                $("#msgaddcdp").show();
                //$("#msgcdp").show();
                
            }
        });

        $("#cambiaestado").click(function(e) {
            e.preventDefault();
            limpiaformcambioestado();
            var posidestado = document.getElementById("memoEstado").selectedIndex;
            var idestado = $('#memoEstado').val();
            //console.log('estado id : ' + idestado);
            if(idestado==11 || idestado==14){
                $("#memoOtroDeptoNombre").show();
                $("#memoOtroDepto").hide();
            }else if(idestado==5 || idestado==35){
                $("#memoOtroDepto").show();
                $("#memoOtroDeptoNombre").show();
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
                    /*if ( console && console.log ) {
                        console.log( " data success : "+ data.success 
                            + " \n data msg buscares : "+ data.message 
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }*/
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
        $("#grabar-detmemo").click(function(e){
            e.preventDefault();
            //if(validarFormulario()==true){
                var inpt = document.createElement('INPUT');
                inpt.type="hidden";
                inpt.name="uid";
                inpt.id="uid";
                inpt.value=uid;
                document.formdetallememo.appendChild(inpt);
                //var datax = $("#formIngresoMemo").serializeArray();
                /*$.each(datax, function(i, field){
                    console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                });*/
                var $loader = $('.loader');
                var formData = new FormData(document.getElementById("formdetallememo"));
               /*  var x = document.getElementById("formIngresoMemo").acceptCharset;
                   console.log("charset : " + x);*/
                $.ajax({
                    data: formData, 
                    type: "POST",
                    dataType: "json", 
                    url: "controllers/controllermemodetalle.php",
                    cache:false,
                    contentType:false,
                    processData:false,
                    beforeSend: function(){
                        $('#myModalDetalle').modal('hide');
                        $('#ModalCargando').modal('show');
                        $('#ModalCargando').on('shown.bs.modal', function () {
                            $loader.show();
                        });
                    }
                })
                .done(function( data, textStatus, jqXHR ) {
                    limpiaFormMemo();
                    /*if ( console && console.log ) {
                        console.log( " data success : "+ data.success 
                            + " \n data msg buscares : "+ data.message 
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }*/
                    $('#ModalCargando').modal('hide');
                    $('#ModalCargando').on('hidden.bs.modal', function () {
                        $('#myModalLittle').modal('show');
                        $('#myModalLittle').on('shown.bs.modal', function () {
                            var modal2 = $(this);
                            modal2.find('.modal-title').text('Mensaje');
                            modal2.find('.msg').text(data.message);
                            $('#cerrarModalLittle').focus();
                            getlistaHistorialDetalles(memId);
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
            //}
        });
        //funcion limpia el formulario del modal para agregar CDP
        $("#agregarcdp").click(function(e){
            limpiaformcdp();
        });
        //funcion que graba las observaciones al memo
        $("#grabarcdp").click(function(e){
            e.preventDefault();
            if(validarFormularioCDP()==true){
                var inptuid = document.createElement('input');
                inptuid.type="hidden";
                inptuid.name="uid";
                inptuid.value=uid;
                document.formcdp.appendChild(inptuid);

                var datax = $("#formcdp").serializeArray();
                /*$.each(datax, function(i, field){
                    console.log("contenido del form CDP = "+ field.name + ":" + field.value + " ");
                });*/
                var $loader = $('.loader');
                var formData = new FormData(document.getElementById("formcdp"));
                $.ajax({
                    data: formData, 
                    type: "POST",
                    dataType: "json", 
                    url: "controllers/controllermemocdp.php",
                    cache:false,
                    contentType:false,
                    processData:false,
                    beforeSend: function(){
                        $('#myModalCDPMemo').modal('hide');
                        $('#ModalCargando').modal('show');
                        $('#ModalCargando').on('shown.bs.modal', function () {
                            $loader.show();
                        });
                    }                    
                })
                .done(function( data, textStatus, jqXHR ) {
                    /*if ( console && console.log ) {
                        console.log( " data success : "+ data.success 
                            + " \n data msg buscares : "+ data.message 
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }*/
                    $('#ModalCargando').modal('hide');
                    $('#ModalCargando').on('hidden.bs.modal', function () {
                        $('#myModalLittle').modal('show');
                        $('#myModalLittle').on('shown.bs.modal', function () {
                            var modal2 = $(this);
                            modal2.find('.modal-title').text('Mensaje');
                            modal2.find('.msg').text(data.message);
                            $('#cerrarModalLittle').focus();
                            limpiaformcdp();
                            $("#msgaddcdp").hide();
                            getlistamemoCDP(memId);
                            getlistaHistorialEstado(memId,depto);
                        });
                    });
                })
                .fail(function( jqXHR, textStatus, errorThrown ) {
                    limpiaformcdp();
                    if ( console && console.log ) {
                        console.log( " La solicitud GRABA ESTADO ha fallado,  textStatus : " +  textStatus 
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
            //console.log('seleccion estado :'+idestado);

            if(validarFormularioEstado(idestado)==true){
                var datax = $("#formcambioestado").serializeArray();
                /*$.each(datax, function(i, field){
                    console.log("contenido del form ESTADO = "+ field.name + ":" + field.value + " ");
                });*/
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
                    /*if ( console && console.log ) {
                        console.log( " data success : "+ data.success 
                            + " \n data msg buscares : "+ data.message 
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }*/
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
                /*$.each(datax, function(i, field){
                    console.log("contenido del form observacion = "+ field.name + ":" + field.value + " ");
                });*/
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
                    /*if ( console && console.log ) {
                        console.log( " data success : "+ data.success 
                            + " \n data msg buscares : "+ data.message 
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }*/
                    $('#ModalCargando').modal('hide');
                    $('#ModalCargando').on('hidden.bs.modal', function () {
                        $('#myModalLittle').modal('show');
                        $('#myModalLittle').on('shown.bs.modal', function () {
                            var modal2 = $(this);
                            modal2.find('.modal-title').text('Mensaje');
                            modal2.find('.msg').text(data.message);
                            $('#cerrarModalLittle').focus();
                            $("#resultobs").hide();
                            limpiaformobservacion();
                            getlistaHistorialObs(memId);
                            getlistaHistorialEstado(memId,depto);
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
                //console.log(formData);
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
                    /*if ( console && console.log ) {
                        console.log( " data success : "+ data.success 
                            + " \n data msg buscares : "+ data.message 
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }*/
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
                //console.log(formData);
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
                    /*if ( console && console.log ) {
                        console.log( " data success : "+ data.success 
                            + " \n data msg buscares : "+ data.message 
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }*/
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
        //funcion global restaura ver datos del memo
        $(function(){
            $.fn.restauraverdatos = function(){
                //$('#titulo').text('Gestión Memo');
                deshabilitaform();
                $("#cambiaestado").show();
                $("#editar-memo").show();
                $('#actualizar-memo').hide();
                $("#Accionmem").val("");
            }
        });
        //LEVANTA MODAL RES para buscar y agregar resolucion, 
        $("#agrega-res").click(function(){
            //$("#linkres").text("");
            $('#listado_resol').hide();            
            $("#myModalBuscaRes").modal({
                backdrop: 'static',
                keyboard: false
            });
        });
        //MODAL RES limpia objetos con mensajes y listado de lo buscado
        $("#buscaNumRes").on("click",function(e){
                $('#msgres').html(""); 
                $('#listaresol').text("");
                //$("#linkres").text("");
        });
        //MODAL RES busca resoluciones si presiona boton buscar al final del input
        $("#buscar-res").on("click",function(e){
            e.preventDefault();
            numRes = $("#buscaNumRes").val().trim();
                if(numRes == null || numRes.length == 0 ){
                    $('#msgres').html('<div class="alert alert-danger" id="msgres" role="alert">NO debe ir vacío o espacios en blanco</div>')
                    document.getElementById('buscaNumRes').focus();
                }else{
                    buscaRes();
                }
        });
        //MODAL RES busca resoluciones si presiona enter en el  input
        $("#buscaNumRes").on("keydown",function(e){
                if(e.which == 13){      
                    e.preventDefault();
                        numRes = $("#buscaNumRes").val().trim();
                        if(numRes == null || numRes.length == 0 ){
                            $('#msgres').html('<div class="alert alert-danger" id="msgres" role="alert">NO debe ir vacío o espacios en blanco</div>')
                            document.getElementById('buscaNumRes').focus();
                        }else{
                            buscaRes();
                        }                    
                }
                if(e.which == 8){      
                    $('#msgres').html(""); 
                }             
        });
        //MODAL RES limpia formulario y mensajes
        $("#limpiar-busca_res").click(function(e){
            e.preventDefault();
             $('#formBusquedaRes')[0].reset();
             $('#msgres').html(""); 
             $("#linkres").text("");
             $('#listaresol').text("");
        });
        // MODAL RES Funcion que busca numero de resolucion y devuelve url ubicacion
        function buscaRes(){
            var datax = $("#formBusquedaRes").serializeArray();
                $.ajax({
                    data: datax, 
                    type: "POST",
                    dataType: "json", 
                    url: "http://resoluciones2.umce.cl/controllers/controllerresoluciones.php", 
                })
                .done(function( data, textStatus, jqXHR ) {
                    $("#listaresol").html(""); 
                    /*if ( console && console.log ) {
                        console.log( " data success : "+ data.success 
                            + " \n data msg buscares : "+ data.message 
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }*/
                    if(data.total>0){
                        $("#listado_resol").show();
                        /*terminar aqui el listado de resoluciones "listaresol" */
                        fila = '';
                        for (var i = 0; i < data.total; i++) {
                            var chek='<input class="chkidres" type="hidden" value="'
                                        + data.datos[i].res_id+'" name="idres">';
                            fila = '<tr id="fila' + i + '">';
                            //fila += '<td>'+chek+'</td>';
                            fila += '<td><a target="_blank" href="'+data.datos[0].res_ruta+'">';
                            fila += data.datos[0].res_anio + "-" + data.datos[0].res_numero + " : " + data.datos[0].res_descripcion;
                            fila += '</a></td>';
                            fila += '<td>'+chek+'<button id="agregaidres" name="agregaidres" class="btn btn-sm btn-success borrar" type="button">Agregar</button>';
                            fila += '</td>';
                            fila += '</tr>';
                            $("#listaresol").append(fila);
                        }
                        $('#buscaNumRes').val("");
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
        };
        // MODAL RES  graba resolucion al memo , OK funcionando
        $(document).on('click', '.borrar', function (event) {
            event.preventDefault();
            // colocar codigo que agrega resolucion al memo, en tabla resoluciones
            $(this).closest('tr').remove();
            var resid=$(this).siblings('input').val();
            //console.log($(this).siblings('input').val());

            var datax = {
                "Accion":"registrares",
                "uId": uid,                
                "memId": memId,
                "resId": resid
            }
                var $loader = $('.loader');
                //var formData = new FormData(document.getElementById("formobservacion"));
                $.ajax({
                    data: datax, 
                    type: "POST",
                    dataType: "json", 
                    url: "controllers/controllermemoresolucion.php",
                    /*cache:false,
                    contentType:false,
                    processData:false,*/
                    beforeSend: function(){
                        $('#myModalBuscaRes').modal('hide');
                        $('#ModalCargando').modal('show');
                        $('#ModalCargando').on('shown.bs.modal', function () {
                            $loader.show();
                        });
                    }                    
                })
                .done(function( data, textStatus, jqXHR ) {
                    /*if ( console && console.log ) {
                        console.log( " data success : "+ data.success 
                            + " \n data msg buscares : "+ data.message 
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }*/
                    $('#ModalCargando').modal('hide');
                    $('#ModalCargando').on('hidden.bs.modal', function () {
                        $('#myModalLittle').modal('show');
                        $('#myModalLittle').on('shown.bs.modal', function () {
                            var modal2 = $(this);
                            modal2.find('.modal-title').text('Mensaje');
                            modal2.find('.msg').text(data.message);
                            $('#cerrarModalLittle').focus();
                            getlistaResoluciones(memId);
                            getlistaHistorialEstado(memId,depto);
                        });
                    });
                    
                })
                .fail(function( jqXHR, textStatus, errorThrown ) {
                    if ( console && console.log ) {
                        console.log( " La solicitud agrega resolucion ha fallado,  textStatus : " +  textStatus 
                            + " \n errorThrown : "+ errorThrown
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }
                });
        });
        // funcion que carga en input hidden "nomanalista" el nombre del analista selecionado del select "asignausu"
        $("#asignausu").change(function(event) {
            $('#nomanalista').val($("#asignausu option:selected").text());
        });
        // funcion que limpia formulario de la asignacion
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
                    getlistaUsuAsignaMemo($('#memoId').val());
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