$(document).ready(function() {
    $(".select2").select2();
    $("#table-clientes").DataTable();
    $("#table-proveedores").DataTable();
    $("#table-productos").DataTable();
    $("#table-empleados").DataTable();
    $("#table-usuarios").DataTable();
    $("#table-ordenes").DataTable();
    $("#table-cotizaciones").DataTable();
    $("#table-facturas").DataTable();
});

function crear_cookie(name, value, days2expire, path) {
    var date = new Date();
    date.setTime(date.getTime() + (days2expire * 24 * 60 * 60 * 1000));
    var expires = date.toUTCString();
    document.cookie = name + '=' + value + ';' +
      'expires=' + expires + ';' +
      'path=' + path + ';';
  }
  
  function leer_cookie(name) {
    var cookie_value = "",
      current_cookie = "",
      name_expr = name + "=",
      all_cookies = document.cookie.split(';'),
      n = all_cookies.length;
  
    for (var i = 0; i < n; i++) {
      current_cookie = all_cookies[i].trim();
      if (current_cookie.indexOf(name_expr) == 0) {
        cookie_value = current_cookie.substring(name_expr.length, current_cookie.length);
        break;
      }
    }
    return cookie_value;
  }
  
  function eliminar_cookie(name) {
    document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
  }