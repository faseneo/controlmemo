        function deshabilitabotones(){
            document.getElementById('editar-usuario').style.display = 'none';
            document.getElementById('guardar-usuario').style.display = 'none';
            document.getElementById('actualizar-usuario').style.display = 'none';
        }
        function limpiaform(){
            $("#usuId").val("");
            $("#usuRut").val("");
            $("#usuNombre").val("");
			$("#usuPass").val("");
        }        
        function habilitaform(){
            $("#usuId").prop( "disabled", false );
            $("#usuRut").prop( "disabled", false );
            $("#usuNombre").prop( "disabled", false );
			$("#usuPerfilId").prop( "disabled", false );
			$("#usuPass").prop( "disabled", false);
        }
        function deshabilitaform(){
            $("#usuId").prop( "disabled", true );
            $("#usuRut").prop( "disabled", true );
            $("#usuNombre").prop( "disabled", true ); 
			$("#usuPerfilId").prop( "disabled", true );
			$("#usuPass").prop( "disabled", true );
        }
		var getlistaperfiles = function (){
            var datax = {
                "Accion":"listar"
            }
            $.ajax({
                data: datax, 
                type: "GET",
                dataType: "json", 
                url: "controllers/controllerusuarioperfil.php",          
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#usuPerfilId").html("");
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                $("#usuPerfilId").append('<option value="0">Seleccionar...</option>');
                for(var i=0; i<data.datos.length;i++){
                    console.log('id: '+data.datos[i].usu_perfil_id + ' nombre: '+data.datos[i].usu_perfil_nombre);
                    opcion = '<option value='+ data.datos[i].usu_perfil_id +'>'+data.datos[i].usu_perfil_nombre+'</option>';
                    $("#usuPerfilId").append(opcion);
                }
               // $("#listaperfil").append(fila);
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
    $(document).ready(function(){
        function validarFormulario(){   
            var txtRut = document.getElementById('usuRut').value;
            var txtNombre = document.getElementById('usuNombre').value;
			var txtPass = document.getElementById('usuPass').value;
                //Test campo obligatorio
                if(txtRut == null || txtRut.length == 0 || /^\s+$/.test(txtRut)){
                    alert('ERROR: El campo rut no debe ir vacío o con espacios en blanco');
                    document.getElementById('usuRut').focus();
                    return false;
                }
                if(txtNombre == null || txtNombre.length == 0 || /^\s+$/.test(txtNombre)){
                    alert('ERROR: El campo nombre no debe ir vacío o con espacios en blanco');
                    document.getElementById('usuNombre').focus();
                    return false;
                }
                if(txtPass == null || txtPass.length == 0 || /^\s+$/.test(txtPass)){
                    alert('ERROR: El campo contraseña no debe ir vacío o con espacios en blanco');
                    document.getElementById('usuPass').focus();
                    return false;
                }                 
            return true;
        }         
		 
        deshabilitabotones();
        //funcion para listar los cecostos
        var getlista = function (){
            var datax = {
                "Accion":"listar"
            }
            $.ajax({
                data: datax, 
                type: "GET",
                dataType: "json", 
                url: "controllers/controllerusuario.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#listausuario").html("");
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                                //$.each(data.datos[i], function(k, v) { console.log(k + ' : ' + v); });
                                console.log('id: '+data.datos[i].usu_id + ' rut: '+data.datos[i].usu_rut + ' nombre: '+data.datos[i].usu_nombre + ' perfil: '+data.datos[i].usu_perfil_nombre + ' password: '+data.datos[i].usu_password);

                                fila = '<tr><td>'+ data.datos[i].usu_rut +'</td>';
                                fila += '<td>'+ data.datos[i].usu_nombre +'</td>';
								fila += '<td>'+ data.datos[i].usu_perfil_nombre +'</td>';

                                fila += '<td><button id="ver-usuario" type="button" '
                                fila += 'class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal"'
                                fila += ' onclick="verUsuario(\'ver\',\'' + data.datos[i].usu_id + '\')">';
                                fila += 'Ver / Editar</button>';
                                fila += ' <button id="delete-language-modal" name="delete-language-modal" type="button" ';
                                fila += 'class="btn btn-xs btn-danger" data-toggle="modal" data-target="#myModalDelete" ';
                                fila += 'onclick="deleteUsuario(\''+ data.datos[i].usu_id +'\',\'' + data.datos[i].usu_rut +'\',\''
                                + data.datos[i].usu_nombre +'\')">';
                                fila += 'Eliminar</button></td>';
                                fila += '</tr>';
                                $("#listausuario").append(fila);
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
        $("#crea-usuario").click(function(e){
            e.preventDefault();
            limpiaform();
            habilitaform();
            getlistaperfiles();
            $("#Accion").val("registrar");
            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                modal.find('.modal-title-form').text('Creación Usuario');  
                deshabilitabotones();
                $('#guardar-usuario').show();
                $('#usuRut').focus();
                //$('#usuNombre');
            });
        });

        // implementacion boton para guardar el centro de costo
        $("#guardar-usuario").click(function(e){
            e.preventDefault();
            if(validarFormulario()==true){
                var datax = $("#formUsuario").serializeArray();
                $.each(datax, function(i, field){
                    console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                });
                $.ajax({
                    data: datax, 
                    type: "POST",
                    dataType: "json", 
                    url: "controllers/controllerusuario.php", 
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
                        modal2.find('.modal-title').text('Mensaje del Servidor');
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
        $("#editar-usuario").click(function(e){
            e.preventDefault();
            $('.modal-title-form').text('Editar Usuario');
            habilitaform();
            deshabilitabotones();
            $('#actualizar-usuario').show();
            $("#Accion").val("actualizar");               
        });

        //  envia los nuevos datos para actualizar
        $("#actualizar-usuario").click(function(e){
                    // Detenemos el comportamiento normal del evento click sobre el elemento clicado
                    e.preventDefault();
                    if(validarFormulario()==true){
                        var datax = $("#formUsuario").serializeArray();
                        /*   $.each(datax, function(i, field){
                            console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                        });*/
                        $.ajax({
                            data: datax,    // En data se puede utilizar un objeto JSON, un array o un query string
                            type: "POST",   //Cambiar a type: POST si necesario
                            dataType: "json",  // Formato de datos que se espera en la respuesta
                            url: "controllers/controllerusuario.php",  // URL a la que se enviará la solicitud Ajax
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
        $("#eliminar-usuario").click(function(e){
            e.preventDefault();
            console.log("paso");
            var datax = $("#formDeleteUsuario").serializeArray();

            console.log("paso2");

                    $.each(datax, function(i, field){
                        console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                    });
                console.log("paso3");
                    $.ajax({
                        data: datax, 
                        type: "POST",
                        dataType: "json", 
                        url: "controllers/controllerusuario.php",
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
    function verUsuario(action, usuid){
		
		deshabilitaform();
        deshabilitabotones();
		getlistaperfiles();
        var datay = {"usuId": usuid,
                     "Accion":"obtener"
                    };
        $.ajax({
            data: datay, 
            type: "POST",
            dataType: "json", 
            url: "controllers/controllerusuario.php",
        })
        .done(function(data,textStatus,jqXHR ) {
            if ( console && console.log ) {
                console.log( " data success : "+ data.success 
                    + " \n data msg : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
			
            $("#usuId").val(data.datos.usu_id);   
            $("#usuRut").val(data.datos.usu_rut);
            $("#usuNombre").val(data.datos.usu_nombre);
            $("#usuPass").val(data.datos.usu_password);
			$("#usuPerfilId").val(data.datos.usu_usu_perfil_id);

            
            $("#Accion").val(action);

            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                if (action === 'actualizar'){
                    modal.find('.modal-title-form').text('Actualizar Usuario');
                    $('#guardar-usuario').hide();                    
                    $('#actualizar-usuario').show();   
                }else if (action === 'ver'){
                    modal.find('.modal-title-form').text('Datos Usuario');
                    deshabilitabotones();
                    $('#editar-usuario').show();   
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
    function deleteUsuario(idusu, nameUsu){     
        document.formDeleteUsuario.usuId.value = idusu;
        document.formDeleteUsuario.nameUsu.value = nameUsu;
        document.formDeleteUsuario.Accion.value = "eliminar";
        $('#myModalDelete').on('shown.bs.modal', function () {
            $('#myInput').focus()
        });
    }