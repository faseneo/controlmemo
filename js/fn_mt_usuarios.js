        function deshabilitabotones(){
            document.getElementById('editar-usuario').style.display = 'none';
            document.getElementById('guardar-usuario').style.display = 'none';
            document.getElementById('actualizar-usuario').style.display = 'none';
        }
        function deshabilitabotonesPerfil(){
            document.getElementById('editar-perfil').style.display = 'none';
            document.getElementById('guardar-perfil').style.display = 'none';
            document.getElementById('actualizar-perfil').style.display = 'none';
        }

        function limpiaform(){
            $('#formUsuario')[0].reset();
            $('#msgPerfil').hide();
        }

        function limpiaformperfil(){
            $('#formPerfil')[0].reset();
        }

        function habilitaform(){
            $("#usuId").prop( "disabled", false );
            $("#usuRut").prop( "disabled", false );
            $("#usuNombre").prop( "disabled", false );
            $("#usuEmail").prop( "disabled", false );
            $("#usuPass").prop( "disabled", false);
			$("#usuRolId").prop( "disabled", false );
            $("#usuSeccionId").prop( "disabled", false );
			$("#usuEstadoId").prop( "disabled", false);
        }

        function deshabilitaform(){
            $("#usuId").prop( "disabled", true );
            $("#usuRut").prop( "disabled", true );
            $("#usuNombre").prop( "disabled", true );
            $("#usuEmail").prop( "disabled", true );
            $("#usuPass").prop( "disabled", true);
            $("#usuRolId").prop( "disabled", true );
            $("#usuSeccionId").prop( "disabled", true );
            $("#usuEstadoId").prop( "disabled", true);
        }

        function habilitaformPerfil(){
            $("#usuPerfiles").prop( "disabled", false);
        }

        function deshabilitaformPerfil(){
            $("#usuPerfiles").prop( "disabled", true);
        }  

		function getlistaroles(){
            var datax = {
                "Accion":"listar"
            }
            $.ajax({
                data: datax, 
                type: "GET",
                dataType: "json", 
                url: "controllers/controllerusuariorol.php",          
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#usuRolId").html("");
                if ( console && console.log ) {
                    console.log( " data success Roles : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                //$("#usuRolId").append('<option value="0">Seleccionar...</option>');
                for(var i=0; i<data.datos.length;i++){
                    //console.log('id: '+data.datos[i].usuario_rol_id + ' nombre: '+data.datos[i].usuario_rol_nombre);
                    opcion = '<option value='+ data.datos[i].usuario_rol_id +'>'+data.datos[i].usuario_rol_nombre+'</option>';
                    $("#usuRolId").append(opcion);
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

        function getlistaPerfiles(){
            var datax = {
                "Accion":"listar"
            }
            $.ajax({
                data: datax, 
                type: "GET",
                dataType: "json", 
                url: "controllers/controllerperfil.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#usuPerfiles").html("");
                if ( console && console.log ) {
                    console.log( " data success Perfil: "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                    //console.log('id: '+data.datos[i].perf_id + ' nombre: '+data.datos[i].perf_nombre);
                    opcion = '<option value='+ data.datos[i].perf_id +'>'+data.datos[i].perf_nombre+'</option>';
                    $("#usuPerfiles").append(opcion);
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

        function getlistaSecciones(){
            var datax = {
                "Accion":"listar"
            }
            $.ajax({
                data: datax, 
                type: "GET",
                dataType: "json", 
                url: "controllers/controllerseccion.php",          
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#usuSeccionId").html("");
                if ( console && console.log ) {
                    console.log( " data success Secciones : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                    //console.log('id: '+data.datos[i].sec_id + ' nombre: '+data.datos[i].sec_nombre);
                    opcion = '<option value='+ data.datos[i].sec_id +'>'+data.datos[i].sec_nombre+'</option>';
                    $("#usuSeccionId").append(opcion);
                }
            })
            .fail(function( jqXHR, textStatus, errorThrown ) {
                if ( console && console.log ) {
                    console.log( " La solicitud getlista seccion ha fallado,  textStatus : " +  textStatus 
                        + " \n errorThrown : "+ errorThrown
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
            });
        }        

    getlistaroles();
    getlistaPerfiles();
    getlistaSecciones();

    $(document).ready(function(){
        function validarFormulario(){
            var txtRut = document.getElementById('usuRut').value;
            var txtNombre = document.getElementById('usuNombre').value;
            var txtEmail = document.getElementById('usuEmail').value;
			var txtPass = document.getElementById('usuPass').value;
            var selRol = document.getElementById('usuRolId').selectedIndex;
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
                if(txtEmail == null || txtEmail.length == 0 || /^\s+$/.test(txtEmail)){
                    alert('ERROR: El campo nombre no debe ir vacío o con espacios en blanco');
                    document.getElementById('usuEmail').focus();
                    return false;
                }                
                if(txtPass == null || txtPass.length == 0 || /^\s+$/.test(txtPass)){
                    alert('ERROR: El campo contraseña no debe ir vacío o con espacios en blanco');
                    document.getElementById('usuPass').focus();
                    return false;
                }                 
            return true;
        }
        function validarFormularioPerfil(){
            var selPer = document.getElementById('usuPerfiles').selectedIndex;
            //valida seleccion un perfil
            if( selPer == null || isNaN(selPer) || selPer == -1 ) {
                $('#usuPerfiles').parent().attr('class','form-group has-error');
                $('#usuPerfiles').parent().children('span').text('Debe seleccionar Perfil para el usuario').show();
                document.getElementById('usuPerfiles').focus();
                return false;                
            }else{
                $('#usuPerfiles').parent().attr('class','form-group has-success');
                $('#usuPerfiles').parent().children('span').text('').hide();
            }                 
            return true;
        }
		 
        /*deshabilitabotones();
        deshabilitabotonesPerfil();*/
        //funcion para listar los Usuarios
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
                    console.log( " data success Usuarios : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                    estado_id= parseInt(data.datos[i].usu_estado_id);
                    switch(estado_id){
                        case 0:
                            estadonombre = 'Creado';
                            break;
                        case 1:
                            estadonombre = 'Activo';
                            break;
                        case 2:
                            estadonombre = 'Inactivo';
                            break;
                        default:
                            estadonombre = 'Creado';
                            break;
                    }
                                //$.each(data.datos[i], function(k, v) { console.log(k + ' : ' + v); });
                                //console.log('id: '+data.datos[i].usu_id + ' rut: '+data.datos[i].usu_rut + ' nombre: '+data.datos[i].usu_nombre + ' rol: '+data.datos[i].usu_rol_nombre);

                                fila = '<tr><td>'+ data.datos[i].usu_rut +'</td>';
                                fila += '<td>'+ data.datos[i].usu_email +'</td>';
                                fila += '<td>'+ data.datos[i].usu_nombre +'</td>';
								fila += '<td>'+ data.datos[i].usu_rol_nombre +'</td>';
                                fila += '<td>'+ data.datos[i].usu_sec_nombre +'</td>';
                                fila += '<td>'+ estadonombre +'</td>';
                                fila += '<td><button id="ver-usuario" type="button" '
                                fila += 'class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal"'
                                fila += ' onclick="verUsuario(\'ver\',\'' + data.datos[i].usu_id + '\')">';
                                fila += 'Ver / Editar</button>';
                                // Solo admin deberia ver este boton
                                    fila += ' <button id="ver-usuario" type="button" '
                                    fila += 'class="btn btn-xs btn-info" data-toggle="modal" data-target="#myModalPerfil"'
                                    fila += ' onclick="verUsuario(\'perf\',\'' + data.datos[i].usu_id + '\')">';
                                    fila += 'Perfil</button>';
                                // Solo admin deberia ver este boton
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
            getlistaroles();
            $("#Accion").val("registrar");
            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                modal.find('.modal-title-form').text('Creación Usuario');  
                deshabilitabotones();
                habilitaform();
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
            var usuId = document.getElementById('id').value;
                var datax = {
                    "Accion":"eliminar",
                    "usuId":usuId
                }
                    /*$.each(datax, function(i, field){
                        console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                    });*/
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

        $("#guardar-perfil").click(function(e){
            e.preventDefault();
            if(validarFormularioPerfil()==true){
                var datax = $("#formPerfil").serializeArray();
                var accion={name:"Accion",value:"addperfil"};
                datax.push(accion);

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
                    $('#myModalPerfil').modal('hide');
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

        $("#editar-perfil").click(function(e){
            e.preventDefault();
            $('.modal-title-form').text('Editar Perfil');
            habilitaformPerfil();
            deshabilitabotonesPerfil();
            $('#actualizar-perfil').show();
            $("#Accion").val("actualizar");               
        });        
        $("#actualizar-perfil").click(function(e){
                    // Detenemos el comportamiento normal del evento click sobre el elemento clicado
                    e.preventDefault();
                    if(validarFormulario()==true){
                        var datax = $("#formPerfil").serializeArray();
                        var accion={name:"Accion",value:"addperfil"};
                        datax.push(accion);

                        $.each(datax, function(i, field){
                            console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                        });
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
                            $('#myModalPerfil').modal('hide');
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
        deshabilitabotones();
        deshabilitabotonesPerfil();
        getlista();
    });
    //funcion levanta modal y muestra  los datos del centro de costo cuando presion boton Ver/Editar, aca se puede mdificar si quiere
    function verUsuario(action, usuid){
        limpiaform();
        limpiaformperfil(); 
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
            $("#usuEmail").val(data.datos.usu_email);
            $("#usuPass").val(data.datos.usu_password);
			$("#usuRolId").val(data.datos.usu_rol_id).prop('selected',true);
            $("#usuSeccionId").val(data.datos.usu_sec_id).prop('selected',true);
            $("#usuEstadoId").val(data.datos.usu_estado_id).prop('selected',true);

            if(data.datos.usu_perfiles.length==0){
                $("#msgPerfil").removeClass("alert-success");
                $("#msgPerfil").addClass("alert-danger");
                $('#msgPerfil').show();
                $("#msgPerfil").text('Este usuario aun no tiene perfil asignado');
            }else{
                $('#msgPerfil').show();
                $("#msgPerfil").removeClass("alert-danger");
                $("#msgPerfil").addClass("alert-success");
                var selPer = document.getElementById('usuPerfiles');
                perfiles="";
                for(var i=0; i<data.datos.usu_perfiles.length; i++){
                    perfiles += data.datos.usu_perfiles[i].perf_nombre + ', ';
                    selPer[(data.datos.usu_perfiles[i].perf_id-1)].selected = true;
                }
                    perfiles = perfiles.trim();
                    perfiles = perfiles.slice(0, -1);
                    $("#msgPerfil").text('Perfil(es) : '+perfiles);
            }
                $("#idUsu").val(data.datos.usu_id);
                $("#rutUsu").val(data.datos.usu_rut);
                $("#nomUsu").val(data.datos.usu_nombre);
                $("#rolUsu").val(data.datos.usu_rol_nombre);


            if(action=='ver'){
                $("#Accion").val(action);
                $('#myModal').on('shown.bs.modal', function () {
                    var modal = $(this);
                        modal.find('.modal-title-form').text('Datos Usuario');
                        deshabilitaform();
                        deshabilitabotones();
                        $('#editar-usuario').show();   
                });
            }else if(action=='perf'){
                $('#myModalPerfil').on('shown.bs.modal', function () {
                    var modal = $(this);
                        modal.find('.modal-title-form').text('Datos Perfil Usuario');
                        deshabilitabotonesPerfil();
                        if(data.datos.usu_perfiles.length==0){
                            habilitaformPerfil();
                            $('#guardar-perfil').show();   
                        }else{
                            deshabilitaformPerfil();
                            $('#guardar-perfil').hide();
                            $('#editar-perfil').show();                            
                        }
                });
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
    }
    // Funcion que levanta modal para eliminar centro de costo 
    function deleteUsuario(idusu, rut, nameUsu){     
        document.formDeleteUsuario.id.value = idusu;
        document.formDeleteUsuario.nameUsu.value = nameUsu;
        //document.formDeleteUsuario.Accion.value = "eliminar";
        $('#myModalDelete').on('shown.bs.modal', function () {
            $('#myInput').focus()
        });
    }