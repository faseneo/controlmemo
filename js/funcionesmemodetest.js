        function deshabilitabotones(){
            document.getElementById('editar-memodetest').style.display = 'none';
            document.getElementById('guardar-memodetest').style.display = 'none';
            document.getElementById('actualizar-memodetest').style.display = 'none';
        }
        function limpiaform(){
            $("#memodetestId").val("");
            $("#memodetestTipo").val("");
        }        
        function habilitaform(){
            $("#memodetestId").prop( "disabled", false );
            $("#memodetestTipo").prop( "disabled", false );
        }
        function deshabilitaform(){
            $("#memodetestId").prop( "disabled", true );
            $("#memodetestTipo").prop( "disabled", true );
        }
$(document).ready(function(){
        function validarFormulario(){
            var txtTipo = document.getElementById('memodetestTipo').value;
                //Test campo obligatorio
                if(txtTipo == null || txtTipo.length == 0 || /^\s+$/.test(txtTipo)){
                    alert('ERROR: El campo tipo no debe ir vacío o con espacios en blanco');
                    document.getElementById('memodetestTipo').focus();
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
                url: "controllers/controllermemodetalleestado.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#listamemodetest").html("");
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                                //$.each(data.datos[i], function(k, v) { console.log(k + ' : ' + v); });
                                console.log('id: '+data.datos[i].memo_det_est_id + ' tipo: '+data.datos[i].memo_det_est_tipo);

                                fila = '<tr><td>'+ data.datos[i].memo_det_est_tipo +'</td>';
                                //fila += '<td>'+ data.datos[i].ccosto_codigo +'</td>';

                                fila += '<td><button id="ver-memodetest" type="button" '
                                fila += 'class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal"'
                                fila += ' onclick="verMemoDetEst(\'ver\',\'' + data.datos[i].memo_det_est_id + '\')">';
                                fila += 'Ver / Editar</button>';
                                fila += ' <button id="delete-language-modal" name="delete-language-modal" type="button" ';
                                fila += 'class="btn btn-xs btn-danger" data-toggle="modal" data-target="#myModalDelete" ';
                                fila += 'onclick="deleteMemoDetEst(\''+ data.datos[i].memo_det_est_id +'\',\''
                                + data.datos[i].memo_det_est_tipo +'\')">';
                                fila += 'Eliminar</button></td>';
                                fila += '</tr>';
                                $("#listamemodetest").append(fila);
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
        $("#crea-memodetest").click(function(e){
            e.preventDefault();
            limpiaform();
            habilitaform();
            $("#Accion").val("registrar");
            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                modal.find('.modal-title-form').text('Creación Memo Detalle Estado');  
                deshabilitabotones();
                $('#guardar-memodetest').show();
                $('#memodetestTipo').focus();
            });
        });

        // implementacion boton para guardar el centro de costo
        $("#guardar-memodetest").click(function(e){
            e.preventDefault();
            if(validarFormulario()==true){
                var datax = $("#formMemoDetEst").serializeArray();
                $.each(datax, function(i, field){
                    console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                });
                $.ajax({
                    data: datax, 
                    type: "POST",
                    dataType: "json", 
                    url: "controllers/controllermemodetalleestado.php", 
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
        $("#editar-memodetest").click(function(e){
            e.preventDefault();
            $('.modal-title-form').text('Editar Memo Detalle Estado');
            habilitaform();
            deshabilitabotones();
            $('#actualizar-memodetest').show();
            $("#Accion").val("actualizar");               
        });

        //  envia los nuevos datos para actualizar
        $("#actualizar-memodetest").click(function(e){
                    // Detenemos el comportamiento normal del evento click sobre el elemento clicado
                    e.preventDefault();
                    if(validarFormulario()==true){
                        var datax = $("#formMemoDetEst").serializeArray();
                        /*   $.each(datax, function(i, field){
                            console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                        });*/
                        $.ajax({
                            data: datax,    // En data se puede utilizar un objeto JSON, un array o un query string
                            type: "POST",   //Cambiar a type: POST si necesario
                            dataType: "json",  // Formato de datos que se espera en la respuesta
                            url: "controllers/controllermemodetalleestado.php",  // URL a la que se enviará la solicitud Ajax
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
        $("#eliminar-memodetest").click(function(e){
            e.preventDefault();
            console.log("paso");
            var datax = $("#formDeleteMemoDetEst").serializeArray();

            console.log("paso2");

                    $.each(datax, function(i, field){
                        console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                    });
                console.log("paso3");
                    $.ajax({
                        data: datax, 
                        type: "POST",
                        dataType: "json", 
                        url: "controllers/controllermemodetalleestado.php",
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
    function verMemoDetEst(action, memodetestid){
        deshabilitabotones();
        var datay = {"memodetestId": memodetestid,
                     "Accion":"obtener"
                    };
        $.ajax({
            data: datay, 
            type: "POST",
            dataType: "json", 
            url: "controllers/controllermemodetalleestado.php",
        })
        .done(function(data,textStatus,jqXHR ) {
            if ( console && console.log ) {
                console.log( " data success : "+ data.success 
                    + " \n data msg : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
            $("#memodetestId").val(data.datos.memo_det_est_id);
            $("#memodetestTipo").val(data.datos.memo_det_est_tipo);

            deshabilitaform();
            $("#Accion").val(action);

            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                if (action === 'actualizar'){
                    modal.find('.modal-title-form').text('Actualizar Memo Detalle Estado');
                    $('#guardar-memodetest').hide();                    
                    $('#actualizar-memodetest').show();   
                }else if (action === 'ver'){
                    modal.find('.modal-title-form').text('Datos Memo Detalle Estado');
                    deshabilitabotones();
                    $('#editar-memodetest').show();   
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
    function deleteMemoDetEst(idmemodetest, nameMemoDetEst){     
        document.formDeleteMemoDetEst.memodetestId.value = idmemodetest;
        document.formDeleteMemoDetEst.nameMemoDetEst.value = nameMemoDetEst;
        document.formDeleteMemoDetEst.Accion.value = "eliminar";
        $('#myModalDelete').on('shown.bs.modal', function () {
            $('#myInput').focus()
        });
    }      