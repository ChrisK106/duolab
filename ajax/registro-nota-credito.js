$("#col-btn-anular-factura").hide();
$("#col-btn-pendiente-factura").hide();
$("#col-btn-cancelar-factura").hide();

$("#btn-save-facturaprod").prop("disabled", true);
$("#btn-add-prodtofactura").prop("disabled", true);
$("#btn-select-cotizacion").prop("disabled", true);
$("#btn-select-factura").prop("disabled", true);
$('input[name="facturacion_prodcant"]').prop("disabled", true);
$('#div_diaspago').hide();
$('input[name="facturacion_formpago"]').prop("required",false);

$(document).ready(function(){
  $("#m_registro_nota_credito").attr("class","nav-link active");
  $("#m_nota_credito").attr("class","nav-link active");
  $("#m_nota_credito").parent().attr("class","nav-item has-treeview menu-open");
  $(document).prop('title', 'Registro de Nota de Crédito - DuoLab Group');
});

$('select[name="facturacion_formpagotext"]').on("change", function() {
  valtipo = $(this).val();
  cotiztipopago = $('input[name="facturacion_formpago"]');
  div_tipopago = $('#div_diaspago');
  if(valtipo != ""){    
    if(valtipo == "Otro"){
      cotiztipopago.val("");
      cotiztipopago.prop("required",true);
      div_tipopago.show();
    } else {
      cotiztipopago.val(valtipo);
      cotiztipopago.prop("required",false);
      div_tipopago.hide();
    }
  }
});

$.post("../../modules/facturacion/listar-notas-credito.php", function(data) {
  $('select[name="facturas_listado"]').empty();
  $('select[name="facturas_listado"]').select2({
    data: JSON.parse(data)
  });
});

$('select[name="facturas_listado"]').on("change", function() {
  val_lstfacs = $(this).val();
  if (val_lstfacs != "" && val_lstfacs != null) {
    $("#btn-select-factura").prop("disabled", false);
  } else {
    $("#btn-select-factura").prop("disabled", true);
  }
});

$('input[name="facturacion_valcliente"]').autocomplete({
  source: function(request, response) {
    $.getJSON("../../modules/clientes/obtener-clientes.php", { cotiz_nomcliente: $('input[name="facturacion_valcliente"]').val() }, response);
  },
  select: function (event, ui) {
    $(this).val(ui.item.label);
    $('input[name="facturacion_cliruc"]').val("");
    $('input[name="facturacion_clidirecc"]').val("");
    $('input[name="facturacion_clirefer"]').val("");
    if (ui.item.id != "" && ui.item.id != null) {
      $.post(
        "../../modules/clientes/consultar-cliente.php",
        { FILTER: ui.item.id },
        function(data) {
          var mydata = JSON.parse(data);
          $('input[name="facturacion_cliente"]').val(mydata[0]["CODIGO"]);
          $('input[name="facturacion_cliruc"]').val(mydata[0]["RUC"]);
          $('input[name="facturacion_clidirecc"]').val(mydata[0]["DIRECC"]);
          //$('input[name="facturacion_clirefer"]').val("No registrada");
        }
      );
    }
  }
});

buscarCorrelativo();

$.post("../../modules/usuarios/listar-usuarios-xtipo.php", function(data) {
  mydata = JSON.parse(data);
  data_users = mydata[0];
  user_id = mydata[1];
  user_job = mydata[2];

  $('select[name="facturacion_usuario"]').empty();
  $('select[name="facturacion_usuario"]').select2({
    data: data_users
  });

  $('select[name="facturacion_usuario"]').val(user_id);
  $('select[name="facturacion_usuario"]').trigger("change");
  $('input[name="facturacion_usuarioid"]').val(user_id);
  
  if(user_job != "Secretaria" && user_job != "Secretario"){
    $('select[name="facturacion_usuario"]').prop("disabled",true);
  }

});

$('select[name="facturacion_usuario"]').on("change", function(){
  $('input[name="facturacion_usuarioid"]').val($(this).val());
});

$.post("../../modules/facturacion/listar-factura-boleta.php", function(data) {
  $('select[name="facturacion_listadofact"]').empty();
  $('select[name="facturacion_listadofact"]').select2({
    data: JSON.parse(data)
  });
});

