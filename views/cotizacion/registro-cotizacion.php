<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-md-12">
                    <div class="m-0 text-dark text-center text-lg">
                        <i class="fas fa-file-invoice-dollar"></i>&nbsp;&nbsp;Cotización
                    </div>
                </div>
            </div>
            <div style="max-width: 1140px; margin: 0 auto;"></div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div style="max-width: 1140px; margin: 0 auto;">
                <form id="FRM_INSERT_COTIZACION" method="post" action="<?php echo $functions->direct_sistema(); ?>/modules/cotizaciones/insert-update-cotizacion.php" enctype="multipart/form-data">
                    <input type="hidden" name="id_cotizacion">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <select class="form-control select2" name="cotizacion_listado">
                                                    <option value="">No se han encontrado cotizaciones</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" id="btn-select-cotizacion" class="form-control btn btn-primary">Seleccionar</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" id="btn-nuevo" class="btn btn-primary btn-block"><i class="fa fa-plus fa-1x"></i>&nbsp;&nbsp;<font>Nuevo </font></button>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="card-title">Datos de Cotización</div>
                                </div>
                                <div class="col-md-10">
                                    <div class="" style="height: 2.2rem;">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-file-invoice-dollar"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder="N° Cotización" name="cotizacion_nro" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-1 text-right">
                                                <label>Estado:</label>
                                            </div>
                                            <div class="col-md-2">
                                                <select class="form-control" name="cotizacion_estado">
                                                    <option value="1" selected>Vigente</option>
                                                    <option value="2">Anulada</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 text-right">
                                                <label>Vendedor:</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="hidden" name="cotizacion_usuarioid">
                                                <select class="select2 form-control" name="cotizacion_usuario"></select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>RUC</label>
                                        <input type="text" maxlength="11" class="form-control" name="cotizacion_cliruc" placeholder="RUC" required>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label>Razón Social / Nombre</label>
                                        <input type="text" name="cotizacion_valcliente" class="form-control" placeholder="Nombre de cliente" required>
                                    </div>
                                    <input type="hidden" name="cotizacion_cliente">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Fecha de Cotización</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="date" class="form-control" placeholder="Fecha de cotización" name="cotizacion_fecha" value="<?php echo date("Y-m-d"); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Dirección</label>
                                        <input type="text" class="form-control" name="cotizacion_clidirecc" placeholder="Dirección" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Referencia</label>
                                        <input type="text" class="form-control" name="cotizacion_clirefer" placeholder="Referencia">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Forma de Pago</label>
                                        <select name="cotizacion_formpagotext" class="form-control" required>
                                            <option value="">Seleccione</option>
                                            <option value="0">Contado</option>
                                            <option value="15">15 días</option>
                                            <option value="30">30 días</option>
                                            <option value="45">45 días</option>
                                            <option value="60">60 días</option>
                                            <option value="Otro">Especificar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" id="div_diaspago">
                                        <label>Días de Pago</label>
                                        <input type="number" min="0" max="365" step="1" class="form-control" name="cotizacion_formpago" placeholder="Número de días">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Fecha de Entrega</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="date" class="form-control" name="cotizacion_fecentrega" value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Tipo de Moneda</label>
                                    <select name="cotizacion_tipmon" class="form-control select2" required>
                                        <option value="" selected>Seleccione moneda</option>
                                        <option value="MN">Moneda Nacional</option>
                                        <option value="ME">Moneda Extranjera</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-danger">
                        <div class="card-header">
                            <div class="card-title">
                                <i class="fas fa-box"></i>&nbsp;&nbsp;Productos
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Producto</label>
                                        <select class="form-control select2" name="cotizacion_producto">
                                            <option value="" selected>Registre productos</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="cotizacion_nameprod">
                                
                                <div class="col-md-2">
                                    <label>Precio Unitario</label>
                                    <input type="number" min="0" class="form-control" name="cotizacion_prodprecio" placeholder="" value="0.00">
                                </div>
                                <div class="col-md-2">
                                    <label>Cantidad</label>
                                    <input type="number" min="0" class="form-control" name="cotizacion_prodcant" placeholder="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Descripción</label>
                                        <input type="text" class="form-control" name="cotizacion_proddesc" placeholder="Descripción de producto" readonly>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="cotizacion_stockprod">
                            <div class="row mt-3">
                                <div id="col-btn-add-prodtocotiz" class="col-md-12">
                                    <button type="button" id="btn-add-prodtocotiz" class="btn btn-primary btn-block"><i class="fa fa-save fa-1x"></i>&nbsp;&nbsp;<font>Agregar artículo</font></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-body">
                            <div>
                                <label>Haga doble clic sobre un ítem para eliminarlo del detalle</label>
                            </div>
                            <div class="table-responsive">
                                <table id="table-productscotiz" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Producto</th>
                                            <th>Descripción</th>
                                            <th>Precio Unitario</th>
                                            <th>Cantidad</th>
                                            <th>Importe</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="row mb-2">
                                        <div class="col-md-8 text-right">
                                            <label>Descuento %</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" name="cotizacion_porcdesc" min="0" step="5" value="0" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-8 text-right">
                                            <label>Valor Dscto.</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="cotizacion_cantdesc" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row mb-2">
                                        <div class="col-md-6 text-right">
                                            <label>Op. Gravada</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" name="cotizacion_opergrab" min="0" step="0.1" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-6 text-right">
                                            <label>IGV 18%</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" name="cotizacion_igv" min="0" step="0.1" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-6 text-right">
                                            <label>Total</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="cotizacion_total" class="form-control" required readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div id="col-btn-save-cotizprod" class="col-md-12">
                                    <button type="submit" id="btn-save-cotizprod" class="btn btn-success btn-block"><i class="fa fa-save fa-1x"></i>&nbsp;&nbsp;<font>Grabar cotización </font></button>
                                </div>
                                <div id="col-btn-anular-cotizprod" class="col-md-6">
                                    <button type="button" id="btn-anular-cotizprod" class="btn btn-danger btn-block"><i class="fa fa-trash fa-1x"></i>&nbsp;&nbsp;<font>Anular cotización </font></button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>