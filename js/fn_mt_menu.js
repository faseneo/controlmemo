        function deshabilitabotones(){
            document.getElementById('editar-menu').style.display = 'none';
            document.getElementById('guardar-menu').style.display = 'none';
            document.getElementById('actualizar-menu').style.display = 'none';
        }

        function limpiaform(){
            $("#menuId").val("");
            $("#menuNombre").val("");
            $("#menuUrl").val("");
            $("#menuDescrip").val("");
            $("#menuEstado").val("");
        }

        function habilitaform(){
            $("#menuId").prop( "disabled", false );
            $("#menuNombre").prop( "disabled", false );
            $("#menuUrl").prop( "disabled", false );
            $("#menuDescrip").prop( "disabled", false );
            $("#menuEstado").prop( "disabled", false );
        }

        function deshabilitaform(){
            $("#menuId").prop( "disabled", true );
            $("#menuNombre").prop( "disabled", true );
            $("#menuUrl").prop( "disabled", true );
            $("#menuDescrip").prop( "disabled", true );
            $("#menuEstado").prop( "disabled", true );
        }

    $(document).ready(function(){
        function validarFormulario(){
            var txtNombre = document.getElementById('menuNombre').value;
            var txtUrl = document.getElementById('menuUrl').value;
            var txtDescrip = document.getElementById('menuDescrip').value;
            var txtEstado = document.getElementById('menuEstado').value;

                //Test campo obligatorio
                if(txtNombre == null || txtNombre.length == 0 || /^\s+$/.test(txtNombre)){
                    alert('ERROR: El campo nombre no debe ir vacío o con espacios en blanco');
                    document.getElementById('menuNombre').focus();
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
                url: "controllers/controllermenu.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#listadomenu").html("");
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                                $.each(data.datos[i], function(k, v) { console.log(k + ' : ' + v); });
                                console.log('id: '+data.datos[i].men_id + ' tipo: '+data.datos[i].men_nombre);
                                var activo = data.datos[i].men_estado == 1 ? 'Activo':'Inactivo';
                                
                                fila = '<tr><td>'+ data.datos[i].men_nombre +'</td>';
                                fila += '<td>'+ data.datos[i].men_url +'</td>';
                                fila += '<td>'+ data.datos[i].men_descrip +'</td>';
                                fila += '<td>'+ activo +'</td>';

                                fila += '<td><button id="ver-menu" type="button" '
                                fila += 'class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal"'
                                fila += ' onclick="verMenu(\'ver\',\'' + data.datos[i].men_id + '\')">';
                                fila += 'Ver / Editar</button>';
                                fila += ' <button id="delete-language-modal" name="delete-language-modal" type="button" ';
                                fila += 'class="btn btn-xs btn-danger" data-toggle="modal" data-target="#myModalDelete" ';
                                fila += 'onclick="deleteMenu(\''+ data.datos[i].men_id +'\',\''
                                + data.datos[i].men_nombre +'\')">';
                                fila += 'Eliminar</button></td>';
                                fila += '</tr>';
                                $("#listadomenu").append(fila);
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
        $("#crea-menu").click(function(e){
            e.preventDefault();
            limpiaform();
            habilitaform();
            $("#Accion").val("registrar");
            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                modal.find('.modal-title-form').text('Creación Menu');  
                deshabilitabotones();
                $('#guardar-menu').show();
                $('#menuNombre').focus();
            });
        });

        // implementacion boton para guardar el centro de costo
        $("#guardar-menu").click(function(e){
            e.preventDefault();
            if(validarFormulario()==true){
                var datax = $("#formMenu").serializeArray();
                $.each(datax, function(i, field){
                    console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                });
                $.ajax({
                    data: datax, 
                    type: "POST",
                    dataType: "json", 
                    url: "controllers/controllermenu.php", 
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
        $("#editar-menu").click(function(e){
            e.preventDefault();
            $('.modal-title-form').text('Editar Menu');
            habilitaform();
            deshabilitabotones();
            $('#actualizar-menu').show();
            $("#Accion").val("actualizar");               
        });

        //  envia los nuevos datos para actualizar
        $("#actualizar-menu").click(function(e){
                    // Detenemos el comportamiento normal del evento click sobre el elemento clicado
                    e.preventDefault();
                    if(validarFormulario()==true){
                        var datax = $("#formMenu").serializeArray();
                        /*   $.each(datax, function(i, field){
                            console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                        });*/
                        $.ajax({
                            data: datax,    // En data se puede utilizar un objeto JSON, un array o un query string
                            type: "POST",   //Cambiar a type: POST si necesario
                            dataType: "json",  // Formato de datos que se espera en la respuesta
                            url: "controllers/controllermenu.php",  // URL a la que se enviará la solicitud Ajax
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
        $("#eliminar-menu").click(function(e){
            e.preventDefault();
            console.log("paso");
            var datax = $("#formDeleteMenu").serializeArray();

            console.log("paso2");

                    $.each(datax, function(i, field){
                        console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                    });
                console.log("paso3");
                    $.ajax({
                        data: datax, 
                        type: "POST",
                        dataType: "json", 
                        url: "controllers/controllermenu.php",
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
    function verMenu(action, menuId){
        deshabilitabotones();
        var datay = {"menuId": menuId,
                     "Accion":"obtener"
                    };
        $.ajax({
            data: datay, 
            type: "POST",
            dataType: "json", 
            url: "controllers/controllermenu.php",
        })
        .done(function(data,textStatus,jqXHR ) {
            if ( console && console.log ) {
                console.log( " data success : "+ data.success 
                    + " \n data msg : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
            $("#menuId").val(data.datos.men_id);
            $("#menuNombre").val(data.datos.men_nombre);
            $("#menuUrl").val(data.datos.men_url);
            $("#menuDescrip").val(data.datos.men_descrip);
            $("#menuEstado").val(data.datos.men_estado);

            deshabilitaform();
            $("#Accion").val(action);

            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                if (action === 'actualizar'){
                    modal.find('.modal-title-form').text('Actualizar Menu');
                    $('#guardar-menu').hide();                    
                    $('#actualizar-menu').show();   
                }else if (action === 'ver'){
                    modal.find('.modal-title-form').text('Datos Menu');
                    deshabilitabotones();
                    $('#editar-menu').show();   
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
    function deleteMenu(idmenu, nameMenu){     
        document.formDeleteMenu.menuId.value = idmenu;
        document.formDeleteMenu.nameMenu.value = nameMenu;
        document.formDeleteMenu.Accion.value = "eliminar";
        $('#myModalDelete').on('shown.bs.modal', function () {
            $('#myInput').focus()
        });
    }  