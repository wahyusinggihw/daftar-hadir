<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard <?php isset($title) ? print('- ' . $title) : '' ?></title>
  <link rel="shortcut icon" href="<?= base_url('assets/img/icon.png') ?>" type="image/x-icon">
  <link rel="stylesheet" href="<?= base_url('assets/back_end/style_admin.css') ?>">
  <!-- <link rel="stylesheet" href="<?= base_url('assets/css/agendarapat.css') ?>"> -->
  <!-- <link rel="stylesheet" href="<?= base_url('assets/css/daftarpeserta.css') ?>"> -->
  <!-- <link rel="stylesheet" href="<?= base_url('assets/css/agendakosong.css') ?>"> -->
  <!-- <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>"> -->

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css') ?>">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/jqvmap/jqvmap.min.css') ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css') ?>">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') ?>">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/daterangepicker/daterangepicker.css') ?>">
  <!-- summernote -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/summernote/summernote-bs4.min.css') ?>">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/timepicker@1.14.1/jquery.timepicker.min.css"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <!-- <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script> -->
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> -->
  <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css"> -->
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

  <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>


  <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css"> -->
  <style>
    table.dataTable>tbody>tr.child ul.dtr-details {
      display: block;
    }
  </style>
</head>


<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <!-- <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="<?= base_url('assets/img/logo.png') ?>" alt="DaftarHadir" width="100">
    </div> -->

    <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: #007bff;">

      <ul class="navbar-nav" style="padding-left: 10px;">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars" style="color:white"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a class="nav-link" href="<?= base_url('/') ?>" target="_blank" role="button"><i class="fas fa-link" style="color:white"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a class="nav-link" href="#" onclick="return false;" style="cursor: default; color:white" role="button">
            <?php
            if (session()->get('role') == 'superadmin') {
              echo 'Super Admin';
            } else if (session()->get('role') == 'admin') {
              echo 'Admin ' . session()->get('nama');
            } else if (session()->get('role') == 'operator') {
              echo 'Operator ' . session()->get('nama');
            }

            ?></a>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto" style="padding-right: 10px;">
        <!-- <li class="nav-item">
             <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
                 <i class="fas fa-th-large"></i>
             </a>
         </li> -->
        <!-- fas list -->
        <li class="nav-item dropdown">
          <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link" style="color:white;"><i class="fas fa-th-large"></i> </a>
          <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="left: 0px; right: inherit;">
            <li><a href="<?= base_url('admin/profile') ?>" class="dropdown-item"><i class="fas fa-user"></i> Profile</a></li>
            <li><a href="<?= base_url('admin/profile/edit-profilepassword/' . session()->get('slug')) ?>" class="dropdown-item"><i class="fas fa-lock"></i> Edit Password</a></li>
          </ul>
        </li>
      </ul>
    </nav>

    <!-- Main Sidebar Container -->
    <?= $this->include('admin/templates/sidebar'); ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0"><?php isset($title) ? print($title) : '' ?></h1>
              <!-- <span class="m-0"><?php isset($subtitle) ? print($subtitle) : '' ?></span> -->
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a style="text-decoration: none;" href="<?= base_url('admin') ?>">Home</a></li>
                <li class="breadcrumb-item <?php echo isset($subtitle) ? '' : 'active' ?>"><?php isset($title) ? print($title) : '' ?></li>
                <?php if (isset($title1)) :  ?>
                  <li class="breadcrumb-item <?php echo isset($title1) ? '' : 'active' ?>"><?php isset($title1) ? print($title1) : '' ?></li>
                <?php endif; ?>
                <?php if (isset($subtitle)) :  ?>
                  <li class="breadcrumb-item active"><?php isset($subtitle) ? print(elipsis($subtitle, 30)) : '' ?></li>
                <?php endif; ?>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Tempat konten -->