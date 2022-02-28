$(document).ready(function(){
  $("#m_reportes").attr("class","nav-link active");
  $("#m_reportes").parent().attr("class","nav-item has-treeview menu-open");
  $("#m_rpt_productos").attr("class","nav-link active");
  $(document).prop('title', 'Reportes de Productos - DuoLab Group');
});

$.post(
  "../../modules/productos/listar-productos-xprov.php",
  { ESTADO: "ALL", REPORT : 1 },
  function(data) {
    $('select[name="product_list"]').empty();
    $('select[name="product_list"]').select2({
      data: JSON.parse(data)
    });
  }
);

$("#btn-rpt-unidades-vendidas-cliente").click(function (e) {
    e.preventDefault();
    var productId=$('select[name="product_list"]').val();
    var dateFrom = $('input[name="date_from"]').val();
    var dateTo = $('input[name="date_to"]').val();
    var url="../../modules/reportes/unidades-vendidas-por-cliente.php?productid=" + productId 
    + "&datefrom=" + dateFrom + "&dateto=" + dateTo;
    window.open(url);
});

$("#btn-rpt-top-mas-vendido").click(function (e) {
    e.preventDefault();
    var url="../../modules/reportes/top-productos.php?mode=1";
    window.open(url,"Top 20 Productos Más Vendidos","");
});

$("#btn-rpt-top-menos-vendido").click(function (e) {
    e.preventDefault();
    var url="../../modules/reportes/top-productos.php?mode=2";
    window.open(url,"Top 20 Productos Menos Vendidos","");
});

$("#btn-product-list").click(function (e) {
    e.preventDefault();
    window.location.assign("../../views/productos/listado-producto");
});