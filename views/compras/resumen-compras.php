<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-md-12">
                    <div class="m-0 text-dark text-center text-lg">
                        <i class="fas fa-receipt"></i>&nbsp;&nbsp;Resumen de Compras
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
                        <div class="row">
                            <!--
                            <div class="col-md-4">
                                <div class="card-title">Filtrar por tipo de orden:</div>
                            </div>
                            <div class="col-md-4">
                                <div class="" style="height: 2.2rem;">
                                    <div class="input-group mb-3">
                                        <select class="select2 form-control" name="ordenes_tipo">
                                            <option value="">Seleccione</option>
                                            <option value="COMPRA">Compra</option>
                                            <option value="SERVICIO">Servicio</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            -->
                            <div class="col-md-4"></div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <button id="btn-nuevo" js-type="" type="button" class="btn btn-success btn-block"><i class="fa fa-plus fa-1x"></i> Nueva Compra</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 col-lg-3">
                                <div class="form-group">
                                    <label>N° Compra</label>
                                    <input type="text" name="orden_numero" class="form-control" placeholder="Nro de compra">
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="form-group">
                                    <label>Proveedor</label>
                                    <input type="text" name="orden_proveedor" class="form-control" placeholder="Nombre de proveedor">
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="form-group">
                                    <label>Fecha Inicio</label>
                                    <input type="date" name="orden_fecinic" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="form-group">
                                    <label>Fecha Fin</label>
                                    <input type="date" name="orden_fecfin" class="form-control">
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
                                   <i class="fa fa-search"></i>&nbsp;&nbsp;Buscar Compras
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
                            <table id="table-ordenes" class="table table-bordered table-hover" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nro. Compra</th>
                                        <th>Fecha</th>
                                        <th>Proveedor</th>
                                        <th>Moneda</th>
                                        <th>Total Neto</th>
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