<?php
// Start a session to manage user login state
session_start();

// Check if the user is already logged in and redirect to home if so
// This prevents logged-in users from accessing the login page again
if (isset($_SESSION['loggedInUser'])) {
  header('Location: views/home');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DuoLab</title>
  <meta name="description" content="Empresa peruana dedicada a la IMPORTACIÓN, COMERCIALIZACIÓN Y DISTRIBUCIÓN de productos del rubro cosmético y farmacéutico.">
  <meta property="og:type" content="website">
  <meta property="og:title" content="DuoLab">
  <meta property="og:site" content="DuoLab">
  <meta property="og:url" content="http://localhost/duolab">
  <meta property="og:description" content="Bienvenido a DuoLab. Inicie sesión para continuar.">
  <meta property="og:image" content="../img/duolabgroup_logo.png">

  <meta property="twitter:title" content="DuoLab">
  <meta property="twitter:description" content="Bienvenido a DuoLab. Inicie sesión para continuar.">
  <meta name="twitter:image" content="../img/duolabgroup_logo.png">
  <meta name="twitter:card" content="summary_large_image">
  <!--<meta name="twitter:site" content="@duolab">-->
  
  <meta name="theme-color" content="#e9ecef">
  <meta name="author" content="Christian Cano">
  
  <link rel="icon" href="./img/favicons/chemistry-32x32.png" sizes="32x32" type="image/png">
  <link rel="icon" href="./img/favicons/chemistry-16x16.png" sizes="16x16" type="image/png">
  
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
  <!-- AdminLTE Template Style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/4.0.0-rc3/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <!-- <a href="#" class="h1"><b>DuoLab </b>Group</a> -->
      <img class="mb-0" src="./img/duolabgroup_logo_alt.png" width="225" height="225">
    </div>
    <div class="card-body">
      <p class="login-box-msg">Ingrese sus credenciales para acceder</p>

      <form id="login-form">
        <div class="input-group mb-3">
          <input type="text" name="txtUsername" pattern="[A-Za-z0-9_-]{1,50}" maxlength="50" class="form-control" placeholder="Usuario" required="" autofocus="" autocomplete="username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="txtPassword" pattern="[A-Za-z0-9_-]{1,72}" maxlength="72" class="form-control" placeholder="Contraseña" required="" autocomplete="current-password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div> -->
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" id="btnLogin" class="btn btn-primary btn-block">Ingresar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!--
      <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      -->
      <p class="mt-5 mb-3 text-muted text-center">© 2025 DuoLab</p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<!-- Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
<!-- AdminLTE -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/4.0.0-rc3/js/adminlte.min.js"></script>

<script type="text/javascript">
  toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-center",
    "preventDuplicates": true,
    "onclick": null,
    "showDuration": "500",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
    }
</script>
<script src="./ajax/login.js"></script>

</body>
</html>
