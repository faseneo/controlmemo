<!DOCTYPE html>
<html lang="es">
<head>
    <?php include "header.php"; ?>
    <title>Ingreso memo</title>
</head>
<body>
    <?php include "barranav.php"; ?>
    <div class="container" style="margin-top:50px">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <center><h1>Ingreso Detalle Memo</h1></center><br><br>
                <form id="contact-form" method="post" action="#" role="form">
                    <div class="messages"></div>
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label >Descripción</label>
                                    <textarea name="" class="form-control"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label >Procedimiento de compra</label>
                                    <select name="select" class="form-control">
                                        <option value="value1">Seleccionar...</option> 
                                        <option value="value2" >-----</option>
                                        <option value="value3">----</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >Proveedor</label><br>
                                    <select name="select" class="form-control">
                                        <option value="value1">Seleccionar...</option> 
                                        <option value="value2" >-----</option>
                                        <option value="value3">----</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label >Rut proveedor</label>
                                    <input id="" type="text" name="" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label >Número orden de compra Sistema Interno</label>
                                    <input id="" type="text" name="" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>                        
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label >Número orden compra Chilecompra</label>
                                    <input id="" type="text" name="" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><br>
                                    <input type="submit" class="btn btn-success btn-send" value="Agregar detalle">
                                    <input type="submit" class="btn btn-success btn-send" value="Agregar archivo">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >Monto total</label>
                                    <input id="" type="text" name="" class="form-control">
                                    <div class="help-block with-errors"></div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div><br><br><br><br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >Observaciones</label>
                                    <textarea name="" class="form-control"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >Estado</label>
                                    <select name="select" class="form-control">
                                        <option value="value1">En proceso</option> 
                                        <option value="value2" >-----</option>
                                        <option value="value3">----</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <br><br><br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><br>
                                    <input type="submit" class="btn btn-success btn-send" value="Editar">
                                    <input type="submit" class="btn btn-success btn-send" value="Grabar">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div><br>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-success btn-send" value="Limpiar">
                                    <input type="submit" class="btn btn-success btn-send" value="Cancelar">
                                    <div class="help-block with-errors"></div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div><!-- /.8 -->
        </div> <!-- /.row-->
    </div> <!-- /.container-->
</body>
</html>