$.post(
  "../../modules/productos/listar-productos-xprov.php",
  { ESTADO: 1 },
  function(data) {
    $('select[name="facturacion_producto"]').empty();
    $('select[name="facturacion_producto"]').select2({
      data: JSON.parse(data)
    });
  }
);

$('select[name="facturacion_producto"]').on("change", function() {
  DATA_ID = $(this).val();
  $('input[name="facturacion_prodcant"]').val(0);
  $('input[name="facturacion_nameprod"]').val("");
  $('input[name="facturacion_proddesc"]').val("");
  $('input[name="facturacion_prodprecio"]').val("");
  $('input[name="facturacion_stockprod"]').val("");
  $('input[name="facturacion_codeprod"]').val("");
  if (DATA_ID != "" && DATA_ID != null) {
    $('input[name="facturacion_prodcant"]').prop("disabled", false);
    $.post(
      "../../modules/productos/consultar-productos.php",
      { FILTER: DATA_ID, ESTADO: "1" },
      function(data) {
        var mydata = JSON.parse(data);
        stock_producto = parseInt(mydata[0]["CANTIDAD"]);
        $('input[name="facturacion_codeprod"]').val(mydata[0]["CODPROD"]);
        $('input[name="facturacion_nameprod"]').val(mydata[0]["NOMBRE"]);
        $('input[name="facturacion_proddesc"]').val(mydata[0]["DESCRIPTION"]);
        $('input[name="facturacion_prodprecio"]').val(mydata[0]["PRECIO"]);
        $('input[name="facturacion_stockprod"]').val(mydata[0]["CANTIDAD"]);
        if (stock_producto <= 0) {
          $.Notification.notify(
            "error",
            "bottom-right",
            "Stock agotado",
            "Producto seleccionado no cuenta con existencias"
          );
          $("#btn-add-prodtofactura").prop("disabled", true);
        }
      }
    );
  } else {
    $('input[name="facturacion_prodcant"]').prop("disabled", true);
  }
});

$('input[name="facturacion_prodcant"]').on("change", function() {
  cant_prod = parseInt($(this).val());
  stock_prod = parseInt($('input[name="facturacion_stockprod"]').val());
  select_prod = $('select[name="facturacion_producto"]').val();

  if (cant_prod <= stock_prod) {
    tbl_data = tbl_prodfactura
      .rows()
      .data()
      .toArray();

    var cantidad_final = 0;
    cantidad_final += cant_prod;

    if (tbl_data.length > 0) {
      for (i = 0; i < tbl_data.length; i++) {
        id_prod = tbl_data[i][0];
        cant_agreg = parseInt(tbl_data[i][5]);
        if (select_prod == id_prod) {
          cantidad_final += cant_agreg;
        }
      }
      //console.log(cantidad_final);
      if (cantidad_final > stock_prod) {
        $("#btn-add-prodtofactura").prop("disabled", true);
        $.Notification.notify(
          "error",
          "bottom-right",
          "Stock insuficiente",
          "Producto no cuenta con stock suficiente"
        );
      } else if (cantidad_final <= stock_prod) {
        $("#btn-add-prodtofactura").prop("disabled", false);
      }
    } else {
      $("#btn-add-prodtofactura").prop("disabled", false);
    }
  } else if (cant_prod > stock_prod) {
    $("#btn-add-prodtofactura").prop("disabled", true);
    $.Notification.notify(
      "error",
      "bottom-right",
      "Stock insuficiente",
      "Producto no cuenta con stock suficiente"
    );
  }
});

var tbl_prodfactura = $("#table-productsfactura").DataTable({
  "language": {"url": "../../plugins/datatables/Spanish.json"}
});

var total_temporal = 0;
tbl_prodfactura.columns([0]).visible(false);

var tbl_data = "";

