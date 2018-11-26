        function deshabilitabotones(){
            document.getElementById('editar-menuitem').style.display = 'none';
            document.getElementById('guardar-menuitem').style.display = 'none';
            document.getElementById('actualizar-menuitem').style.display = 'none';
        }

        function limpiaform(){
            $("#menuitemId").val("");
            $("#menuitemNombre").val("");
            $("#menuitemUrl").val("");
            $("#menuitemEstado").val("");
            $("#menuitemMemid").val("");
        }

        function habilitaform(){
            $("#menuitemId").prop( "disabled", false );
            $("#menuitemNombre").prop( "disabled", false );
            $("#menuitemUrl").prop( "disabled", false );
            $("#menuitemEstado").prop( "disabled", false );
            $("#menuitemMemid").prop( "disabled", false );
        }

        function deshabilitaform(){
            $("#menuitemId").prop( "disabled", true );
            $("#menuitemNombre").prop( "disabled", true );
            $("#menuitemUrl").prop( "disabled", true );
            $("#menuitemEstado").prop( "disabled", true );
            $("#menuitemMemid").prop( "disabled", true );
        }
        function getlistaMenus (){
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
                $("#menuitemMemid").html("");
                if ( console && console.log ) {
                    console.log( " data success Lista Menus: "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                                //$.each(data.datos[i], function(k, v) { console.log(k + ' : ' + v); });
                                //console.log('id: '+data.datos[i].men_id + ' tipo: '+data.datos[i].men_nombre);
                                fila = '<option value="'+data.datos[i].men_id + '">'+ data.datos[i].men_nombre+ '</option>';
                                $("#menuitemMemid").append(fila);
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
    getlistaMenus();

    $(document).ready(function(){
        function validarFormulario(){
            var txtNombre = document.getElementById('menuitemNombre').value;
            var txtUrl = document.getElementById('menuitemUrl').value;
            var selEstEstado = document.getElementById('menuitemEstado').selectedIndex;
            var selEstMenuId = document.getElementById('menuitemMemid').selectedIndex;

                //Test campo obligatorio
                if(txtNombre == null || txtNombre.length == 0 || /^\s+$/.test(txtNombre)){
                    alert('ERROR: El campo nombre no debe ir vacío o con espacios en blanco');
                    document.getElementById('menuitemNombre').focus();
                    return false;
                }
                if( selEstEstado == null || isNaN(selEstEstado) || selEstEstado == -1 ) {
                    /*$('#memoestActivo').parent().attr('class','form-group has-error');
                    $('#memoestActivo').parent().children('span').text('Debe seleccionar un Departamento o Unidad Solicitante').show();*/
                    alert('ERROR: Debe selecciona una opcion');
                    document.getElementById('menuitemEstado').focus();
                    return false;
                }
                if( selEstMenuId == null || isNaN(selEstMenuId) || selEstMenuId == -1 ) {
                    /*$('#memoestActivo').parent().attr('class','form-group has-error');
                    $('#memoestActivo').parent().children('span').text('Debe seleccionar un Departamento o Unidad Solicitante').show();*/
                    alert('ERROR: Debe selecciona una opcion');
                    document.getElementById('menuitemMemid').focus();
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
                url: "controllers/controllermenuitem.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#listadomenuitem").html("");
                if ( console && console.log ) {
                    console.log( " data success Lista Menus Item: "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                                //$.each(data.datos[i], function(k, v) { console.log(k + ' : ' + v); });
                                //console.log('id: '+data.datos[i].menitem_id + ' tipo: '+data.datos[i].menitem_nombre);
                                var activo = data.datos[i].menitem_estado == 1 ? 'Activo':'Inactivo';

                                fila = '<tr><td>'+ data.datos[i].menitem_nombre +'</td>';
                                fila += '<td>'+ data.datos[i].menitem_url +'</td>';
                                fila += '<td>'+ data.datos[i].menitem_memnom +'</td>';                                
                                fila += '<td>'+ activo +'</td>';

                                fila += '<td><button id="ver-menuitem" type="button" '
                                fila += 'class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal"'
                                fila += ' onclick="verMenuItem(\'ver\',\'' + data.datos[i].menitem_id + '\')">';
                                fila += 'Ver / Editar</button>';
                                fila += ' <button id="delete-language-modal" name="delete-language-modal" type="button" ';
                                fila += 'class="btn btn-xs btn-danger" data-toggle="modal" data-target="#myModalDelete" ';
                                fila += 'onclick="deleteMenu(\''+ data.datos[i].menitem_id +'\',\''
                                + data.datos[i].menitem_nombre +'\')">';
                                fila += 'Eliminar</button></td>';
                                fila += '</tr>';
                                $("#listadomenuitem").append(fila);
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
        $("#crea-menuitem").click(function(e){
            e.preventDefault();
            limpiaform();
            habilitaform();
            $("#Accion").val("registrar");
            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                modal.find('.modal-title-form').text('Creación Menu Item');  
                deshabilitabotones();
                $('#guardar-menuitem').show();
                $('#menuitemNombre').focus();
            });
        });

        // implementacion boton para guardar el centro de costo
        $("#guardar-menuitem").click(function(e){
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
                    url: "controllers/controllermenuitem.php", 
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
        $("#editar-menuitem").click(function(e){
            e.preventDefault();
            $('.modal-title-form').text('Editar Menu Item');
            habilitaform();
            deshabilitabotones();
            $('#actualizar-menuitem').show();
            $("#Accion").val("actualizar");               
        });

        //  envia los nuevos datos para actualizar
        $("#actualizar-menuitem").click(function(e){
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
                            url: "controllers/controllermenuitem.php",  // URL a la que se enviará la solicitud Ajax
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
        $("#eliminar-menuitem").click(function(e){
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
                        url: "controllers/controllermenuitem.php",
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
    function verMenuItem(action, menuitemId){
        limpiaform();
        deshabilitabotones();
        var datay = {"menuitemId": menuitemId,
                     "Accion":"obtener"
                    };
        $.ajax({
            data: datay, 
            type: "POST",
            dataType: "json", 
            url: "controllers/controllermenuitem.php",
        })
        .done(function(data,textStatus,jqXHR ) {
            if ( console && console.log ) {
                console.log( " data success : "+ data.success 
                    + " \n data msg : "+ data.message 
                    + " \n textStatus : " + textStatus
                    + " \n jqXHR.status : " + jqXHR.status );
            }
            $("#menuitemId").val(data.datos.menitem_id);
            $("#menuitemNombre").val(data.datos.menitem_nombre);
            $("#menuitemUrl").val(data.datos.menitem_url);
            $("#menuitemEstado").val(data.datos.menitem_estado);
            $("#menuitemMemid").val(data.datos.menitem_memid);

            deshabilitaform();
            $("#Accion").val(action);

            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                if (action === 'actualizar'){
                    modal.find('.modal-title-form').text('Actualizar Menu');
                    $('#guardar-menuitem').hide();                    
                    $('#actualizar-menuitem').show();   
                }else if (action === 'ver'){
                    modal.find('.modal-title-form').text('Datos Menu');
                    deshabilitabotones();
                    $('#editar-menuitem').show();   
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
    function deleteMenu(idmenuitem, nameMenu){     
        document.formDeleteMenu.menuitemId.value = idmenuitem;
        document.formDeleteMenu.nameMenu.value = nameMenu;
        document.formDeleteMenu.Accion.value = "eliminar";
        $('#myModalDelete').on('shown.bs.modal', function () {
            $('#myInput').focus()
        });
    }  