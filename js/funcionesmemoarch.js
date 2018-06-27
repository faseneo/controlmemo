    function deshabilitabotones(){
        document.getElementById('editar-memoarch').style.display = 'none';
        document.getElementById('guardar-memoarch').style.display = 'none';
        document.getElementById('actualizar-memoarch').style.display = 'none';
    }
    function limpiaform(){
        $("#memoarchId").val("");
        $("#memoarchUrl").val("");
    }        
    function habilitaform(){
        $("#memoarchId").prop( "disabled", false );
        $("#memoarchUrl").prop( "disabled", false );
    }
    function deshabilitaform(){
        $("#memoarchId").prop( "disabled", true );
        $("#memoarchUrl").prop( "disabled", true );
    }

    $(document).ready(function(){
        //funcion para validar campos del formulario
        function validarFormulario(){
            var txtUrl = document.getElementById('memoarchUrl').value;
                //Test campo obligatorio
                if(txtUrl == null || txtUrl.length == 0 || /^\s+$/.test(txtUrl)){
                    alert('ERROR: El campo URL no debe ir vacío o con espacios en blanco');
                    document.getElementById('memoarchUrl').focus();
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
                url: "controllers/controllermemoarchivo.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#listamemoarch").html("");
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                                //$.each(data.datos[i], function(k, v) { console.log(k + ' : ' + v); });
                                console.log('id: '+data.datos[i].memo_arch_id + ' URL: '+data.datos[i].memo_arch_url);

                                fila = '<tr><td>'+ data.datos[i].memo_arch_url +'</td>';
                                //fila += '<td>'+ data.datos[i].ccosto_codigo +'</td>';
                                fila += '<td><button id="ver-memoarch" type="button" '
                                fila += 'class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal"'
                                fila += ' onclick="verMemoArch(\'ver\',\'' + data.datos[i].memo_arch_id + '\')">';
                                fila += 'Ver / Editar</button>';
                                fila += ' <button id="delete-language-modal" name="delete-language-modal" type="button" ';
                                fila += 'class="btn btn-xs btn-danger" data-toggle="modal" data-target="#myModalDelete" ';
                                fila += 'onclick="deleteMemoArch(\''+ data.datos[i].memo_arch_id +'\',\''
                                + data.datos[i].memo_arch_url +'\')">';
                                fila += 'Eliminar</button></td>';
                                fila += '</tr>';
                                $("#listamemoarch").append(fila);
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
        $("#crea-memoarch").click(function(e){
            e.preventDefault();
            limpiaform();
            habilitaform();
            $("#Accion").val("registrar");
            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                modal.find('.modal-title-form').text('Creación Memo Archivo');  
                deshabilitabotones();
                $('#guardar-memoarch').show();
                $('#memoarchUrl').focus();
            });
        });

        // implementacion boton para guardar el centro de costo
        $("#guardar-memoarch").click(function(e){
            e.preventDefault();
            if(validarFormulario()==true){
                var datax = $("#formMemoArch").serializeArray();
                $.each(datax, function(i, field){
                    console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                });
                $.ajax({
                    data: datax, 
                    type: "POST",
                    dataType: "json", 
                    url: "controllers/controllermemoarchivo.php", 
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
        $("#editar-memoarch").click(function(e){
            e.preventDefault();
            $('.modal-title-form').text('Editar Memo Archivo');
            habilitaform();
            deshabilitabotones();
            $('#actualizar-memoarch').show();
            $("#Accion").val("actualizar");               
        });

        //  envia los nuevos datos para actualizar
        $("#actualizar-memoarch").click(function(e){
                    // Detenemos el comportamiento normal del evento click sobre el elemento clicado
                    e.preventDefault();
                    if(validarFormulario()==true){
                        var datax = $("#formMemoArch").serializeArray();
                        /*   $.each(datax, function(i, field){
                            console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                        });*/
                        $.ajax({
                            data: datax,    // En data se puede utilizar un objeto JSON, un array o un query string
                            type: "POST",   //Cambiar a type: POST si necesario
                            dataType: "json",  // Formato de datos que se espera en la respuesta
                            url: "controllers/controllermemoarchivo.php",  // URL a la que se enviará la solicitud Ajax
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
        $("#eliminar-memoarch").click(function(e){
            e.preventDefault();
            console.log("paso");
            var datax = $("#formDeleteMemoArch").serializeArray();

            console.log("paso2");

                    $.each(datax, function(i, field){
                        console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                    });
                console.log("paso3");
                    $.ajax({
                        data: datax, 
                        type: "POST",
                        dataType: "json", 
                        url: "controllers/controllermemoarchivo.php",
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
    function verMemoArch(action, memoarchid){
        deshabilitabotones();
        var datay = {"memoarchId": memoarchid,
                     "Accion":"obtener"
                    };
        $.ajax({
            data: datay, 
            type: "POST",
            dataType: "json", 
            url: "controllers/controllermemoarchivo.php",
        })
        .done(function(data,textStatus,jqXHR ) {
            if ( console && console.log ) {
                console.log( " data success : "+ data.success 
                    + " \n data msg : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
            $("#memoarchId").val(data.datos.memo_arch_id);
            $("#memoarchUrl").val(data.datos.memo_arch_url);

            deshabilitaform();
            $("#Accion").val(action);

            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                if (action === 'actualizar'){
                    modal.find('.modal-title-form').text('Actualizar Memo Archivo');
                    $('#guardar-memoarch').hide();                    
                    $('#actualizar-memoarch').show();   
                }else if (action === 'ver'){
                    modal.find('.modal-title-form').text('Datos Memo Archivo');
                    deshabilitabotones();
                    $('#editar-memoarch').show();   
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
    function deleteMemoArch(idmemoarch, namememoarch){     
        document.formDeleteMemoArch.memoarchId.value = idmemoarch;
        document.formDeleteMemoArch.namememoarch.value = namememoarch;
        document.formDeleteMemoArch.Accion.value = "eliminar";
        $('#myModalDelete').on('shown.bs.modal', function () {
            $('#myInput').focus()
        });
    }      