$("#btn-add-prodtofactura").click(function() {
  idprod = $('select[name="facturacion_producto"]').val();
  cod_prod = $('input[name="facturacion_codeprod"]').val();
  producto = $('input[name="facturacion_nameprod"]').val();
  descripcion = $('input[name="facturacion_proddesc"]').val();
  precio = parseFloat($('input[name="facturacion_prodprecio"]').val());
  cantidad = parseInt($('input[name="facturacion_prodcant"]').val());
  importe = precio * cantidad;
  var importe_actual = importe;

  if (idprod != "" && cantidad != "" && cantidad > 0) {
    $("#btn-add-prodtofactura").prop("disabled", true);
    tbl_prodfactura
      .rows(function(idx, data, node) {
        old_importe = data[6];
        old_cantidad = parseInt(data[5]);
        if (data[2] === producto) {
          importe += old_importe;
          cantidad += old_cantidad;
        }
        return data[2] === producto;
      })
      .remove()
      .draw();

    tbl_prodfactura.rows
      .add([
        {
          0: idprod,
          1: cod_prod,
          2: producto,
          3: descripcion,
          4: precio.toFixed(2),
          5: cantidad,
          6: importe.toFixed(2)
        }
      ])
      .draw();

    tbl_data = tbl_prodfactura
      .rows()
      .data()
      .toArray();

    opergrab =
      $('input[name="facturacion_opergrab"]').val() != ""
        ? $('input[name="facturacion_opergrab"]').val()
        : 0;
    importe_totactual = parseFloat(opergrab);
    importe_totactual += importe_actual;
    new_igv = importe_totactual * 0.18;
    new_total = importe_totactual + new_igv;

    total_temporal = new_total;

    $('input[name="facturacion_opergrab"]').val(importe_totactual.toFixed(2));
    $('input[name="facturacion_igv"]').val(new_igv.toFixed(2));
    $('input[name="facturacion_total"]').val(new_total.toFixed(2));

    $('input[name="facturacion_prodcant"]').val(0);
    $('input[name="facturacion_prodprecio"]').val(0.00);

    $.Notification.notify(
      "success",
      "bottom-right",
      "Producto añadido",
      "El producto ha sido agregado a la factura correctamente"
    );

    if (tbl_data.length > 0) {
      $("#btn-save-facturaprod").prop("disabled", false);
      porc_desc = parseFloat($('input[name="facturacion_porcdesc"]').val()) / 100;
      val_desc = new_total * porc_desc;
      $('input[name="facturacion_cantdesc"]').val(val_desc.toFixed(3));
    } else {
      $('input[name="facturacion_cantdesc"]').val(0);
      $('input[name="facturacion_porcdesc"]').val(0);
      $("#btn-save-facturaprod").prop("disabled", true);
      total_temporal = 0;
    }
  } else {
    $('select[name="facturacion_producto"]').focus();
    $.Notification.notify(
      "error",
      "bottom-right",
      "Error al añadir",
      "Seleccione un producto de la lista"
    );
  }
});

$('select[name="facturacion_listadofact"]').on("change", function() {
  val_lstcotiz = $(this).val();
  if (val_lstcotiz != "" && val_lstcotiz != null) {
    $("#btn-select-cotizacion").prop("disabled", false);
  } else {
    $("#btn-select-cotizacion").prop("disabled", true);
  }
});

