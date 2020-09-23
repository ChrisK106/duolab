$("#col-btn-delete-employee").hide();

$(document).ready(function(){
  $("#m_empleados").attr("class","nav-link active");
  $(document).prop('title', 'Empleados - DuoLab Group');
});

var tabla_empleados = $('#table-empleados');

tabla_empleados.dataTable({
    "ajax": {
        "url": "../../modules/empleados/consultar-empleado.php",
        "type": "POST",
        "data": { "FILTER": "ALL" },
    },
    "columns": [
        { "data": "CODIGO" },
        { "data": "NOMBRES" },
        { "data": "APELLIDOS" },
        { "data": "CARGO" },
        { "data": "TIPO_DOC" },
        { "data": "NUM_DOC" },
        { "data": "FEC_NAC" },
        { "data": "FEC_ING" }
    ],
    "order": [[0, "DESC"]],
    dom: 'Bfrtip',
    buttons: [
                {
                    extend: 'csv',
                    text: '<i class="fa fa-file-csv"></i>&nbsp;&nbsp;Descargar CSV'
                },
                {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel"></i>&nbsp;&nbsp;Descargar Excel'
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i>&nbsp;&nbsp;Imprimir'
                }
            ],
    "language": {
            "url": "../../plugins/datatables/Spanish.json"
        }
});


$("#FRM_INSERT_EMPLEADO").submit(function (e) {
    e.preventDefault();
    var form = $(this);
    var idform = form.attr("id");
    var url = form.attr('action');
    var formElement = document.getElementById(idform);
    var formData_rec = new FormData(formElement);
    var id_empleado = $('input[name="empleado_id"]').val();
    $.ajax({
        type: "POST",
        url: url,
        data: formData_rec,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
            Swal.fire({
                html: '<h4>Guardando información</h4>',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            })
        },
        success: function (data) {
            if (data == "ERROR") {
                $.Notification.notify("error", "bottom-right", "Error de guardado", "No se pudo guardar datos del empleado");
                Swal.close();
            } else if (data == "EXISTE") {
                $.Notification.notify("error", "bottom-right", "Error de guardado", "Empleado ya existe en la base de datos");
                Swal.close();
            } else if (data == "OK_INSERT") {
                $.Notification.notify("success", "bottom-right", "Empleado guardado", "Datos almacenados");
                Swal.close();
                $('#table-empleados').DataTable().ajax.reload();
            } else if (data == "OK_UPDATE") {
                if (id_empleado != "" && id_empleado != null) {
                    $('input[name="empleado_id"]').val("");
                    $("#btn-save-employee font").html("Guardar empleado");
                    $("#col-btn-save-employee").attr("class", "col-md-12");
                    $("#col-btn-delete-employee").hide();
                    form.find("input, textarea").val("");
                }
                $.Notification.notify("success", "bottom-right", "Empleado actualizado", "Datos actualizados");
                Swal.close();
                $('#table-empleados').DataTable().ajax.reload();
            }
        }
    });
});

tabla_empleados.on('click', 'tr', function () {
    var data = tabla_empleados.fnGetData(this);
    if (data == null) return;
    
    var id_row = data["CODIGO"];
    Swal.fire({
        html: '<h4>Cargando información del empleado</h4>',
        allowOutsideClick: false,
        onBeforeOpen: () => {
            Swal.showLoading();
        }
    });
    $.post("../../modules/empleados/consultar-empleado.php", { FILTER: id_row }, function (data) {
        var data_json = JSON.parse(data);
        $('input[name="empleado_codigo"]').focus();
        $('#btn-delete-employee').attr("js-id", data_json[0]["CODIGO"]);
        $('input[name="empleado_id"]').val(data_json[0]["CODIGO"]);
        $('input[name="empleado_codigo"]').val("EMP-" + data_json[0]["CODIGO"]);
        $('input[name="empleado_nombres"]').val(data_json[0]["NOMBRES"]);
        $('input[name="empleado_apepat"]').val(data_json[0]["APE_PAT"]);
        $('input[name="empleado_apemat"]').val(data_json[0]["APE_MAT"]);
        $('input[name="empleado_direccion"]').val(data_json[0]["DIRECCION"]);

        $('select[name="empleado_tipodoc"]').val(data_json[0]["TIPO_DOC"]);
        $('select[name="empleado_tipodoc"]').trigger('change');

        $('input[name="empleado_numdoc"]').val(data_json[0]["NUM_DOC"]);
        
        $('select[name="empleado_estado_civ"]').val(data_json[0]["ESTADO_CIV"]);
        $('select[name="empleado_estado_civ"]').trigger('change');

        $('input[name="empleado_fecnac"]').val(data_json[0]["FEC_NAC"]);
        
        $('select[name="empleado_cargo"]').val(data_json[0]["CARGO"]);
        $('select[name="empleado_cargo"]').trigger('change');

        $('input[name="empleado_fecing"]').val(data_json[0]["FEC_ING"]);
        $('input[name="empleado_telefono"]').val(data_json[0]["TELEFONO"]);
        $('input[name="empleado_correo"]').val(data_json[0]["EMAIL"]);

        $('select[name="empleado_grado_est"]').val(data_json[0]["GRADO_EST"]);
        $('select[name="empleado_grado_est"]').trigger('change');
        
        $('input[name="empleado_carrera"]').val(data_json[0]["CARRERA"]);
        $("#btn-save-employee font").html("Actualizar empleado");
        $("#col-btn-save-employee").attr("class", "col-md-6");
        $("#col-btn-delete-employee").show("fast");
    }).done(function(){
        $(window).scrollTop(0);    
    });
    Swal.close();
});

$("#btn-delete-employee").click(function () {
    element = $(this);
    id_val = element.attr("js-id");
    if (id_val != "" && id_val != null) {
        Swal.fire({
            title: 'Se eliminará este empleado',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                $.post("../../modules/empleados/eliminar-empleado.php", { empleado_id: id_val }, function (data) {
                    if (data == true) {
                        $("#FRM_INSERT_EMPLEADO").find("input, textarea").val("");
                        $('#table-empleados').DataTable().ajax.reload();
                        $('input[name="empleado_id"]').val("");                        
                        $("#btn-save-employee font").html("Guardar empleado");
                        $("#col-btn-save-employee").attr("class", "col-md-12");
                        $("#col-btn-delete-employee").hide();
                        $.Notification.notify("success", "bottom-right", "Empleado eliminado", "Información eliminada correctamente");
                    }
                });
            }
        })
    }
})