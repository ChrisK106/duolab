<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-md-12">
                    <div class="m-0 text-dark text-center text-lg">
                        <i class="fas fa-user-tie"></i>&nbsp;&nbsp;Registro de Empleado
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div style="max-width: 1140px;margin: 0 auto;">
                <form id="FRM_INSERT_EMPLEADO" method="post" action="<?php echo $functions->direct_sistema(); ?>/modules/empleados/insert-update-empleado.php" enctype="multipart/form-data">
                    <input type="hidden" name="empleado_id">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-title">Datos de Empleado</div>
                            <div class="float-right" style="height: 2rem; width: 170px">
                                <input type="text" placeholder="Código de empleado" class="form-control" name="empleado_codigo" readonly>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nombres</label>
                                        <input type="text" class="form-control" placeholder="Ingrese nombres" name="empleado_nombres" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Apellido Paterno</label>
                                        <input type="text" class="form-control" placeholder="Ingrese apellido paterno" name="empleado_apepat" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Apellido Materno</label>
                                        <input type="text" class="form-control" placeholder="Ingrese apellido materno" name="empleado_apemat" required>
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
                                            <input type="text" class="form-control" placeholder="Ingrese dirección" name="empleado_direccion" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tipo de Doc. Identidad</label>
                                        <select class="form-control select2" style="width: 100%;" name="empleado_tipodoc" required>
                                            <option value="">Seleccione un tipo</option>
                                            <option value="DNI">DNI</option>
                                            <option value="Carnet de Extranjería">Carnet de Extranjería</option>
                                            <option value="Libreta Electoral">Libreta Electoral</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Número de Doc. Identidad</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-id-card"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Ingrese número de Doc." name="empleado_numdoc" required>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Estado Civil</label>
                                        <select class="form-control select2" style="width: 100%;" name="empleado_estado_civ">
                                            <option value="">Seleccione estado</option>
                                            <option value="Soltero">Soltero</option>
                                            <option value="Casado">Casado</option>
                                            <option value="Divorciado">Divorciado</option>
                                            <option value="Viudo">Viudo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Fecha de Nacimiento</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="date" class="form-control"  name="empleado_fecnac" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Cargo</label>
                                        <select class="form-control select2" style="width: 100%;" name="empleado_cargo" required>
                                            <option value="">Seleccione un cargo</option>
                                            <option value="Gerente General">Gerente General</option>
                                            <option value="Gerente de Marketing">Gerente de Marketing</option>
                                            <option value="Secretario">Secretario</option>
                                            <option value="Transportista">Transportista</option>
                                            <option value="Mantenimiento">Mantenimiento</option>
                                            <option value="Visitador">Visitador</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Fecha de Ingreso</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="date" class="form-control" name="empleado_fecing" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Teléfono</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-phone"></i>
                                                </span>
                                            </div>
                                            <input type="phone" class="form-control" pattern="[0-9--]{0,20}" placeholder="Ingrese teléfono" name="empleado_telefono">
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label>Correo electrónico</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-envelope"></i>
                                                </span>
                                            </div>
                                            <input type="email" class="form-control" placeholder="Ingrese un correo electrónico" name="empleado_correo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Grado de Estudios</label>
                                        <select class="form-control select2" style="width: 100%;" name="empleado_grado_est">
                                            <option value="">Seleccione grado</option>
                                            <option value="Titulado">Titulado</option>
                                            <option value="Bachiller">Bachiller</option>
                                            <option value="Técnico">Técnico</option>
                                            <option value="Actualmente cursando">Actualmente cursando</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label>Carrera</label>
                                        <input type="text" class="form-control" placeholder="Ingrese carrera" name="empleado_carrera">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="col-btn-save-employee" class="col-md-12" style="alignment-baseline: central;">
                            <button type="submit" id="btn-save-employee" class="btn btn-success btn-block"><i class="fa fa-save fa-1x"></i>&nbsp;&nbsp;<font>Guardar empleado</font></button>
                        </div>
                        <div id="col-btn-delete-employee" class="col-md-6">
                            <button type="button" id="btn-delete-employee" js-id="" class="btn btn-danger btn-block"><i class="fa fa-trash fa-1x"></i>&nbsp;&nbsp;Eliminar empleado</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-empleados" class="table table-bordered table-hover" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Cargo</th>
                                    <th>Doc. Identidad</th>
                                    <th>Número Doc.</th>
                                    <th>Fec. Nacimiento</th>
                                    <th>Fec. Ingreso</th>
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