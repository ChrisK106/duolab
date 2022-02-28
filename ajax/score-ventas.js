$('select[name="reporte_periodo_month"]').prop("disabled",true);
$('select[name="reporte_periodo_year"]').prop("disabled",true);
$("#div-filtro-periodo").hide();

$(document).ready(function(){
  $("#m_reportes").attr("class","nav-link active");
  $("#m_reportes").parent().attr("class","nav-item has-treeview menu-open");
  $("#m_score_ventas").attr("class","nav-link active");
  $(document).prop('title', 'Score de Ventas - DuoLab Group');
});

var year_actual = parseInt(moment().format('YYYY'));
var meses = [
  "",
  "Enero",
  "Febrero",
  "Marzo",
  "Abril",
  "Mayo",
  "Junio",
  "Julio",
  "Agosto",
  "Septiembre",
  "Octubre",
  "Noviembre",
  "Diciembre"
];

function llenar_meses() {
  var options = [];
  for (i = 0; i < meses.length; i++) {
    codigo = i==0?"":i;
    nombre_mes = meses[i]==""?"Seleccione un mes":meses[i];
    options.push({ id: codigo, text: nombre_mes });
  }
  $('select[name="reporte_periodo_month"]').empty();
  $('select[name="reporte_periodo_month"]').select2({
    data: options
  });
}

function llenar_years(){
  var options = [];  
  var date_past = moment().subtract(5, 'years').calendar();
  var year_past = parseInt(moment(date_past).format('YYYY'));
  options.push({ id: "", text: "Seleccione un año" });
  for (i = 0; i < 10; i++) {
    next_year = year_past + i;
    options.push({ id: next_year, text: next_year });
  }

  $('select[name="reporte_periodo_year"]').empty();
  $('select[name="reporte_periodo_year"]').select2({
    data: options
  });
  $('select[name="reporte_periodo_year"]').val(year_actual);
  $('select[name="reporte_periodo_year"]').trigger("change");
}

