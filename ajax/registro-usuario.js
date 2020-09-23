$("#col-btn-delete-user").hide();

$(document).ready(function(){
  $("#m_usuarios").attr("class","nav-link active");
  $(document).prop('title', 'Usuarios - DuoLab Group');
});

var tabla_usuarios = $('#table-usuarios');

tabla_usuarios.dataTable({
    "ajax": {
        "url": "../../modules/usuarios/consultar-usuario.php",
        "type": "POST",
        "data": { "FILTER": "ALL" },
    },
    "columns": [
        { "data": "CODIGO_USR" },
        { "data": "USERNAME" },
        { "data": "CODIGO_EMP" },
        { "data": "NOMBRE_EMP" },
        { "data": "CARGO_EMP" },
        { "data": "FEC_REG" }
    ],
    "order": [[1, "asc"]],
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

$.post("../../modules/empleados/consultar-empleado.php", { FILTER: "SELECT_LIST" }, function (data) {
    $('select[name="usuario_empleado_id"]').select2({
        data: JSON.parse(data)
    })
});


$("#FRM_INSERT_USUARIO").submit(function (e) {
    e.preventDefault();
    var form = $(this);
    var idform = form.attr("id");
    var url = form.attr('action');
    var formElement = document.getElementById(idform);
    var formData_rec = new FormData(formElement);
    var id_usuario = $('input[name="usuario_id"]').val();

    if ( $("#usuario_pass").val() != "" || $("#usuario_pass_conf").val() != "" ){
        if( $("#usuario_pass").val() != $("#usuario_pass_conf").val() ){
            $.Notification.notify("error", "bottom-right", "Contraseña", "Las contraseñas ingresadas no coinciden.");
            return;
        }
    }

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
                $.Notification.notify("error", "bottom-right", "Error de guardado", "No se pudo guardar datos del usuario");
                Swal.close();
            } else if (data == "EXISTE") {
                $.Notification.notify("error", "bottom-right", "Error de guardado", "Usuario ya existe en la base de datos");
                Swal.close();
            } else if (data == "OK_INSERT") {
                form.find("input, textarea, select").val("");
                form.find("select").trigger("change");
                $("#usuario_fecreg").val(function(){return this.defaultValue;});
                $('#table-usuarios').DataTable().ajax.reload();
                $.Notification.notify("success", "bottom-right", "Usuario creado", "Datos almacenados");
                Swal.close();

            } else if (data == "OK_UPDATE") {
                if (id_usuario != "" && id_usuario != null) {
                    $('input[name="usuario_id"]').val("");
                    $("#btn-save-user font").html("Guardar usuario");
                    $("#col-btn-save-user").attr("class", "col-md-12");
                    $("#col-btn-delete-user").hide();
                    form.find("input, textarea, select").val("");
                    form.find("select").trigger("change");

                    $("#password-card").attr("class", "card card-secondary");
                    $("#password-card-header font").html("Contraseña");
                    $("#pass-label-1 font").html("Contraseña");
                    $("#pass-label-2 font").html("Confirmar Contraseña");
                    $("#usuario_pass").prop('required',true);
                    $("#usuario_pass_conf").prop('required',true);

                    $("#usuario_fecreg").val(function(){return this.defaultValue;});
                }
                $.Notification.notify("success", "bottom-right", "Usuario actualizado", "Datos actualizados");
                Swal.close();
                $('#table-usuarios').DataTable().ajax.reload();
            }
        }
    });
});

tabla_usuarios.on('click', 'tr', function () {
    var data = tabla_usuarios.fnGetData(this);
    if (data == null) return;

    var id_row = data["CODIGO_USR"];
    Swal.fire({
        html: '<h4>Cargando información deL usuario</h4>',
        allowOutsideClick: false,
        onBeforeOpen: () => {
            Swal.showLoading();
        }
    });
    $.post("../../modules/usuarios/consultar-usuario.php", { FILTER: id_row }, function (data) {
        var data_json = JSON.parse(data);

        $('input[name="usuario_codigo"]').focus();
        $('#btn-delete-user').attr("js-id", data_json[0]["CODIGO"]);

        $('input[name="usuario_id"]').val(data_json[0]["CODIGO"]);
        $('input[name="usuario_codigo"]').val("USR-" + data_json[0]["CODIGO"]);
        $('input[name="usuario_nombre"]').val(data_json[0]["USERNAME"]);

        $('select[name="usuario_empleado_id"]').val(data_json[0]["CODIGO_EMP"]);
        $('select[name="usuario_empleado_id"]').trigger('change');

        $('input[name="usuario_fecreg"]').val(data_json[0]["FEC_REG"]);

        $("#password-card").attr("class", "card card-secondary collapsed-card");
        $("#password-card-header font").html("Cambiar contraseña");
        $("#pass-label-1 font").html("Nueva Contraseña (dejar en blanco para dejar sin cambios)");
        $("#pass-label-2 font").html("Confirmar Nueva Contraseña");
        $("#usuario_pass").removeAttr('required');
        $("#usuario_pass_conf").removeAttr('required');

        $("#btn-save-user font").html("Actualizar usuario");
        $("#col-btn-save-user").attr("class", "col-md-6");
        $("#col-btn-delete-user").show("fast");

    }).done(function(){
        $(window).scrollTop(0);    
    });

    Swal.close();
});

$("#btn-delete-user").click(function () {
    element = $(this);
    id_val = element.attr("js-id");
    if (id_val != "" && id_val != null) {
        Swal.fire({
            title: 'Se eliminará este usuario',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                $.post("../../modules/usuarios/eliminar-usuario.php", { user_id: id_val }, function (data) {
                    if (data == true) {
                        $("#FRM_INSERT_USUARIO").find("input, textarea, select").val("");
                        $("#FRM_INSERT_USUARIO").find("select").trigger("change");

                        $('#table-usuarios').DataTable().ajax.reload();
                        $('input[name="user_id"]').val("");                    
                        $("#btn-save-user font").html("Guardar usuario");
                        $("#col-btn-save-user").attr("class", "col-md-12");
                        $("#col-btn-delete-user").hide();

                        $("#password-card").attr("class", "card card-secondary");
                        $("#password-card-header font").html("Contraseña");
                        $("#pass-label-1 font").html("Contraseña");
                        $("#pass-label-2 font").html("Confirmar Contraseña");
                        $("#usuario_pass").prop('required',true);
                        $("#usuario_pass_conf").prop('required',true);

                        $("#usuario_fecreg").val(function(){return this.defaultValue;});

                        $.Notification.notify("success", "bottom-right", "Usuario eliminado", "Información eliminada correctamente");
                    }
                });
            }
        })
    }
})