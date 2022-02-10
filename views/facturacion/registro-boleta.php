<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-md-12">
                    <div class="m-0 text-dark text-center text-lg">
                        <i class="fas fa-file-invoice"></i>&nbsp;&nbsp;Boleta
                    </div>
                </div>
            </div>
            <div style="max-width: 1140px; margin: 0 auto;"></div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div style="max-width: 1140px; margin: 0 auto;">
                <div class="row mb-3">
                    <div class="col-md-6 float-right">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <select class="form-control select2" name="facturas_listado">
                                        <option value="">No se han encontrado boletas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <button type="button" id="btn-select-factura" class="form-control btn btn-primary">Seleccionar boleta</button>
                            </div>
                        </div>
                    </div>
                    <div id="col-btn-nuevafac" class="col-md-6">
                        <button type="button" id="btn-nuevafac" class="btn btn-primary btn-block"><i class="fa fa-plus fa-1x"></i>&nbsp;&nbsp;<font>Nueva boleta</font></button>
                    </div>
                </div>
                <form id="FRM_INSERT_FACTURA" method="post" action="<?php echo $functions->direct_sistema(); ?>/modules/facturacion/insert-boleta.php" enctype="multipart/form-data">
                    <input type="hidden" name="id_factura">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card-title">Datos de Boleta</div>
                                </div>
                                <div class="col-md-9">
                                    <div class="" style="height: 2.2rem;">
                                        <div class="row">
                                            <div class="col-md-2 text-right">
                                                <label>Estado:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <select class="form-control" name="facturacion_estado">
                                                    <option value="">Seleccione</option>
                                                    <option value="1" selected>Vigente</option>
                                                    <option value="3">Pendiente de Pago</option>
                                                    <option value="4">Cancelada</option>
                                                    <option value="2">Anulada</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 text-right">
                                                <label>Vendedor:</label>
                                            </div>
                                            <div class="col-md-5 col-sm-3">
                                                <input type="hidden" name="facturacion_usuarioid">
                                                <select class="select2 form-control" name="facturacion_usuario"></select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <label>N° de cotización</label>
                            <div class="row">
                                <div class="col-md-8 col-lg-4">
                                    <div class="form-group">
                                        <select class="form-control select2" name="facturacion_listadocotiz">
                                            <option value="">No se han encontrado cotizaciones</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <button type="button" id="btn-select-cotizacion" class="form-control btn btn-primary">Seleccionar cotización</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Serie</label>
                                                <select class="form-control select2" name="facturacion_series">
                                                    <option value="B001" selected>B001</option>
                                                    <option value="B002">B002</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>N° Boleta</label>
                                                <input type="text" class="form-control" placeholder="Correlativo de factura" name="facturacion_nro" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Vendedor</label>
                                        <input type="text" class="form-control" placeholder="Vendedor de cotización" name="facturacion_cotizvendedor" readonly>
                                    </div>
                                </div>
                                -->
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Doc. Identidad</label>
                                        <input type="text" maxlength="11" class="form-control" name="facturacion_cliruc" placeholder="DNI" required>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label>Nombres y Apellidos</label>
                                        <input type="text" name="facturacion_valcliente" class="form-control" placeholder="Nombre de cliente" required>
                                    </div>
                                    <input type="hidden" name="facturacion_cliente">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Fecha de Boleta</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="date" class="form-control" placeholder="Fecha de cotización" name="facturacion_fecha" value="<?php echo date("Y-m-d"); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Dirección</label>
                                        <input type="text" class="form-control" name="facturacion_clidirecc" placeholder="Dirección" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Referencia</label>
                                        <input type="text" class="form-control" name="facturacion_clirefer" placeholder="Referencia">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Forma de Pago</label>
                                        <select name="facturacion_formpagotext" class="form-control" required>
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
                                        <input type="number" min="0" max="365" step="1" class="form-control" name="facturacion_formpago" placeholder="Número de días">
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
                                            <input type="date" class="form-control" name="facturacion_fecentrega" value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Tipo de Moneda</label>
                                    <select name="facturacion_tipmon" class="form-control select2" required>
                                        <option value="">Seleccione moneda</option>
                                        <option value="MN" selected>Moneda Nacional</option>
                                        <option value="ME">Moneda Extranjera</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-danger">
                        <div class="card-header">
                            <div class="card-title"><i class="fas fa-box"></i>&nbsp;&nbsp;Productos</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Producto</label>
                                        <select class="form-control select2" name="facturacion_producto">
                                            <option value="" selected>Registre productos</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="facturacion_nameprod">
                                <input type="hidden" name="facturacion_codeprod">

                                <div class="col-md-2">
                                    <label>Precio Unitario</label>
                                    <input type="number" class="form-control" name="facturacion_prodprecio" value="0.00">
                                </div>
                                <div class="col-md-2">
                                    <label>Cantidad</label>
                                    <input type="number" min="0" class="form-control" name="facturacion_prodcant" placeholder="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Descripción</label>
                                        <input type="text" class="form-control" name="facturacion_proddesc" placeholder="Descripción de producto" readonly>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="facturacion_stockprod">
                            <div class="row mt-3">
                                <div id="col-btn-add-prodtofactura" class="col-md-12">
                                    <button type="button" id="btn-add-prodtofactura" class="btn btn-primary btn-block"><i class="fa fa-save fa-1x"></i>&nbsp;&nbsp;<font>Agregar artículo</font></button>
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
                                <table id="table-productsfactura" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Código</th>
                                            <th>Nombre</th>
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
                                            <input type="number" name="facturacion_porcdesc" placeholder="Porcentaje de descuento" min="0" step="5" value="0" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-8 text-right">
                                            <label>Valor Dscto.</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="facturacion_cantdesc" placeholder="" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row mb-2">
                                        <div class="col-md-6 text-right">
                                            <label>Op. Gravada</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" name="facturacion_opergrab" min="0" step="0.1" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-6 text-right">
                                            <label>IGV 18%</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" name="facturacion_igv" min="0" step="0.1" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-6 text-right">
                                            <label>Total</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="facturacion_total" class="form-control" required readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div id="col-btn-save-facturaprod" class="col-md-12">
                                    <button type="submit" id="btn-save-facturaprod" class="btn btn-success btn-block"><i class="fa fa-save fa-1x"></i>&nbsp;&nbsp;<font>Grabar boleta</font></button>
                                </div>
                                <div id="col-btn-anular-factura" class="col-md-4">
                                    <button type="button" id="btn-anular-factura" class="btn btn-danger btn-block"><i class="fa fa-minus-circle fa-1x"></i>&nbsp;&nbsp;<font><b>Anular</b> boleta</font></button>
                                </div>
                                <div id="col-btn-pendiente-factura" class="col-md-4">
                                    <button type="button" id="btn-pendiente-factura" class="btn btn-warning btn-block"><i class="fa fa-dollar-sign fa-1x"></i>&nbsp;&nbsp;<font>Marcar como <b>Pendiente de Pago</b></font></button>
                                </div>
                                <div id="col-btn-cancelar-factura" class="col-md-4">
                                    <button type="button" id="btn-cancelar-factura" class="btn btn-success btn-block"><i class="fa fa-check-circle fa-1x"></i>&nbsp;&nbsp;<font>Marcar como <b>Cancelada</b></font></button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>