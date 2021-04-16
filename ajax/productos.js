$(document).ready(function(){
//  $("#m_almacen").attr("class","nav-link active");
//  $("#m_almacen").parent().attr("class","nav-item has-treeview menu-open");
  $("#m_rpt_productos").attr("class","nav-link active");
  $(document).prop('title', 'Reporte de Productos - DuoLab Group');
});

$("#btn-product-list").click(function (e) {
    e.preventDefault();
    window.location.assign("../../views/productos/listado-producto");
});

$("#btn-rpt-top-mas-vendido").click(function (e) {
    e.preventDefault();
    var url="../../modules/reportes/top-productos.php?mode=1";
    window.open(url,"Top 10 Productos Más Vendidos","");
});

$("#btn-rpt-top-menos-vendido").click(function (e) {
    e.preventDefault();
    var url="../../modules/reportes/top-productos.php?mode=2";
    window.open(url,"Top 10 Productos Más Vendidos","");
});