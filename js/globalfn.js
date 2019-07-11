    //funcion para revisar y mejorar
    function diaSemana() {
        var x = document.getElementById("fecha");
        let date = new Date(x.value.replace(/-+/g, '/'));

        let options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        console.log(date.toLocaleDateString('es-MX', options));
    }
    function fechaCompleta(){
        let dias = ["Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado", "Domingo"];
        let meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        //function diaSemana() {
            var x = document.getElementById("fecha");
            let date = new Date(x.value.replace(/-+/g, '/'));

            var fechaNum = date.getDate();
            var mes_name = date.getMonth();
            console.log(dias[date.getDay()-1] + " " + fechaNum + " de " + meses[mes_name] + " de " + date.getFullYear());
        //}
    }


    function fechaActual(){
        var fecha = new Date(); //Fecha actual
        var mes = fecha.getMonth()+1; //obteniendo mes
        var dia = fecha.getDate(); //obteniendo dia
        var ano = fecha.getFullYear(); //obteniendo año
        if(dia<10)
            dia='0'+dia; //agrega cero si el menor de 10
        if(mes<10)
            mes='0'+mes //agrega cero si el menor de 10
        var fechaCompleta = ano + "-" + mes + "-"+dia;
        return fechaCompleta;
    }
    
    function anioActual(){
        var fecha = new Date(); //Fecha actual
        var anio = fecha.getFullYear(); //obteniendo año
        return anio;
    }

    function mesActualTexto(mes){
        let meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        return meses[mes];
    }

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
		if( param.val() == null || param.val() == "" || param.val() < 1 ) { //isNaN(param.val())
			param.parent().attr('class','form-group has-error');
			param.parent().children('span').text('Debe selecionar una opcion').show();
		}else{
			param.parent().attr('class','form-group has-success');
			param.parent().children('span').text('').hide();
		}
    }

    //function drawpaginador(compag,total,filasPorPagina,cantidadMostrar,fnlista,secid,estado){
    function drawpaginador(total,filasPorPagina,cantidadMostrar,fnlista,compag,deptosolid,deptodesid,estado,usuid,anio,mes){
        totalPag = Math.ceil(total/filasPorPagina);
        var pagina="";
        var funcioninicio="";
        var funcionfin="";
            //console.log("total paginas : "+totalPag);
            //calcula incremento para boton siguiente
            IncrimentNum =((compag +1)<=totalPag) ? (compag +1) : 1;
                //console.log("incremento: "+IncrimentNum);
                //calcula decremento  para boton anterior
            DecrementNum =(compag -1) < 1 ?  1 : (compag -1);
                //console.log("decremento: "+DecrementNum);
                if(totalPag<cantidadMostrar){
                    cantidadMostrar=totalPag;
                }
                // valida primera pagina y deshabilita anterior
                concatfuncion = fnlista + '(' + deptosolid + ',' + deptodesid + ',' + estado ;
                funcionfin = ',' + usuid + ',' + anio + ',' + mes + ')';
                if(compag == 1 ){
                    pagina = "<li class='disabled'><a href='#'><span aria-hidden='true'>&laquo;</span></a></li>";
                }else{
                    pagina = "<li><a href='#' onclick='" + concatfuncion + ','+ DecrementNum + funcionfin + "'><span aria-hidden='true'>&laquo;</span></a></li>";
                }
                // secid=1,estado=0,pag,usuid=0
                    //console.log("calculo ceil : " + (Math.ceil(cantidadMostrar/2)-1));
                    //valida y calcula desde hasta para paginador segun pagina actual
                desde=compag-(Math.ceil(cantidadMostrar/2)-1); //42 - 4   => ((10/2)-1) 
                hasta=compag+(Math.ceil(cantidadMostrar/2)); //42 + 5   => ((10/2)-1)
                    //console.log("desde ceil: "+desde);
                    //console.log("hasta ceil: "+hasta);                       
                    //valida desde si menor a 1 y hasta menor a cantidadMostrar (siempre mostrar diez numeros de paginas)
                desde = (desde < 1) ? 1 : desde;
                hasta = (hasta < cantidadMostrar) ? cantidadMostrar : hasta;
                    //console.log("desde : " + desde);
                    //console.log("hasta : " + hasta);
                    // valida y calcula ultimas 10 paginas del paginador
                desde = (hasta > totalPag) ? totalPag - (cantidadMostrar-1) : desde;
                hasta = (hasta > totalPag) ? totalPag : hasta;
                    //console.log("desde fin : " + desde);
                    //console.log("hasta fin : " + hasta);
                    // dibuja  numeros de paginas en paginador
                for(i=desde; i<= hasta; i++){
                    //Se valida la paginacion total de registros
                    if(i <= totalPag){
                        //Validamos la pag activo
                        if(i==compag){
                            pagina+="<li class='active'><a href='#'>"+i+"</a></li>";
                        }else {
                            pagina += "<li><a href='#' onclick='" + concatfuncion + ','+ i + funcionfin + "'>"+i+"</a></li>";
                        }
                    }
                }
                //console.log(pagina);
                // valida ultima pagina y deshabilita siguiente
            if(compag == totalPag ){
                pagina += "<li class='disabled'><a href='#'><span aria-hidden='true'>&raquo;</span></a></li>";
            }else{
                pagina+= "<li><a href='#' onclick='" + concatfuncion + ','+ IncrimentNum + funcionfin + "'><span aria-hidden='true'>&raquo;</span></a></li>";
            }
        return pagina;
    }

    // funciones para ordenar tabla
    function comparer(index) {
        return function(a, b) {
            var valA = getCellValue(a, index);
            valB = getCellValue(b, index);

            return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB);
        }
    }
    
    function getCellValue(row, index) {
        return $(row).children('td').eq(index).html();
    }
    
    function setIcon(element, asc) {
        $("th").each(function(index) {
            $(this).removeClass("sorting");
            $(this).removeClass("asc");
            $(this).removeClass("desc");
        });
        element.addClass("sorting");
        if (asc) 
            element.addClass("asc");
        else 
            element.addClass("desc");
    }
    // FIN funciones para ordenar tabla