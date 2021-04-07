$("#col-btn-delete-client").hide();

$(document).ready(function(){
  $("#m_clientes").attr("class","nav-link active");
  $(document).prop('title', 'Clientes - DuoLab Group');
});

var tabla_clientes = $('#table-clientes');

tabla_clientes.dataTable({
    "ajax": {
        "url": "../../modules/clientes/consultar-cliente.php",
        "type": "POST",
        "data": { "FILTER": "ALL" },
    },
    "columns": [
        { "data": "CODIGO" },
        { "data": "RUC" },
        { "data": "RAZ_SOC" },
        { "data": "NOM_COM" },
        { "data": "TELEF" },
        { "data": "CELULAR" }
    ],
    "order": [[0, "DESC"]],
    dom: 'Bfrtip',
    buttons: [
            {
                extend: 'pdf',
                text: '<i class="fa fa-file-pdf"></i>&nbsp;&nbsp;Descargar PDF'
            },
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

/* Init DataTables */
//var tabla_clientes = $('#table-clientes').dataTable();

$("#FRM_INSERT_CLIENTE").submit(function (e) {
    e.preventDefault();
    var form = $(this);
    var idform = form.attr("id");
    var url = form.attr('action');
    var formElement = document.getElementById(idform);
    var formData_rec = new FormData(formElement);
    var id_cliente = $('input[name="cliente_id"]').val();
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
                $.Notification.notify("error", "bottom-right", "Error de guardado", "No se pudo guardar datos del cliente");
                Swal.close();
            } else if (data == "EXISTE") {
                $.Notification.notify("error", "bottom-right", "Error de guardado", "Cliente ya existe en la base de datos");
                Swal.close();
            } else if (data == "OK_INSERT") {
                $.Notification.notify("success", "bottom-right", "Cliente guardado", "Datos almacenados");
                Swal.close();
                $('#table-clientes').DataTable().ajax.reload();

            } else if (data == "OK_UPDATE") {
                if (id_cliente != "" && id_cliente != null) { 
                    $('input[name="cliente_id"]').val("");
                    $("#btn-save-client font").html("Guardar cliente");
                    $("#col-btn-save-client").attr("class", "col-md-12");
                    $("#col-btn-delete-client").hide();
                    form.find("input, textarea").val("");
                }
                
                $.Notification.notify("success", "bottom-right", "Cliente actualizado", "Datos actualizados");
                Swal.close();

                $('#table-clientes').DataTable().ajax.reload();
            }
        }
    });
});

$.post("../../modules/ubigeo/consultar-ubigeo.php", { MODE_UBIGEO: "DEPARTMENTS" }, function (data) {
    $('select[name="cliente_departamento"]').select2({
        data: JSON.parse(data)
    })
});

$('select[name="cliente_departamento"]').on("change", function (e) {
    element = $(this);
    ID_DEPART = element.val();
    $.post("../../modules/ubigeo/consultar-ubigeo.php", { MODE_UBIGEO: "PROVINCES", ID_DEPART: ID_DEPART }, function (data) {
        $('select[name="cliente_provincia"]').empty();
        $('select[name="cliente_provincia"]').select2({
            data: JSON.parse(data)
        })
    });
})

$('select[name="cliente_provincia"]').on("change", function (e) {
    element = $(this);
    ID_PROV = element.val();
    $.post("../../modules/ubigeo/consultar-ubigeo.php", { MODE_UBIGEO: "DISTRICTS", ID_PROV: ID_PROV }, function (data) {
        $('select[name="cliente_distrito"]').empty();
        $('select[name="cliente_distrito"]').select2({
            data: JSON.parse(data)
        })
    });
})

