    function deshabilitabotones(){
        document.getElementById('editar-prov').style.display = 'none';
        document.getElementById('guardar-prov').style.display = 'none';
        document.getElementById('actualizar-prov').style.display = 'none';
    }
    function limpiaform(){
        $("#provId").val("");
        $("#provNombre").val("");
        $("#provRut").val("");
        $("#provFono").val("");
        $("#provDireccion").val("");
        $("#provCiudad").val("");
        $("#provRegion").val("");
        $("#provCuenta").val("");
        $("#provContNombre").val("");
        $("#provContEmail").val("");
        $("#provContFono").val("");
        $("#provEstado").val("");
    }
    function habilitaform(){
        $("#provId").prop( "disabled", false );
        $("#provNombre").prop( "disabled", false );
        $("#provRut").prop( "disabled", false );
        $("#provFono").prop( "disabled", false );
        $("#provDireccion").prop( "disabled", false );
        $("#provCiudad").prop( "disabled", false );
        $("#provRegion").prop( "disabled", false );
        $("#provCuenta").prop( "disabled", false );
        $("#provContNombre").prop( "disabled", false );
        $("#provContEmail").prop( "disabled", false );
        $("#provContFono").prop( "disabled", false );
        $("#provEstado").prop( "disabled", false );
    }
    function deshabilitaform(){
        $("#provId").prop( "disabled", true );
        $("#provNombre").prop( "disabled", true );
        $("#provRut").prop( "disabled", true );
        $("#provFono").prop( "disabled", true );
        $("#provDireccion").prop( "disabled", true );
        $("#provCiudad").prop( "disabled", true );
        $("#provRegion").prop( "disabled", true );
        $("#provCuenta").prop( "disabled", true );
        $("#provContNombre").prop( "disabled", true );
        $("#provContEmail").prop( "disabled", true );
        $("#provContFono").prop( "disabled", true );
        $("#provEstado").prop( "disabled", true );        
    }

    $(document).ready(function(){
        //funcion para validar campos del formulario
        function validarFormulario(){
            var txtNombre = document.getElementById('provNombre').value;
            var txtRut = document.getElementById('provRut').value;
                //Test campo obligatorio
                if(txtNombre == null || txtNombre.length == 0 || /^\s+$/.test(txtNombre)){
                    alert('ERROR: El campo nombre no debe ir vacío o con espacios en blanco');
                    document.getElementById('provNombre').focus();
                    return false;
                }
                if(txtRut == null || txtRut.length == 0 || /^\s+$/.test(txtRut)){
                    alert('ERROR: El campo Rut no debe ir vacío o con espacios en blanco');
                    document.getElementById('provRut').focus();
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
                url: "controllers/controllerproveedor.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#listaprov").html("");
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                                //$.each(data.datos[i], function(k, v) { console.log(k + ' : ' + v); });
                                console.log('id: '+data.datos[i].prov_id + ' nombre: '+data.datos[i].prov_nombre);
                                fila = '<tr>';
                                fila += '<td>'+ data.datos[i].prov_rut +'</td>';
                                fila += '<td>'+ data.datos[i].prov_nombre +'</td>';
                                fila += '<td>'+ data.datos[i].prov_contacto_nombre +'</td>';
                                fila += '<td>'+ data.datos[i].prov_contacto_fono +'</td>';

                                fila += '<td><button id="ver-cecosto" type="button" '
                                fila += 'class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal"'
                                fila += ' onclick="verProv(\'ver\',\'' + data.datos[i].prov_id + '\')">';
                                fila += 'Ver / Editar</button>';
                                fila += ' <button id="delete-language-modal" name="delete-language-modal" type="button" ';
                                fila += 'class="btn btn-xs btn-danger" data-toggle="modal" data-target="#myModalDelete" ';
                                fila += 'onclick="deleteProv(\''+ data.datos[i].prov_id +'\',\''
                                + data.datos[i].prov_nombre +'\')">';
                                fila += 'Eliminar</button></td>';
                                fila += '</tr>';
                                $("#listaprov").append(fila);
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
        $("#crea-prov").click(function(e){
            e.preventDefault();
            limpiaform();
            habilitaform();
            $("#Accion").val("registrar");
            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                modal.find('.modal-title-form').text('Creación Proveedor');  
                deshabilitabotones();
                $('#guardar-prov').show();
                $('#provNombre').focus();
            });
        });

        // implementacion boton para guardar el centro de costo
        $("#guardar-prov").click(function(e){
            e.preventDefault();
            if(validarFormulario()==true){
                var datax = $("#formProv").serializeArray();
                $.each(datax, function(i, field){
                    console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                });
                $.ajax({
                    data: datax, 
                    type: "POST",
                    dataType: "json", 
                    url: "controllers/controllerproveedor.php", 
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
        $("#editar-prov").click(function(e){
            e.preventDefault();
            $('.modal-title-form').text('Editar Proveedor');
            habilitaform();
            deshabilitabotones();
            $('#actualizar-prov').show();
            $("#Accion").val("actualizar");               
        });

        //  envia los nuevos datos para actualizar
        $("#actualizar-prov").click(function(e){
                    // Detenemos el comportamiento normal del evento click sobre el elemento clicado
                    e.preventDefault();
                    if(validarFormulario()==true){
                        var datax = $("#formProv").serializeArray();
                        /*   $.each(datax, function(i, field){
                            console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                        });*/
                        $.ajax({
                            data: datax,    // En data se puede utilizar un objeto JSON, un array o un query string
                            type: "POST",   //Cambiar a type: POST si necesario
                            dataType: "json",  // Formato de datos que se espera en la respuesta
                            url: "controllers/controllerproveedor.php",  // URL a la que se enviará la solicitud Ajax
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
        $("#eliminar-prov").click(function(e){
            e.preventDefault();
            console.log("paso");
            var datax = $("#formDeleteProv").serializeArray();

            console.log("paso2");

                    $.each(datax, function(i, field){
                        console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                    });
                console.log("paso3");
                    $.ajax({
                        data: datax, 
                        type: "POST",
                        dataType: "json", 
                        url: "controllers/controllerproveedor.php",
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
    function verProv(action, provid){
        deshabilitabotones();
        var datay = {"provId": provid,
                     "Accion":"obtener"
                    };
        $.ajax({
            data: datay, 
            type: "POST",
            dataType: "json", 
            url: "controllers/controllerproveedor.php",
        })
        .done(function(data,textStatus,jqXHR ) {
            if ( console && console.log ) {
                console.log( " data success : "+ data.success 
                    + " \n data msg : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
            $("#provId").val(data.datos.prov_id);
            $("#provRut").val(data.datos.prov_rut);
            $("#provNombre").val(data.datos.prov_nombre);
            $("#provFono").val(data.datos.prov_fono);
            $("#provDireccion").val(data.datos.prov_direccion);
            $("#provCiudad").val(data.datos.prov_ciudad);
            $("#provRegion").val(data.datos.prov_region);
            $("#provCuenta").val(data.datos.prov_cuenta);
            $("#provContNombre").val(data.datos.prov_contacto_nombre);
            $("#provContEmail").val(data.datos.prov_contacto_email);
            $("#provContFono").val(data.datos.prov_contacto_fono);
            $("#provEstado").val(data.datos.prov_estado);
            deshabilitaform();
            $("#Accion").val(action);

            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                if (action === 'actualizar'){
                    modal.find('.modal-title-form').text('Actualizar Proveedor');
                    $('#guardar-prov').hide();                    
                    $('#actualizar-prov').show();   
                }else if (action === 'ver'){
                    modal.find('.modal-title-form').text('Datos Proveedor');
                    deshabilitabotones();
                    $('#editar-prov').show();   
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
    function deleteProv(idprov, nameprov){     
        document.formDeleteProv.provId.value = idprov;
        document.formDeleteProv.nameprov.value = nameprov;
        document.formDeleteProv.Accion.value = "eliminar";  
        $('#myModalDelete').on('shown.bs.modal', function () {
            $('#myInput').focus()
        });
    }     