$("#btn-buscar").prop("disabled",true);

$(document).ready(function(){
  $("#m_resumen_cotizacion").attr("class","nav-link active");
  $("#m_cotizacion").attr("class","nav-link active");
  $("#m_cotizacion").parent().attr("class","nav-item has-treeview menu-open");
  $(document).prop('title', 'Resumen de Cotizaciones - DuoLab Group');
});

var tbl_cotizaciones = $("#table-cotizaciones").DataTable({
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

$.post(
  "../../modules/cotizaciones/consultar-cotizacion.php",
  { FILTER: "ALL", ESTADO: "ALL" },
  function(data) {
    tbl_cotizaciones.clear().draw();
    data_cotiz = JSON.parse(data);
    for (i = 0; i < data_cotiz.length; i++) {
      tbl_cotizaciones.rows
        .add([
          {
            0: data_cotiz[i]["CODIGOID"],
            1: data_cotiz[i]["CODIGO"],
            2: data_cotiz[i]["FECREG"],
            3: data_cotiz[i]["CLIENTNAME"],
            4: data_cotiz[i]["TOTAL_NET"],
            5: data_cotiz[i]["ESTADO_VAL"]
          }]).draw();

          tbl_cotizaciones.columns.adjust().draw();
    }
  }
).then(function() {
    Swal.close();
});

tbl_cotizaciones.columns([0]).visible(false);

$('input[name="cotizacion_numero"]').autocomplete({
    source: function(request, response) {
      $.getJSON("../../modules/cotizaciones/obtener-cotizaciones.php", { orden_cotizacion: $('input[name="cotizacion_numero"]').val() }, response);
    },
    select: function (event, ui) {
      $(this).val(ui.item.label);
    }
});

$('input[name="cotizacion_cliente"]').autocomplete({  
    source: function(request, response) {
      $.getJSON("../../modules/clientes/obtener-clientes.php", { 
        cotiz_nomcliente: $('input[name="cotizacion_cliente"]').val()
      }, response);
    },
    select: function (event, ui) {
      $(this).val(ui.item.label);
    }
});

$('input[name="cotizacion_numero"], input[name="cotizacion_cliente"]').on("keyup", function() {
    cotiz_nroo = $('input[name="cotizacion_numero"]').val();
    cotiz_client = $('input[name="cotizacion_cliente"]').val();
    if(cotiz_nroo != "" || cotiz_client != ""){
        $("#btn-buscar").prop("disabled",false);
    } else {
        $("#btn-buscar").prop("disabled",true);
    }
});

$('input[name="cotizacion_numero"], input[name="cotizacion_cliente"], input[name="cotizacion_fecinic"], input[name="cotizacion_fecfin"]').on("change", function() {
    cotiz_nroo = $('input[name="cotizacion_numero"]').val();
    cotiz_client = $('input[name="cotizacion_cliente"]').val();
    cotiz_fini = $('input[name="cotizacion_fecinic"]').val();
    cotiz_ffin = $('input[name="cotizacion_fecfin"]').val();

    if(cotiz_nroo != "" || cotiz_client != "" || (cotiz_fini != "" && cotiz_ffin != "") ){
        $("#btn-buscar").prop("disabled",false);
    } else {
        $("#btn-buscar").prop("disabled",true);
    }

    if(moment(cotiz_fini).isValid() && moment(cotiz_ffin).isValid()){
        fecinic = $('input[name="cotizacion_fecinic"]');
        fecfin = $('input[name="cotizacion_fecfin"]');
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

$('input[name="cotizacion_fecinic"]').on("change", function() {
    fecinic = $(this);
    fecfin = $('input[name="cotizacion_fecfin"]');
    if(moment(fecinic.val()).isValid()){
        new_date = moment(fecinic.val()).add(1, 'day');
        fecfin.val(new_date.format('YYYY-MM-DD'));
    }
});

$("#btn-buscar").click(function(){
    cotiz_nroo = $('input[name="cotizacion_numero"]').val();
    cotiz_client = $('input[name="cotizacion_cliente"]').val();
    cotiz_fini = $('input[name="cotizacion_fecinic"]').val();
    cotiz_ffin = $('input[name="cotizacion_fecfin"]').val();
    if(cotiz_nroo != "" || cotiz_client != "" || (cotiz_fini != "" && cotiz_ffin != "") ){
        Swal.fire({
            html: "<h4>Buscando cotizaciones</h4>",
            allowOutsideClick: false,
            onBeforeOpen: () => {
              Swal.showLoading();
            }
        });
        $.post(
            "../../modules/cotizaciones/filtrar-cotizaciones.php",
            { cotiz_nroo:cotiz_nroo, cotiz_client:cotiz_client, cotiz_fini:cotiz_fini, cotiz_ffin:cotiz_ffin  },
            function(data) {
                tbl_cotizaciones.clear().draw();
                data_cotiz = JSON.parse(data);
                for (i = 0; i < data_cotiz.length; i++) {
                tbl_cotizaciones.rows
                    .add([
                    {
                      0: data_cotiz[i]["CODIGOID"],
                      1: data_cotiz[i]["CODIGO"],
                      2: data_cotiz[i]["FECREG"],
                      3: data_cotiz[i]["CLIENTNAME"],
                      4: data_cotiz[i]["TOTAL_NET"],
                      5: data_cotiz[i]["ESTADO_VAL"]
                    }]).draw();

                    tbl_cotizaciones.columns.adjust().draw();
                }
            }
        ).then(function() {
            Swal.close();
        });
    }
});

$("#table-cotizaciones").contextMenu({
  selector: "tbody tr",
  callback: function(key, options) {
    tbl_data = tbl_cotizaciones.rows().data().toArray();  
    if(tbl_data.length > 0){
        var data_row = tbl_cotizaciones.row(this).data();
        var row_id = data_row[0];
        var accion = key;
        switch (accion) {
        case "edit":
            crear_cookie('COOKIE_ID_COTIZ', row_id, 1, "/");
            location.href = "registro-cotizacion";
            break;
        case "delete":
            $.post(
                "../../modules/cotizaciones/anular-cotizacion.php",
                { ID_COTIZ:row_id },
                function(data) {
                    if(data == true){
                      $.post(
                        "../../modules/cotizaciones/consultar-cotizacion.php",
                        { FILTER: "ALL", ESTADO: "ALL" },
                        function(data) {
                          tbl_cotizaciones.clear().draw();
                          data_cotiz = JSON.parse(data);
                          for (i = 0; i < data_cotiz.length; i++) {
                            tbl_cotizaciones.rows
                              .add([
                                {
                                  0: data_cotiz[i]["CODIGOID"],
                                  1: data_cotiz[i]["CODIGO"],
                                  2: data_cotiz[i]["FECREG"],
                                  3: data_cotiz[i]["CLIENTNAME"],
                                  4: data_cotiz[i]["TOTAL_NET"],
                                  5: data_cotiz[i]["ESTADO_VAL"]
                                }]).draw();

                                tbl_cotizaciones.columns.adjust().draw();
                          }
                        }
                      )
                      $.Notification.notify(
                          "success",
                          "bottom-right",
                          "Operación completada",
                          "Cotización anulada correctamente"
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