<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-md-12">
                    <div class="m-0 text-dark text-center text-lg">
                        <i class="fas fa-user"></i>&nbsp;&nbsp;Registro de Cliente (Padrón Comercial)
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div style="max-width: 1140px;margin: 0 auto;">
                <form id="FRM_INSERT_CLIENTE" method="post" action="<?php echo $functions->direct_sistema(); ?>/modules/clientes/insert-update-cliente.php" enctype="multipart/form-data">
                    <input type="hidden" name="cliente_id">
                    <div class="card card-primary">
                        <div class="card-header ">
                            <div class="card-title">Datos de Cliente</div>
                            <div class="float-right" style="height: 2rem; width: 150px">
                                <input type="text" placeholder="Código de cliente" class="form-control" name="cliente_codigo" readonly>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>RUC</label>
                                        <input minlength="11" maxlength="11" type="text" class="form-control" placeholder="Ingrese RUC" name="cliente_ruc" required>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Razón Social</label>
                                        <input type="text" class="form-control" placeholder="Ingrese razón social" name="cliente_razsoc" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Nombre Comercial</label>
                                        <input type="text" class="form-control" placeholder="Ingrese nombre comercial" name="cliente_nomcom">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Teléfono</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-phone"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" pattern="[0-9--]{0,20}" placeholder="Ingrese teléfono fijo" name="cliente_telfij">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Celular</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-mobile-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" pattern="[0-9--]{0,20}" placeholder="Ingrese teléfono celular" name="cliente_telcel">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Fecha de Registro</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="date" class="form-control" name="cliente_fecreg" value="<?php echo date("Y-m-d"); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-danger">
                        <div class="card-header">
                            <div class="card-title">Otros datos</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Departamento</label>
                                        <select class="form-control select2" style="width: 100%;" name="cliente_departamento" required>
                                            <option value="">Seleccione un departamento</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Provincia</label>
                                        <select class="form-control select2" style="width: 100%;" name="cliente_provincia" required>
                                            <option value="">Seleccione una provincia</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Distrito</label>
                                        <select class="form-control select2" style="width: 100%;" name="cliente_distrito" required>
                                            <option value="">Seleccione un distrito</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Dirección</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-home"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Ingrese una dirección" name="cliente_direccion" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Correo Electrónico</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-envelope"></i>
                                                </span>
                                            </div>
                                            <input type="email" class="form-control" placeholder="Ingrese un correo electrónico" name="cliente_correo">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Pago de Comisión</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="number" class="form-control" placeholder="Ingrese pago de comisión" name="cliente_pagocomision">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-info">
                                <div class="card-header">
                                    <div class="card-title">Contacto 1</div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label>Nombre</label>
                                                <input type="text" class="form-control" placeholder="Ingrese nombre de contacto" name="cliente_nomcont_1">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Celular</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-mobile-alt"></i>
                                                        </span>
                                                    </div>
                                                    <input type="phone" class="form-control" name="cliente_celcont_1" pattern="[0-9--]{0,20}">
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
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label>Nombre</label>
                                                <input type="text" class="form-control" placeholder="Ingrese nombre de contacto" name="cliente_nomcont_2">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Celular</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-mobile-alt"></i>
                                                        </span>
                                                    </div>
                                                    <input type="phone" class="form-control" name="cliente_celcont_2" pattern="[0-9--]{0,20}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="row">
                        <div id="col-btn-save-client" class="col-md-12">
                            <button type="submit" id="btn-save-client" class="btn btn-success btn-block"><i class="fa fa-save fa-1x"></i>&nbsp;&nbsp;<font>Guardar cliente</font></button>
                        </div>
                        <div id="col-btn-delete-client" class="col-md-6">
                            <button type="button" js-id="" id="btn-delete-client" class="btn btn-danger btn-block"><i class="fa fa-trash fa-1x"></i>&nbsp;&nbsp;Eliminar cliente</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-clientes" class="table table-bordered table-hover" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>RUC</th>
                                    <th>Razón Social</th>
                                    <th>Nombre Comercial</th>
                                    <th>Teléfono</th>
                                    <th>Celular</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th>Código</th>
                                    <th>RUC</th>
                                    <th>Razón Social</th>
                                    <th>Nombre Comercial</th>
                                    <th>Teléfono</th>
                                    <th>Celular</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>