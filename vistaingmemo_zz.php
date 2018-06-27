<!DOCTYPE html> 
<html lang="es">
<head>
    <?php include "header.php"; ?>
    <title>Ingreso memo</title>
    <script src="js/funcionesmemo.js"></script>
</head>
<body> 
    <?php include "barranav.php"; ?>
    <div class="container" style="margin-top:50px">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <center><h1>Ingreso memo</h1></center><br><br>
                <form id="formIngresoMemo" name="formIngresoMemo" method="POST" action="" role="form">
                    <div class="messages"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="memonum">Número Memo</label>
                                <input id="memonum" type="text" name="memonum" class="form-control" required>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label >Número resoluciones</label><br>
                                <button type="button" class="btn btn-primary">Buscar número</button>
                                <a href="#">Link resolucion</a>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label >Fecha recepción memo</label>
                                <input id="" type="text" name="" class="form-control">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label >Fecha memo</label>
                                <input id="" type="text" name="" class="form-control">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label >Fecha entrega analista</label>
                                <input id="" type="text" name="" class="form-control">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label >Departamento</label>
                                <select name="memodepto" id="memodepto" class="form-control">
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label >Centro de costos</label>
                                <select name="memocc" id="memocc" class="form-control">
                                    <option value="0">Seleccionar</option> 
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label >Código centro de costos</label>
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
                                <label >Estado</label>
                                <select name="estadomemo" id="estadomemo" class="form-control">
                                </select>
                                <div class="help-block with-errors"></div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="40%">Descripción</th>
                                        <th width="30%">Proveedor</th>
                                        <th width="10%">N° Factura</th>
                                        <th width="10%">Eliminar</th>
                                        <th width="10%">Agregar</th>
                                    </tr>
                                </thead>
                                <tbody id="listaDetalleMemo">
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <button id="editar-memo" name="editar-memo" type="button" class="btn btn-warning">Editar</button>
                            <button id="actualizar-memo" name="actualizar-memo" type="button" class="btn btn-primary">Actualizar</button>
                            <button id="guardar-memo" name="guardar-memo" type="button" class="btn btn-primary">Guardar</button>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="col-md-6">
                            <button id="limpiar-memo" type="button" class="btn btn-default" data-dismiss="modal">Limpiar</button>
                            <button id="cancelar-memo" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </form>
            </div><!-- /.8 -->
        </div> <!-- /.row-->
    </div> <!-- /.container-->
</body>
</html> 