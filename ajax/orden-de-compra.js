$("#col-btn-delete-orden").hide();
$("#btn-save-orden").prop("disabled", true);
$("#btn-add-prodtporden").prop("disabled", true);
$("#btn-select-orden").prop("disabled", true);
$('#div_diaspago').hide();
$('input[name="orden_tipopago"]').prop("required",false);

$(document).ready(function(){
  $("#m_ordenes").attr("class","nav-link active");
  $("#m_ordenes").parent().attr("class","nav-item has-treeview menu-open");
  $("#m_orden_compra").attr("class","nav-link active");
  $(document).prop('title', 'Orden de Compra - DuoLab Group');
});

var porc_igv = 0.18;

$('select[name="orden_tipopagotext"]').on("change", function() {
  valtipo = $(this).val();
  ordentipopago = $('input[name="orden_tipopago"]');
  div_tipopago = $('#div_diaspago');
  if(valtipo != ""){    
    if(valtipo == "Otro"){
      ordentipopago.val("");
      ordentipopago.prop("required",true);
      div_tipopago.show();
    } else {
      ordentipopago.val(valtipo);
      ordentipopago.prop("required",false);
      div_tipopago.hide();
    }
  }
});

$.post("../../modules/ordenes/listar-ordenes.php", {orden_tipo:"COMPRA"}, function(data) {
  $('select[name="orden_listado"]').empty();
  $('select[name="orden_listado"]').select2({
    data: JSON.parse(data)
  });
});

$.post("../../modules/proveedores/listar-proveedores.php", function(data) {
  $('select[name="orden_proveedor"]').empty();
  $('select[name="orden_proveedor"]').select2({
    data: JSON.parse(data)
  });
});

/*
$('input[name="orden_cotizacion"]').autocomplete({
  source: function(request, response) {
    $.getJSON("../../modules/cotizaciones/obtener-cotizaciones.php", { orden_cotizacion: $('input[name="orden_cotizacion"]').val() }, response);
  },
  select: function (event, ui) {
    $(this).val(ui.item.label);
  }
});
*/

$('select[name="orden_listado"]').on("change", function() {
  val_lstordens = $(this).val();
  if (val_lstordens != "" && val_lstordens != null) {
    $("#btn-select-orden").prop("disabled", false);
  } else {
    $("#btn-select-orden").prop("disabled", true);
  }
});

$('select[name="orden_proveedor"]').on('change', function(){
  provid = $(this).val();
  if(provid != ""){
    //$('input[name="orden_producto_val"]').val("");
    $('input[name="orden_porcdscto"]').val("0");
    $('input[name="orden_valordscto"]').val("0");
    $.post(
      "../../modules/proveedores/consultar-proveedor.php",
      { FILTER:provid },
      function(data) {
        var mydata = JSON.parse(data);
        $('input[name="orden_provruc"]').val(mydata[0]["NUMERO"]);
        $('input[name="orden_nomprov"]').val(mydata[0]["RAZ_SOC"]);
      }
    );

    /*$('input[name="orden_producto_val"]').autocomplete({  
      source: function(request, response) {
        $.getJSON("../../modules/productos/obtener-productos.php", { 
          orden_nomprod: $('input[name="orden_producto_val"]').val(), prov_id: provid 
        }, response);
      },
      select: function (event, ui) {
        $(this).val(ui.item.label);
        $('input[name="orden_cantidad"]').val(0);
        $('input[name="orden_codprod"]').val("");
        $('input[name="orden_descprod"]').val("");
        $('input[name="orden_precunit"]').val("");
        $('input[name="orden_stockprod"]').val("");
        $('input[name="orden_nameprod"]').val("");
        if (ui.item.id != "" && ui.item.id != null) {
          $('input[name="orden_cantidad"]').prop("disabled", false);
          $.post(
            "../../modules/productos/consultar-productos.php",
            { FILTER: ui.item.id, ESTADO:'1' },
            function(data) {
              $('input[name="orden_porcdscto"]').prop("disabled", false);
              $('input[name="orden_cantidad"]').prop("disabled", false);
              var mydata = JSON.parse(data);
              precioprod_temp = parseFloat(mydata[0]["PRECIO"]);
              stock_producto = parseInt(mydata[0]["CANTIDAD"]);
              $('input[name="orden_producto"]').val(mydata[0]["CODIGO"]);
              $('input[name="orden_nameprod"]').val(mydata[0]["NOMBRE"]);
              $('input[name="orden_codprod"]').val(mydata[0]["CODPROD"]);
              $('input[name="orden_descprod"]').val(mydata[0]["DESCRIPTION"]);
              $('input[name="orden_precunit"]').val(mydata[0]["PRECIO"]);
              $('input[name="orden_stockprod"]').val(stock_producto);
              $('input[name="orden_valunit"]').val(mydata[0]["UNITVALUE"]);
            }
          );
        } else {
          $('input[name="orden_cantidad"]').prop("disabled", true);
        }
      }
    });*/
  }
});

