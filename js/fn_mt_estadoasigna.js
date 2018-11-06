        function deshabilitabotones(){
            document.getElementById('editar-estadoAsigna').style.display = 'none';
            document.getElementById('guardar-estadoAsigna').style.display = 'none';
            document.getElementById('actualizar-estadoAsigna').style.display = 'none';
        }
        function limpiaform(){
            $("#estadoAsignaId").val("");
            $("#estadoAsignaTexto").val("");
        }        
        function habilitaform(){
            $("#estadoAsignaId").prop( "disabled", false );
            $("#estadoAsignaTexto").prop( "disabled", false );
        }
        function deshabilitaform(){
            $("#estadoAsignaId").prop( "disabled", true );
            $("#estadoAsignaTexto").prop( "disabled", true );
        }

    $(document).ready(function(){
        function validarFormulario(){
            var txtNombre = document.getElementById('estadoAsignaTexto').value;
                //Test campo obligatorio
                if(txtNombre == null || txtNombre.length == 0 || /^\s+$/.test(txtNombre)){
                    alert('ERROR: El campo nombre no debe ir vacío o con espacios en blanco');
                    document.getElementById('estadoAsignaTexto').focus();
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
                url: "controllers/controllerestadoasigna.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#listaestadoAsigna").html("");
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                                //$.each(data.datos[i], function(k, v) { console.log(k + ' : ' + v); });
                                console.log('id: '+data.datos[i].est_asigna_id + ' nombre: '+data.datos[i].est_asigna_texto);

                                fila = '<tr><td>'+ data.datos[i].est_asigna_texto +'</td>';
                                //fila += '<td>'+ data.datos[i].ccosto_codigo +'</td>';

                                fila += '<td><button id="ver-estadoAsigna" type="button" '
                                fila += 'class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal"'
                                fila += ' onclick="verestadoAsigna(\'ver\',\'' + data.datos[i].est_asigna_id + '\')">';
                                fila += 'Ver / Editar</button>';
                                fila += ' <button id="delete-language-modal" name="delete-language-modal" type="button" ';
                                fila += 'class="btn btn-xs btn-danger" data-toggle="modal" data-target="#myModalDelete" ';
                                fila += 'onclick="deleteestadoAsigna(\''+ data.datos[i].est_asigna_id +'\',\''
                                + data.datos[i].est_asigna_texto +'\')">';
                                fila += 'Eliminar</button></td>';
                                fila += '</tr>';
                                $("#listaestadoAsigna").append(fila);
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
        $("#crea-estadoAsigna").click(function(e){
            e.preventDefault();
            limpiaform();
            habilitaform();
            $("#Accion").val("registrar");
            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                modal.find('.modal-title-form').text('Creación Estado Asignación');  
                deshabilitabotones();
                $('#guardar-estadoAsigna').show();
                $('#estadoAsignaTexto').focus();
            });
        });

        // implementacion boton para guardar el centro de costo
        $("#guardar-estadoAsigna").click(function(e){
            e.preventDefault();
            if(validarFormulario()==true){
                var datax = $("#formestadoAsigna").serializeArray();
                $.each(datax, function(i, field){
                    console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                });
                $.ajax({
                    data: datax, 
                    type: "POST",
                    dataType: "json", 
                    url: "controllers/controllerestadoasigna.php", 
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
        $("#editar-estadoAsigna").click(function(e){
            e.preventDefault();
            $('.modal-title-form').text('Editar Estado Asignación');
            habilitaform();
            deshabilitabotones();
            $('#actualizar-estadoAsigna').show();
            $("#Accion").val("actualizar");               
        });

        //  envia los nuevos datos para actualizar
        $("#actualizar-estadoAsigna").click(function(e){
                    // Detenemos el comportamiento normal del evento click sobre el elemento clicado
                    e.preventDefault();
                    if(validarFormulario()==true){
                        var datax = $("#formestadoAsigna").serializeArray();
                        /*   $.each(datax, function(i, field){
                            console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                        });*/
                        $.ajax({
                            data: datax,    // En data se puede utilizar un objeto JSON, un array o un query string
                            type: "POST",   //Cambiar a type: POST si necesario
                            dataType: "json",  // Formato de datos que se espera en la respuesta
                            url: "controllers/controllerestadoasigna.php",  // URL a la que se enviará la solicitud Ajax
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
        $("#eliminar-estadoAsigna").click(function(e){
            e.preventDefault();
            console.log("paso");
            var datax = $("#formDeleteestadoAsigna").serializeArray();

            console.log("paso2");

                    $.each(datax, function(i, field){
                        console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                    });
                console.log("paso3");
                    $.ajax({
                        data: datax, 
                        type: "POST",
                        dataType: "json", 
                        url: "controllers/controllerestadoasigna.php",
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
    function verestadoAsigna(action, est_asig_id){
        deshabilitabotones();
        console.log('pase');
        var datay = {"estadoAsignaId": est_asig_id,
                     "Accion":"obtener"
                    };
        $.ajax({
            data: datay, 
            type: "POST",
            dataType: "json", 
            url: "controllers/controllerestadoasigna.php",
        })
        .done(function(data,textStatus,jqXHR ) {
            if ( console && console.log ) {
                console.log( " data success : "+ data.success 
                    + " \n data msg : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
            $("#estadoAsignaId").val(data.datos.est_asigna_id);
            $("#estadoAsignaTexto").val(data.datos.est_asigna_texto);

            deshabilitaform();
            $("#Accion").val(action);

            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                if (action === 'actualizar'){
                    modal.find('.modal-title-form').text('Actualizar Estado Asignación');
                    $('#guardar-estadoAsigna').hide();                    
                    $('#actualizar-estadoAsigna').show();   
                }else if (action === 'ver'){
                    modal.find('.modal-title-form').text('Datos Estado Asignación');
                    deshabilitabotones();
                    $('#editar-estadoAsigna').show();   
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
    function deleteestadoAsigna(idestAsigna, txtestAsigna){     
        document.formDeleteestadoAsigna.estadoAsignaId.value = idestAsigna;
        document.formDeleteestadoAsigna.nameestadoAsigna.value = txtestAsigna;
        document.formDeleteestadoAsigna.Accion.value = "eliminar";
        $('#myModalDelete').on('shown.bs.modal', function () {
            $('#myInput').focus()
        });
    }