$("#btn-select-factura").click(function() {
  DATA_ID = $('select[name="facturas_listado"]').val();
  if (DATA_ID != "" && DATA_ID != null) {

    $('input[name="id_factura"]').val("");
    $('select[name="facturacion_estado"]').val("1");

    Swal.fire({
      html: "<h4>Cargando datos de nota de crédito</h4>",
      allowOutsideClick: false,
      onBeforeOpen: () => {
        Swal.showLoading();
      }
    });

    $.post(
      "../../modules/facturacion/consultar-nota-credito.php",
      { FILTER: DATA_ID, ESTADO:"ALL" },
      function(data) {
        var data_json = JSON.parse(data);

        if(data_json.length > 0){

          id_factura = data_json[0]["CODIGOID"];
          est_factura = data_json[0]["ESTADO"];

          $("#col-btn-save-facturaprod").hide("fast");

          if(est_factura == 1) //VIGENTE
          {
            $("#btn-anular-factura").prop("disabled",false);
            $("#btn-pendiente-factura").prop("disabled",false);
            $("#btn-cancelar-factura").prop("disabled",false);
          }
          else if (est_factura == 2) //ANULADA
          {
            $("#btn-anular-factura").prop("disabled",true);
            $("#btn-pendiente-factura").prop("disabled",false);
            $("#btn-cancelar-factura").prop("disabled",false);
          }
          else if (est_factura == 3) //PENDIENTE DE PAGO
          {
            $("#btn-anular-factura").prop("disabled",false);
            $("#btn-pendiente-factura").prop("disabled",true);
            $("#btn-cancelar-factura").prop("disabled",false);
          }
          else if (est_factura == 4) //CANCELADA
          {
            $("#btn-anular-factura").prop("disabled",false);
            $("#btn-pendiente-factura").prop("disabled",false);
            $("#btn-cancelar-factura").prop("disabled",true);
          }

          $docType = data_json[0]["REFERENCED_DOC_TYPE"];
          $('select[name="facturacion_listadofact"] option:selected').removeAttr("selected"); 

          if ($docType == 1){
            $("select[name='facturacion_listadofact'] option[value=" + data_json[0]["REFERENCED_DOC_ID"] + "]:contains('F')").attr('selected','selected');
          }else{
            $("select[name='facturacion_listadofact'] option[value=" + data_json[0]["REFERENCED_DOC_ID"] + "]:contains('B')").attr('selected','selected');
          }
          
          $('select[name="facturacion_listadofact"]').trigger("change");
          $('select[name="facturacion_listadofact"]').prop("disabled",true);
          $("#btn-select-cotizacion").prop("disabled",true);

          $('select[name="facturacion_estado"]').prop("disabled",true);

          $('input[name="id_factura"]').val(id_factura);
          
          $("#btn-anular-factura").attr("js-id",id_factura);
          $("#btn-pendiente-factura").attr("js-id",id_factura);
          $("#btn-cancelar-factura").attr("js-id",id_factura);

          $('select[name="facturacion_series"]').val(data_json[0]["SERIE"]);
          $('select[name="facturacion_series"]').trigger("change");
          $('select[name="facturacion_series"]').prop("disabled",true);

          $('input[name="facturacion_nro"]').val(data_json[0]["CODIGO"]);
          $('input[name="facturacion_nro"]').prop("disabled",true);
          
          $('select[name="facturacion_estado"]').val(est_factura);
          $('input[name="facturacion_valcliente"]').focus();
          $('input[name="facturacion_fecha"]').val(data_json[0]["FECREG"]);
          $('select[name="facturacion_usuario"]').val(data_json[0]["USER_ID"]);
          $('select[name="facturacion_usuario"]').trigger("change");
          $('input[name="facturacion_usuarioid"]').val(data_json[0]["USER_ID"]);

          $('input[name="facturacion_cliente"]').val(data_json[0]["CLIENTID"]);
          $('input[name="facturacion_valcliente"]').val(data_json[0]["CLIENTNAME"]);
          
          $('input[name="facturacion_cliruc"]').val(data_json[0]["CLIENTRUC"]);
          $('input[name="facturacion_clidirecc"]').val(data_json[0]["CLIENTADDR"]);
          $('input[name="facturacion_clirefer"]').val(data_json[0]["CLIENTREFER"]);

          $('select[name="facturacion_formpagotext"]').val(data_json[0]["PAY_DAYS"]);
          $('select[name="facturacion_formpagotext"]').trigger("change");

          if ($('select[name="facturacion_formpagotext"]').val() == null) {
            $('select[name="facturacion_formpagotext"]').val("Otro");
            $('select[name="facturacion_formpagotext"]').trigger("change");
            $('#div_diaspago').show();
            $('input[name="facturacion_formpago"]').prop("required",true);
            $('input[name="facturacion_formpago"]').val(data_json[0]["PAY_DAYS"] );
          }

          $('input[name="facturacion_fecentrega"]').val(data_json[0]["DELIV_DATE"]);

          $('select[name="facturacion_tipmon"]').val(data_json[0]["CURRENCY"]);
          $('select[name="facturacion_tipmon"]').trigger("change");

          $('select[name="facturacion_motivo_nc"]').val(data_json[0]["REASON"]);
          $('select[name="facturacion_motivo_nc"]').trigger("change");

          $('input[name="facturacion_porcdesc"]').val(data_json[0]["DESC_RATE"]);
          $('input[name="facturacion_cantdesc"]').val(data_json[0]["DESC_VAL"]);
          $('input[name="facturacion_opergrab"]').val(parseFloat(data_json[0]["TOTAL_SUB"]).toFixed(2));
          $('input[name="facturacion_igv"]').val(parseFloat(data_json[0]["TOTAL_TAX"]).toFixed(2));
          $('input[name="facturacion_total"]').val(parseFloat(data_json[0]["TOTAL_NET"]).toFixed(2));

          total_temporal = data_json[0]["TOTAL_NET"];
          codigo_idfac = data_json[0]["CODIGOID"];

          $.post(
            "../../modules/facturacion/consultar-detalle-nota-credito.php",
            { FAC_ID: codigo_idfac },
            function(data) {
              $('select[name="facturacion_producto"]').val("");
              $('select[name="facturacion_producto"]').trigger("change");
              $('input[name="facturacion_proddesc"]').val("");
              $('input[name="facturacion_prodprecio"]').val("");
              $('input[name="facturacion_prodcant"]').val(0);
              $("#btn-add-prodtofactura").prop("disabled", true);
              //$("#btn-save-facturaprod").prop("disabled", false);
  
              tbl_prodfactura.clear().draw();
              detafact_prods = JSON.parse(data);
              for (i = 0; i < detafact_prods.length; i++) {
                var precio = parseFloat(detafact_prods[i]["PRECIOUNIT"]).toFixed(2);
                var importe = parseFloat(detafact_prods[i]["IMPORTE"]).toFixed(2);

                tbl_prodfactura.rows
                  .add([
                    {
                      0: detafact_prods[i]["IDPROD"],
                      1: detafact_prods[i]["CODPROD"],
                      2: detafact_prods[i]["NOMBRE"],
                      3: detafact_prods[i]["DESCRIP"],
                      4: precio,
                      5: detafact_prods[i]["CANTIDAD"],
                      6: importe
                    }
                  ])
                  .draw();
              }
            }
          ).then(function() {
            Swal.close();
          });
        }
        $("#col-btn-save-facturaprod").hide("fast");
        $("#col-btn-anular-factura").show("fast");        
        $("#col-btn-pendiente-factura").show("fast");        
        $("#col-btn-cancelar-factura").show("fast");
      }
    );

  }
});

