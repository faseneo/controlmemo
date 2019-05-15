

$(document).ready(function(){
	$(".help-block").hide();
	$('#noexiste').hide();

	$("#formUser").focusout(function(){
		var txtUserEmail = $(this).val();
           if(txtUserEmail == null || txtUserEmail.length == 0 || /^\s+$/.test(txtUserEmail)){
                	$('#spanuser').text('').hide();
                    $('#formUser').parent().attr('class','input-group has-error');
                    $('#spanuser').attr('class','input-group has-error');
                    $('#spanuser').text('El campo email no debe ir vacío o con espacios en blanco').show();
			}else{
                	enailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
                	if(enailRegex.test(txtUserEmail)){
                		$('#spanuser').text('').hide();
                		$('#formUser').parent().attr('class','input-group has-success');
                	}else{
                		$('#formUser').parent().attr('class','input-group has-error');
                		$('#spanuser').attr('class','input-group has-error');
                    	$('#spanuser').text('Debe ingresar email Válido').show();
                	}
            }
    });

	$("#formPass").focusout(function(){
		var txtPass = $(this).val();
                if(txtPass == null || txtPass.length == 0 || /^\s+$/.test(txtPass)){
                	$('#spanpass').text('').hide();
                    $('#formPass').parent().attr('class','input-group has-error');
                    $('#spanpass').attr('class','input-group has-error');
                    $('#spanpass').text('El campo contraseña no debe ir vacío o con espacios en blanco').show();
                }else{
                	$('#spanpass').text('').hide();
                	$('#formPass').parent().attr('class','input-group has-success');
                }
    });    

        function validarFormulario(){
            var txtUserEmail = document.getElementById('formUser').value;
			var txtPass = document.getElementById('formPass').value;
                //Test campo obligatorio
                if(txtUserEmail == null || txtUserEmail.length == 0 || /^\s+$/.test(txtUserEmail)){
                	$('#spanuser').text('').hide();
                    $('#formUser').parent().attr('class','input-group has-error');
                    $('#spanuser').attr('class','input-group has-error');
                    $('#spanuser').text('El campo email no debe ir vacío o con espacios en blanco').show();
                    document.getElementById('formUser').focus();
                    return false;
                }else{
                	enailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
                	if(enailRegex.test(txtUserEmail)){
                		$('#spanuser').text('').hide();
                		$('#formUser').parent().attr('class','input-group has-success');
                	}else{
                		$('#formUser').parent().attr('class','input-group has-error');
                		$('#spanuser').attr('class','input-group has-error');
                    	$('#spanuser').text('Debe ingresar email Válido').show();
                		document.getElementById('formUser').focus();
                		return false;                		
                	}
                }
                if(txtPass == null || txtPass.length == 0 || /^\s+$/.test(txtPass)){
                	$('#spanpass').text('').hide();
                    $('#formPass').parent().attr('class','input-group has-error');
                    $('#spanpass').attr('class','input-group has-error');
                    $('#spanpass').text('El campo contraseña no debe ir vacío o con espacios en blanco').show();
                    document.getElementById('formPass').focus();
                    return false;
                }else{
                	$('#spanpass').text('').hide();
                	$('#formPass').parent().attr('class','input-group has-success');
                }
            return true;
        }	
	function validauser(){
		if(validarFormulario()==true){
                var datax = $("#formLogin").serializeArray();
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
                    if(data.success==true){
                    	$('#noexiste').hide();
                    	window.location.href = "vs_listadomemos.php";
                    }else{
                    	$('#noexiste').html('<strong><span class="glyphicon glyphicon-exclamation-sign"></span></strong> '+data.message).show();
                    }
                    //window.location.href = "home.php";
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
	}
	$("#validar").click(function(event) {
		event.preventDefault();
		console.log('paso');
		validauser();
	});
	$("#formPass").keypress(function(event) {
		//event.preventDefault();
		if (event.which == 13 ) {
            console.log('paso presiona enter en password');
     		validauser();
  		}
	});	
});