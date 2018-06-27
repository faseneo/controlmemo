    function deshabilitabotones(){
        document.getElementById('editar-memodetcomp').style.display = 'none';
        document.getElementById('guardar-memodetcomp').style.display = 'none';
        document.getElementById('actualizar-memodetcomp').style.display = 'none';
    }
    function limpiaform(){
        $("#detcompId").val("");
        $("#detcompNombre").val("");
        $("#detcompCant").val("");
        $("#detcompValor").val("");
        $("#detcompTotal").val("");
    }        
    function habilitaform(){
        $("#detcompId").prop( "disabled", false );
        $("#detcompNombre").prop( "disabled", false );
        $("#detcompCant").prop( "disabled", false );
        $("#detcompValor").prop( "disabled", false );
        $("#detcompTotal").prop( "disabled", false );
    }
    function deshabilitaform(){
        $("#detcompId").prop( "disabled", true );
        $("#detcompNombre").prop( "disabled", true );
        $("#detcompCant").prop( "disabled", true );
        $("#detcompValor").prop( "disabled", true );
        $("#detcompTotal").prop( "disabled", true );
    }

    $(document).ready(function(){
        //funcion para validar campos del formulario
        function validarFormulario(){
            var txtNombre = document.getElementById('detcompNombre').value;
            var txtCantidad = document.getElementById('detcompCant').value;
            var txtValor = document.getElementById('detcompValor').value;
            var txtTotal = document.getElementById('detcompTotal').value;
                //Test campo obligatorio
                if(txtNombre == null || txtNombre.length == 0 || /^\s+$/.test(txtNombre)){
                    alert('ERROR: El campo nombre no debe ir vacío o con espacios en blanco');
                    document.getElementById('detcompNombre').focus();
                    return false;
                }
                if(txtCantidad == null || txtCantidad.length == 0 || /^\s+$/.test(txtCantidad)){
                    alert('ERROR: El campo cantidad no debe ir vacío o con espacios en blanco');
                    document.getElementById('detcompCant').focus();
                    return false;
                }
                if(txtValor == null || txtValor.length == 0 || /^\s+$/.test(txtValor)){
                    alert('ERROR: El campo valor no debe ir vacío o con espacios en blanco');
                    document.getElementById('detcompValor').focus();
                    return false;
                }
                if(txtTotal == null || txtTotal.length == 0 || /^\s+$/.test(txtTotal)){
                    alert('ERROR: El campo total no debe ir vacío o con espacios en blanco');
                    document.getElementById('detcompTotal').focus();
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
                url: "controllers/controllermemodetallecompra.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#listamemodetcomp").html("");
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                                //$.each(data.datos[i], function(k, v) { console.log(k + ' : ' + v); });
                                console.log('id: '+data.datos[i].memo_detalle_compra_id + ' nombre: '+data.datos[i].memo_detalle_compra_nom_producto);

                                fila = '<tr><td>'+ data.datos[i].memo_detalle_compra_nom_producto +'</td>';
                                fila += '<td>'+ data.datos[i].memo_detalle_compra_cantidad +'</td>';
                                fila += '<td>'+ data.datos[i].memo_detalle_compra_valor +'</td>';
                                fila += '<td>'+ data.datos[i].memo_detalle_compra_total +'</td>';
                                fila += '<td><button id="ver-memodetcomp" type="button" '
                                fila += 'class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal"'
                                fila += ' onclick="verMemoDetComp(\'ver\',\'' + data.datos[i].memo_detalle_compra_id + '\')">';
                                fila += 'Ver / Editar</button>';
                                fila += ' <button id="delete-language-modal" name="delete-language-modal" type="button" ';
                                fila += 'class="btn btn-xs btn-danger" data-toggle="modal" data-target="#myModalDelete" ';
                                fila += 'onclick="deleteMemoDetComp(\''+ data.datos[i].memo_detalle_compra_id +'\',\''
                                + data.datos[i].memo_detalle_compra_nom_producto +'\')">';
                                fila += 'Eliminar</button></td>';
                                fila += '</tr>';
                                $("#listamemodetcomp").append(fila);
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
        $("#crea-memodetcomp").click(function(e){
            e.preventDefault();
            limpiaform();
            habilitaform();
            $("#Accion").val("registrar");
            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                modal.find('.modal-title-form').text('Creación Detalle Compra');  
                deshabilitabotones();
                $('#guardar-memodetcomp').show();
                $('#detcompNombre').focus();
            });
        });

        // implementacion boton para guardar el centro de costo
        $("#guardar-memodetcomp").click(function(e){
            e.preventDefault();
            if(validarFormulario()==true){
                var datax = $("#formMemoDetComp").serializeArray();
                $.each(datax, function(i, field){
                    console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                });
                $.ajax({
                    data: datax, 
                    type: "POST",
                    dataType: "json", 
                    url: "controllers/controllermemodetallecompra.php", 
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
        $("#editar-memodetcomp").click(function(e){
            e.preventDefault();
            $('.modal-title-form').text('Editar Detalle Compra');
            habilitaform();
            deshabilitabotones();
            $('#actualizar-memodetcomp').show();
            $("#Accion").val("actualizar");               
        });

        //  envia los nuevos datos para actualizar
        $("#actualizar-memodetcomp").click(function(e){
                    // Detenemos el comportamiento normal del evento click sobre el elemento clicado
                    e.preventDefault();
                    if(validarFormulario()==true){
                        var datax = $("#formMemoDetComp").serializeArray();
                        /*   $.each(datax, function(i, field){
                            console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                        });*/
                        $.ajax({
                            data: datax,    // En data se puede utilizar un objeto JSON, un array o un query string
                            type: "POST",   //Cambiar a type: POST si necesario
                            dataType: "json",  // Formato de datos que se espera en la respuesta
                            url: "controllers/controllermemodetallecompra.php",  // URL a la que se enviará la solicitud Ajax
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
        $("#eliminar-memodetcomp").click(function(e){
            e.preventDefault();
            console.log("paso");
            var datax = $("#formDeleteMemoDetComp").serializeArray();

            console.log("paso2");

                    $.each(datax, function(i, field){
                        console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                    });
                console.log("paso3");
                    $.ajax({
                        data: datax, 
                        type: "POST",
                        dataType: "json", 
                        url: "controllers/controllermemodetallecompra.php",
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
    function verMemoDetComp(action, memodetcompid){
        deshabilitabotones();
        var datay = {"detcompId": memodetcompid,
                     "Accion":"obtener"
                    };
        $.ajax({
            data: datay, 
            type: "POST",
            dataType: "json", 
            url: "controllers/controllermemodetallecompra.php",
        })
        .done(function(data,textStatus,jqXHR ) {
            if ( console && console.log ) {
                console.log( " data success : "+ data.success 
                    + " \n data msg : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
            $("#detcompId").val(data.datos.memo_detalle_compra_id);
            $("#detcompNombre").val(data.datos.memo_detalle_compra_nom_producto);
            $("#detcompCant").val(data.datos.memo_detalle_compra_cantidad);
            $("#detcompValor").val(data.datos.memo_detalle_compra_valor);
            $("#detcompTotal").val(data.datos.memo_detalle_compra_total);

            deshabilitaform();
            $("#Accion").val(action);

            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                if (action === 'actualizar'){
                    modal.find('.modal-title-form').text('Actualizar Detalle Compra');
                    $('#guardar-memodetcomp').hide();                    
                    $('#actualizar-memodetcomp').show();   
                }else if (action === 'ver'){
                    modal.find('.modal-title-form').text('Datos Detalle Compra');
                    deshabilitabotones();
                    $('#editar-memodetcomp').show();   
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
    function deleteMemoDetComp(idmemodetcomp, namememodetcomp){     
        document.formDeleteMemoDetComp.detcompId.value = idmemodetcomp;
        document.formDeleteMemoDetComp.namememodetcomp.value = namememodetcomp;
        document.formDeleteMemoDetComp.Accion.value = "eliminar";
        $('#myModalDelete').on('shown.bs.modal', function () {
            $('#myInput').focus()
        });
    }      