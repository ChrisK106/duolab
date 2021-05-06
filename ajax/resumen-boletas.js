$(document).ready(function(){
  $("#m_resumen_boleta").attr("class","nav-link active");
  $("#m_boleta").attr("class","nav-link active");
  $("#m_boleta").parent().attr("class","nav-item has-treeview menu-open");
  $(document).prop('title', 'Resumen de Boletas - DuoLab Group');
});

var tbl_facturas = $("#table-boletas").DataTable({
  dom: 'Bfrtip',
  "order": [[0, "DESC"]],
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
  language: { url: "../../plugins/datatables/Spanish.json" }
});

listarDocumentos(true);

tbl_facturas.columns([0]).visible(false);

/*
$('input[name="factura_numero"]').autocomplete({
    source: function(request, response) {
      $.getJSON("../../modules/facturacion/obtener-boletas.php", { factura_num: $('input[name="factura_numero"]').val() }, response);
    },
    select: function (event, ui) {
      $(this).val(ui.item.label);
    }
});
*/

$('input[name="factura_cliente"]').autocomplete({  
    source: function(request, response) {
      $.getJSON("../../modules/clientes/obtener-clientes.php", { 
        cotiz_nomcliente: $('input[name="factura_cliente"]').val()
      }, response);
    },
    select: function (event, ui) {
      $(this).val(ui.item.label);
    }
});

$('input[name="factura_fecini"], input[name="factura_fecfin"]').on("change", function() {
    fact_fini = $('input[name="factura_fecini"]').val();
    fact_ffin = $('input[name="factura_fecfin"]').val();

    if(moment(fact_fini).isValid() && moment(fact_ffin).isValid()){
        fecinic = $('input[name="factura_fecini"]');
        fecfin = $('input[name="factura_fecfin"]');
        rango_dias = moment.range(moment(fecinic.val()).format('YYYY-MM-DD'), moment(fecfin.val()).format('YYYY-MM-DD'));
        dif_days = rango_dias.diff('days');

        if (dif_days < 0) { //ERROR
            new_date = moment(fecinic.val()).add(1, 'day');
            fecfin.val(new_date.format('YYYY-MM-DD'));
        }else{ //OK
            rango_dias = moment.range(moment(fecfin.val()).format('YYYY-MM-DD'), moment(fecinic.val()).format('YYYY-MM-DD'));
            if (dif_days < 0) {
                new_date = moment(fecinic.val()).add(1, 'day');
                fecfin.val(new_date.format('YYYY-MM-DD'));
            }
        }
    }

});

$('input[name="factura_fecini"]').on("change", function() {
    fecinic = $(this);
    fecfin = $('input[name="factura_fecfin"]');
    if(moment(fecinic.val()).isValid()){
        new_date = moment(fecinic.val()).add(1, 'day');
        fecfin.val(new_date.format('YYYY-MM-DD'));
    }
});

$("#btn-buscar").click(function(){
  listarDocumentos();
});

