        function deshabilitabotones(){
            document.getElementById('editar-depto').style.display = 'none';
            document.getElementById('guardar-depto').style.display = 'none';
            document.getElementById('actualizar-depto').style.display = 'none';
        }

        function limpiaform(){
            $("#deptoId").val("");
            $("#deptoNombre").val("");
            $("#deptoNombreCorto").val("");
        }        

        function habilitaform(){
            $("#deptoId").prop("disabled", false );
            $("#deptoNombre").prop("disabled", false );
            $("#deptoNombreCorto").prop("disabled", false );
            $("#deptoEstado").prop("disabled", false );
            $("#deptoHabilitado").prop("disabled", false );
        }
        function deshabilitaform(){
            $("#deptoId").prop( "disabled", true );
            $("#deptoNombre").prop( "disabled", true );
            $("#deptoNombreCorto").prop("disabled", true );
            $("#deptoEstado").prop("disabled", true );
            $("#deptoHabilitado").prop("disabled", true );
        }

    $(document).ready(function(){
        var titulo='';
        function validarFormulario(){
            var txtNombre = document.getElementById('deptoNombre').value;
            var txtnomcorto = document.getElementById('deptoNombreCorto').value;
                //Test campo obligatorio
                if(txtNombre == null || txtNombre.length == 0 || /^\s+$/.test(txtNombre)){
                    alert('ERROR: El campo nombre no debe ir vacío o con espacios en blanco');
                    document.getElementById('deptoNombre').focus();
                    return false;
                }
                if(txtnomcorto == null || txtnomcorto.length == 0 || /^\s+$/.test(txtnomcorto)){
                    alert('ERROR: El campo nombre no debe ir vacío o con espacios en blanco');
                    document.getElementById('deptoNombreCorto').focus();
                    return false;
                }
            return true;
        }         
        //funcion para listar los Deptos.
        var getlista = function (){
            var datax = {
                "Accion":"listar"
            }
            $.ajax({
                data: datax, 
                type: "GET",
                dataType: "json", 
                url: "controllers/controllerdepartamento.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#listadepto").html("");
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                                //$.each(data.datos[i], function(k, v) { console.log(k + ' : ' + v); });
                                console.log('id: '+data.datos[i].depto_id + ' nombre: '+data.datos[i].depto_nombre);
                                fila = '<tr><td>'+ data.datos[i].depto_nombre +'</td>';
                                if(data.datos[i].depto_nomcorto==null){
                                    fila += '<td></td>';
                                }else{
                                    fila += '<td>'+ data.datos[i].depto_nomcorto +'</td>';
                                }
                                fila += '<td><button id="ver-depto" type="button" '
                                fila += 'class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal"'
                                fila += ' onclick="verDepto(\'ver\',\'' + data.datos[i].depto_id + '\')">';
                                fila += 'Ver / Editar</button>';
                                fila += '</td>';
                                fila += '<td class="text-center">';
                                if(data.datos[i].depto_estado==1){
                                    fila += '<span class="glyphicon glyphicon-ok text-success"></span>';
                                }else{
                                    fila += '<span class="glyphicon glyphicon-remove text-danger"></span>';
                                }
                                fila += '</td>';
                                fila += '<td class="text-center">';
                                if(data.datos[i].depto_habilita==1){
                                    fila += '<span class="glyphicon glyphicon-ok text-success"></span>';
                                }else{
                                    fila += '<span class="glyphicon glyphicon-remove text-danger"></span>';
                                }
                                fila += '</td>';
                                fila += '</tr>';
                                $("#listadepto").append(fila);
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
        deshabilitabotones();
        getlista();

/*        $('.texto-gris').each(function() {            
            var valorActual = $(this).val();
         
            $(this).focus(function(){                
                if( $(this).val() == valorActual ) {
                    $(this).val('');
                    $(this).removeClass('texto-gris');
                };
            });
         
            $(this).blur(function(){
                if( $(this).val() == '' ) {
                    $(this).val(valorActual);
                    $(this).addClass('texto-gris');
                };
            });
        });*/
        $("#busqueda").keyup(function(){
            if( $(this).val() != ""){
                $("#listadodepto tbody>tr").hide();
                $("#listadodepto td:contiene-palabra('" + $(this).val() + "')").parent("tr").show();
            }else{
                $("#listadodepto tbody>tr").show();
            }
        });
        $.extend($.expr[":"], 
            {
            "contiene-palabra": function(elem, i, match, array) {
                return (elem.textContent || elem.innerText || $(elem).text() || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
            }
        });

        //Levanta modal nuevo centro de costos
        $("#crea-depto").click(function(e){
            e.preventDefault();
            limpiaform();
            habilitaform();
            $("#Accion").val("registrar");
            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                modal.find('.modal-title-form').text('Creación Departamento');  
                deshabilitabotones();
                $('#guardar-depto').show();
                $('#deptoNombre').focus();
            });
        });
        // implementacion boton para guardar el centro de costo
        $("#guardar-depto").click(function(e){
            e.preventDefault();
            if(validarFormulario()==true){
                var datax = $("#formDepto").serializeArray();
                $.each(datax, function(i, field){
                    console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                });
                $.ajax({
                    data: datax, 
                    type: "POST",
                    dataType: "json", 
                    url: "controllers/controllerdepartamento.php", 
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
        $("#editar-depto").click(function(e){
            e.preventDefault();
            $('.modal-title-form').text('Editar Departamento');
            habilitaform();
            deshabilitabotones();
            $('#actualizar-depto').show();
            $("#Accion").val("actualizar");               
        });
        //  envia los nuevos datos para actualizar
        $("#actualizar-depto").click(function(e){
                    // Detenemos el comportamiento normal del evento click sobre el elemento clicado
                    e.preventDefault();
                    if(validarFormulario()==true){
                        var datax = $("#formDepto").serializeArray();
                        /*   $.each(datax, function(i, field){
                            console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                        });*/
                        $.ajax({
                            data: datax,    // En data se puede utilizar un objeto JSON, un array o un query string
                            type: "POST",   //Cambiar a type: POST si necesario
                            dataType: "json",  // Formato de datos que se espera en la respuesta
                            url: "controllers/controllerdepartamento.php",  // URL a la que se enviará la solicitud Ajax
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
        $("#eliminar-depto").click(function(e){
            e.preventDefault();
            console.log("paso");
            var datax = $("#formDeleteDepto").serializeArray();

            console.log("paso2");

                    $.each(datax, function(i, field){
                        console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                    });
                console.log("paso3");
                    $.ajax({
                        data: datax, 
                        type: "POST",
                        dataType: "json", 
                        url: "controllers/controllerdepartamento.php",
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
    });
    //funcion levanta modal y muestra  los datos del centro de costo cuando presion boton Ver/Editar, aca se puede mdificar si quiere
    function verDepto(action, deptoid){
        deshabilitabotones();
        console.log('pase');
        var datay = {"deptoId": deptoid,
                     "Accion":"obtener"
                    };
        $.ajax({
            data: datay, 
            type: "POST",
            dataType: "json", 
            url: "controllers/controllerdepartamento.php",
        })
        .done(function(data,textStatus,jqXHR ) {
            if ( console && console.log ) {
                console.log( " data success : "+ data.success 
                    + " \n data msg : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
            $("#deptoId").val(data.datos.depto_id);
            $("#deptoNombre").val(data.datos.depto_nombre);
            $("#deptoNombreCorto").val(data.datos.depto_nomcorto);
            $("#deptoEstado").val(data.datos.depto_estado);
            $("#deptoHabilitado").val(data.datos.depto_habilita);

            deshabilitaform();
            $("#Accion").val(action);

            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                if (action === 'actualizar'){
                    modal.find('.modal-title-form').text('Actualizar Departamento');
                    $('#guardar-depto').hide();                    
                    $('#actualizar-depto').show();   
                }else if (action === 'ver'){
                    modal.find('.modal-title-form').text('Datos Departamento');
                    deshabilitabotones();
                    $('#editar-depto').show();   
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
    function deleteDepto(iddepto, nameDepto){     
        document.formDeleteDepto.deptoId.value = iddepto;
        document.formDeleteDepto.nameDepto.value = nameDepto;
        document.formDeleteDepto.Accion.value = "eliminar";
        $('#myModalDelete').on('shown.bs.modal', function () {
            $('#myInput').focus()
        });
    }
