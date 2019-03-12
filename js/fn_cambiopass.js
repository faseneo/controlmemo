        function limpiaform(){
            $('#formCambioPass')[0].reset();
        }

    $(document).ready(function(){
        function validarFormulario(){
            var txtRut = document.getElementById('usuRut').value;
            var txtNombre = document.getElementById('usuNombre').value;
            var txtEmail = document.getElementById('usuEmail').value;
			var txtPass = document.getElementById('usuPass').value;
            var selRol = document.getElementById('usuRolId').selectedIndex;
                //Test campo obligatorio
                if(txtRut == null || txtRut.length == 0 || /^\s+$/.test(txtRut)){
                    alert('ERROR: El campo rut no debe ir vacío o con espacios en blanco');
                    document.getElementById('usuRut').focus();
                    return false;
                }
                if(txtNombre == null || txtNombre.length == 0 || /^\s+$/.test(txtNombre)){
                    alert('ERROR: El campo nombre no debe ir vacío o con espacios en blanco');
                    document.getElementById('usuNombre').focus();
                    return false;
                }
                if(txtEmail == null || txtEmail.length == 0 || /^\s+$/.test(txtEmail)){
                    alert('ERROR: El campo nombre no debe ir vacío o con espacios en blanco');
                    document.getElementById('usuEmail').focus();
                    return false;
                }                
                if(txtPass == null || txtPass.length == 0 || /^\s+$/.test(txtPass)){
                    alert('ERROR: El campo contraseña no debe ir vacío o con espacios en blanco');
                    document.getElementById('usuPass').focus();
                    return false;
                }                 
            return true;
        }
        // implementacion boton para guardar el centro de costo
        $("#cambiar").click(function(e){
            e.preventDefault();
            if(validarFormulario()==true){
                var datax = $("#formUsuario").serializeArray();
                $.each(datax, function(i, field){
                    console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                });
                $.ajax({
                    data: datax, 
                    type: "POST",
                    dataType: "json", 
                    url: "controllers/controllerusuario.php", 
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

    });