<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-md-12">
                    <div class="m-0 text-dark text-center text-lg">
                        <i class="fas fa-people-carry"></i>&nbsp;&nbsp;Registro de Proveedor
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div style="max-width: 1140px;margin: 0 auto;">
                <form id="FRM_INSERT_PROVEEDOR" method="post" action="<?php echo $functions->direct_sistema(); ?>/modules/proveedores/insert-update-proveedor.php" enctype="multipart/form-data">
                    <input type="hidden" name="proveedor_id" value="">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-title">Datos de Empresa</div>
                            <div class="card-tools">
                                <div class="float-left" style="height: 2rem; width: 170px">
                                    <input type="text" placeholder="Código de proveedor" class="form-control" name="proveedor_codigo" readonly>
                                </div>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Colapsar">
                                     <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>RUC Proveedor</label>
                                        <input type="text" class="form-control" name="proveedor_numero" 
                                        placeholder="Número de proveedor" required>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Razón Social</label>
                                        <input type="text" class="form-control" placeholder="Ingrese razón social" name="proveedor_razsoc" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>País</label>
                                        <input type="text" class="form-control" placeholder="Ingrese país" name="proveedor_pais" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Ciudad</label>
                                        <input type="text" class="form-control" placeholder="Ingrese ciudad" name="proveedor_ciudad" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Distrito</label>
                                        <input type="text" class="form-control" placeholder="Ingrese distrito" name="proveedor_distrito" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label>Dirección</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-home"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Ingrese dirección" name="proveedor_direccion" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Fecha de Registro</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="date" class="form-control" name="proveedor_fecreg" value="<?php echo date('Y-m-d'); ?>" readonly required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    
                                </div>
                                <div class="col-md-6">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-info">
                                <div class="card-header">
                                    <div class="card-title">Contacto 1</div>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Colapsar">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label>Nombre</label>
                                                <input type="text" class="form-control" placeholder="Ingrese nombre de contacto" name="proveedor_contnom_1">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Teléfono</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-phone"></i>
                                                        </span>
                                                    </div>
                                                    <input type="phone" class="form-control" name="proveedor_conttelef_1">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-info">
                                <div class="card-header">
                                    <div class="card-title">Contacto 2</div>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Colapsar">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label>Nombre</label>
                                                <input type="text" class="form-control" placeholder="Ingrese nombre de contacto" name="proveedor_contnom_2">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Teléfono</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-phone"></i>
                                                        </span>
                                                    </div>
                                                    <input type="phone" class="form-control" name="proveedor_conttelef_2">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-danger">
                                <div class="card-header">
                                    <div class="card-title">Cuenta Bancaria 1</div>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Colapsar">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label><i class="fas fa-landmark"></i> Banco</label>
                                        <select name="proveedor_banco_1" class="form-control select2" style="width:100%"></select>
                                    </div>
                                    <div class="form-group">
                                        <label><i class="fas fa-coins"></i> Tipo de moneda</label>
                                        <select name="proveedor_tipmoneda_1" class="select2" style="width:100%"></select>
                                    </div>
                                    <div class="form-group">
                                        <label><i class="fas fa-piggy-bank"></i> Cta. Corriente</label>
                                        <input type="text" name="proveedor_ctacorriente_1" class="form-control" placeholder="Ingrese cuenta corriente">
                                    </div>
                                    <div class="form-group">
                                        <label><i class="fas fa-user-alt"></i> Titular Cta.</label>
                                        <input type="text" name="proveedor_titularcta_1" class="form-control" placeholder="Ingrese titular de cuenta corriente">
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="card card-danger">
                                <div class="card-header">
                                    <div class="card-title">Cuenta Bancaria 2</div>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Colapsar">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label><i class="fas fa-landmark"></i> Banco</label>
                                        <select name="proveedor_banco_2" class="form-control select2" style="width:100%"></select>
                                    </div>
                                    <div class="form-group">
                                        <label><i class="fas fa-coins"></i> Tipo de moneda</label>
                                        <select name="proveedor_tipmoneda_2" class="select2" style="width:100%"></select>
                                    </div>
                                    <div class="form-group">
                                        <label><i class="fas fa-piggy-bank"></i> Cta. Corriente</label>
                                        <input type="text" name="proveedor_ctacorriente_2" class="form-control" placeholder="Ingrese cuenta corriente">
                                    </div>
                                    <div class="form-group">
                                        <label><i class="fas fa-user-alt"></i> Titular Cta.</label>
                                        <input type="text" name="proveedor_titularcta_2" class="form-control" placeholder="Ingrese titular de cuenta corriente">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="col-btn-save-proveedor" class="col-md-12">
                            <button type="submit" id="btn-save-proveedor" class="btn btn-success btn-block"><i class="fa fa-save fa-1x"></i>&nbsp;&nbsp;<font>Guardar proveedor</font></button>
                        </div>
                        <div id="col-btn-delete-proveedor" class="col-md-6">
                            <button type="button" js-id="" id="btn-delete-proveedor" class="btn btn-danger btn-block"><i class="fa fa-trash fa-1x"></i>&nbsp;&nbsp;Eliminar proveedor</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card mt-3">
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-proveedores" class="table table-bordered table-hover" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>N° Proveedor</th>
                                    <th>Razón Social</th>
                                    <th>Dirección</th>
                                    <th>Ciudad</th>
                                    <th>País</th>
                                    <th>Fec. Registro</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>