var precioprod_temp = 0;

/*$('select[name="orden_producto"]').on("change", function() {
  DATA_ID = $(this).val();  
  $('input[name="orden_cantidad"]').val(0);
  $('input[name="orden_codprod"]').val("");
  $('input[name="orden_descprod"]').val("");
  $('input[name="orden_precunit"]').val("");
  $('input[name="orden_stockprod"]').val("");
  $('input[name="orden_nameprod"]').val("");
  if (DATA_ID != "" && DATA_ID != null) {
    $('input[name="orden_cantidad"]').prop("disabled", false);
    $.post(
      "../../modules/productos/consultar-productos.php",
      { FILTER: DATA_ID, ESTADO:'1' },
      function(data) {
        $('input[name="orden_porcdscto"]').prop("disabled", false);
        $('input[name="orden_cantidad"]').prop("disabled", false);
        var mydata = JSON.parse(data);
        precioprod_temp = parseFloat(mydata[0]["PRECIO"]);
        stock_producto = parseInt(mydata[0]["CANTIDAD"]);
        $('input[name="orden_nameprod"]').val(mydata[0]["NOMBRE"]);
        $('input[name="orden_codprod"]').val(mydata[0]["CODPROD"]);
        $('input[name="orden_descprod"]').val(mydata[0]["DESCRIPTION"]);
        $('input[name="orden_precunit"]').val(mydata[0]["PRECIO"]);
        $('input[name="orden_stockprod"]').val(stock_producto);
        $('input[name="orden_valunit"]').val(mydata[0]["UNITVALUE"]);
      }
    );
  } else {
    $('input[name="orden_cantidad"]').prop("disabled", true);
  }
});*/

/*
$('input[name="orden_cantidad"]').on("change", function() {
  cant_prod = parseInt($(this).val());
  stock_prod = parseInt($('input[name="orden_stockprod"]').val());
  select_prod = $('input[name="orden_producto"]').val();

  //if (cant_prod <= stock_prod) {
    tbl_data = tbl_prodordcompra
      .rows()
      .data()
      .toArray();

    var cantidad_final = 0;
    cantidad_final += cant_prod;

    if (tbl_data.length > 0) {
      for (i = 0; i < tbl_data.length; i++) {
        id_prod = tbl_data[i][0];
        nom_prod = tbl_data[i][3];
        cant_agreg = parseInt(tbl_data[i][4]);
        if (select_prod == id_prod || select_prod == nom_prod) {
          cantidad_final += cant_agreg;
        }
      }

      $("#btn-add-prodtporden").prop("disabled", false);
      if (cantidad_final > stock_prod) {
        $("#btn-add-prodtporden").prop("disabled", true);
        $.Notification.notify(
          "error",
          "bottom-right",
          "Stock insuficiente",
          "Producto no cuenta con stock suficiente"
        );
      } else if (cantidad_final <= stock_prod) {
        $("#btn-add-prodtporden").prop("disabled", false);
      }
    } else {
      $("#btn-add-prodtporden").prop("disabled", false);
    }
});
*/


var tbl_prodordcompra = $("#table-ord-compras").DataTable({
  "language": {"url": "../../plugins/datatables/Spanish.json"}
});

var total_temporal = 0;

//tbl_prodordcompra.columns([0,10,11,12,13,14]).visible(false);

var tbl_data = "";

