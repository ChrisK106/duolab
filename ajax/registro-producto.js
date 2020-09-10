$(document).ready(function(){
  $("#m_almacen").attr("class","nav-link active");
  $("#m_almacen").parent().attr("class","nav-item has-treeview menu-open");
  $("#m_registro_producto").attr("class","nav-link active");
  $(document).prop('title', 'Registro de Productos - DuoLab Group');
});

$.post("../../modules/proveedores/listar-proveedores.php", function (data) {
    $('select[name="producto_proveedor"]').empty();
    $('select[name="producto_proveedor"]').select2({
        data: JSON.parse(data)
    })
});

$("#FRM_INSERT_PRODUCTO").submit(function (e) {
    e.preventDefault();
    var form = $(this);
    var idform = form.attr("id");
    var url = form.attr('action');
    var formElement = document.getElementById(idform);
    var formData_rec = new FormData(formElement);
    var id_product = $('input[name="producto_id"]').val();
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
                $.Notification.notify("error", "bottom-right", "Error de guardado", "No se pudo guardar datos del producto");
                Swal.close();
            } else if (data == "EXISTE") {
                $.Notification.notify("error", "bottom-right", "Error de guardado", "Producto ya existe en la base de datos");
                Swal.close();
            } else if (data == "OK_INSERT") {
                $.Notification.notify("success", "bottom-right", "Producto guardado", "Datos almacenados");
                form.find("input, textarea, select").val("");
                $('select[name="producto_proveedor"]').trigger('change');
                Swal.close();
                $('#table-productos').DataTable().ajax.reload();
            } else if (data == "OK_UPDATE") {
                if (id_product != "" && id_product != null) {
                    $('input[name="producto_id"]').val("");
                    $("#btn-save-product font").html("Guardar producto");
                    $("#btn-delete-product").hide();
                    form.find("input, textarea, select").val("");
                    $('select[name="producto_proveedor"]').trigger('change');
                }
                $.Notification.notify("success", "bottom-right", "Producto actualizado", "Datos actualizados");
                Swal.close();
            }
        }
    });
});

$("#btn-new").click(function (e) {
    e.preventDefault();
    location.reload();
})

$("#btn-product-list").click(function (e) {
    e.preventDefault();
    window.location.assign("../../views/productos/listado-producto");
})