$("#btn-select-cotizacion").click(function() {

  var docId = $('select[name="facturacion_listadofact"]').val();
  var docNumber = $('select[name="facturacion_listadofact"] option:selected').text();
  var docUrl = "";
  var docDetailUrl = "";
  
  if (docId != "" && docId != null) {

    $('input[name="id_factura"]').val("");
    $('select[name="facturacion_estado"]').val("1");

    Swal.fire({
      html: "<h4>Cargando datos de documento</h4>",
      allowOutsideClick: false,
      onBeforeOpen: () => {
        Swal.showLoading();
      }
    });

    if (docNumber.charAt(0) == "F") {
      $('select[name="facturacion_series"]').val("FNC1");
      docUrl = "../../modules/facturacion/consultar-factura.php";
      docDetailUrl = "../../modules/facturacion/consultar-detalle-factura.php";
    } else {
      $('select[name="facturacion_series"]').val("BNC1");
      docUrl = "../../modules/facturacion/consultar-boleta.php";
      docDetailUrl = "../../modules/facturacion/consultar-detalle-boleta.php";
    }

    $('select[name="facturacion_series"]').trigger("change");

    buscarCorrelativo();

    $.post(docUrl, { FILTER: docId, ESTADO: "ALL" }, function(data) {

        var data_json = JSON.parse(data);
        $('input[name="facturacion_valcliente"]').focus();
        $('input[name="facturacion_fecha"]').val(data_json[0]["FECREG"]);
        $('select[name="facturacion_usuario"]').val(data_json[0]["USER_ID"]);
        $('select[name="facturacion_usuario"]').trigger("change");
        $('input[name="facturacion_usuarioid"]').val(data_json[0]["USER_ID"]);

        $('input[name="facturacion_cliente"]').val(data_json[0]["CLIENTID"]);
        $('input[name="facturacion_valcliente"]').val(data_json[0]["CLIENTNAME"]);
        
        $('input[name="facturacion_cliruc"]').val(data_json[0]["CLIENTRUC"]);
        $('input[name="facturacion_clidirecc"]').val(data_json[0]["CLIENTADDR"]);
        $('input[name="facturacion_clirefer"]').val(data_json[0]["CLIENTREFER"]);

        $('select[name="facturacion_formpagotext"]').val(data_json[0]["PAY_DAYS"]);
        $('select[name="facturacion_formpagotext"]').trigger("change");

        if ($('select[name="facturacion_formpagotext"]').val() == null) {
          $('select[name="facturacion_formpagotext"]').val("Otro");
          $('select[name="facturacion_formpagotext"]').trigger("change");
          $('#div_diaspago').show();
          $('input[name="facturacion_formpago"]').prop("required",true);
          $('input[name="facturacion_formpago"]').val(data_json[0]["PAY_DAYS"] );
        }

        $('input[name="facturacion_fecentrega"]').val(data_json[0]["DELIV_DATE"]);

        $('select[name="facturacion_tipmon"]').val(data_json[0]["CURRENCY"]);
        $('select[name="facturacion_tipmon"]').trigger("change");

        $('input[name="facturacion_porcdesc"]').val(data_json[0]["DESC_RATE"]);
        $('input[name="facturacion_cantdesc"]').val(data_json[0]["DESC_VAL"]);
        $('input[name="facturacion_opergrab"]').val(parseFloat(data_json[0]["TOTAL_SUB"]).toFixed(2));
        $('input[name="facturacion_igv"]').val(parseFloat(data_json[0]["TOTAL_TAX"]).toFixed(2));
        $('input[name="facturacion_total"]').val(parseFloat(data_json[0]["TOTAL_NET"]).toFixed(2));

        total_temporal = data_json[0]["TOTAL_NET"];
        codigo_idfac = data_json[0]["CODIGOID"];

        $.post(docDetailUrl, { FAC_ID: codigo_idfac }, function(data) {
            $('select[name="facturacion_producto"]').val("");
            $('select[name="facturacion_producto"]').trigger("change");
            $('input[name="facturacion_proddesc"]').val("");
            $('input[name="facturacion_prodprecio"]').val("");
            $('input[name="facturacion_prodcant"]').val(0);
            $("#btn-add-prodtofactura").prop("disabled", true);
            $("#btn-save-facturaprod").prop("disabled", false);

            tbl_prodfactura.clear().draw();
            detallefac_json = JSON.parse(data);
            for (i = 0; i < detallefac_json.length; i++) {
              var precio = parseFloat(detallefac_json[i]["PRECIOUNIT"]).toFixed(2);
              var importe = parseFloat(detallefac_json[i]["IMPORTE"]).toFixed(2);

              tbl_prodfactura.rows
                .add([
                  {
                    0: detallefac_json[i]["IDPROD"],
                    1: detallefac_json[i]["CODPROD"],
                    2: detallefac_json[i]["NOMBRE"],
                    3: detallefac_json[i]["DESCRIP"],
                    4: precio,
                    5: detallefac_json[i]["CANTIDAD"],
                    6: importe
                  }
                ])
                .draw();
            }
          }
        );
      }
    ).then(function() {
      Swal.close();
    });
  }
});