$("#table-boletas").contextMenu({
  selector: "tbody tr",
  callback: function(key, options) {
    tbl_data = tbl_facturas.rows().data().toArray();  

    if(tbl_data.length > 0){
      var data_row = tbl_facturas.row(this).data();
          var row_id = data_row[0];
          var action = key;
          
          switch (action) {

            case "edit":
                crear_cookie('COOKIE_ID_FACT', row_id, 1, "/");
                location.href = "registro-boleta";
                break;

            case "vigente":
              Swal.fire({
                title: "¿Está seguro de marcar como VIGENTE la boleta " + data_row[1] + "?",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Marcar como VIGENTE",
                cancelButtonText: "Cancelar"
              }).then(result => {
                if (result.value) {
                  $.post(
                      "../../modules/facturacion/cambiar-estado-doc.php",
                        { TIPO_DOC: 'RECEIPT', ID_DOC: row_id, ESTADO_DOC : 1},
                        function(data) {
                            if(data){
                              listarDocumentos();
                              $.Notification.notify(
                                  "success",
                                  "bottom-right",
                                  "Boleta Vigente",
                                  "La boleta " + data_row[1] + " fue marcada con éxito"
                                  );
                            }else{
                              $.Notification.notify(
                                  "error",
                                  "bottom-right",
                                  "Error",
                                  "La boleta " + data_row[1] + " no pudo ser marcada como vigente"
                                  );
                            }
                        }
                    );
                }});
                break;

            case "anulado":
              Swal.fire({
                title: "¿Está seguro de ANULAR la boleta " + data_row[1] + "?",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Anular",
                cancelButtonText: "Cancelar"
              }).then(result => {
                if (result.value) {
                  $.post(
                      "../../modules/facturacion/cambiar-estado-doc.php",
                        { TIPO_DOC: 'RECEIPT', ID_DOC: row_id, ESTADO_DOC : 2},
                        function(data) {
                            if(data){
                              listarDocumentos();
                              $.Notification.notify(
                                  "success",
                                  "bottom-right",
                                  "Boleta Anulada",
                                  "La boleta " + data_row[1] + " fue anulada con éxito"
                                  );
                            }else{
                              $.Notification.notify(
                                  "error",
                                  "bottom-right",
                                  "Error",
                                  "La boleta " + data_row[1] + " no pudo ser anulada"
                                  );
                            }
                        }
                    );
                }});
                break;

            case "pendiente":
              Swal.fire({
                title: "¿Está seguro de marcar como PENDIENTE DE PAGO la boleta " + data_row[1] + "?",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Marcar como PENDIENTE DE PAGO",
                cancelButtonText: "Cancelar"
              }).then(result => {
                if (result.value) {
                  $.post(
                      "../../modules/facturacion/cambiar-estado-doc.php",
                        { TIPO_DOC: 'RECEIPT', ID_DOC: row_id, ESTADO_DOC : 3},
                        function(data) {
                            if(data){
                              listarDocumentos();
                              $.Notification.notify(
                                  "success",
                                  "bottom-right",
                                  "Boleta Pendiente de Pago",
                                  "La boleta " + data_row[1] + " fue marcada con éxito"
                                  );
                            }else{
                              $.Notification.notify(
                                  "error",
                                  "bottom-right",
                                  "Error",
                                  "La boleta " + data_row[1] + " no pudo ser marcada como pendiente de pago"
                                  );
                            }
                        }
                    );
                }});
                break;

            case "cancelado":
              Swal.fire({
                title: "¿Está seguro de marcar como CANCELADA la boleta " + data_row[1] + "?",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Marcar como CANCELADA",
                cancelButtonText: "Cancelar"
              }).then(result => {
                if (result.value) {
                  $.post(
                      "../../modules/facturacion/cambiar-estado-doc.php",
                        { TIPO_DOC: 'RECEIPT', ID_DOC: row_id, ESTADO_DOC : 4},
                        function(data) {
                            if(data){
                              listarDocumentos();
                              $.Notification.notify(
                                  "success",
                                  "bottom-right",
                                  "Boleta Cancelada",
                                  "La boleta " + data_row[1] + " fue cancelada con éxito"
                                  );
                            }else{
                              $.Notification.notify(
                                  "error",
                                  "bottom-right",
                                  "Error",
                                  "La boleta " + data_row[1] + " no pudo ser cancelada"
                                  );
                            }
                        }
                    );
                }});
                break;
        }
    }
  },
  items: {
      "edit": {"name": "Ver y editar", "icon": "edit"},
      "separator1": "",
      "status": {
        "name": "Cambiar estado",
        "items": {
          "vigente": {"name": "Vigente"},
          "anulado": {"name": "Anulado"},
          "pendiente": {"name": "Pendiente de Pago"},
          "cancelado": {"name": "Cancelado"}
        }
      },
      "separator2": "",
      "close": {"name": "Cerrar", "icon": "quit"}
  }
});

$("#btn-reset").click(function (e) {
    e.preventDefault();
    location.reload();
});

function listarDocumentos(loadMode){
    fact_nroo = $('input[name="factura_numero"]').val();
    fact_client = $('input[name="factura_cliente"]').val();
    fact_fini = $('input[name="factura_fecini"]').val();
    fact_ffin = $('input[name="factura_fecfin"]').val();
    fact_estado = $('select[name="factura_estado"]').val();
    fact_vendedor = $('select[name="factura_vendedor"]').val();

    defaultLoad = 0;
    
    if (loadMode == true){
      defaultLoad = 1;
    }

    Swal.fire({
        html: "<h4>Cargando boletas</h4>",
        allowOutsideClick: false,
        onBeforeOpen: () => {
          Swal.showLoading();
        }
    });

    $.post(
        "../../modules/facturacion/filtrar-doc.php",
        { TIPO_DOC: 'RECEIPT', defaultLoad: defaultLoad, fact_nroo:fact_nroo, fact_client:fact_client, fact_fini:fact_fini, 
          fact_ffin:fact_ffin, fact_estado:fact_estado, fact_vendedor: fact_vendedor },
        function(data) {
            tbl_facturas.clear().draw();
            data_factura = JSON.parse(data);
            for (i = 0; i < data_factura.length; i++) {
                tbl_facturas.rows.add([
                {
                  0: data_factura[i]["ID"],
                  1: data_factura[i]["SERIES_NUMBER"],
                  2: data_factura[i]["DATE"],
                  3: data_factura[i]["CUSTOMER"],
                  4: data_factura[i]["TOTAL_NET"],
                  5: data_factura[i]["STATUS"],
                  6: data_factura[i]["SELLER_NAME"]
                }]).draw();

                tbl_facturas.columns.adjust().draw();
            }
        }
    ).then(function() {
        Swal.close();
    });
}