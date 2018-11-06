    function deshabilitabotones(){
        document.getElementById('editar-proccomp').style.display = 'none';
        document.getElementById('guardar-proccomp').style.display = 'none';
        document.getElementById('actualizar-proccomp').style.display = 'none';
    }
    function limpiaform(){
        $("#proccompId").val("");
        $("#proccompTipo").val("");
        $("#proccompOrden").val("");
        $("#proccompDescrip").val("");
    }        
    function habilitaform(){
        $("#proccompId").prop( "disabled", false );
        $("#proccompTipo").prop( "disabled", false );
        $("#proccompOrden").prop( "disabled", false );
        $("#proccompDescrip").prop( "disabled", false );
        $("#proccompActivo").prop( "disabled", false );
    }
    function deshabilitaform(){
        $("#proccompId").prop( "disabled", true );
        $("#proccompTipo").prop( "disabled", true );
        $("#proccompOrden").prop( "disabled", true );
        $("#proccompDescrip").prop( "disabled", true );
        $("#proccompActivo").prop( "disabled", true );
    }

    $(document).ready(function(){
        //funcion para validar campos del formulario
        function validarFormulario(){
            var txtTipo = document.getElementById('proccompTipo').value;
            var txtPriori = document.getElementById('proccompOrden').value;
            var txtDescrip = document.getElementById('proccompDescrip').value;
            var proctActivo = document.getElementById('proccompActivo').selectedIndex;
                //Test campo obligatorio
                if(txtTipo == null || txtTipo.length == 0 || /^\s+$/.test(txtTipo)){
                    alert('ERROR: El campo tipo no debe ir vacío o con espacios en blanco');
                    document.getElementById('proccompTipo').focus();
                    return false;
                }   
                if(txtDescrip == null || txtDescrip.length == 0 || /^\s+$/.test(txtDescrip)){
                    alert('ERROR: El campo prioridad no debe ir vacío o con espacios en blanco');
                    document.getElementById('proccompDescrip').focus();
                    return false;
                }                
                if(txtPriori == null || txtPriori.length == 0 || /^\s+$/.test(txtPriori)){
                    alert('ERROR: El campo prioridad no debe ir vacío o con espacios en blanco');
                    document.getElementById('proccompOrden').focus();
                    return false;
                }
                if( proctActivo == null || isNaN(proctActivo) || proctActivo == -1 ) {
                    alert('ERROR: Debe selecciona una opcion');
                    document.getElementById('proccompActivo').focus();
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
                url: "controllers/controllerprocedimientocompra.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#listaproccomp").html("");
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                                //$.each(data.datos[i], function(k, v) { console.log(k + ' : ' + v); });
                                console.log('id: '+data.datos[i].proc_comp_id + ' tipo: '+data.datos[i].proc_comp_tipo);
                                var activo = data.datos[i].proc_activo == 1 ? 'Activo':'Inactivo';

                                fila = '<tr><td>'+ data.datos[i].proc_comp_tipo +'</td>';
                                fila += '<td>' + data.datos[i].proc_descrip +'</td>';
                                fila += '<td>' + data.datos[i].proc_orden +'</td>';
                                fila += '<td>' + activo + '</td>';
                                fila += '<td><button id="ver-proccomp" type="button" '
                                fila += 'class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal"'
                                fila += ' onclick="verProcComp(\'ver\',\'' + data.datos[i].proc_comp_id + '\')">';
                                fila += 'Ver / Editar</button>';
                                fila += ' <button id="delete-language-modal" name="delete-language-modal" type="button" ';
                                fila += 'class="btn btn-xs btn-danger" data-toggle="modal" data-target="#myModalDelete" ';
                                fila += 'onclick="deleteProcComp(\''+ data.datos[i].proc_comp_id +'\',\''
                                + data.datos[i].proc_comp_tipo +'\')">';
                                fila += 'Eliminar</button></td>';
                                fila += '</tr>';
                                $("#listaproccomp").append(fila);
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
        $("#crea-proccomp").click(function(e){
            e.preventDefault();
            limpiaform();
            habilitaform();
            $("#Accion").val("registrar");
            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                modal.find('.modal-title-form').text('Creación Procedimiento de Compra');  
                deshabilitabotones();
                $('#guardar-proccomp').show();
                $('#proccompTipo').focus();
            });
        });

        // implementacion boton para guardar el centro de costo
        $("#guardar-proccomp").click(function(e){
            e.preventDefault();
            if(validarFormulario()==true){
                var datax = $("#formProcComp").serializeArray();
                $.each(datax, function(i, field){
                    console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                });
                $.ajax({
                    data: datax, 
                    type: "POST",
                    dataType: "json", 
                    url: "controllers/controllerprocedimientocompra.php", 
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
        $("#editar-proccomp").click(function(e){
            e.preventDefault();
            $('.modal-title-form').text('Editar Procedimiento de Compra');
            habilitaform();
            deshabilitabotones();
            $('#actualizar-proccomp').show();
            $("#Accion").val("actualizar");               
        });

        //  envia los nuevos datos para actualizar
        $("#actualizar-proccomp").click(function(e){
                    // Detenemos el comportamiento normal del evento click sobre el elemento clicado
                    e.preventDefault();
                    if(validarFormulario()==true){
                        var datax = $("#formProcComp").serializeArray();
                        /*   $.each(datax, function(i, field){
                            console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                        });*/
                        $.ajax({
                            data: datax,    // En data se puede utilizar un objeto JSON, un array o un query string
                            type: "POST",   //Cambiar a type: POST si necesario
                            dataType: "json",  // Formato de datos que se espera en la respuesta
                            url: "controllers/controllerprocedimientocompra.php",  // URL a la que se enviará la solicitud Ajax
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
        $("#eliminar-proccomp").click(function(e){
            e.preventDefault();
            console.log("paso");
            var datax = $("#formDeleteProcComp").serializeArray();

            console.log("paso2");

                    $.each(datax, function(i, field){
                        console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                    });
                console.log("paso3");
                    $.ajax({
                        data: datax, 
                        type: "POST",
                        dataType: "json", 
                        url: "controllers/controllerprocedimientocompra.php",
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
    function verProcComp(action, proccompid){
        deshabilitabotones();
        var datay = {"proccompId": proccompid,
                     "Accion":"obtener"
                    };
        $.ajax({
            data: datay, 
            type: "POST",
            dataType: "json", 
            url: "controllers/controllerprocedimientocompra.php",
        })
        .done(function(data,textStatus,jqXHR ) {
            if ( console && console.log ) {
                console.log( " data success : "+ data.success 
                    + " \n data msg : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
            console.log(data.datos.proc_descrip);
            $("#proccompId").val(data.datos.proc_comp_id);
            $("#proccompTipo").val(data.datos.proc_comp_tipo);
            $("#proccompDescrip").val(data.datos.proc_descrip);
            $("#proccompOrden").val(data.datos.proc_orden);
            $("#proccompActivo").val(data.datos.proc_activo);

            deshabilitaform();
            $("#Accion").val(action);

            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                if (action === 'actualizar'){
                    modal.find('.modal-title-form').text('Actualizar Procedimiento de Compra');
                    $('#guardar-proccomp').hide();                    
                    $('#actualizar-proccomp').show();   
                }else if (action === 'ver'){
                    modal.find('.modal-title-form').text('Datos procedimiento de Compra');
                    deshabilitabotones();
                    $('#editar-proccomp').show();   
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
    function deleteProcComp(idproccomp, nameproccomp){     
        document.formDeleteProcComp.proccompId.value = idproccomp;
        document.formDeleteProcComp.nameproccomp.value = nameproccomp;
        document.formDeleteProcComp.Accion.value = "eliminar";
        $('#myModalDelete').on('shown.bs.modal', function () {
            $('#myInput').focus()
        });
    }    