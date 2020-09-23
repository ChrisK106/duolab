$("#btn-buscar").prop("disabled",true);

$(document).ready(function(){
  $("#m_resumen_boleta").attr("class","nav-link active");
  $("#m_boleta").attr("class","nav-link active");
  $("#m_boleta").parent().attr("class","nav-item has-treeview menu-open");
  $(document).prop('title', 'Resumen de Boletas - DuoLab Group');
});

var tbl_facturas = $("#table-boletas").DataTable({
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
  language: { url: "../../plugins/datatables/Spanish.json" }
});

$.post(
  "../../modules/facturacion/consultar-boleta.php",
  { FILTER: "ALL", ESTADO: "ALL" },
  function(data) {
    tbl_facturas.clear().draw();
    data_factura = JSON.parse(data);
    for (i = 0; i < data_factura.length; i++) {
      tbl_facturas.rows
        .add([
          {
            0: data_factura[i]["CODIGOID"],
            1: data_factura[i]["CODIGO"],
            2: data_factura[i]["CLIENTNAME"],
            3: data_factura[i]["TOTAL_NET"],
            4: data_factura[i]["ESTADO_VAL"]
          }
        ])
        .draw();
    }
  }
).then(function() {
    Swal.close();
});

tbl_facturas.columns([0]).visible(false);

$('input[name="factura_numero"]').autocomplete({
    source: function(request, response) {
      $.getJSON("../../modules/facturacion/obtener-boletas.php", { factura_num: $('input[name="factura_numero"]').val() }, response);
    },
    select: function (event, ui) {
      $(this).val(ui.item.label);
    }
});

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

$('input[name="factura_numero"], input[name="factura_cliente"]').on("keyup", function() {
    fact_nroo = $('input[name="factura_numero"]').val();
    fact_client = $('input[name="factura_cliente"]').val();
    if(fact_nroo != "" || fact_client != ""){
        $("#btn-buscar").prop("disabled",false);
    } else {
        $("#btn-buscar").prop("disabled",true);
    }
});

$('input[name="factura_numero"], input[name="factura_cliente"], input[name="factura_fecini"], input[name="factura_fecfin"]').on("change", function() {
    fact_nroo = $('input[name="factura_numero"]').val();
    fact_client = $('input[name="factura_cliente"]').val();
    fact_fini = $('input[name="factura_fecini"]').val();
    fact_ffin = $('input[name="factura_fecfin"]').val();

    if(fact_nroo != "" || fact_client != "" || (fact_fini != "" && fact_ffin != "") ){
        $("#btn-buscar").prop("disabled",false);
    } else {
        $("#btn-buscar").prop("disabled",true);
    }

    if(moment(fact_fini).isValid() && moment(fact_ffin).isValid()){
        fecinic = $('input[name="factura_fecini"]');
        fecfin = $('input[name="factura_fecfin"]');
        rango_dias = moment.range(moment(fecinic.val()).format('YYYY-MM-DD'), moment(fecfin.val()).format('YYYY-MM-DD'));
        dif_days = rango_dias.diff('days');
        if (dif_days < 0) { //ERROR
            new_date = moment(fecinic.val()).add(1, 'day');
            fecfin.val(new_date.format('YYYY-MM-DD'));
        } else { //OK
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
    fact_nroo = $('input[name="factura_numero"]').val();
    fact_client = $('input[name="factura_cliente"]').val();
    fact_fini = $('input[name="factura_fecini"]').val();
    fact_ffin = $('input[name="factura_fecfin"]').val();
    if(fact_nroo != "" || fact_client != "" || (fact_fini != "" && fact_ffin != "") ){
        Swal.fire({
            html: "<h4>Buscando boletas</h4>",
            allowOutsideClick: false,
            onBeforeOpen: () => {
              Swal.showLoading();
            }
        });
        $.post(
            "../../modules/facturacion/filtrar-boletas.php",
            { fact_nroo:fact_nroo, fact_client:fact_client, fact_fini:fact_fini, fact_ffin:fact_ffin  },
            function(data) {
                tbl_facturas.clear().draw();
                data_factura = JSON.parse(data);
                for (i = 0; i < data_factura.length; i++) {
                tbl_facturas.rows
                    .add([
                    {
                      0: data_factura[i]["CODIGOID"],
                      1: data_factura[i]["CODIGO"],
                      2: data_factura[i]["CLIENTNAME"],
                      3: data_factura[i]["TOTAL_NET"],
                      4: data_factura[i]["ESTADO_VAL"]
                    }
                    ])
                    .draw();
                }
            }
        ).then(function() {
            Swal.close();
        });
    }
});

$("#table-boletas").contextMenu({
  selector: "tbody tr",
  callback: function(key, options) {
    tbl_data = tbl_facturas.rows().data().toArray();  
    if(tbl_data.length > 0){
        var data_row = tbl_facturas.row(this).data();
        var row_id = data_row[0];
        var accion = key;
        switch (accion) {
        case "edit":
            crear_cookie('COOKIE_ID_FACT', row_id, 1, "/");
            location.href = "registro-boleta";
            break;
        case "delete":
            $.post(
                "../../modules/facturacion/anular-boleta.php",
                { ID_FACTURA:row_id },
                function(data) {
                    if(data == true){
                     $.post(
                         "../../modules/facturacion/consultar-boleta.php",
                         { FILTER: "ALL", ESTADO: "ALL" },
                         function(data) {
                           tbl_facturas.clear().draw();
                           data_factura = JSON.parse(data);
                           for (i = 0; i < data_factura.length; i++) {
                             tbl_facturas.rows
                               .add([
                                 {
                                   0: data_factura[i]["CODIGOID"],
                                   1: data_factura[i]["CODIGO"],
                                   2: data_factura[i]["CLIENTNAME"],
                                   3: data_factura[i]["TOTAL_NET"],
                                   4: data_factura[i]["ESTADO_VAL"]
                                 }
                               ])
                               .draw();
                           }
                         }
                      )
                      $.Notification.notify(
                          "success",
                          "bottom-right",
                          "Operación completada",
                          "Boleta anulada correctamente"
                      );
                    }
                }
            );
            break;
        }
    }
  },
  items: {
    edit: { name: "Visualizar", icon: "edit" },
    delete: { name: "Anular", icon: "delete" },
    sep1: "---------",
    quit: {
      name: "Cancelar",
      icon: function($element, key, item) {
        return "context-menu-icon context-menu-icon-quit";
      }
    }
  }
});

$("#btn-reset").click(function (e) {
    e.preventDefault();
    location.reload();
});