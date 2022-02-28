<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-md-12">
                    <div class="m-0 text-dark text-center text-lg">
                        <i class="fas fa-chart-bar"></i>&nbsp;&nbsp;Gráfico de Ventas Acumuladas por Periodo
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
                        <div class="card-title">Ventas Acumuladas por Periodo</div>
                        <div class="float-right" style="height: 2rem; width: 150px">
                            <span>
                                <select name="reporte_periodo_year" class="form-control select2">
                                    <option value="">Seleccione un año</option>
                                </select>
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="content">
                            <div id="bar-chart" style="width: 100%; height: 600px;"></div>
                            <div style="float:right;">
                                <button type="button" class="btn btn-secondary">
                                    Intervalo de actualización (ms) 
                                    <span class="badge bg-secondary">
                                        <input id="updateInterval" type="number" step="1000" min="3000" style="text-align: right; width:5em">
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>