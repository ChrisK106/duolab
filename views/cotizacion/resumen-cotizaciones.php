<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-md-12">
                    <div class="m-0 text-dark text-center text-lg">
                        <i class="fas fa-file-invoice-dollar"></i>&nbsp;&nbsp;Resumen de Cotizaciones
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
                                <a href="registro-cotizacion" class="btn btn-success btn-block"><i class="fa fa-plus fa-1x"></i> Nueva Cotización</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 col-lg-3">
                                <div class="form-group">
                                    <label>N° Cotización</label>
                                    <input type="text" name="cotizacion_numero" class="form-control" placeholder="Nro de cotización">
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="form-group">
                                    <label>Cliente</label>
                                    <input type="text" name="cotizacion_cliente" class="form-control" placeholder="Nombre de cliente">
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="form-group">
                                    <label>Fecha Inicio</label>
                                    <input type="date" name="cotizacion_fecinic" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="form-group">
                                    <label>Fecha Fin</label>
                                    <input type="date" name="cotizacion_fecfin" class="form-control">
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
                                   <i class="fa fa-search"></i>&nbsp;&nbsp;Buscar Cotizaciones
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div>
                                <label>Haga clic derecho sobre un ítem para ver opciones disponibles.</label>
                            </div>
                            <table id="table-cotizaciones" class="table table-bordered table-hover" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nro. Cotización</th>
                                        <th>F. Emisión</th>
                                        <th>Cliente</th>
                                        <th>Monto</th>
                                        <th>Estado</th>
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