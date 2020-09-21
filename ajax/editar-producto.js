var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};

$(document).ready(function(){
  $("#m_almacen").attr("class","nav-link active");
  $("#m_almacen").parent().attr("class","nav-item has-treeview menu-open");
  $("#m_registro_producto").attr("class","nav-link active");
  $(document).prop('title', 'Editar Producto - DuoLab Group');
});

$(document).ready(function() {
    var product_id = getUrlParameter('id');

    if(product_id == "" || product_id == null){
        window.location.replace("../../views/productos/listado-producto");
        return;
    }

    $.post("../../modules/productos/consultar-productos.php", { FILTER: product_id, ESTADO: 'ALL' }, function (data) {
        var data_json = JSON.parse(data);

        if(data_json[0] == null){
            window.location.replace("../../views/productos/listado-producto");
            return;
        }

        $('#btn-delete-product').attr("js-id", data_json[0]["CODIGO"]);
        $('input[name="producto_id"]').val(data_json[0]["CODIGO"]);
        $('input[name="producto_codigo"]').val("PROD-" + data_json[0]["CODIGO"]);
        $('input[name="producto_code"]').val(data_json[0]["CODPROD"]);       
        $('input[name="producto_estado"]').prop("checked",data_json[0]["ESTADO"]);
        $('input[name="producto_nombre"]').val(data_json[0]["NOMBRE"]);
        $('input[name="producto_description"]').val(data_json[0]["DESCRIPTION"]);
        $('input[name="producto_marca"]').val(data_json[0]["MARCA"]);
        $('input[name="producto_proveedor_referencia"]').val(data_json[0]["PROVEEDOR_REF"]);

        if (data_json[0]["FECVENC"] != "1970-01-01"){
            $('input[name="producto_fecvenc"]').val(data_json[0]["FECVENC"]);
        }
        
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
                window.location.replace("../../views/productos/listado-producto");

                $.Notification.notify("success", "bottom-right", "Producto actualizado", "Datos actualizados");
                Swal.close();
            }
        }
    });
});

$("#btn-delete-product").click(function () {
    var id_val = getUrlParameter('id');
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
                        window.location.replace("../../views/productos/listado-producto");

                        $.Notification.notify("success", "bottom-right", "Producto eliminado", "Información borrada correctamente");
                    }
                });
            }
        })
    }
});

$("#btn-cancel").click(function (e) {
    e.preventDefault();
    window.location.assign("../../views/productos/listado-producto");
});