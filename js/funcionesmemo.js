    function deshabilitabotones(){
        document.getElementById('editar-memo').style.display = 'none';
        document.getElementById('actualizar-memo').style.display = 'none';
        document.getElementById('finalizar-memo').style.display = 'none';        
    }
    function deshabilitabotonesdetalle(){
        document.getElementById('editar-det-memo').style.display = 'none';
        document.getElementById('actualizar-det-memo').style.display = 'none';
        document.getElementById('agregar-det-memo').style.display = 'none';        
    }
    function deshabilitabotonesdetcompra(){
        document.getElementById('editar-det-memo-compra').style.display = 'none';
        document.getElementById('actualizar-det-memo-compra').style.display = 'none';
        document.getElementById('agregar-det-memo-compra').style.display = 'none';        
    }
    function limpiaFormMemo(){
        $('#formIngresoMemo')[0].reset();
        $("#listaArchivosMemo").html("");
        $("#linkres").text("");
        $("#linkres").attr("href","");
        $('#memoNum').focus();
    }

    function limpiaFormDetalle(){
        $('#formDetalleMemo')[0].reset();
        $('#memoDetDescripcion').focus();
    }
    function limpiaFormCompra(){
        $('#formDetalleCompra')[0].reset();
        $('#detCompraNombreProd').focus();        
    }
        function validarFormulario(){
            var txtNombre = document.getElementById('provNombre').value;
            var txtRut = document.getElementById('provRut').value;
                //Test campo obligatorio
                if(txtNombre == null || txtNombre.length == 0 || /^\s+$/.test(txtNombre)){
                    alert('ERROR: El campo nombre no debe ir vacío o con espacios en blanco');
                    document.getElementById('provNombre').focus();
                    return false;
                }
                if(txtRut == null || txtRut.length == 0 || /^\s+$/.test(txtRut)){
                    alert('ERROR: El campo Rut no debe ir vacío o con espacios en blanco');
                    document.getElementById('provRut').focus();
                    return false;
                }                
            return true;
        }
    $(document).ready(function(){
        //funcion para listar los cecostos en el select, ver el tema de agregar el id y no el codigo (este puede cambiar el id no)
        var getlistaCecosto = function (){
            var datax = {
                "Accion":"listar"
            }
            $.ajax({
                data: datax, 
                type: "GET",
                dataType: "json", 
                url: "controllers/controllercentrocostos.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#memoCcosto").html("");
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg ccosto : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                /* $.each(data.datos, function(i, field){
                    console.log("contenido del json = "+ field.ccosto_codigo + ":" + field.ccosto_nombre + ":" + field.ccosto_dep_codigo + " ");
                }); */
                $("#memoCcosto").append('<option value="0">Seleccionar...</option>');
                for(var i=0; i<data.datos.length;i++){
                   // console.log('id: '+data.datos[i].ccosto_codigo + ' nombre CeCosto: '+data.datos[i].ccosto_nombre);
                    if(data.datos[i].ccosto_codigo==data.datos[i].ccosto_dep_codigo){
                        opcion = '<option style="font-weight:bold" value='+ data.datos[i].ccosto_codigo +'> - '+data.datos[i].ccosto_nombre+'</option>';
                    }else{
                        opcion = '<option value='+ data.datos[i].ccosto_codigo +'>&nbsp;&nbsp;&nbsp;&nbsp;'+data.datos[i].ccosto_nombre+'</option>';
                    } 
                    $("#memoCcosto").append(opcion);
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
        //Funcion que lista los deptos
        var getlistaDepto = function (){
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
                $("#memoDepto").html("");
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg deptos : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                $("#memoDepto").append('<option value="0">Seleccionar...</option>');
                $("#memoDeptoDest").append('<option value="0">Seleccionar...</option>');
                for(var i=0; i<data.datos.length;i++){
                   // console.log('id: ' + data.datos[i].depto_id + ' nombre Depto: ' + data.datos[i].depto_nombre);
                    opcion = '<option value=' + data.datos[i].depto_id + '>' + data.datos[i].depto_nombre + '</option>';
                    $("#memoDepto").append(opcion);

                    if(data.datos[i].depto_id==34){
                        opcion = '<option value=' + data.datos[i].depto_id + ' selected>' + data.datos[i].depto_nombre + '</option>';
                    }
                    $("#memoDeptoDest").append(opcion);
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
        //Funcion que lista los estado del memo
        var getlistaEstadosMemo = function (){
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
                        + " \n data msg memest : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                    //console.log('id: ' + data.datos[i].memo_est_id + ' nombre EstadoMemo: ' + data.datos[i].memo_est_tipo);
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
        //Funcion que lista los estados del detalle memo
        var getlistaDetEstadoMemo = function (){
            var datax = {
                "Accion":"listar"
            }
            $.ajax({
                data: datax, 
                type: "GET",
                dataType: "json", 
                url: "controllers/controllermemodetalleestado.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#detalleestadomemo").html("");
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg memdetest : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                    //console.log('id: ' + data.datos[i].memo_det_est_id + ' nombre EstadoMemo: ' + data.datos[i].memo_det_est_tipo);
                    opcion = '<option value=' + data.datos[i].memo_det_est_id + '>' + data.datos[i].memo_det_est_tipo + '</option>';
                    $("#detalleestadomemo").append(opcion);
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
        //Funcion que lista los procedimientos de compra
        var getlistaProcedCompra = function (){
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
                $("#memoDetPcompra").html("");
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg procomp : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                    //console.log('id: ' + data.datos[i].proc_comp_id + ' nombre EstadoMemo: ' + data.datos[i].proc_comp_tipo);
                    opcion = '<option value=' + data.datos[i].proc_comp_id + '>' + data.datos[i].proc_comp_tipo + '</option>';
                    $("#memoDetPcompra").append(opcion);
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
        //Funcion que lista los proveedores
        var getlistaProveedores = function (){
            var datax = {
                "Accion":"listar"
            }
            $.ajax({
                data: datax, 
                type: "GET",
                dataType: "json", 
                url: "controllers/controllerproveedor.php", 
            })
            .done(function( data, textStatus, jqXHR ) {
                $("#memoDetProveedor").html("");
                if ( console && console.log ) {
                    console.log( " data success : "+ data.success 
                        + " \n data msg prov : "+ data.message 
                        + " \n textStatus : " + textStatus
                        + " \n jqXHR.status : " + jqXHR.status );
                }
                for(var i=0; i<data.datos.length;i++){
                    //console.log('id: ' + data.datos[i].prov_id + ' nombre EstadoMemo: ' + data.datos[i].prov_nombre);
                    opcion = '<option value=' + data.datos[i].prov_id + '>' + data.datos[i].prov_nombre + '</option>';
                    $("#memoDetProveedor").append(opcion);
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
        $("#limpiar-memo").click(function(e){
            e.preventDefault();
            limpiaFormMemo();
        });
        $("#limpiar-archivo").click(function(e){
            e.preventDefault();
            $('#my-file-selector').val(null);
            $("#listaArchivosMemo").html("");
        });

        $("#limpiar-det-memo").click(function(e){
            e.preventDefault();
            limpiaFormDetalle();
        });
        $("#limpiar-det-memo-compra").click(function(e){
            e.preventDefault();
            limpiaFormCompra();
        });
        $("#limpiar-busca_res").click(function(e){
            e.preventDefault();
            $('#formBusquedaRes')[0].reset();
            $('#msgres').html("");
            $('#buscaNumRes').focus();
        });
        deshabilitabotones();
        deshabilitabotonesdetalle();
        deshabilitabotonesdetcompra();
        getlistaCecosto();
        getlistaDepto();
        getlistaEstadosMemo();
        getlistaDetEstadoMemo();
        getlistaProcedCompra();
        getlistaProveedores();
        $('#finalizar-memo').show();
        $('#agregar-det-memo').show();
        $('#agregar-det-memo-compra').show();
        // Funcion que busca numero de resolucion y devuelve url ubicacion
        var buscaRes = function (){
            var datax = $("#formBusquedaRes").serializeArray();
                /*$.each(datax, function(i, field){
                    console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                });*/
                $.ajax({
                    data: datax, 
                    type: "POST",
                    dataType: "json", 
                    url: "http://resoluciones2.umce.cl/controllers/controllerresoluciones.php", 
                })
                .done(function( data, textStatus, jqXHR ) {
                    if ( console && console.log ) {
                        console.log( " data success : "+ data.success 
                            + " \n data msg buscares : "+ data.message 
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }
                    if(data.total>0){
                        $("#linkres").text(data.datos[0].res_anio + "-" + data.datos[0].res_numero + " : " + data.datos[0].res_descripcion);  
                        $("#linkres").attr("href",data.datos[0].res_ruta);
                        $("#memoUrlRes").val(data.datos[0].res_ruta);
                        $('#buscaNumRes').val("");
                        $('#myModalBuscaRes').modal('hide');
                    }else{
                        $('#msgres').html('<div class="alert alert-warning" id="msgres" role="alert">NO existe Resolución</div>')
                    }

                })
                .fail(function( jqXHR, textStatus, errorThrown ) {
                    if ( console && console.log ) {
                        console.log( " La solicitud ha fallado,  textStatus : " +  textStatus 
                            + " \n errorThrown : "+ errorThrown
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }
                });
        };
        $("#buscar-res").on("click",function(e){
            e.preventDefault();
            numRes = $("#buscaNumRes").val().trim();
            //?Accion=buscar&buscaNumRes=2017-100002
            //if(validarFormulario()==true){
            if(numRes == null || numRes.length == 0 ){
                $('#msgres').html('<div class="alert alert-danger" id="msgres" role="alert">NO debe ir vacío o espacios en blanco</div>')
                document.getElementById('buscaNumRes').focus();
            }else{
                buscaRes();
            }
           // }
        });
        $("#buscaNumRes").on("keydown",function(e){
            if(e.which == 13){      
                e.preventDefault();
                 buscaRes();
            }
            if(e.which == 8){      
                $('#msgres').html(""); 
            }             
        });
        $("#buscaNumRes").on("click",function(e){
            $('#msgres').html(""); 
        });
        $("#memoCcosto").change(function() {
            $("#memoCodigoCcosto").val($(this).val());
        });
        $("#memoDetProveedor").change(function() {
            $("#memoDetRutProv").val($(this).val());
        });        
        $('#myModalDetalle').on('shown.bs.modal', function (e) {
             $("#AccionMemoDet").val("registrar");
            $('#memoDetDescripcion').focus();
        }); 
        $('#myModalDetalleCompra').on('shown.bs.modal', function (e) {
            $('#detCompraNombreProd').focus();
        }); 
        $('#myModalBuscaRes').on('shown.bs.modal', function (e) {
            $('#buscaNumRes').focus();
        });
        function returnFileSize(number) {
            if(number < 1024) {
                return number + 'bytes';
            } else if(number > 1024 && number < 1048576) {
                return (number/1024).toFixed(1) + 'KB';
            } else if(number > 1048576) {
                return (number/1048576).toFixed(1) + 'MB';
            }
        }
        $("#my-file-selector").change(function() {
            var archivos = document.getElementById("my-file-selector");//Creamos un objeto con el elemento que contiene los archivos: el campo input file, que tiene el id = 'archivos'
            var archivo = archivos.files; //Obtenemos los archivos seleccionados en el imput
            if(archivo.length===0){
                $("#upload-file-info").append("No ha seleccionado archivos para subir");
            }else{
                
                for(i=0; i<archivo.length; i++){
                    var lista="<tr>";
                    lista += "<td>"+archivo[i].name+"</td>";
                    lista += "<td>"+returnFileSize(archivo[i].size)+"</td>";
                    /*lista += "<td><button type='button' id='quitarfile' class='close' onclick='quitafile(\'"+i+"\')'>&times;</button></td>";*/
                    lista += "</tr>";
                    $("#listaArchivosMemo").append(lista);                    
                }
            }
        });
        //si tiene numero memo Levanta modal nuevo detalle memo y graba el memo
        //$("#crea-detalle-memo").click(function(e){
        $("#formIngresoMemo").on('submit',function(e){
            e.preventDefault();
           
                var datax = $("#formIngresoMemo").serializeArray();
                $.each(datax, function(i, field){
                    console.log("contenido del form = "+ field.name + ":" + field.value + " ");
                });            

            var valor = $('input:text[name=memoNum]').val();
            var valida=true;
            if( valor !=""){
                $("#memoNum").parent().attr("class","form-group");
                //GRABAR EN BASE DE DATOS TEMPORAL EL MEMO
                //valida=grabarMemo();
                //console.log(" graba ? "+ valida);
                if(valida==true){
                    limpiaFormDetalle();
                    $('#myModalDetalle').modal('show');
                }else{
                    $("#memoNum").parent().attr("class","form-group has-error");
                    $('#myModalLittle').modal('show');
                        $('#myModalLittle').on('shown.bs.modal', function () {
                            var modal2 = $(this);
                            modal2.find('.modal-title').text('Mensaje');
                            modal2.find('.msg').html('<b>Error al ingresar el memo</b>');  
                            $('#cerrarModalLittle').focus();
                    });
                }
                
            }else{
                $("#memoNum").parent().attr("class","form-group has-error");
                $('#myModalLittle').modal('show');
                    $('#myModalLittle').on('shown.bs.modal', function () {
                        var modal2 = $(this);
                        modal2.find('.modal-title').text('Mensaje');
                        modal2.find('.msg').html('<b>Debe indicar Numero de memo antes de agregar detalle</b>');  
                        $('#cerrarModalLittle').focus();
                });
            }
        });

        function grabarMemo(){
            var graba=false;
            console.log("valor graba definicion : "+ graba);
           /* if(validarFormulario()==true){*/

                $.ajax({
                    data: datax, 
                    type: "POST",
                    dataType: "json", 
                    url: "controllers/controllermemo.php", 
                })
                .done(function( data, textStatus, jqXHR ) {
                    if ( console && console.log ) {
                        console.log( " data success : "+ data.success 
                            + " \n data msg : "+ data.message 
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }
                    graba=data.success;
                    console.log("valor graba en el done : "+ graba);
                })
                .fail(function( jqXHR, textStatus, errorThrown ) {
                    if ( console && console.log ) {
                        console.log( " La solicitud ha fallado,  textStatus : " +  textStatus 
                            + " \n errorThrown : "+ errorThrown
                            + " \n textStatus : " + textStatus
                            + " \n jqXHR.status : " + jqXHR.status );
                    }
                    graba=false;
                    console.log("valor graba en el fail : "+ graba);
                });
            /*}*/
            console.log("valor graba : "+ graba);
            return graba
        }        
        
    });
