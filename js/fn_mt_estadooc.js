        function deshabilitabotones(){
            document.getElementById('editar-estadoOC').style.display = 'none';
            document.getElementById('guardar-estadoOC').style.display = 'none';
            document.getElementById('actualizar-estadoOC').style.display = 'none';
        }
        function limpiaform(){
            $("#estadoOCId").val("");
            $("#estadoOCTipo").val("");
            $("#estadoOCPriori").val("");
            //$("#estadoOCActivo").val("");
        }        
        function habilitaform(){
            $("#estadoOCId").prop( "disabled", false );
            $("#estadoOCTipo").prop( "disabled", false );
            $("#estadoOCPriori").prop( "disabled", false );
            $("#estadoOCActivo").prop( "disabled", false );
        }
        function deshabilitaform(){
            $("#estadoOCId").prop( "disabled", true );
            $("#estadoOCTipo").prop( "disabled", true );
            $("#estadoOCPriori").prop( "disabled", true );
            $("#estadoOCActivo").prop( "disabled", true );
        }
$(document).ready(function(){
        function validarFormulario(){
            var txtTipo = document.getElementById('estadoOCTipo').value;
            var txtPriori = document.getElementById('estadoOCPriori').value;
            var selEstActivo = document.getElementById('estadoOCActivo').selectedIndex;

                //Test campo obligatorio
                if(txtTipo == null || txtTipo.length == 0 || /^\s+$/.test(txtTipo)){
                    alert('ERROR: El campo tipo no debe ir vacío o con espacios en blanco');
                    document.getElementById('estadoOCTipo').focus();
                    return false;
                }
                if(txtPriori == null || txtPriori.length == 0 || /^\s+$/.test(txtPriori)){
                    alert('ERROR: El campo prioridad no debe ir vacío o con espacios en blanco');
                    document.getElementById('estadoOCPriori').focus();
                    return false;
                }
                if( selEstActivo == null || isNaN(selEstActivo) || selEstActivo == -1 ) {
                    alert('ERROR: Debe selecciona una opcion');
                    document.getElementById('estadoOCActivo').focus();
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
                url: "controllers/controllerestadoocompra.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#listaestadoOC").html("");
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                                //$.each(data.datos[i], function(k, v) { console.log(k + ' : ' + v); });
                                console.log('id: '+data.datos[i].est_oc_id + ' tipo: '+data.datos[i].est_oc_tipo);
                               var activo = data.datos[i].est_oc_activo == 1 ? 'Activo':'Inactivo';

                                fila = '<tr><td>'+ data.datos[i].est_oc_tipo +'</td>';
                                fila += '<td>'+ data.datos[i].est_oc_prioridad +'</td>';
                                fila += '<td>'+ activo +'</td>';

                                fila += '<td><button id="ver-estadoOC" type="button" '
                                fila += 'class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal"'
                                fila += ' onclick="verestadoOC(\'ver\',\'' + data.datos[i].est_oc_id + '\')">';
                                fila += 'Ver / Editar</button>';
                                fila += ' <button id="delete-language-modal" name="delete-language-modal" type="button" ';
                                fila += 'class="btn btn-xs btn-danger" data-toggle="modal" data-target="#myModalDelete" ';
                                fila += 'onclick="deleteestadoOC(\''+ data.datos[i].est_oc_id +'\',\''
                                + data.datos[i].est_oc_tipo +'\')">';
                                fila += 'Eliminar</button></td>';
                                fila += '</tr>';
                                $("#listaestadoOC").append(fila);
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
        $("#crea-estadoOC").click(function(e){
            e.preventDefault();
            limpiaform();
            habilitaform();
            $("#Accion").val("registrar");
            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                modal.find('.modal-title-form').text('Creación Estado Orden de Compra');  
                deshabilitabotones();
                $('#guardar-estadoOC').show();
                $('#estadoOCTipo').focus();
            });
        });

        // implementacion boton para guardar el centro de costo
        $("#guardar-estadoOC").click(function(e){
            e.preventDefault();
            if(validarFormulario()==true){
                var datax = $("#formestadoOC").serializeArray();
                $.each(datax, function(i, field){
                    console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                });
                $.ajax({
                    data: datax, 
                    type: "POST",
                    dataType: "json", 
                    url: "controllers/controllerestadoocompra.php", 
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
        $("#editar-estadoOC").click(function(e){
            e.preventDefault();
            $('.modal-title-form').text('Editar Estado Orden de Compra');
            habilitaform();
            deshabilitabotones();
            $('#actualizar-estadoOC').show();
            $("#Accion").val("actualizar");               
        });

        //  envia los nuevos datos para actualizar
        $("#actualizar-estadoOC").click(function(e){
                    // Detenemos el comportamiento normal del evento click sobre el elemento clicado
                    e.preventDefault();
                    if(validarFormulario()==true){
                        var datax = $("#formestadoOC").serializeArray();
                        /*   $.each(datax, function(i, field){
                            console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                        });*/
                        $.ajax({
                            data: datax,    // En data se puede utilizar un objeto JSON, un array o un query string
                            type: "POST",   //Cambiar a type: POST si necesario
                            dataType: "json",  // Formato de datos que se espera en la respuesta
                            url: "controllers/controllerestadoocompra.php",  // URL a la que se enviará la solicitud Ajax
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
        $("#eliminar-estadoOC").click(function(e){
            e.preventDefault();
            console.log("paso");
            var datax = $("#formDeleteestadoOC").serializeArray();

            console.log("paso2");

                    $.each(datax, function(i, field){
                        console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                    });
                console.log("paso3");
                    $.ajax({
                        data: datax, 
                        type: "POST",
                        dataType: "json", 
                        url: "controllers/controllerestadoocompra.php",
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
    function verestadoOC(action, estadoOC_id){
        deshabilitabotones();
        var datay = {"estadoOCId": estadoOC_id,
                     "Accion":"obtener"
                    };
        $.ajax({
            data: datay, 
            type: "POST",
            dataType: "json", 
            url: "controllers/controllerestadoocompra.php",
        })
        .done(function(data,textStatus,jqXHR ) {
            if ( console && console.log ) {
                console.log( " data success : "+ data.success 
                    + " \n data msg : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
            $("#estadoOCId").val(data.datos.est_oc_id);
            $("#estadoOCTipo").val(data.datos.est_oc_tipo);
            $("#estadoOCPriori").val(data.datos.est_oc_prioridad);
            $("#estadoOCActivo").val(data.datos.est_oc_activo);

            deshabilitaform();
            $("#Accion").val(action);

            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                if (action === 'actualizar'){
                    modal.find('.modal-title-form').text('Actualizar Estado Orden de Compra');
                    $('#guardar-estadoOC').hide();                    
                    $('#actualizar-estadoOC').show();   
                }else if (action === 'ver'){
                    modal.find('.modal-title-form').text('Datos Estado Orden de Compra');
                    deshabilitabotones();
                    $('#editar-estadoOC').show();   
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
    function deleteestadoOC(idestadoOC, nameestadoOC){     
        document.formDeleteestadoOC.estadoOCId.value = idestadoOC;
        document.formDeleteestadoOC.nameestadoOC.value = nameestadoOC;
        document.formDeleteestadoOC.Accion.value = "eliminar";
        $('#myModalDelete').on('shown.bs.modal', function () {
            $('#myInput').focus()
        });
    }      