$("#btn-add-prodtporden").click(function(e) {

  e.preventDefault();
  
  code = $('input[name="orden_codprod"]').val();
  description = $('input[name="orden_descprod"]').val();
  gloss = $('input[name="orden_glosa"]').val();
  unit_value = $('select[name="orden_valunit"]').val();
  
  if (unit_value == "") unit_value = "-";

  unit_price = parseFloat($('input[name="orden_precunit"]').val());
  quantity = parseInt($('input[name="orden_cantidad"]').val());

  discount_rate = parseFloat($('input[name="orden_porcdscto"]').val());
  discounted_total = parseFloat($('input[name="orden_valordscto"]').val());

  if (code != "" && description != "" && gloss != "" && unit_price >= 0 && quantity > 0) {
    $("#btn-add-prodtporden").prop("disabled", true);

    tbl_prodordcompra
      .rows(function(idx, data, node) {
      })
      .remove()
      .draw();
      
      detail_index = tbl_prodordcompra.rows().count() + 1;

      tbl_prodordcompra.rows
      .add([
        {
          0: detail_index,
          1: code,
          2: description,
          3: gloss,
          4: unit_value,
          5: unit_price,
          6: quantity,
          7: discount_rate,
          8: discounted_total
        }
      ])
      .draw();

    tbl_data = tbl_prodordcompra
      .rows()
      .data()
      .toArray();

    total_compra =
      $('input[name="orden_totcompra"]').val() != ""
        ? $('input[name="orden_totcompra"]').val()
        : 0;

    total_compra_actual = parseFloat(total_compra);
    total_compra_actual += discounted_total 
    
    igv = total_compra_actual * porc_igv;    
    total_neto = total_compra_actual + igv;

    total_temporal = total_neto;
    
    $('input[name="orden_codprod"]').val("");
    $('input[name="orden_descprod"]').val("");
    $('input[name="orden_glosa"]').val(""); 
    $('input[name="orden_valunit"]').val("");
    $('input[name="orden_precunit"]').val(0);
    $('input[name="orden_cantidad"]').val(0);
    $('input[name="orden_porcdscto"]').val(0);
    $('input[name="orden_valordscto"]').val(0);
    $('input[name="orden_valorigv"]').val(0);

    $('input[name="orden_totcompra"]').val(total_compra_actual.toFixed(2));
    $('input[name="orden_igv"]').val(igv.toFixed(2));
    $('input[name="orden_totneto"]').val(total_neto.toFixed(2));

    $.Notification.notify(
      "success",
      "bottom-right",
      "Artículo añadido",
      "El artículo fue agregado a la OC."
    );

    if (tbl_data.length > 0) {
      $("#btn-save-orden").prop("disabled", false);
      //porc_descuento = parseFloat(porc_desc) / 100;
      //val_desc = new_total * porc_descuento;
      //$('input[name="orden_valordscto"]').val(val_desc.toFixed(2));
    } else {
      $('input[name="orden_valordscto"]').val(0);
      $('input[name="orden_porcdscto"]').val(0);
      $('input[name="orden_igv"]').val(0);
      $('input[name="orden_porcigv"]').val(0);
      $("#btn-save-orden").prop("disabled", true);
      total_temporal = 0;
    }

  } else {
    $('input[name="orden_codprod"]').focus();
    $.Notification.notify(
      "error",
      "bottom-right",
      "Datos Faltantes de Artículo",
      "Complete datos faltantes (Código, Descripcion, Glosa, Precio, Cantidad)"
    );
  }
});