$("#table-productsfactura").on("dblclick", "tr", function() {
  var data_row = tbl_prodfactura.row(this).data();
  var row_id = data_row[0];
  var importe_prod = data_row[6];

  opergrab =
    $('input[name="facturacion_opergrab"]').val() != ""
      ? $('input[name="facturacion_opergrab"]').val()
      : 0;
  importe_totactual = parseFloat(opergrab);
  importe_totactual -= importe_prod;
  new_igv = importe_totactual * 0.18;
  new_total = importe_totactual + new_igv;

  total_temporal = new_total;

  $('input[name="facturacion_opergrab"]').val(importe_totactual.toFixed(2));
  $('input[name="facturacion_igv"]').val(new_igv.toFixed(2));
  $('input[name="facturacion_total"]').val(new_total.toFixed(2));

  tbl_prodfactura
    .rows(tbl_prodfactura.row(this))
    .remove()
    .draw();

  tbl_data = tbl_prodfactura
    .rows()
    .data()
    .toArray();

  $('input[name="facturacion_prodcant"]').val(0);
  $("#btn-add-prodtofactura").prop("disabled", true);

  $.Notification.notify(
    "success",
    "bottom-right",
    "Producto eliminado",
    "El producto ha sido eliminado correctamente"
  );

  if (tbl_data.length > 0) {
    //$("#btn-save-facturaprod").prop("disabled", false);
    porc_desc = parseFloat($('input[name="facturacion_porcdesc"]').val()) / 100;
    val_desc = new_total * porc_desc;
    $('input[name="facturacion_cantdesc"]').val(val_desc.toFixed(3));
  } else {
    $("#btn-save-facturaprod").prop("disabled", true);
    $('input[name="facturacion_cantdesc"]').val(0);
    $('input[name="facturacion_porcdesc"]').val(0);
    total_temporal = 0;
  }
});

