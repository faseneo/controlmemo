    function deshabilitabotones(){
        document.getElementById('editar-cecosto').style.display = 'none';
        document.getElementById('guardar-cecosto').style.display = 'none';
        document.getElementById('actualizar-cecosto').style.display = 'none';
    }
    function limpiaform(){
        $("#ccCodigo").val("");
        $("#ccNombre").val("");
        //$("#ccDependencia").val("");
    }        
    function habilitaform(){
        $("#ccCodigo").prop( "disabled", false );
        $("#ccNombre").prop( "disabled", false );
        $("#ccTipo").prop( "disabled", false );
        $("#ccDependencia").prop( "disabled", false );
        $("#ccEstado").prop( "disabled", false );
    }
    function deshabilitaform(){
        $("#ccCodigo").prop( "disabled", true );
        $("#ccNombre").prop( "disabled", true );
        $("#ccTipo").prop( "disabled", true );
        $("#ccDependencia").prop( "disabled", true );
        $("#ccEstado").prop( "disabled", true );
    }
           //funcion para listar los cecostos
    var getlistaDep = function (){
            var datax = {
                "Accion":"listar"
            }
            $.ajax({
                data: datax, 
                type: "GET",
                dataType: "json", 
                url: "controllers/controllerdependencia.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#ccDependencia").html("");
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                    console.log('id: '+data.datos[i].dep_codigo + ' nombre: '+data.datos[i].dep_nombre);
                    opcion = '<option value='+ data.datos[i].dep_codigo +'>'+ data.datos[i].dep_codigo +' - '+ data.datos[i].dep_nombre+'</option>';
                    $("#ccDependencia").append(opcion);
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
    getlistaDep();
    $(document).ready(function(){
        //funcion para validar campos del formulario
        function validarFormulario(){
            var txtNombre = document.getElementById('ccNombre').value;
            var txtCodigo = document.getElementById('ccDependencia').value;
                //Test campo obligatorio
                if(txtNombre == null || txtNombre.length == 0 || /^\s+$/.test(txtNombre)){
                    alert('ERROR: El campo nombre no debe ir vacío o con espacios en blanco');
                    document.getElementById('ccNombre').focus();
                    return false;
                }
                if(txtCodigo == null || txtCodigo.length == 0 || /^\s+$/.test(txtCodigo)){
                    alert('ERROR: El campo Codigo no debe ir vacío o con espacios en blanco');
                    document.getElementById('ccDependencia').focus();
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
                url: "controllers/controllercentrocostos.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#listacecostos").html("");
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                                //$.each(data.datos[i], function(k, v) { console.log(k + ' : ' + v); });
                                console.log('id: '+data.datos[i].ccosto_codigo + ' nombre: '+data.datos[i].ccosto_nombre);

                                fila = '<tr>';
                                fila += '<td>'+ data.datos[i].ccosto_codigo +'</td>';
                                fila += '<td>'+ data.datos[i].ccosto_nombre +'</td>';
                                fila += '<td>'+ data.datos[i].ccosto_tipo +'</td>';
                                fila += '<td>'+ data.datos[i].ccosto_dep_nombre +'</td>';
                                fila += '<td><button id="ver-cecosto" type="button" '
                                fila += 'class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal"'
                                fila += ' onclick="verCecosto(\'ver\',\'' + data.datos[i].ccosto_codigo + '\')">';
                                fila += 'Ver / Editar</button> ';
                                /*fila += ' <button id="delete-language-modal" name="delete-language-modal" type="button" ';
                                fila += 'class="btn btn-xs btn-danger" data-toggle="modal" data-target="#myModalDelete" ';
                                fila += 'onclick="deleteCecosto(\''+ data.datos[i].ccosto_codigo +'\',\''
                                + data.datos[i].ccosto_nombre +'\')">';
                                fila += 'Eliminar</button>';*/
                                fila += '</td>';
                                fila += '<td class="text-center">';
                                if(data.datos[i].ccosto_estado==1){
                                    fila += '<span class="glyphicon glyphicon-ok text-success"></span>';
                                }else{
                                    fila += '<span class="glyphicon glyphicon-remove text-danger"></span>';
                                }
                                fila += '</td>';
                                fila += '</tr>';
                                $("#listacecostos").append(fila);
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
        $("#crea-cecosto").click(function(e){
            e.preventDefault();
            limpiaform();
            habilitaform();
            //getlistaDep();
            $("#Accion").val("registrar");
            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                modal.find('.modal-title-form').text('Creación Centro de Costo');  
                deshabilitabotones();
                $('#guardar-cecosto').show();
                $('#ccNombre').focus();
            });
        });
        $("#active-cecosto").click(function(e) {
            console.log($("#active-cecosto").text);
        });
        // implementacion boton para guardar el centro de costo
        $("#guardar-cecosto").click(function(e){
            e.preventDefault();
            if(validarFormulario()==true){
                var datax = $("#formCecosto").serializeArray();
                $.each(datax, function(i, field){
                    console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                });
                $.ajax({
                    data: datax, 
                    type: "POST",
                    dataType: "json", 
                    url: "controllers/controllercentrocostos.php", 
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
        $("#editar-cecosto").click(function(e){
            e.preventDefault();
            $('.modal-title-form').text('Editar Centro de Costo');
            habilitaform();
            deshabilitabotones();
            $('#actualizar-cecosto').show();
            $("#Accion").val("actualizar");               
        });

        //  envia los nuevos datos para actualizar
        $("#actualizar-cecosto").click(function(e){
                    // Detenemos el comportamiento normal del evento click sobre el elemento clicado
                    e.preventDefault();
                    if(validarFormulario()==true){
                        var datax = $("#formCecosto").serializeArray();
                        /*   $.each(datax, function(i, field){
                            console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                        });*/
                        $.ajax({
                            data: datax,    // En data se puede utilizar un objeto JSON, un array o un query string
                            type: "POST",   //Cambiar a type: POST si necesario
                            dataType: "json",  // Formato de datos que se espera en la respuesta
                            url: "controllers/controllercentrocostos.php",  // URL a la que se enviará la solicitud Ajax
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
        $("#eliminar-cecosto").click(function(e){
            e.preventDefault();
            console.log("paso");
            var datax = $("#formDeleteCecosto").serializeArray();

            console.log("paso2");

                    $.each(datax, function(i, field){
                        console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                    });
                console.log("paso3");
                    $.ajax({
                        data: datax, 
                        type: "POST",
                        dataType: "json", 
                        url: "controllers/controllercentrocostos.php",
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
    function verCecosto(action, ccid){
        deshabilitabotones();
        deshabilitaform();        
        //getlistaDep();
        var datay = {"ccCodigo": ccid,
                     "Accion":"obtener"
                    };
        $.ajax({
            data: datay, 
            type: "POST",
            dataType: "json", 
            url: "controllers/controllercentrocostos.php",
        })
        .done(function(data,textStatus,jqXHR ) {
            if ( console && console.log ) {
                console.log( " data success : "+ data.success 
                    + " \n data msg : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
            $("#ccCodigo").val(data.datos.ccosto_codigo);
            $("#ccNombre").val(data.datos.ccosto_nombre);
            $("#ccTipo").val(data.datos.ccosto_tipo);
            $("#ccDependencia").val(data.datos.ccosto_dep_codigo);
            $("#ccEstado").val(data.datos.ccosto_estado);

            console.log('dependencia : '+data.datos.ccosto_dep_codigo);
            $("#Accion").val(action);
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
    function deleteCecosto(idcecosto, namececosto){     
        document.formDeleteCecosto.ccCodigo.value = idcecosto;
        document.formDeleteCecosto.namececosto.value = namececosto;
        document.formDeleteCecosto.Accion.value = "eliminar";
        $('#myModalDelete').on('shown.bs.modal', function () {
            $('#myInput').focus()
        });
    }      