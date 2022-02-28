$(document).ready(function(){
  $("#m_reportes").attr("class","nav-link active");
  $("#m_reportes").parent().attr("class","nav-item has-treeview menu-open");
  $("#m_ventas_periodo").attr("class","nav-link active");
  $(document).prop('title', 'Ventas por Periodo - DuoLab Group');
});

var current_year = new Date().getFullYear();

function llenar_years(){
  var options = [];  
  var year_past = 2019;
  var year_range = current_year - year_past;
  
  for (i = 0; i <= year_range; i++) {
    next_year = year_past + i;
    options.push({ id: next_year, text: next_year });
  }

  $('select[name="reporte_periodo_year"]').empty();
  $('select[name="reporte_periodo_year"]').select2({
    data: options
  });
  $('select[name="reporte_periodo_year"]').val(current_year);
  $('select[name="reporte_periodo_year"]').trigger("change");
}

$(document).ready(function() {
  llenar_years();
  var period_year = "";

  $('select[name="reporte_periodo_year"]').change(function(){
    val_year = $('select[name="reporte_periodo_year"]').val();
    Swal.fire({
            html: "<h4>Filtrando reporte</h4>",
            allowOutsideClick: false,
            onBeforeOpen: () => {
              Swal.showLoading();
            }
        });
        period_year = $('select[name="reporte_periodo_year"]').val();
        get_data_report(period_year);
        setTimeout(function(){
            Swal.close();
        },500);
      });

  function get_data_report(period_year) {
    $.post(
      "../../modules/reportes/cargar-reporte-ventas-x-periodo.php", { YEAR:period_year }, 
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
            axisLabel: "Meses",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: "Verdana, Arial",
            axisLabelPadding: 30,
            ticks: only_labels
          },
          yaxis: {
            axisLabel: "Total Ventas",
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
          { label: "Ventas del mes", data: only_data, color: "#5482FF" }
        ];

        $.plot("#bar-chart", dataset, options);
        $("#bar-chart").UseTooltip();
      }
    );
  }

  var updateInterval = 10000;
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
    get_data_report(period_year);
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