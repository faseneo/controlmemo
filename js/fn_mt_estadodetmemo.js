        function deshabilitabotones(){
            document.getElementById('editar-estadoDM').style.display = 'none';
            document.getElementById('guardar-estadoDM').style.display = 'none';
            document.getElementById('actualizar-estadoDM').style.display = 'none';
        }
        function limpiaform(){
            $("#estadoDMId").val("");
            $("#estadoDMTipo").val("");
            $("#estadoDMOrden").val("");
            //$("#estadoDMActivo").val("");
        }        
        function habilitaform(){
            $("#estadoDMId").prop( "disabled", false );
            $("#estadoDMTipo").prop( "disabled", false );
            $("#estadoDMOrden").prop( "disabled", false );
            $("#estadoDMActivo").prop( "disabled", false );
        }
        function deshabilitaform(){
            $("#estadoDMId").prop( "disabled", true );
            $("#estadoDMTipo").prop( "disabled", true );
            $("#estadoDMOrden").prop( "disabled", true );
            $("#estadoDMActivo").prop( "disabled", true );
        }
$(document).ready(function(){
        function validarFormulario(){
            var txtTipo = document.getElementById('estadoDMTipo').value;
            var txtPriori = document.getElementById('estadoDMOrden').value;
            var selEstActivo = document.getElementById('estadoDMActivo').selectedIndex;

                //Test campo obligatorio
                if(txtTipo == null || txtTipo.length == 0 || /^\s+$/.test(txtTipo)){
                    alert('ERROR: El campo tipo no debe ir vacío o con espacios en blanco');
                    document.getElementById('estadoDMTipo').focus();
                    return false;
                }
                if(txtPriori == null || txtPriori.length == 0 || /^\s+$/.test(txtPriori)){
                    alert('ERROR: El campo prioridad no debe ir vacío o con espacios en blanco');
                    document.getElementById('estadoDMOrden').focus();
                    return false;
                }
                if( selEstActivo == null || isNaN(selEstActivo) || selEstActivo == -1 ) {
                    alert('ERROR: Debe selecciona una opcion');
                    document.getElementById('estadoDMActivo').focus();
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
                url: "controllers/controllerestadodetmemo.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#listaestadoDM").html("");
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                                //$.each(data.datos[i], function(k, v) { console.log(k + ' : ' + v); });
                                console.log('id: '+data.datos[i].est_detmemo_id + ' tipo: '+data.datos[i].est_detmemo_tipo);
                               var activo = data.datos[i].est_detmemo_activo == 1 ? 'Activo':'Inactivo';

                                fila = '<tr><td>'+ data.datos[i].est_detmemo_tipo +'</td>';
                                fila += '<td>'+ data.datos[i].est_detmemo_orden +'</td>';
                                fila += '<td>'+ activo +'</td>';

                                fila += '<td><button id="ver-estadoDM" type="button" '
                                fila += 'class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal"'
                                fila += ' onclick="verestadoDM(\'ver\',\'' + data.datos[i].est_detmemo_id + '\')">';
                                fila += 'Ver / Editar</button>';
                                fila += ' <button id="delete-language-modal" name="delete-language-modal" type="button" ';
                                fila += 'class="btn btn-xs btn-danger" data-toggle="modal" data-target="#myModalDelete" ';
                                fila += 'onclick="deleteestadoDM(\''+ data.datos[i].est_detmemo_id +'\',\''
                                + data.datos[i].est_detmemo_tipo +'\')">';
                                fila += 'Eliminar</button></td>';
                                fila += '</tr>';
                                $("#listaestadoDM").append(fila);
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
        $("#crea-estadoDM").click(function(e){
            e.preventDefault();
            limpiaform();
            habilitaform();
            $("#Accion").val("registrar");
            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                modal.find('.modal-title-form').text('Creación Estado Detalle Memo');  
                deshabilitabotones();
                $('#guardar-estadoDM').show();
                $('#estadoDMTipo').focus();
            });
        });

        // implementacion boton para guardar el centro de costo
        $("#guardar-estadoDM").click(function(e){
            e.preventDefault();
            if(validarFormulario()==true){
                var datax = $("#formestadoDM").serializeArray();
                $.each(datax, function(i, field){
                    console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                });
                $.ajax({
                    data: datax, 
                    type: "POST",
                    dataType: "json", 
                    url: "controllers/controllerestadodetmemo.php", 
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
        $("#editar-estadoDM").click(function(e){
            e.preventDefault();
            $('.modal-title-form').text('Editar Estado Detalle Memo');
            habilitaform();
            deshabilitabotones();
            $('#actualizar-estadoDM').show();
            $("#Accion").val("actualizar");               
        });

        //  envia los nuevos datos para actualizar
        $("#actualizar-estadoDM").click(function(e){
                    // Detenemos el comportamiento normal del evento click sobre el elemento clicado
                    e.preventDefault();
                    if(validarFormulario()==true){
                        var datax = $("#formestadoDM").serializeArray();
                        /*   $.each(datax, function(i, field){
                            console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                        });*/
                        $.ajax({
                            data: datax,    // En data se puede utilizar un objeto JSON, un array o un query string
                            type: "POST",   //Cambiar a type: POST si necesario
                            dataType: "json",  // Formato de datos que se espera en la respuesta
                            url: "controllers/controllerestadodetmemo.php",  // URL a la que se enviará la solicitud Ajax
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
        $("#eliminar-estadoDM").click(function(e){
            e.preventDefault();
            console.log("paso");
            var datax = $("#formDeleteestadoDM").serializeArray();

            console.log("paso2");

                    $.each(datax, function(i, field){
                        console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                    });
                console.log("paso3");
                    $.ajax({
                        data: datax, 
                        type: "POST",
                        dataType: "json", 
                        url: "controllers/controllerestadodetmemo.php",
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
    function verestadoDM(action, estadoDM_id){
        deshabilitabotones();
        var datay = {"estadoDMId": estadoDM_id,
                     "Accion":"obtener"
                    };
        $.ajax({
            data: datay, 
            type: "POST",
            dataType: "json", 
            url: "controllers/controllerestadodetmemo.php",
        })
        .done(function(data,textStatus,jqXHR ) {
            if ( console && console.log ) {
                console.log( " data success : "+ data.success 
                    + " \n data msg : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
            $("#estadoDMId").val(data.datos.est_detmemo_id);
            $("#estadoDMTipo").val(data.datos.est_detmemo_tipo);
            $("#estadoDMOrden").val(data.datos.est_detmemo_orden);
            $("#estadoDMActivo").val(data.datos.est_detmemo_activo);

            deshabilitaform();
            $("#Accion").val(action);

            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                if (action === 'actualizar'){
                    modal.find('.modal-title-form').text('Actualizar Estado Detalle Memo');
                    $('#guardar-estadoDM').hide();                    
                    $('#actualizar-estadoDM').show();   
                }else if (action === 'ver'){
                    modal.find('.modal-title-form').text('Datos Estado Detalle Memo');
                    deshabilitabotones();
                    $('#editar-estadoDM').show();   
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
    function deleteestadoDM(idestadoDM, nameestadoDM){     
        document.formDeleteestadoDM.estadoDMId.value = idestadoDM;
        document.formDeleteestadoDM.nameestadoDM.value = nameestadoDM;
        document.formDeleteestadoDM.Accion.value = "eliminar";
        $('#myModalDelete').on('shown.bs.modal', function () {
            $('#myInput').focus()
        });
    }      