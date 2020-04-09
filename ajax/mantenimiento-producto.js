$("#btn-delete-product").hide();

$.post("../../modules/proveedores/listar-proveedores.php", function (data) {
    $('select[name="producto_proveedor"]').empty();
    $('select[name="producto_proveedor"]').select2({
        data: JSON.parse(data)
    })
});

var tabla_productos = $('#table-productos');

tabla_productos.dataTable({
    "ajax": {
        "url": "../../modules/productos/consultar-productos.php",
        "type": "POST",
        "data": { "FILTER": "ALL", "ESTADO": "ALL" },
    },
    "columns": [
        { "data": "ID" },
        { "data": "CODIGO" },
        { "data": "NOMBRE" },
        { "data": "DESCPROD" },
        { "data": "MARCA" },
        { "data": "CANTIDAD" },
        { "data": "PRECIO" },
        { "data": "PROVEEDOR" },
        { "data": "FECVENC" },
        { "data": "FECREG" },
        { "data": "ESTADO" }
    ],
    "order": [[0, "DESC"]],
    "language": {
            "url": "../../plugins/datatables/Spanish.json"
        }
});

$("#FRM_INSERT_PRODUCTO").submit(function (e) {
    e.preventDefault();
    var form = $(this);
    var idform = form.attr("id");
    var url = form.attr('action');
    var formElement = document.getElementById(idform);
    var formData_rec = new FormData(formElement);
    var id_cliente = $('input[name="producto_id"]').val();
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
                if (id_cliente != "" && id_cliente != null) {
                    $('input[name="producto_id"]').val("");
                    $("#btn-save-product font").html("Guardar producto");
                    $("#btn-delete-product").hide();
                    form.find("input, textarea, select").val("");
                    $('select[name="producto_proveedor"]').trigger('change');
                }
                $.Notification.notify("success", "bottom-right", "Producto actualizado", "Datos actualizados");
                Swal.close();
                $('#table-productos').DataTable().ajax.reload();
            }
        }
    });
});

tabla_productos.on('click', 'tr', function () {
    var data = tabla_productos.fnGetData(this);
    if (data == null) return;
    
    var id_row = data["ID"];
    Swal.fire({
        html: '<h4>Cargando información del producto</h4>',
        allowOutsideClick: false,
        onBeforeOpen: () => {
            Swal.showLoading();
        }
    });
    $.post("../../modules/productos/consultar-productos.php", { FILTER: id_row, ESTADO: 'ALL' }, function (data) {
        var data_json = JSON.parse(data);        
        $('#btn-delete-product').attr("js-id", data_json[0]["CODIGO"]);
        $('input[name="producto_id"]').val(data_json[0]["CODIGO"]);
        $('input[name="producto_codigo"]').val("PROD-" + data_json[0]["CODIGO"]);
        $('input[name="producto_code"]').val(data_json[0]["CODPROD"]);       
        $('input[name="producto_estado"]').prop("checked",data_json[0]["ESTADO"]);
        $('input[name="producto_nombre"]').val(data_json[0]["NOMBRE"]);
        $('input[name="producto_description"]').val(data_json[0]["DESCRIPTION"]);
        $('input[name="producto_marca"]').val(data_json[0]["MARCA"]);
        $('input[name="producto_fecvenc"]').val(data_json[0]["FECVENC"]);
        $('input[name="producto_cantidad"]').val(data_json[0]["CANTIDAD"]);        
        $('input[name="producto_precio"]').val(data_json[0]["PRECIO"]);
        
        $('select[name="producto_proveedor"]').val(data_json[0]["PROVEEDOR"]);
        $('select[name="producto_proveedor"]').trigger('change');

        $('select[name="producto_unitvalue"]').val(data_json[0]["UNITVALUE"]);
        $('select[name="producto_unitvalue"]').trigger('change');

        $("#btn-save-product font").html("Actualizar producto");
        $("#btn-delete-product").show("fast");
        
    }).done(function(){
        $(window).scrollTop(0);    
        $('input[name="producto_codigo"]').focus();
        setTimeout(function(){
            Swal.close();
        },500);        
    });
});

$("#btn-delete-product").click(function () {
    element = $(this);
    id_val = element.attr("js-id");
    if (id_val != "" && id_val != null) {
        Swal.fire({
            title: 'Se eliminará este producto',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Borrar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                $.post("../../modules/productos/eliminar-producto.php", { producto_id: id_val }, function (data) {
                    if (data == true) {
                        $('#table-productos').DataTable().ajax.reload();

                        $("#btn-save-product font").html("Guardar producto");
                        $('input[name="producto_id"]').val("");     
                        $("#FRM_INSERT_PRODUCTO").find("input, textarea, select").val("");
                        $('select[name="producto_proveedor"]').trigger('change');
                        
                        $("#btn-delete-product").hide();
                        $.Notification.notify("success", "bottom-right", "Producto eliminado", "Información borrada correctamente");
                    }
                });
            }
        })
    }
})

$("#btn-new").click(function (e) {
    e.preventDefault();
    location.reload();
})