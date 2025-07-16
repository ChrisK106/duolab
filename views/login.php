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
<html lang="es" data-bs-theme="auto">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Empresa peruana dedicada a la IMPORTACIÓN, COMERCIALIZACIÓN Y DISTRIBUCIÓN de productos del rubro cosmético y farmacéutico.">
  <meta name="author" content="Christian Cano">
  <title>DuoLab</title>
  
  <meta property="og:type" content="website">
  <meta property="og:title" content="DuoLab">
  <meta property="og:site" content="DuoLab">
  <meta property="og:url" content="http://localhost/duolab">
  <meta property="og:description" content="Bienvenido a DuoLab. Inicie sesión para continuar.">
  <meta property="og:image" content="../img/duolabgroup_logo.png">

  <meta property="twitter:title" content="DuoLab">
  <meta property="twitter:description" content="Bienvenido a DuoLab. Inicie sesión para continuar.">
  <meta name="twitter:image" content="./img/duolabgroup_logo.png">
  <meta name="twitter:card" content="summary_large_image">
  <!--<meta name="twitter:site" content="@duolab">-->

  <link rel="icon" href="./img/favicons/chemistry-32x32.png" sizes="32x32" type="image/png">
  <link rel="icon" href="./img/favicons/chemistry-16x16.png" sizes="16x16" type="image/png">
  
  <script src="./js/color-modes.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
  <meta name="theme-color" content="#712cf9">
  <link href="./css/login.css" rel="stylesheet">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
  <!-- AdminLTE Template Style 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/4.0.0-rc3/css/adminlte.min.css">
  -->
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary">
  <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
    <symbol id="check2" viewBox="0 0 16 16">
        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"></path>
    </symbol>
    <symbol id="circle-half" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"></path>
    </symbol>
    <symbol id="moon-stars-fill" viewBox="0 0 16 16">
        <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"></path>
        <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"></path>
    </symbol>
    <symbol id="sun-fill" viewBox="0 0 16 16">
        <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"></path>
    </symbol>
  </svg>

  <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
    <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
      <svg class="bi my-1 theme-icon-active" aria-hidden="true">
        <use href="#circle-half"></use>
      </svg>
      <span class="visually-hidden" id="bd-theme-text">Cambiar tema</span>
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
      <li>
          <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
              <svg class="bi me-2 opacity-50" aria-hidden="true">
                  <use href="#sun-fill"></use>
              </svg>
              Claro
              <svg class="bi ms-auto d-none" aria-hidden="true">
                  <use href="#check2"></use>
              </svg>
          </button>
      </li>
      <li>
          <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
              <svg class="bi me-2 opacity-50" aria-hidden="true">
                  <use href="#moon-stars-fill"></use>
              </svg>
              Oscuro
              <svg class="bi ms-auto d-none" aria-hidden="true">
                  <use href="#check2"></use>
              </svg>
          </button>
      </li>
      <li>
          <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
              <svg class="bi me-2 opacity-50" aria-hidden="true">
                  <use href="#circle-half"></use>
              </svg>
              Auto
              <svg class="bi ms-auto d-none" aria-hidden="true">
                  <use href="#check2"></use>
              </svg>
          </button>
      </li>
    </ul>
  </div>
  <main class="form-signin w-100 m-auto">
    <form id="login-form">
      <div class="text-center">
        <img class="mb-4" src="./img/duolabgroup_logo_alt.png" width="225" height="225">
      </div>
      <h1 class="h3 mb-3 fw-normal">Ingrese sus credenciales</h1>
      
      <div class="form-floating">
        <input type="text" name="txtUsername" pattern="[A-Za-z0-9_-]{1,50}" maxlength="50" class="form-control" id="floatingInput" placeholder="Usuario" required="" autofocus="" autocomplete="username">
        <label for="floatingInput">Usuario</label>
      </div>
      
      <div class="form-floating">
        <input type="password" name="txtPassword" pattern="[A-Za-z0-9_-]{1,72}" maxlength="72" class="form-control" id="floatingPassword" placeholder="Contraseña" required="" autocomplete="current-password">
        <label for="floatingPassword">Contraseña</label>
      </div>
      <!-- 
      <div class="form-check text-start my-3">
          <input class="form-check-input" type="checkbox" value="remember-me" id="checkDefault">
          <label class="form-check-label" for="checkDefault">
              Remember me
          </label>
      </div>
      -->
      <button class="btn btn-primary w-100 py-2" type="submit" id="btnLogin">Ingresar</button>
      <p class="mt-5 mb-3 text-body-secondary text-center">&copy; 2025 DuoLab</p>
    </form>
  </main>

  <!-- jQuery -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Toastr -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
  <!-- AdminLTE 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/4.0.0-rc3/js/adminlte.min.js"></script>
  -->

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
