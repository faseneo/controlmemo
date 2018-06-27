    function deshabilitabotones(){
        document.getElementById('editar-memodetarch').style.display = 'none';
        document.getElementById('guardar-memodetarch').style.display = 'none';
        document.getElementById('actualizar-memodetarch').style.display = 'none';
    }
    function limpiaform(){
        $("#memodetarchId").val("");
        $("#memodetarchUrl").val("");
    }        
    function habilitaform(){
        $("#memodetarchId").prop( "disabled", false );
        $("#memodetarchUrl").prop( "disabled", false );
    }
    function deshabilitaform(){
        $("#memodetarchId").prop( "disabled", true );
        $("#memodetarchUrl").prop( "disabled", true );
    }

    $(document).ready(function(){
        //funcion para validar campos del formulario
        function validarFormulario(){
            var txtURL = document.getElementById('memodetarchUrl').value;
                //Test campo obligatorio
                if(txtURL == null || txtURL.length == 0 || /^\s+$/.test(txtURL)){
                    alert('ERROR: El campo URL no debe ir vacío o con espacios en blanco');
                    document.getElementById('memodetarchUrl').focus();
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
                url: "controllers/controllermemodetallearchivo.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#listamemodetarch").html("");
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                                //$.each(data.datos[i], function(k, v) { console.log(k + ' : ' + v); });
                                console.log('id: '+data.datos[i].memo_det_arch_id + ' nombre: '+data.datos[i].memo_det_arch_url);

                                fila = '<tr><td>'+ data.datos[i].memo_det_arch_url +'</td>';
                                //fila += '<td>'+ data.datos[i].ccosto_codigo +'</td>';
                                fila += '<td><button id="ver-memodetarch" type="button" '
                                fila += 'class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal"'
                                fila += ' onclick="verMemoDetArch(\'ver\',\'' + data.datos[i].memo_det_arch_id + '\')">';
                                fila += 'Ver / Editar</button>';
                                fila += ' <button id="delete-language-modal" name="delete-language-modal" type="button" ';
                                fila += 'class="btn btn-xs btn-danger" data-toggle="modal" data-target="#myModalDelete" ';
                                fila += 'onclick="deleteMemoDetArch(\''+ data.datos[i].memo_det_arch_id +'\',\''
                                + data.datos[i].memo_det_arch_url +'\')">';
                                fila += 'Eliminar</button></td>';
                                fila += '</tr>';
                                $("#listamemodetarch").append(fila);
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
        $("#crea-memodetarch").click(function(e){
            e.preventDefault();
            limpiaform();
            habilitaform();
            $("#Accion").val("registrar");
            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                modal.find('.modal-title-form').text('Creación Memo Detalle Archivo');  
                deshabilitabotones();
                $('#guardar-memodetarch').show();
                $('#memodetarchUrl').focus();
            });
        });

        // implementacion boton para guardar el centro de costo
        $("#guardar-memodetarch").click(function(e){
            e.preventDefault();
            if(validarFormulario()==true){
                var datax = $("#formMemoDetArch").serializeArray();
                $.each(datax, function(i, field){
                    console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                });
                $.ajax({
                    data: datax, 
                    type: "POST",
                    dataType: "json", 
                    url: "controllers/controllermemodetallearchivo.php", 
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
        $("#editar-memodetarch").click(function(e){
            e.preventDefault();
            $('.modal-title-form').text('Editar Memo Detalle Archivo');
            habilitaform();
            deshabilitabotones();
            $('#actualizar-memodetarch').show();
            $("#Accion").val("actualizar");               
        });

        //  envia los nuevos datos para actualizar
        $("#actualizar-memodetarch").click(function(e){
                    // Detenemos el comportamiento normal del evento click sobre el elemento clicado
                    e.preventDefault();
                    if(validarFormulario()==true){
                        var datax = $("#formMemoDetArch").serializeArray();
                        /*   $.each(datax, function(i, field){
                            console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                        });*/
                        $.ajax({
                            data: datax,    // En data se puede utilizar un objeto JSON, un array o un query string
                            type: "POST",   //Cambiar a type: POST si necesario
                            dataType: "json",  // Formato de datos que se espera en la respuesta
                            url: "controllers/controllermemodetallearchivo.php",  // URL a la que se enviará la solicitud Ajax
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
        $("#eliminar-memodetarch").click(function(e){
            e.preventDefault();
            console.log("paso");
            var datax = $("#formDeleteMemoDetArch").serializeArray();

            console.log("paso2");

                    $.each(datax, function(i, field){
                        console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                    });
                console.log("paso3");
                    $.ajax({
                        data: datax, 
                        type: "POST",
                        dataType: "json", 
                        url: "controllers/controllermemodetallearchivo.php",
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
    function verMemoDetArch(action, memodetarchid){
        deshabilitabotones();
        var datay = {"memodetarchId": memodetarchid,
                     "Accion":"obtener"
                    };
        $.ajax({
            data: datay, 
            type: "POST",
            dataType: "json", 
            url: "controllers/controllermemodetallearchivo.php",
        })
        .done(function(data,textStatus,jqXHR ) {
            if ( console && console.log ) {
                console.log( " data success : "+ data.success 
                    + " \n data msg : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
            $("#memodetarchId").val(data.datos.memo_det_arch_id);
            $("#memodetarchUrl").val(data.datos.memo_det_arch_url);

            deshabilitaform();
            $("#Accion").val(action);

            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                if (action === 'actualizar'){
                    modal.find('.modal-title-form').text('Actualizar Memo Detalle Archivo');
                    $('#guardar-memodetarch').hide();                    
                    $('#actualizar-memodetarch').show();   
                }else if (action === 'ver'){
                    modal.find('.modal-title-form').text('Datos Memo Detalle Archivo');
                    deshabilitabotones();
                    $('#editar-memodetarch').show();   
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
    function deleteMemoDetArch(idmemodetarch, namememodetarch){     
        document.formDeleteMemoDetArch.memodetarchId.value = idmemodetarch;
        document.formDeleteMemoDetArch.namememodetarch.value = namememodetarch;
        document.formDeleteMemoDetArch.Accion.value = "eliminar";
        $('#myModalDelete').on('shown.bs.modal', function () {
            $('#myInput').focus()
        });
    }   