tabla_clientes.on('click', 'tr', function () {
    var data = tabla_clientes.fnGetData(this);
    if (data == null) return;
    
    var id_row = data["CODIGO"];
    Swal.fire({
        html: '<h4>Cargando información del cliente</h4>',
        allowOutsideClick: false,
        onBeforeOpen: () => {
            Swal.showLoading();
        }
    });
    $.post("../../modules/clientes/consultar-cliente.php", { FILTER: id_row }, function (data) {
        var data_json = JSON.parse(data);
        $('input[name="cliente_codigo"]').focus();
        $('#btn-delete-client').attr("js-id", data_json[0]["CODIGO"]);
        $('input[name="cliente_id"]').val(data_json[0]["CODIGO"]);
        $('input[name="cliente_codigo"]').val("CLI-" + data_json[0]["CODIGO"]);
        $('input[name="cliente_razsoc"]').val(data_json[0]["RAZ_SOC"]);
        $('input[name="cliente_telfij"]').val(data_json[0]["TELEF"]);
        $('input[name="cliente_ruc"]').val(data_json[0]["RUC"]);
        $('input[name="cliente_telcel"]').val(data_json[0]["CELULAR"]);
        $('input[name="cliente_nomcom"]').val(data_json[0]["NOM_COM"]);
        $('input[name="cliente_fecreg"]').val(data_json[0]["FEC_REG"]);
        $('input[name="cliente_correo"]').val(data_json[0]["EMAIL"]);
        $('input[name="cliente_direccion"]').val(data_json[0]["DIRECC"]);
        $('input[name="cliente_nomcont_1"]').val(data_json[0]["NOMCON_1"]);
        $('input[name="cliente_celcont_1"]').val(data_json[0]["CELCON_1"]);
        $('input[name="cliente_nomcont_2"]').val(data_json[0]["NOMCON_2"]);
        $('input[name="cliente_celcont_2"]').val(data_json[0]["CELCON_2"]);
        $('input[name="cliente_pagocomision"]').val(data_json[0]["PAGCOM"]);
        $("#btn-save-client font").html("Actualizar cliente");
        $("#col-btn-save-client").attr("class", "col-md-6");
        $("#col-btn-delete-client").show("fast");

        $.post("../../modules/ubigeo/consultar-ubigeo.php", { MODE_UBIGEO: "DEPARTMENTS" }, function (data) {
            $('select[name="cliente_departamento"]').select2({
                data: JSON.parse(data)
            })
            $('select[name="cliente_departamento"]').val(data_json[0]["DEPARTAMENTO"]);
            $('select[name="cliente_departamento"]').trigger('change');
        }).then(function () {
            $.post("../../modules/ubigeo/consultar-ubigeo.php", { MODE_UBIGEO: "PROVINCES", ID_DEPART: data_json[0]["DEPARTAMENTO"] }, function (data) {
                $('select[name="cliente_provincia"]').empty();
                $('select[name="cliente_provincia"]').select2({
                    data: JSON.parse(data)
                });
                $('select[name="cliente_provincia"]').val(data_json[0]["PROVINCIA"]);
                $('select[name="cliente_provincia"]').trigger('change');
            }).then(function () {
                $.post("../../modules/ubigeo/consultar-ubigeo.php", { MODE_UBIGEO: "DISTRICTS", ID_PROV: data_json[0]["PROVINCIA"] }, function (data) {
                    $('select[name="cliente_distrito"]').empty();
                    $('select[name="cliente_distrito"]').select2({
                        data: JSON.parse(data)
                    });
                    $('select[name="cliente_distrito"]').val(data_json[0]["DISTRITO"]);
                    $('select[name="cliente_distrito"]').trigger('change');
                });
            });
        });
    }).done(function(){
        $(window).scrollTop(0);    
    });
    Swal.close();
});

$("#btn-delete-client").click(function () {
    element = $(this);
    id_val = element.attr("js-id");
    if (id_val != "" && id_val != null) {
        Swal.fire({
            title: 'Se eliminará este cliente',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                $.post("../../modules/clientes/eliminar-cliente.php", { cliente_id: id_val }, function (data) {
                    if (data == true) {
                        $("#FRM_INSERT_CLIENTE").find("input, textarea").val("");
                        $('#table-clientes').DataTable().ajax.reload();
                        $('input[name="cliente_id"]').val("");
                        $("#btn-save-client font").html("Guardar cliente");
                        $("#col-btn-save-client").attr("class", "col-md-12");
                        $("#col-btn-delete-client").hide();

                        $.Notification.notify("success", "bottom-right", "Cliente eliminado", "Información borrada correctamente");
                    }
                });
            }
        })
    }
})