$('input[name="facturacion_porcdesc"]').on("change", function() {
  num_desc = parseFloat($(this).val());
  if (isNaN(num_desc)) num_desc=0;

  porc_desc = num_desc / 100;
  total_actual = parseFloat($('input[name="facturacion_total"]').val());
  val_desc = total_actual * porc_desc;
  $('input[name="facturacion_cantdesc"]').val(val_desc.toFixed(3));

  total_desc = total_temporal - val_desc;
  $('input[name="facturacion_total"]').val(total_desc.toFixed(2));
});

$("#FRM_INSERT_FACTURA").submit(function(e) {
  e.preventDefault();
  var form = $(this);
  var idform = form.attr("id");
  var url = form.attr("action");
  tbl_data = tbl_prodfactura.rows().data().toArray();
  var formElement = document.getElementById(idform);
  var formData_rec = new FormData(formElement);
  formData_rec.append("facturacion_prods", JSON.stringify(tbl_data));
  $.ajax({
    type: "POST",
    url: url,
    data: formData_rec,
    contentType: false,
    cache: false,
    processData: false,
    beforeSend: function() {
      Swal.fire({
        html: "<h4>Guardando nota de crédito</h4>",
        allowOutsideClick: false,
        onBeforeOpen: () => {
          Swal.showLoading();
        }
      });
    },
    success: function(data) {
      //console.log(data);
      if (data == "ERROR") {
        $.Notification.notify(
          "error",
          "bottom-right",
          "Error de guardado",
          "No se pudo guardar la nota de crédito"
        );
        Swal.close();

      } else if (data == "OK_INSERT") {
        $('input[name="facturacion_valcliente"]').val("");
        $('input[name="facturacion_fecha"]').focus();
        $.Notification.notify(
          "success",
          "bottom-right",
          "Nota de crédito guardada",
          "Datos almacenados"
        );

        postCambioEstado();
        
        $.post("../../modules/facturacion/listar-notas-credito.php", function(data) {
          $('select[name="facturas_listado"]').empty();
          $('select[name="facturas_listado"]').select2({
            data: JSON.parse(data)
            });
        });

        Swal.close();
      }
    }
  });
});

$("#btn-nuevafac").click(function (e) {
    e.preventDefault();
    location.reload();
});

$("#btn-anular-factura").click(function() {
  element = $(this);
  id_val = element.attr("js-id");
  if (id_val != "" && id_val != null) {
    Swal.fire({
      title: "¿Está seguro de ANULAR esta nota de crédito?",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Anular",
      cancelButtonText: "Cancelar"
    }).then(result => {
      if (result.value) {
        $.post(
          "../../modules/facturacion/cambiar-estado-doc.php",
          { TIPO_DOC: 'CREDIT_NOTE', ID_DOC: id_val, ESTADO_DOC : 2},
          function(data) {
            if (data == true) {
              postCambioEstado();
              
              $.Notification.notify(
                "success",
                "bottom-right",
                "Nota de Crédito Anulada",
                "La nota de crédito fue ANULADA con éxito"
              );
            }else{
              $.Notification.notify(
                "error",
                "bottom-right",
                "Error",
                "La nota de crédito no pudo ser ANULADA"
              );
            }
          }
        );
      }
    });
  }
});