$("#table-ord-compras").on("dblclick", "tr", function() {
  var data_row = tbl_prodordcompra.row(this).data();

  if (data_row == null) return;

  var row_id = data_row[0];
  var importe_prod = parseFloat(data_row[8]);
  
  //var porc_igv = $('input[name="orden_porcigv"]').val();
  //porc_igv = porc_igv==""?0:parseFloat(porc_igv);

  opergrab =
    $('input[name="orden_totcompra"]').val() != ""
      ? $('input[name="orden_totcompra"]').val()
      : 0;
  importe_totactual = parseFloat(opergrab);
  importe_totactual -= importe_prod;

  new_igv = importe_totactual * porc_igv;
  new_total = importe_totactual + new_igv;

  //total_temporal = new_total;
  total_temporal = importe_totactual;

  $('input[name="orden_totcompra"]').val(importe_totactual.toFixed(2));
  $('input[name="orden_igv"]').val(new_igv.toFixed(2));
  $('input[name="orden_totneto"]').val(new_total.toFixed(2));

  tbl_prodordcompra
    .rows(tbl_prodordcompra.row(this))
    .remove()
    .draw();

  tbl_data = tbl_prodordcompra
    .rows()
    .data()
    .toArray();

  $('input[name="orden_cantidad"]').val(0);
  $("#btn-add-prodtporden").prop("disabled", true);

  $.Notification.notify(
    "success",
    "bottom-right",
    "Artículo eliminado",
    "El artículo ha sido eliminado de la OC."
  );

  if (tbl_data.length > 0) {
    $("#btn-save-orden").prop("disabled", false);
    //porc_desc = parseFloat($('input[name="orden_porcdscto"]').val()) / 100;
    //val_desc = new_total * porc_desc;
    //$('input[name="orden_valordscto"]').val(val_desc.toFixed(2));
  } else {
    $("#btn-save-orden").prop("disabled", true);
    $('input[name="orden_valordscto"]').val(0);
    $('input[name="orden_porcdscto"]').val(0);
    total_temporal = 0;
  }
});

$('input[name="orden_tipomoneda"]').on("change", function() {
  $('input[name="orden_porcdscto"]').trigger("change");
});

$('input[name="orden_precunit"]').on("change", function() {
  $('input[name="orden_porcdscto"]').trigger("change");
});

$('input[name="orden_cantidad"]').on("change", function() {
  $('input[name="orden_porcdscto"]').trigger("change");
  $("#btn-add-prodtporden").prop("disabled", false);
});

$('input[name="orden_porcdscto"]').on("change", function() {
  precioprod_temp = $('input[name="orden_precunit"]').val();
  cantidad_articulo = $('input[name="orden_cantidad"]').val();
  total_articulo = precioprod_temp * cantidad_articulo;
  porc_desc = parseFloat($(this).val()==""?0:$(this).val()) / 100;
  val_desc = (total_articulo - (total_articulo * porc_desc)).toFixed(2);
  val_igv = (val_desc * porc_igv).toFixed(2);

  $('input[name="orden_valordscto"]').val(val_desc);
  $('input[name="orden_valorigv"]').val(val_igv);
});

/*
$('input[name="orden_porcigv"]').on("change", function() {
  oper_grab = parseFloat($('input[name="orden_totcompra"]').val());
  porc_igv = parseFloat($(this).val()==""?0:$(this).val()) / 100;
  val_igv = (oper_grab * porc_igv).toFixed(2);  
  $('input[name="orden_igv"]').val(val_igv);
  total_igv = oper_grab + parseFloat(val_igv);
  $('input[name="orden_totneto"]').val(total_igv.toFixed(2));
});
*/

