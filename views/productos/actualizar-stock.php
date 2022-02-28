<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-md-12">
                    <div class="m-0 text-dark text-center text-lg">
                        <i class="fas fa-box"></i>&nbsp;&nbsp;Actualizar Stock de un Producto
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div style="max-width: 1140px;margin: 0 auto;">
                <form id="FRM_INSERT_MOV" method="post" action="<?php echo $functions->direct_sistema(); ?>/modules/productos/insert-movimiento-stock.php" enctype="multipart/form-data">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-title">Datos del movimiento de Stock</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Tipo de Movimiento</label>
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" name="mov_tipo" id="rbtnIngreso" value="Ingreso" checked>
                                            <label for="rbtnIngreso" class="custom-control-label">Ingreso Almacén</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" name="mov_tipo" id="rbtnAjuste" value="Ajuste">
                                            <label for="rbtnAjuste" class="custom-control-label">Ajuste Stock</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label>Producto</label>
                                        <select class="form-control select2" name="mov_prod_code" required>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="mov_secondary_info" class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Nro. Guía / Orden</label>
                                        <input type="text" class="form-control" placeholder="Ingrese número de guía u orden" name="mov_guia_orden">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><i class="fas fa-people-carry"></i> Proveedor</label>
                                        <select class="form-control select2" name="mov_prov">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>F. Vencimiento del Lote de Ingreso</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="date" class="form-control" name="mov_fec_venc" value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Observaciones</label>
                                        <input type="text" class="form-control" name="mov_obs">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Stock</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-box"></i>
                                                </span>
                                            </div>
                                            <input type="number" class="form-control" name="mov_cantidad" value="1" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button id="btn-new" class="btn btn-primary">
                                <i class="fa fa-broom fa-1x"></i>&nbsp;&nbsp;Limpiar campos
                            </button>
                            <button id="btn-product-list" class="btn btn-secondary">
                                <i class="fa fa-box fa-1x"></i>&nbsp;&nbsp;Listado de Productos
                            </button>
                            <div class="float-right">
                                <button type="submit" id="btn-save-product" class="btn btn-success btn-md"><i class="fa fa-save fa-1x"></i>&nbsp;&nbsp;<font>Actualizar Stock</font></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>