$("#btn-pendiente-factura").click(function() {
  element = $(this);
  id_val = element.attr("js-id");
  if (id_val != "" && id_val != null) {
    Swal.fire({
      title: "¿Está seguro de marcar como PENDIENTE DE PAGO esta nota de crédito?",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Marcar como PENDIENTE",
      cancelButtonText: "Cancelar"
    }).then(result => {
      if (result.value) {
        $.post(
          "../../modules/facturacion/cambiar-estado-doc.php",
          { TIPO_DOC: 'CREDIT_NOTE', ID_DOC: id_val, ESTADO_DOC : 3},
          function(data) {
            if (data == true) {
              postCambioEstado();

              $.Notification.notify(
                "success",
                "bottom-right",
                "Nota de Crédito Pendiente de Pago",
                "La factura fue marcada como PENDIENTE DE PAGO con éxito"
              );
            }else{
              $.Notification.notify(
                "error",
                "bottom-right",
                "Error",
                "La nota de crédito no pudo ser marcada como PENDIENTE DE PAGO"
              );
            }
          }
        );
      }
    });
  }
});

$("#btn-cancelar-factura").click(function() {
  element = $(this);
  id_val = element.attr("js-id");
  if (id_val != "" && id_val != null) {
    Swal.fire({
      title: "¿Está seguro de marcar como CANCELADA esta nota de crédito?",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Marcar como CANCELADA",
      cancelButtonText: "Cancelar"
    }).then(result => {
      if (result.value) {
        $.post(
          "../../modules/facturacion/cambiar-estado-doc.php",
          { TIPO_DOC: 'CREDIT_NOTE', ID_DOC: id_val, ESTADO_DOC : 4},
          function(data) {
            if (data == true) {
              postCambioEstado();

              $.Notification.notify(
                "success",
                "bottom-right",
                "Nota de Crédito Cancelada",
                "La nota de crédito fue marcada como CANCELADA con éxito"
              );
            }else{
              $.Notification.notify(
                "error",
                "bottom-right",
                "Error",
                "La nota de crédito no pudo ser marcada como CANCELADA"
              );
            }
          }
        );
      }
    });
  }
});

function postCambioEstado(){
  $('select[name="facturacion_estado"]').val("1");
  $('input[name="facturacion_fecha"]').focus();
  tbl_prodfactura.clear().draw();

  $("#FRM_INSERT_FACTURA")
    .find("input, textarea, select")
    .val("");

  $("#FRM_INSERT_FACTURA")[0].reset();

  $('select[name="facturacion_producto"]').trigger("change");
  $("#btn-add-prodtofactura").prop("disabled", false);              
  $('input[name="id_factura"]').val("");
  $('input[name="facturacion_valcliente"]').val("");

  $("#btn-save-facturaprod").prop("disabled", true);
  $("#col-btn-save-facturaprod").show();
  $("#col-btn-anular-factura").hide();
  $("#col-btn-pendiente-factura").hide();
  $("#col-btn-cancelar-factura").hide();

  $('select[name="facturacion_formpagotext"]').prop("disabled",false);
  $('#div_diaspago').hide();
  $('input[name="facturacion_formpago"]').prop("required",false);

  $('select[name="facturacion_series"]').prop("disabled",false);
  $('input[name="facturacion_nro"]').prop("disabled",false);
  $('select[name="facturacion_series"]').trigger("change");
  $('select[name="facturacion_estado"]').prop("disabled",false);

  //$('select[name="facturacion_listadofact"]').val(-1);
  $('select[name="facturacion_listadofact"]').trigger("change");
  $('select[name="facturacion_listadofact"]').prop("disabled",false);

}

$(document).ready(function() {
  var cookie_idfact = leer_cookie('COOKIE_ID_FACT');
  if (cookie_idfact != "") {
    setTimeout(function(){
      $('select[name="facturas_listado"]').val(cookie_idfact);
      $('select[name="facturas_listado"]').trigger("change");
      $('#btn-select-factura').trigger("click");
      eliminar_cookie("COOKIE_ID_FACT");
    },500);
  }
});

function buscarCorrelativo(){
  serieFactura = $('select[name="facturacion_series"]').val();
  
  $.post("../../modules/facturacion/obtener-correlativo-doc.php",
    { TIPO_DOC: "CREDIT_NOTE", SERIE: serieFactura }, function(data) {
    if(data != "" && data != null){
      $('input[name="facturacion_nro"]').val(data);
    }
  });
}

$( 'select[name="facturacion_series"]' ).change(function() {
  idDoc = $('input[name="id_factura"]').val();
  if (idDoc == "") buscarCorrelativo();
});