$("#btn-select-orden").click(function() {
  DATA_ID = $('select[name="orden_listado"]').val();
  if (DATA_ID != "" && DATA_ID != null) {
    Swal.fire({
      html: "<h4>Cargando datos de orden</h4>",
      allowOutsideClick: false,
      onBeforeOpen: () => {
        Swal.showLoading();
      }
    });
    $.post(
      "../../modules/ordenes/consultar-orden.php",
      { TIPO_ORDEN:"COMPRA", FILTER: DATA_ID, ESTADO: "ALL" },
      function(data) {
        var data_json = JSON.parse(data);
        $('input[name="orden_nro"]').focus();
        $('input[name="orden_nro"]').val(data_json[0]["ORDNUMBER"]);
        $("#btn-delete-orden").attr("js-id", data_json[0]["IDORDEN"]);
        $('input[name="orden_id"]').val(data_json[0]["IDORDEN"]);
        $('select[name="orden_estado"]').val(data_json[0]["ORDESTADO"]);
        $('input[name="orden_tcventa"]').val(data_json[0]["EXCVENTA"]);
        $('input[name="orden_tccompra"]').val(data_json[0]["EXCCOMP"]);

        $('select[name="orden_proveedor"]').val(data_json[0]["PROVID"]);
        $('select[name="orden_proveedor"]').trigger("change");

        $('input[name="orden_provruc"]').val();

        $('select[name="orden_tipomoneda"]').val(data_json[0]["TIPOMON"]);

        $('input[name="orden_fecemision"]').val(data_json[0]["FECEMIS"]);
        $('input[name="orden_fecentrega"]').val(data_json[0]["FECDEL"]);
        $('input[name="orden_nrocuenta"]').val(data_json[0]["ACCNUM"]);

        $('select[name="orden_tipopagotext"]').val(data_json[0]["PAYDAYS"] );
        $('select[name="orden_tipopagotext"]').trigger("change");

        if ($('select[name="orden_tipopagotext"]').val() == null){
          $('select[name="orden_tipopagotext"]').val("Otro");
          $('select[name="orden_tipopagotext"]').trigger("change");
          $('#div_diaspago').show();
          $('input[name="orden_tipopago"]').prop("required",true);
          $('input[name="orden_tipopago"]').val(data_json[0]["PAYDAYS"] );
        }
        
        $('input[name="orden_cotizacion"]').val(data_json[0]["COTIZ"]);
        $('input[name="orden_observ"]').val(data_json[0]["OBSERV"]);
        $('input[name="orden_solicitante"]').val(data_json[0]["REQUES"]);
        $('input[name="orden_autorizador"]').val(data_json[0]["APROV"]);

        $('input[name="orden_igv"]').val((data_json[0]["TOTIGV"] * 1).toFixed(2));
        $('input[name="orden_totcompra"]').val((data_json[0]["TOTCOMP"] * 1).toFixed(2));
        $('input[name="orden_totneto"]').val((data_json[0]["TOTNET"] * 1).toFixed(2));

        total_temporal = parseFloat(data_json[0]["TOTCOMP"]);
        codigo_idorden = data_json[0]["IDORDEN"];
        
        $.post(
          "../../modules/ordenes/consultar-detalle-orden.php",
          { IDORDEN: codigo_idorden },
          function(data) {

            $('input[name="orden_codprod"]').val("");
            $('input[name="orden_valunit"]').val("");
            $('input[name="orden_descprod"]').val("");
            $('input[name="orden_glosa"]').val("");
            $('input[name="orden_porcdscto"]').val(0);
            $('input[name="orden_valordscto"]').val("");
            $('input[name="orden_precunit"]').val("");
            $('input[name="orden_cantidad"]').val(0);

            $("#btn-add-prodtporden").prop("disabled", true);
            $("#btn-save-orden").prop("disabled", false);

            tbl_prodordcompra.clear().draw();
            detaorden_json = JSON.parse(data);
            for (i = 0; i < detaorden_json.length; i++) {
              tbl_prodordcompra.rows
                .add([
                  {
                    0: detaorden_json[i]["ROW_ID"],
                    1: detaorden_json[i]["CODE"],
                    2: detaorden_json[i]["DESCRIPTION"],
                    3: detaorden_json[i]["GLOSS"],
                    4: detaorden_json[i]["UNIT_VALUE"],
                    5: (detaorden_json[i]["UNIT_PRICE"] * 1).toFixed(2),
                    6: detaorden_json[i]["QUANTITY"],
                    7: (detaorden_json[i]["DISCOUNT_RATE"] * 1).toFixed(2),
                    8: (detaorden_json[i]["DISCOUNTED_TOTAL"] * 1).toFixed(2)
                  }
                ])
                .draw();
            }
          }
        );

        $("#btn-save-orden font").html("Actualizar Orden de Compra");
        $("#col-btn-save-orden").attr("class", "col-md-6");
        $("#col-btn-delete-orden").show("fast");
      }
    ).then(function() {
      Swal.close();
    });
  }
});

