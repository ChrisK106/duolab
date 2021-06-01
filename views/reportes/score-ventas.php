<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-md-12">
                    <div class="m-0 text-dark text-center text-lg">
                        <i class="fas fa-chart-bar"></i>&nbsp;&nbsp;Score de Ventas por Vendedor
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
                        <div class="card-title">Filtrar reporte</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 col-lg-3">
                                <div class="form-group">
                                    <label>Vendedor</label>
                                    <input type="text" name="reporte_vendedor" class="form-control" placeholder="Nombre de vendedor">
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="form-group">
                                    <label>Periodo</label>
                                    <select name="reporte_periodo" class="form-control">
                                        <option value="">Seleccione un periodo</option>
                                        <option value="MONTH">Mes</option>
                                        <option value="YEAR">Año</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="div-filtro-periodo">
                            <div class="col-sm-6 col-lg-3">
                                <div class="form-group">
                                    <label>Mes</label>
                                    <select name="reporte_periodo_month" class="form-control select2">
                                        <option value="">Seleccione un mes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="form-group">
                                    <label>Año</label>
                                    <select name="reporte_periodo_year" class="form-control select2">
                                        <option value="">Seleccione un año</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button id="btn-reiniciar" class="btn btn-success btn-block" type="button">
                                    <i class="fa fa-sync"></i> &nbsp;Reiniciar valores
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button id="btn-filtrar-reporte" class="btn btn-primary btn-block" type="button">
                                    <i class="fa fa-search"></i> &nbsp;Filtrar reporte
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <div class="card-title">Ventas por Vendedor en Tiempo Real</div>
                    </div>
                    <div class="card-body">
                        <div id="content">
                            <div id="bar-chart" style="width: 100%; height: 370px;"></div>
                            <div style="float:right;">
                                <button type="button" class="btn btn-secondary">
                                    Intervalo de actualización (ms) <span class="badge bg-secondary"><input id="updateInterval" type="number" step="100" min="3000" style="text-align: right; width:5em"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>