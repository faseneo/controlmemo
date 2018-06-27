    function deshabilitabotones(){
        document.getElementById('editar-memodet').style.display = 'none';
        document.getElementById('guardar-memodet').style.display = 'none';
        document.getElementById('actualizar-memodet').style.display = 'none';
    }
    function limpiaform(){
        $("#memodetId").val("");
        $("#memodetDesc").val("");
        $("#memodetNumOcChc").val("");
        $("#memodetCdp").val("");
        $("#memodetNumOcMan").val("");
        $("#memodetNumFact").val("");
        $("#memodetFechFact").val("");
        $("#memodetMonTotal").val("");
        $("#memodetObs").val("");
    }        
    function habilitaform(){
        $("#memodetId").prop( "disabled", false );
        $("#memodetDesc").prop( "disabled", false );
        $("#memodetNumOcChc").prop( "disabled", false );
        $("#memodetCdp").prop( "disabled", false );
        $("#memodetNumOcMan").prop( "disabled", false );
        $("#memodetNumFact").prop( "disabled", false );
        $("#memodetFechFact").prop( "disabled", false );
        $("#memodetMonTotal").prop( "disabled", false );
        $("#memodetObs").prop( "disabled", false );
    }
    function deshabilitaform(){
        $("#memodetId").prop( "disabled", true );
        $("#memodetDesc").prop( "disabled", true );
        $("#memodetNumOcChc").prop( "disabled", true );
        $("#memodetCdp").prop( "disabled", true );
        $("#memodetNumOcMan").prop( "disabled", true );
        $("#memodetNumFact").prop( "disabled", true );
        $("#memodetFechFact").prop( "disabled", true );
        $("#memodetMonTotal").prop( "disabled", true );
        $("#memodetObs").prop( "disabled", true );
    }

    $(document).ready(function(){
        //funcion para validar campos del formulario
        function validarFormulario(){
            var txtDesc = document.getElementById('memodetDesc').value;
            var txtNumOcChc = document.getElementById('memodetNumOcChc').value;
            var txtCdp = document.getElementById('memodetCdp').value;
            var txtNumOcMan = document.getElementById('memodetNumOcMan').value;
            var txtNumFact = document.getElementById('memodetNumFact').value;
            var txtFechFact = document.getElementById('memodetFechFact').value;
            var txtMonTotal = document.getElementById('memodetMonTotal').value;
            var txtObs = document.getElementById('memodetObs').value;
                //Test campo obligatorio
                if(txtDesc == null || txtDesc.length == 0 || /^\s+$/.test(txtDesc)){
                    alert('ERROR: El campo no debe ir vacío o con espacios en blanco');
                    document.getElementById('memodetDesc').focus();
                    return false;
                }
                if(txtNumOcChc == null || txtNumOcChc.length == 0 || /^\s+$/.test(txtNumOcChc)){
                    alert('ERROR: El campo no debe ir vacío o con espacios en blanco');
                    document.getElementById('memodetNumOcChc').focus();
                    return false;
                }
                if(txtCdp == null || txtCdp.length == 0 || /^\s+$/.test(txtCdp)){
                    alert('ERROR: El campo no debe ir vacío o con espacios en blanco');
                    document.getElementById('memodetCdp').focus();
                    return false;
                }
                if(txtNumOcMan == null || txtNumOcMan.length == 0 || /^\s+$/.test(txtNumOcMan)){
                    alert('ERROR: El campo no debe ir vacío o con espacios en blanco');
                    document.getElementById('memodetNumOcMan').focus();
                    return false;
                }
                if(txtNumFact == null || txtNumFact.length == 0 || /^\s+$/.test(txtNumFact)){
                    alert('ERROR: El campo no debe ir vacío o con espacios en blanco');
                    document.getElementById('memodetNumFact').focus();
                    return false;
                }
                if(txtFechFact == null || txtFechFact.length == 0 || /^\s+$/.test(txtFechFact)){
                    alert('ERROR: El campo no debe ir vacío o con espacios en blanco');
                    document.getElementById('memodetFechFact').focus();
                    return false;
                }
                if(txtMonTotal == null || txtMonTotal.length == 0 || /^\s+$/.test(txtMonTotal)){
                    alert('ERROR: El campo no debe ir vacío o con espacios en blanco');
                    document.getElementById('memodetMonTotal').focus();
                    return false;
                }
                if(txtObs == null || txtObs.length == 0 || /^\s+$/.test(txtObs)){
                    alert('ERROR: El campo  no debe ir vacío o con espacios en blanco');
                    document.getElementById('memodetObs').focus();
                    return false;
                }                
            return true;
        }         
        //funcion para listar los cecostos
        var getlista = function (){
            var datax = {
                "Accion":"listar"
            }
            $.ajax({
                data: datax, 
                type: "GET",
                dataType: "json", 
                url: "controllers/controllermemodetalle.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#listamemodet").html("");
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                                //$.each(data.datos[i], function(k, v) { console.log(k + ' : ' + v); });
                                console.log('id: '+data.datos[i].memo_detalle_id + ' descripción: '+data.datos[i].memo_detalle_descripcion);

                                fila = '<tr><td>'+ data.datos[i].memo_detalle_descripcion +'</td>';
                                fila += '<td>'+ data.datos[i].memo_detalle_num_oc_chc +'</td>';
                                fila += '<td>'+ data.datos[i].memo_detalle_cdp +'</td>';
                                fila += '<td>'+ data.datos[i].memo_detalle_num_oc_manager +'</td>';
                                fila += '<td>'+ data.datos[i].memo_detalle_num_factura +'</td>';
                                fila += '<td>'+ data.datos[i].memo_detalle_fecha_factura +'</td>';
                                fila += '<td>'+ data.datos[i].memo_detalle_monto_total +'</td>';
                                fila += '<td>'+ data.datos[i].memo_detalle_observaciones +'</td>';
                                fila += '<td><button id="ver-memodet" type="button" '
                                fila += 'class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal"'
                                fila += ' onclick="verMemoDet(\'ver\',\'' + data.datos[i].memo_detalle_id + '\')">';
                                fila += 'Ver / Editar</button>';
                                fila += ' <button id="delete-language-modal" name="delete-language-modal" type="button" ';
                                fila += 'class="btn btn-xs btn-danger" data-toggle="modal" data-target="#myModalDelete" ';
                                fila += 'onclick="deleteMemoDet(\''+ data.datos[i].memo_detalle_id +'\',\''
                                + data.datos[i].memo_detalle_descripcion +'\')">';
                                fila += 'Eliminar</button></td>';
                                fila += '</tr>';
                                $("#listamemodet").append(fila);
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

        //Levanta modal nuevo centro de costos
        $("#crea-memodet").click(function(e){
            e.preventDefault();
            limpiaform();
            habilitaform();
            $("#Accion").val("registrar");
            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                modal.find('.modal-title-form').text('Creación Memo Detalle');  
                deshabilitabotones();
                $('#guardar-memodet').show();
                $('#memodetDesc').focus();
            });
        });

        // implementacion boton para guardar el centro de costo
        $("#guardar-memodet").click(function(e){
            e.preventDefault();
            if(validarFormulario()==true){
                var datax = $("#formMemoDet").serializeArray();
                $.each(datax, function(i, field){
                    console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                });
                $.ajax({
                    data: datax, 
                    type: "POST",
                    dataType: "json", 
                    url: "controllers/controllermemodetalle.php", 
                })
                .done(function( data, textStatus, jqXHR ) {
                    if ( console && console.log ) {
                        console.log( " data success : "+ data.success 
                            + " \n data msg : "+ data.message 
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }
                    $('#myModal').modal('hide');
                    $('#myModalLittle').modal('show');
                    $('#myModalLittle').on('shown.bs.modal', function () {
                        var modal2 = $(this);
                        modal2.find('.modal-title').text('Mensaje');
                        modal2.find('.msg').text(data.message);  
                        $('#cerrarModalLittle').focus();
                    });
                    getlista();
                    deshabilitabotones();
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
        //Cambia boton y habilita form para actualizar
        $("#editar-memodet").click(function(e){
            e.preventDefault();
            $('.modal-title-form').text('Editar Memo Detalle');
            habilitaform();
            deshabilitabotones();
            $('#actualizar-memodet').show();
            $("#Accion").val("actualizar");               
        });

        //  envia los nuevos datos para actualizar
        $("#actualizar-memodet").click(function(e){
                    // Detenemos el comportamiento normal del evento click sobre el elemento clicado
                    e.preventDefault();
                    if(validarFormulario()==true){
                        var datax = $("#formMemoDet").serializeArray();
                        /*   $.each(datax, function(i, field){
                            console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                        });*/
                        $.ajax({
                            data: datax,    // En data se puede utilizar un objeto JSON, un array o un query string
                            type: "POST",   //Cambiar a type: POST si necesario
                            dataType: "json",  // Formato de datos que se espera en la respuesta
                            url: "controllers/controllermemodetalle.php",  // URL a la que se enviará la solicitud Ajax
                        })
                        .done(function( data, textStatus, jqXHR ) {
                            if ( console && console.log ) {
                                console.log( " data success : "+ data.success 
                                    + " \n data msg : "+ data.message 
                                    + " \n textStatus : " + textStatus
                                    + " \n jqXHR.status : " + jqXHR.status );
                            }
                            $('#myModal').modal('hide');
                            $('#myModalLittle').modal('show');
                            $('#myModalLittle').on('shown.bs.modal', function () {
                                var modal2 = $(this);
                                modal2.find('.modal-title').text('Mensaje');
                                modal2.find('.msg').text(data.message);
                                $('#cerrarModalLittle').focus();                                
                            });
                            getlista();
                            deshabilitabotones();
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
        // Envia los datos para eliminar
        $("#eliminar-memodet").click(function(e){
            e.preventDefault();
            console.log("paso");
            var datax = $("#formDeleteMemoDet").serializeArray();

            console.log("paso2");

                    $.each(datax, function(i, field){
                        console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                    });
                console.log("paso3");
                    $.ajax({
                        data: datax, 
                        type: "POST",
                        dataType: "json", 
                        url: "controllers/controllermemodetalle.php",
                    })
                    .done(function(data,textStatus,jqXHR ) {
                        if ( console && console.log ) {
                            console.log( " data success : "+ data.success 
                                + " \n data msg : "+ data.message 
                                + " \n textStatus : " + textStatus
                                + " \n jqXHR.status : " + jqXHR.status );
                        }
                        $('#myModalDelete').modal('hide');
                        $('#myModalLittle').modal('show');
                        $('#myModalLittle').on('shown.bs.modal', function () {
                            var modal2 = $(this);
                            modal2.find('.modal-title').text('Mensaje');
                            modal2.find('.msg').text(data.message);
                            $('#cerrarModalLittle').focus();                                
                        });
                        getlista(); 
                    })
                    .fail(function( jqXHR, textStatus, errorThrown ) {
                        if ( console && console.log ) {
                            console.log( " La solicitud ha fallado,  textStatus : " +  textStatus 
                                + " \n errorThrown : "+ errorThrown
                                + " \n textStatus : " + textStatus
                                + " \n jqXHR.status : " + jqXHR.status );
                        }
                    });
                });
        deshabilitabotones();
        getlista();
    });
    //funcion levanta modal y muestra  los datos del centro de costo cuando presion boton Ver/Editar, aca se puede mdificar si quiere
    function verMemoDet(action, memodetid){
        deshabilitabotones();
        var datay = {"memodetId": memodetid,
                     "Accion":"obtener"
                    };
        $.ajax({
            data: datay, 
            type: "POST",
            dataType: "json", 
            url: "controllers/controllermemodetalle.php",
        })
        .done(function(data,textStatus,jqXHR ) {
            if ( console && console.log ) {
                console.log( " data success : "+ data.success 
                    + " \n data msg : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
            $("#memodetId").val(data.datos.memo_detalle_id);
            $("#memodetDesc").val(data.datos.memo_detalle_descripcion);
            $("#memodetNumOcChc").val(data.datos.memo_detalle_num_oc_chc);
            $("#memodetCdp").val(data.datos.memo_detalle_cdp);
            $("#memodetNumOcMan").val(data.datos.memo_detalle_num_oc_manager);
            $("#memodetNumFact").val(data.datos.memo_detalle_num_factura);
            $("#memodetFechFact").val(data.datos.memo_detalle_fecha_factura);
            $("#memodetMonTotal").val(data.datos.memo_detalle_monto_total);
            $("#memodetObs").val(data.datos.memo_detalle_observaciones);

            deshabilitaform();
            $("#Accion").val(action);

            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                if (action === 'actualizar'){
                    modal.find('.modal-title-form').text('Actualizar Memo Detalle');
                    $('#guardar-memodet').hide();                    
                    $('#actualizar-memodet').show();   
                }else if (action === 'ver'){
                    modal.find('.modal-title-form').text('Datos Memo Detalle');
                    deshabilitabotones();
                    $('#editar-memodet').show();   
                }

            });
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
    // Funcion que levanta modal para eliminar centro de costo 
    function deleteMemoDet(idmemodet, namememodet){     
        document.formDeleteMemoDet.memodetId.value = idmemodet;
        document.formDeleteMemoDet.namememodet.value = namememodet;
        document.formDeleteMemoDet.Accion.value = "eliminar";
        $('#myModalDelete').on('shown.bs.modal', function () {
            $('#myInput').focus()
        });
    }    