$(document).ready(function() {

    llenar_meses();
    llenar_years();

    var nom_vend = "";
    var period_val = "";
    var period_mes = "";
    var period_year = "";

    $("#btn-filtrar-reporte").click(function(){

        val_nomvend = $('input[name="reporte_vendedor"]').val();
        val_periodo = $('select[name="reporte_periodo"]').val();
        val_mes = $('select[name="reporte_periodo_month"]').val();
        val_year = $('select[name="reporte_periodo_year"]').val();

        if(val_nomvend != "" || (val_periodo == "MONTH" && val_mes != "" && val_year != "" ) || (val_periodo == "YEAR" && val_year != "" ) ) {
            Swal.fire({
                html: "<h4>Filtrando reporte</h4>",
                allowOutsideClick: false,
                onBeforeOpen: () => {
                  Swal.showLoading();
                }
            });
            nom_vend = $('input[name="reporte_vendedor"]').val();
            period_val = $('select[name="reporte_periodo"]').val();
            period_mes = $('select[name="reporte_periodo_month"]').val();
            period_year = $('select[name="reporte_periodo_year"]').val();
            get_data_report(nom_vend,period_val,period_mes,period_year);
            setTimeout(function(){
                Swal.close();
            },500);
        }
    });

    $("#btn-reiniciar").click(function(){
        Swal.fire({
            html: "<h4>Reiniciando reporte</h4>",
            allowOutsideClick: false,
            onBeforeOpen: () => {
              Swal.showLoading();
            }
        });
        $("#div-filtro-periodo").hide("fast");
        $('input[name="reporte_vendedor"]').focus();
        $('input[name="reporte_vendedor"]').val("");
        $('select[name="reporte_periodo"]').val("");
        $('select[name="reporte_periodo_month"]').val("");
        $('select[name="reporte_periodo_month"]').trigger("change");
        $('select[name="reporte_periodo_year"]').val(year_actual);
        $('select[name="reporte_periodo_year"]').trigger("change");
        nom_vend = "";
        period_val = "";
        period_mes = "";
        period_year = "";        
        get_data_report(nom_vend,period_val,period_mes,period_year);
        setTimeout(function(){
            Swal.close();
        },500);
    });

    $('select[name="reporte_periodo"]').on("change",function(){
        periodo = $(this).val();
        $('select[name="reporte_periodo_month"]').val("");
        $('select[name="reporte_periodo_month"]').trigger("change");
        $('select[name="reporte_periodo_year"]').val(year_actual);
        $('select[name="reporte_periodo_year"]').trigger("change");
        if(periodo != ""){
            $("#div-filtro-periodo").show("fast");
            switch (periodo) {
                case "MONTH":
                    $('select[name="reporte_periodo_month"]').prop("disabled",false);
                    $('select[name="reporte_periodo_year"]').prop("disabled",false);
                break;
                case "YEAR":
                    $('select[name="reporte_periodo_month"]').prop("disabled",true);
                    $('select[name="reporte_periodo_year"]').prop("disabled",false);
                break;
            }
        } else {
            $('select[name="reporte_periodo_month"]').prop("disabled",true);
            $('select[name="reporte_periodo_year"]').prop("disabled",true);
            $("#div-filtro-periodo").hide("fast");
        }
    });

    $('input[name="reporte_vendedor"]').autocomplete({
        source: function(request, response) {
          $.getJSON("../../modules/usuarios/obtener-usuarios.php", { NOM_VEND: $('input[name="reporte_vendedor"]').val() }, response);
        },
        select: function (event, ui) {
          $(this).val(ui.item.label);
        }
    });
    
    function get_data_report(nom_vend,period_val,period_mes,period_year) {
    $.post(
      "../../modules/reportes/cargar-reporte-ventas-x-vendedor.php", { VENDEDOR:nom_vend, PERIODO:period_val, MONTH:period_mes, YEAR:period_year }, 
      function(data) {
        var data_report = JSON.parse(data);

        var only_data = data_report[0];
        var only_labels = data_report[1];

        var options = {
          series: {
            bars: {
              show: true,
              barWidth: 0.2,
              align: "center"
            }
          },
          colors: ["#3c8dbc"],
          xaxis: {
            axisLabel: "Vendedores",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: "Verdana, Arial",
            axisLabelPadding: 30,
            ticks: only_labels
          },
          yaxis: {
            axisLabel: "Total ventas",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: "Verdana, Arial",
            axisLabelPadding: 3
          },
          legend: {
            noColumns: 0,
            labelBoxBorderColor: "#000000",
            position: "nw"
          },
          grid: {
            hoverable: true,
            borderWidth: 2,
            backgroundColor: { colors: ["#ffffff", "#EDF5FF"] }
          }
        };

        var dataset = [
          { label: "Score de ventas", data: only_data, color: "#5482FF" }
        ];

        $.plot("#bar-chart", dataset, options);
        $("#bar-chart").UseTooltip();
      }
    );
  }

  var updateInterval = 5000;
  $("#updateInterval")
    .val(updateInterval)
    .change(function() {
      var v = $(this).val();
      if (v && !isNaN(+v)) {
        updateInterval = +v;
        if (updateInterval < 1) {
          updateInterval = 1;
        }
        $(this).val("" + updateInterval);
      }
    });

  function update() {
    get_data_report(nom_vend,period_val,period_mes,period_year);
    setTimeout(update, updateInterval);
  }

  update();

  var previousPoint = null,
    previousLabel = null;

  $.fn.UseTooltip = function() {
    $(this).bind("plothover", function(event, pos, item) {
      if (item) {
        if (
          previousLabel != item.series.label ||
          previousPoint != item.dataIndex
        ) {
          previousPoint = item.dataIndex;
          previousLabel = item.series.label;
          $("#tooltip").remove();

          var x = item.datapoint[0];
          var y = item.datapoint[1];

          var color = item.series.color;

          showTooltip(
            item.pageX,
            item.pageY,
            color,
            "<strong>" +
              item.series.label +
              "</strong><br>" +
              item.series.xaxis.ticks[x].label +
              " : <strong>" +
              y +
              "</strong>"
          );
        }
      } else {
        $("#tooltip").remove();
        previousPoint = null;
      }
    });
  };

  function showTooltip(x, y, color, contents) {
    $('<div id="tooltip">' + contents + "</div>")
      .css({
        position: "absolute",
        display: "none",
        top: y - 40,
        left: x - 120,
        border: "2px solid " + color,
        padding: "3px",
        "font-size": "9px",
        "border-radius": "5px",
        "background-color": "#fff",
        "font-family": "Verdana, Arial, Helvetica, Tahoma, sans-serif",
        opacity: 0.9
      })
      .appendTo("body")
      .fadeIn(200);
  }
});