    function getListadoEstadoMemos(){
            var datax = {
                "Accion":"listar"
            }
            $.ajax({
                data: datax,  
                type: "GET",
                dataType: "json", 
                url: "controllers/controllermemoestado.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#memoEstado").html(""); 
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                    console.log('id: ' + data.datos[i].memo_est_id + ' nombre EstadoMemo: ' + data.datos[i].memo_est_tipo);
                    opcion = '<option value=' + data.datos[i].memo_est_id + '>' + data.datos[i].memo_est_tipo + '</option>';
                    $("#memoEstado").append(opcion);
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
    function getListadoUsuarios(){
            var datax = {
                "Accion":"listar"
            }
            $.ajax({
                data: datax,  
                type: "GET",
                dataType: "json", 
                url: "controllers/controllerusuario.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#usuario").html(""); 
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                    console.log('id: ' + data.datos[i].usu_id + ' nombre: ' + data.datos[i].usu_nombre);
                    opcion = '<option value=' + data.datos[i].usu_id + '>' + data.datos[i].usu_nombre + ' - '+ data.datos[i].usu_rol_nombre + '</option>';
                    $("#usuario").append(opcion);
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
    getListadoEstadoMemos();
    getListadoUsuarios();

    function getListadoMemos(){
            var datax = {
                "Accionmem":"listar"
            }
            $.ajax({
                data: datax,  
                type: "GET",
                dataType: "json", 
                url: "controllers/controllermemo.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#listamemos").html(""); 
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                    console.log('id: ' + data.datos[i].mem_id + ' numero memo: ' + data.datos[i].mem_numero);
                    fila = '<tr><td>'+ data.datos[i].mem_anio + '-' + data.datos[i].mem_numero + '</td>';
                    fila += '<td>'+ data.datos[i].mem_fecha +'</td>';
                    fila += '<td>'+ data.datos[i].mem_materia +'</td>';
                    fila += '<td>'+ '123' +'</td>';
                    fila += '<td>'+ '2018-100700' +'</td>';
                    fila += '<td>'+ 'OC-123' +'</td>';
                    fila += '<td><button id="ver-memo" type="button" '
                    fila += 'class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal"'
                    fila += ' onclick="verMemo(\'ver\',\'' + data.datos[i].mem_id + '\')">';
                    fila += 'Ver / Editar</button>';
                    fila += ' <button id="delete-language-modal" name="delete-language-modal" type="button" ';
                    fila += 'class="btn btn-xs btn-danger" data-toggle="modal" data-target="#myModalDelete" ';
                    fila += 'onclick="deleteAnular(\''+ data.datos[i].mem_id +'\',\'' + data.datos[i].mem_anio +'\',\''
                            + data.datos[i].mem_materia +'\')">';
                    fila += 'Anular</button>';
                    fila += ' <button id="Asignar" type="button" class="btn btn-xs btn-primary" >Asignar</button></td>';
                    fila += '</tr>';
                    $("#listamemos").append(fila);
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
    getListadoMemos();