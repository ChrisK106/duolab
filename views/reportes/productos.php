<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-md-12">
                    <div class="m-0 text-dark text-center text-lg">
                        <i class="fas fa-file-alt"></i>&nbsp;&nbsp;Reporte de Productos
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div style="max-width: 1140px;margin: 0 auto;">
                <div class="card card-primary">
                    <div class="card-header">
                        <div class="card-title">Unidades Vendidas por Cliente</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Seleccione un producto</label>
                                    <select class="form-control select2" name="product_list"></select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fecha Inicio</label>
                                    <input type="date" name="date_from" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fecha Fin</label>
                                    <input type="date" name="date_to" class="form-control">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-4" >
                                <button id="btn-rpt-unidades-vendidas-cliente" class="btn btn-block btn-success">
                                    <i class="fa fa-file-alt fa-1x"></i>&nbsp;&nbsp;Ver reporte
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        <div class="card-title">Top Productos</div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <label>Haga clic sobre uno de los siguientes botones para obtener un reporte en PDF</label>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3"></div>
                            <div class="col-md-6" >
                                <button id="btn-rpt-top-mas-vendido" class="btn btn-block btn-success">
                                    <i class="fa fa-file-alt fa-1x"></i>&nbsp;&nbsp;Top 20 de Productos más vendidos
                                </button>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <button id="btn-rpt-top-menos-vendido" class="btn btn-block btn-danger">
                                    <i class="fa fa-file-alt fa-1x"></i>&nbsp;&nbsp;Top 20 de Productos menos vendidos
                                </button>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button id="btn-product-list" class="btn btn-secondary">
                            <i class="fa fa-box fa-1x"></i>&nbsp;&nbsp;Ver Listado de Productos
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>