$("#FRM_INSERT_DETA_ORDCOMPRA").submit(function (e) {
  e.preventDefault();

  var form = $(this);
  var idform = form.attr("id");
  var url = form.attr('action');
  var formElement = document.getElementById(idform);

  tbl_data = tbl_prodordcompra.rows().data().toArray();

  var formData_rec = new FormData(formElement);
  formData_rec.append("orden_tipo","COMPRA");
  formData_rec.append("orden_lstprods", JSON.stringify(tbl_data));
  var id_ordcompra = $('input[name="orden_id"]').val();

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
            $.Notification.notify("error", "bottom-right", "Error de guardado", "No se pudo guardar datos de orden de compra");
            Swal.close();
          } else if (data == "OK_INSERT") {
            $('input[name="orden_nro"]').focus();
            form.find("input, textarea, select").val("");

            $('select[name="orden_estado"]').val("Pendiente");
            $('select[name="orden_estado"]').trigger("change");

            $('select[name="orden_proveedor"]').trigger("change");

            $('select[name="orden_tipopagotext"]').trigger("change");
            $('select[name="orden_tipopagotext"]').prop("disabled",false);

            $('#div_diaspago').hide();
            $('input[name="orden_tipopago"]').prop("required",false);

            $.Notification.notify("success", "bottom-right", "Orden de Compra guardada", "Datos almacenados");
            tbl_prodordcompra.clear().draw();

            Swal.close();
            $("#btn-save-orden").prop("disabled", true);
            $("#btn-add-prodtporden").prop("disabled", true);
            $.post("../../modules/ordenes/listar-ordenes.php", {orden_tipo:"COMPRA"}, function(data) {
              $('select[name="orden_listado"]').empty();
              $('select[name="orden_listado"]').select2({
                data: JSON.parse(data)
              });
            });
            
          } else if (data == "OK_UPDATE") {
              if (id_ordcompra != "" && id_ordcompra != null) {
                $('input[name="orden_nro"]').focus();
                $('input[name="orden_id"]').val("");
                $("#btn-save-orden font").html("Guardar orden de compra");
                $("#btn-save-orden").prop("disabled", true);
                $("#btn-add-prodtporden").prop("disabled", true);
                $("#col-btn-save-orden").attr("class", "col-md-12");
                $("#col-btn-delete-orden").hide();
                form.find("input, textarea, select").val("");

                $('select[name="orden_estado"]').val("Pendiente");
                $('select[name="orden_estado"]').trigger("change");

                $('select[name="orden_proveedor"]').trigger("change");

                $('select[name="orden_tipopagotext"]').trigger("change");
                $('select[name="orden_tipopagotext"]').prop("disabled",false);

                $('#div_diaspago').hide();
                $('input[name="orden_tipopago"]').prop("required",false);
                tbl_prodordcompra.clear().draw();
              }
              $.Notification.notify("success", "bottom-right", "Orden de compra actualizada", "Datos actualizados");
              Swal.close();
          }
      }
  });
});

$("#btn-delete-orden").click(function() {
  element = $(this);
  id_val = element.attr("js-id");
  if (id_val != "" && id_val != null) {
    Swal.fire({
      title: "Se eliminará esta Orden de Compra",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Borrar",
      cancelButtonText: "Cancelar"
    }).then(result => {
      if (result.value) {
        $.post(
          "../../modules/ordenes/eliminar-orden.php",
          { ID_ORDER: id_val },
          function(data) {
            if (data == true) {
              $('input[name="orden_nro"]').focus();
              tbl_prodordcompra.clear().draw();
              $("#FRM_INSERT_DETA_ORDCOMPRA")
                .find("input, textarea, select")
                .val("");

              $('select[name="orden_proveedor"]').trigger("change");     
              
              $.post("../../modules/ordenes/listar-ordenes.php", {orden_tipo:"COMPRA"}, function(data) {
                $('select[name="orden_listado"]').empty();
                $('select[name="orden_listado"]').select2({
                  data: JSON.parse(data)
                });
              });

              $('input[name="orden_id"]').val("");
              $("#btn-add-prodtporden").prop("disabled", false);
              $("#btn-save-orden").prop("disabled", true);
              $("#btn-save-orden font").html("Guardar Orden de Compra");
              $("#col-btn-save-orden").attr("class", "col-md-12");
              $("#col-btn-delete-orden").hide();

              $('select[name="orden_tipopagotext"]').prop("disabled",false);
              $('#div_diaspago').hide();
              $('input[name="orden_tipopago"]').prop("required",false);

              $.Notification.notify(
                "success",
                "bottom-right",
                "Orden de Compra Eliminada",
                "Información eliminada correctamente."
              );
            }
          }
        );
      }
    });
  }
});

$(document).ready(function() {
  var cookie_idorden = leer_cookie('COOKIE_ID_ORDEN');
  if (cookie_idorden != "") {
    setTimeout(function(){
      $('select[name="orden_listado"]').val(cookie_idorden);
      $('select[name="orden_listado"]').trigger("change");
      $('#btn-select-orden').trigger("click");
      eliminar_cookie("COOKIE_ID_ORDEN");
    },500);
  }
});