<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-md-12">
                    <div class="m-0 text-dark text-center text-lg">
                        <i class="fas fa-file-invoice"></i>&nbsp;&nbsp;Resumen de Facturas
                    </div>
                </div>
            </div>
            <div style="max-width: 1140px; margin: 0 auto;"></div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div style="max-width: 1140px; margin: 0 auto;">
                <div class="card card-primary">
                    <div class="card-header">
                        <div class="row justify-content-end">
                            <div class="col-md-4">
                                <a href="registro-factura" class="btn btn-success btn-block"><i class="fa fa-plus fa-1x"></i> Nueva Factura</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>N° Factura</label>
                                    <input type="text" name="factura_numero" class="form-control" placeholder="Nro de factura">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cliente</label>
                                    <input type="text" name="factura_cliente" class="form-control" placeholder="Nombre de cliente">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Estado</label>
                                    <select class="form-control select2" style="width: 100%;" name="factura_estado">
                                        <option value="" selected>(Todos)</option>
                                        <option value="1">Vigente</option>
                                        <option value="2">Anulado</option>
                                        <option value="3">Pendiente de Pago</option>
                                        <option value="4">Cancelado</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!--
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Vendedor</label>
                                    <select class="form-control select2" style="width: 100%;" name="factura_vendedor">
                                        <option value="">(Todos)</option>
                                    </select>
                                </div>
                            </div>
                            -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fecha Inicio</label>
                                    <input type="date" name="factura_fecini" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fecha Fin</label>
                                    <input type="date" name="factura_fecfin" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <button id="btn-reset" class="btn btn-primary btn-block">
                                    <i class="fa fa-broom fa-1x"></i>&nbsp;&nbsp;Limpiar filtros
                                </button>
                            </div>
                            <div class="col-md-8">
                                <button id="btn-buscar" class="btn btn-success btn-block" type="button">
                                   <i class="fa fa-search"></i>&nbsp;&nbsp;Buscar Facturas
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <div>
                            <label>Haga clic derecho sobre un ítem para ver opciones disponibles.</label>
                        </div>
                        <div class="table-responsive">
                            <table id="table-facturas" class="table table-bordered table-hover" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nro. Factura</th>
                                        <th>F. Emisión</th>
                                        <th>Cliente</th>
                                        <th>Total Neto</th>
                                        <th>Estado</th>
                                        <th>Vendedor</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>