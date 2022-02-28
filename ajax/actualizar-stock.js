$(document).ready(function(){
  $("#m_almacen").attr("class","nav-link active");
  $("#m_almacen").parent().attr("class","nav-item has-treeview menu-open");
  $("#m_actualizar_stock").attr("class","nav-link active");
  $(document).prop('title', 'Actualizar Stock - DuoLab Group');
});

$.post(
    "../../modules/productos/listar-productos-xprov.php",
    { ESTADO: "ALL"},
    function (data) {
    $('select[name="mov_prod_code"]').empty();
    $('select[name="mov_prod_code"]').select2({
        data: JSON.parse(data)
    })
});

$.post(
    "../../modules/proveedores/listar-proveedores.php",
    function (data) {
    $('select[name="mov_prov"]').empty();
    $('select[name="mov_prov"]').select2({
        data: JSON.parse(data)
    })
});

$("#rbtnIngreso").on("change", function(){
    checkTipoMov();
})

$("#rbtnAjuste").on("change", function(){
    checkTipoMov();
})

function checkTipoMov(){
    if ($("#rbtnIngreso").is(":checked")){
        $("#mov_secondary_info").removeClass("d-none");
    }else{
        $("#mov_secondary_info").addClass("d-none");
    }
}

$("#FRM_INSERT_MOV").submit(function (e) {
    e.preventDefault();

    if ($('input[name="mov_cantidad"]').val() == 0){
        toastr.error("Especifique un valor movimiento de stock diferente de 0.",'Stock no válido');
        return;
    }

    if ($("#rbtnIngreso").is(":checked")){

        if ($('select[name="mov_prov"]').val() == 0){
            toastr.error("Seleccione un proveedor para asociarlo a este ingreso.",'Proveedor No Seleccionado');
            return;
        }

        if ($('input[name="mov_cantidad"]').val() < 0){
            toastr.error("El stock de ingreso no puede ser negativo.",'Stock no válido');
            return;
        }
        
    }

    var form = $(this);
    var idform = form.attr("id");
    var url = form.attr('action');
    var formElement = document.getElementById(idform);
    var formData_rec = new FormData(formElement);
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
                $.Notification.notify("error", "bottom-right", "Error de guardado", "No se pudieron guardar datos del movimiento de stock");
                Swal.close();
            } else if (data == "OK_INSERT") {
                $.Notification.notify("success", "bottom-right", "Movimiento guardado", "Stock Actualizado");
                form.find("textarea, select").val("");
                $('input[name="mov_obs"]').val("");
                $('input[name="mov_cantidad"]').val("1");
                $('select[name="mov_prod_code"]').trigger('change');
                $('select[name="mov_prov"]').trigger('change');
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