    function validarFormatoFecha(campo) {
        var date = campo.replace(/-+/g, '/'); 
        var RegExPattern = /^\d{2,4}\/\d{1,2}\/\d{1,2}$/;
        if ((date.match(RegExPattern)) && (date!='')) {
            return true;
        }else{
            return false;
        }
    }

    function existeFecha(fecha){
        var fechaf = fecha.split("-");
        var day = fechaf[2];
        var month = fechaf[1];
        var year = fechaf[0];
        var date = new Date(year,month,'0');
        if(year<1995) 
        	return false;
        if((day-0)>(date.getDate()-0)){
            return false;
        }
          return true;
    }

    function validatxtonline(param){
        if ( param.val() == null || param.val().length == 0 || /^\s+$/.test(param.val())) {
                param.parent().attr('class','form-group has-error');
                param.parent().children('span').text('Campo No debe ir vacío o con espacios en blanco').show();
            }else {
                param.parent().attr('class','form-group has-success');
                param.parent().children('span').text('').hide();
        }
    }

    function validafechaonline(param){
        if ( param.val() == null || param.val().length == 0 || /^\s+$/.test(param.val())) {
                param.parent().attr('class','form-group has-error');
                param.parent().children('span').text('Campo No debe ir vacío o con espacios en blanco').show();
            }else {
                param.parent().attr('class','form-group has-success');
                param.parent().children('span').text('').hide();
        }
        if(param.val() == null || param.val().length == 0 || /^\s+$/.test(param.val())){
            param.parent().attr('class','form-group has-error');
            param.parent().children('span').text('Debe ingresar una fecha').show();
        }else{
            if( validarFormatoFecha(param.val())){
                if(existeFecha(param.val())){
                    param.parent().attr('class','form-group has-success');
                    param.parent().children('span').text('').hide();
                }else{
                    param.parent().attr('class','form-group has-error');
                    param.parent().children('span').text('La fecha introducida no es valida.').show();
                }
            }else{
                param.parent().attr('class','form-group has-error');
                param.parent().children('span').text('El formato de la fecha es incorrecto.').show();
            }
        }        
    }

    function validaselectonline(param){
		if( param.val() == null || param.val() == "" || param.val() < 0 ) { //isNaN(param.val())
			param.parent().attr('class','form-group has-error');
			param.parent().children('span').text('Debe selecionar una opcion').show();
		}else{
			param.parent().attr('class','form-group has-success');
			param.parent().children('span').text('').hide();
		}
    }