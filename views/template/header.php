<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>DuoLab Group</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  
  <!-- Select2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
  
  <!-- Datatables -->
  <link rel="stylesheet" href="<?php echo $functions->direct_sistema(); ?>/plugins/datatables-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="<?php echo $functions->direct_sistema(); ?>/plugins/datatables/buttons.dataTables.min.css">
  <link rel="stylesheet" href="<?php echo $functions->direct_sistema(); ?>/plugins/datatables/buttons.bootstrap4.min.css">
 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.css"> 
  <link rel="stylesheet" href="<?php echo $functions->direct_sistema(); ?>/plugins/notifyjs/dist/notify.css" />
  <link rel="stylesheet" href="<?php echo $functions->direct_sistema(); ?>/css/style-duolab.css" />

  <!-- jQuery UI -->
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <!-- Context Menu -->
  <link rel="stylesheet" href="<?php echo $functions->direct_sistema(); ?>/plugins/context-menu/jquery.contextMenu.css" />

  <!-- AdminLTE Template Style -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  <!-- Favicons -->
  <link rel="icon" href="<?php echo $functions->direct_sistema(); ?>/img/favicons/chemistry-32x32.png" sizes="32x32" type="image/png">
  <link rel="icon" href="<?php echo $functions->direct_sistema(); ?>/img/favicons/chemistry-16x16.png" sizes="16x16" type="image/png">

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    
    <!-- Left navbar links -->
    <ul class="navbar-nav">

      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>

      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo $functions->direct_paginas()."home" ?>" class="nav-link">Inicio</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo $functions->direct_paginas()."clientes/registro-cliente" ?>" class="nav-link">Clientes</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo $functions->direct_paginas()."productos/listado-producto" ?>" class="nav-link">Listado de Productos</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo $functions->direct_paginas()."facturacion/registro-factura" ?>" class="nav-link">Factura</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo $functions->direct_paginas()."facturacion/registro-boleta" ?>" class="nav-link">Boleta</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo $functions->direct_paginas()."facturacion/registro-nota-credito" ?>" class="nav-link">Nota de Crédito</a>
      </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <!-- Dropdown User Menu -->
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
          <?php
            $user_avatar_url = $functions->direct_sistema() . "/img/avatars/" . $_SESSION['loggedInUser']['PHOTO_URL'];
          ?>
          <img src="<?php echo $user_avatar_url; ?>" class="user-image img-circle elevation-2 bg-default" alt="User Image">
          <span class="d-none d-md-inline"><?php echo $_SESSION['loggedInUser']['EMPLOYEE_NAME']; ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <!-- User image -->
          <li class="user-header" style="background-color: #f8f9fa;">
            <img src="<?php echo $user_avatar_url; ?>" class="img-circle elevation-2" alt="User Image">
            <p>
              <?php
                $user_name_string = $_SESSION['loggedInUser']['EMPLOYEE_NAME'];
                echo $user_name_string;
              ?>
              <small>@<?php echo ($_SESSION['loggedInUser']['USERNAME']); ?></small>
              <small><?php echo strtoupper($_SESSION['loggedInUser']['JOB']); ?></small>
            </p>
          </li>
          <!-- Menu Body
          <li class="user-body">
            <div class="row">
              <div class="col-4 text-center">
                <a href="#">Followers</a>
              </div>
              <div class="col-4 text-center">
                <a href="#">Sales</a>
              </div>
              <div class="col-4 text-center">
                <a href="#">Friends</a>
              </div>
            </div>
          </li>
          -->
          <!-- Menu Footer -->
          <li class="user-footer">
            <!-- <a href="#" class="btn btn-primary "><i class="fas fa-id-badge"></i> Perfil</a> -->
            <a href="<?php echo $functions->direct_sistema(); ?>/modules/end_session.php" class="btn btn-danger btn-block float-right"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
          </li>
        </ul>
      </li>
      
    </ul>
  </nav>
  <!-- /.navbar -->
