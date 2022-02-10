<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Inicio</h1>
        </div>
        <div class="col-sm-6">
          <!--
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
            <li class="breadcrumb-item active">Starter Page</li>
          </ol>
          -->
        </div> 
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">

        <div class="col-md-12">

          <div class="card card-primary card-outline">
            <div class="card-header">
              <h5 class="m-1"><i class="far fa-hand-spock"></i> ¡Bienvenido(a)! <strong><?php echo $_SESSION['loggedInUser']['EMPLOYEE_NAME']; ?></strong></h5>
            </div>
            <div class="card-body">
              <div class="text-center">
                <img class="m-2" src="<?php echo $functions->direct_sistema(); ?>/img/duolabgroup_logo.png" alt="" width="225" height="225">
                <!--<span class="brand-text font-weight-dark text-cyan text-xl"><strong>DUOLAB</strong> GROUP</span>-->
              </div>
            </div>

          </div>

        </div>
        <!-- /.col-md-6 -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->