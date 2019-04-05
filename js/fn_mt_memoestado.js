        var bgcolor='white-bg';
        var txtcolor='black-text';

        function deshabilitabotones(){
            document.getElementById('editar-memoest').style.display = 'none';
            document.getElementById('guardar-memoest').style.display = 'none';
            document.getElementById('actualizar-memoest').style.display = 'none';
        }
        function limpiaform(){
            bgcolor='white-bg';
            txtcolor='black-text';            
            $('#ejcolor').attr('class','form-control ' + bgcolor + ' ' + txtcolor);
            $("#memoestId").val("");
            $("#memoestTipo").val("");
			$("#memoestOrden").val("");
        }

        function habilitaform(){
            $("#memoestId").prop( "disabled", false );
            $("#memoestTipo").prop( "disabled", false );
            $("#memoestOrden").prop( "disabled", false );
            $("#memoestDesc").prop( "disabled", false );
            $("#memoestColorbg").prop( "disabled", false );
            $("#memoestColortxt").prop( "disabled", false );
            $("#memoestActivo").prop( "disabled", false );
            $("#memoestDeptoId").prop( "disabled", false );
        }

        function deshabilitaform(){
            $("#memoestId").prop( "disabled", true );
            $("#memoestTipo").prop( "disabled", true );
            $("#memoestDesc").prop( "disabled", true );
            $("#memoestColorbg").prop( "disabled", true );
            $("#memoestColortxt").prop( "disabled", true );            
            $("#memoestOrden").prop( "disabled", true );
            $("#memoestActivo").prop( "disabled", true );
            $("#memoestDeptoId").prop( "disabled", true );            
        }

        var getlistadepto = function (){
            var datax = {
                "Accion":"listarminhabilita"
            }
            $.ajax({
                data: datax, 
                type: "GET",
                dataType: "json", 
                url: "controllers/controllerdepartamento.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#memoestDeptoId").html("");
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                    console.log('id: '+data.datos[i].depto_id + ' tipo: '+data.datos[i].depto_nombre);
                    opcion = '<option value='+ data.datos[i].depto_id +'>'+data.datos[i].depto_nombre+'</option>';
                    $("#memoestDeptoId").append(opcion);
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
    getlistadepto();
    $(document).ready(function(){
        function validarFormulario(){
            var txtTipo = document.getElementById('memoestTipo').value;
            var txtPriori = document.getElementById('memoestOrden').value;
            var selEstActivo = document.getElementById('memoestActivo').selectedIndex;
            var selEstdepto = document.getElementById('memoestDeptoId').selectedIndex;
                //Test campo obligatorio
                if(txtTipo == null || txtTipo.length == 0 || /^\s+$/.test(txtTipo)){
                    alert('ERROR: El campo Nombre Estado no debe ir vacío o con espacios en blanco');
                    document.getElementById('memoestTipo').focus();
                    return false;
                } 
                if(txtPriori == null || txtPriori.length == 0 || /^\s+$/.test(txtPriori)){
                    alert('ERROR: El campo Prioridad no debe ir vacío o con espacios en blanco');
                    document.getElementById('memoestOrden').focus();
                    return false;
                }
                if( selEstActivo == null || isNaN(selEstActivo) || selEstActivo == -1 ) {
                    /*$('#memoestActivo').parent().attr('class','form-group has-error');
                    $('#memoestActivo').parent().children('span').text('Debe seleccionar un Departamento o Unidad Solicitante').show();*/
                    alert('ERROR: Debe selecciona una opcion');
                    document.getElementById('memoestActivo').focus();
                    return false;
                }
                if( selEstdepto == null || isNaN(selEstdepto) || selEstdepto == -1 ) {
                    /*$('#memoestActivo').parent().attr('class','form-group has-error');
                    $('#memoestActivo').parent().children('span').text('Debe seleccionar un Departamento o Unidad Solicitante').show();*/
                    alert('ERROR: Debe selecciona una opcion');
                    document.getElementById('memoestDeptoId').focus();
                    return false;                    
                }
            return true;
        }         
        deshabilitabotones();
        //funcion para listar los cecostos
        var getlista = function (){
            var datax = {
                "Accion":"listar",
                'depto':'null'
            }
            $.ajax({
                data: datax, 
                type: "GET",
                dataType: "json", 
                url: "controllers/controllermemoestado.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#listamemoestado").html("");
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                                //$.each(data.datos[i], function(k, v) { console.log(k + ' : ' + v); });
                                console.log('id: '+data.datos[i].memo_est_id + ' tipo: '+data.datos[i].memo_est_tipo);
                                $clasetr = (data.datos[i].memo_est_depto_id % 9) ? 'class="fila1"':'class="fila2"';
                                var activo = data.datos[i].memo_est_activo == 1 ? 'Activo':'Inactivo';

                                fila = '<tr '+$clasetr+'>';
                                fila += '<td class="'+ data.datos[i].memo_est_colorbg + ' '+ data.datos[i].memo_est_colortxt+'">'+ data.datos[i].memo_est_tipo +'</td>';
                                fila += '<td>'+ data.datos[i].memo_est_depto_nombre +'</td>';
                                fila += '<td>'+ data.datos[i].memo_est_orden +'</td>';
                                fila += '<td>'+ activo +'</td>';
                                fila += '<td><button id="ver-memoest" type="button" '
                                fila += 'class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal"'
                                fila += ' onclick="verMemoEst(\'ver\',\'' + data.datos[i].memo_est_id + '\')">';
                                fila += 'Ver / Editar</button>';
                                fila += ' <button id="delete-language-modal" name="delete-language-modal" type="button" ';
                                fila += 'class="btn btn-xs btn-danger" data-toggle="modal" data-target="#myModalDelete" ';
                                fila += 'onclick="deleteMemoEst(\''+ data.datos[i].memo_est_id +'\',\''
                                + data.datos[i].memo_est_tipo +'\')">';
                                fila += 'Eliminar</button></td>';
                                fila += '</tr>';
                                $("#listamemoestado").append(fila);
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
        $("#crea-memoest").click(function(e){
            e.preventDefault();
            limpiaform();
            habilitaform();
            $("#Accion").val("registrar");
            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                modal.find('.modal-title-form').text('Creación Memo Estado');  
                deshabilitabotones();
                $('#guardar-memoest').show();
                $('#memoestTipo').focus();
            });
        });

        // implementacion boton para guardar el centro de costo
        $("#guardar-memoest").click(function(e){
            e.preventDefault();
            if(validarFormulario()==true){
                var datax = $("#formMemoEst").serializeArray();
                $.each(datax, function(i, field){
                    console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                });
                $.ajax({
                    data: datax, 
                    type: "POST",
                    dataType: "json", 
                    url: "controllers/controllermemoestado.php", 
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
        $("#editar-memoest").click(function(e){
            e.preventDefault();
            $('.modal-title-form').text('Editar Memo Estado');
            habilitaform();
            deshabilitabotones();
            $('#actualizar-memoest').show();
            $("#Accion").val("actualizar");               
        });

        //  envia los nuevos datos para actualizar
        $("#actualizar-memoest").click(function(e){
                    // Detenemos el comportamiento normal del evento click sobre el elemento clicado
                    e.preventDefault();
                    if(validarFormulario()==true){
                        var datax = $("#formMemoEst").serializeArray();
                        /*   $.each(datax, function(i, field){
                            console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                        });*/
                        $.ajax({
                            data: datax,    // En data se puede utilizar un objeto JSON, un array o un query string
                            type: "POST",   //Cambiar a type: POST si necesario
                            dataType: "json",  // Formato de datos que se espera en la respuesta
                            url: "controllers/controllermemoestado.php",  // URL a la que se enviará la solicitud Ajax
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
        $("#eliminar-memoest").click(function(e){
            e.preventDefault();
            console.log("paso");
            var datax = $("#formDeleteMemoEst").serializeArray();

            console.log("paso2");

                    $.each(datax, function(i, field){
                        console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                    });
                console.log("paso3");
                    $.ajax({
                        data: datax, 
                        type: "POST",
                        dataType: "json", 
                        url: "controllers/controllermemoestado.php",
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

        $("#memoestColorbg").change(function(event) {
            bgcolor = $("#memoestColorbg").val();
            $('#ejcolor').attr('class','form-control ' + bgcolor + ' ' + txtcolor);
        });
        $("#memoestColortxt").change(function(event) {
            txtcolor = $("#memoestColortxt").val();
            $('#ejcolor').attr('class','form-control ' + txtcolor + ' ' + bgcolor);
        });
        
    });
    //funcion levanta modal y muestra  los datos del centro de costo cuando presion boton Ver/Editar, aca se puede mdificar si quiere
    function verMemoEst(action, memoestid){
        deshabilitabotones();
        limpiaform();
        var datay = {"memoestId": memoestid,
                     "Accion":"obtener"
                    };
        $.ajax({
            data: datay, 
            type: "POST",
            dataType: "json", 
            url: "controllers/controllermemoestado.php",
        })
        .done(function(data,textStatus,jqXHR ) {
            if ( console && console.log ) {
                console.log( " data success : "+ data.success 
                    + " \n data msg : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
            $("#memoestId").val(data.datos.memo_est_id);
            $("#memoestTipo").val(data.datos.memo_est_tipo);
            $("#memoestOrden").val(data.datos.memo_est_orden);
            $("#memoestDesc").val(data.datos.memo_est_desc);
            $("#memoestColorbg").val(data.datos.memo_est_colorbg);
            $("#memoestColortxt").val(data.datos.memo_est_colortxt);
            $("#memoestActivo").val(data.datos.memo_est_activo);
            $("#memoestDeptoId").val(data.datos.memo_est_depto_id);

            deshabilitaform();
            $("#Accion").val(action);

            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                if (action === 'actualizar'){
                    modal.find('.modal-title-form').text('Actualizar Memo Estado');
                    $('#guardar-memoest').hide();                    
                    $('#actualizar-memoest').show();   
                }else if (action === 'ver'){
                    modal.find('.modal-title-form').text('Datos Memo Estado');
                    deshabilitabotones();
                    $('#editar-memoest').show();   
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
    function deleteMemoEst(idmemoest, nameMemoest){     
        document.formDeleteMemoEst.memoestId.value = idmemoest;
        document.formDeleteMemoEst.nameMemoest.value = nameMemoest;
        document.formDeleteMemoEst.Accion.value = "eliminar";
        $('#myModalDelete').on('shown.bs.modal', function () {
            $('#myInput').focus()
        });
    }  