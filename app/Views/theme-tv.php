<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mahindra</title>
  <link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.jpg'); ?>" type="image/x-icon">

  <!-- Google Font: Source Sans Pro -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> -->
  <!-- JQUERY UI  -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.css'); ?> ">

   <!-- FONT AWSOME -->
   <link rel="stylesheet" href="<?php echo base_url('assets/plugins/fontawesome-free/css/all.min.css'); ?> ">

  <link rel="stylesheet" href="<?php echo base_url('assets/css/daterangepicker.css'); ?> ">

  <!-- Toastr style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/toastr/toastr.min.css'); ?> ">

  <!-- Select2 style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/select2/css/select2.min.css'); ?>">

  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>">
  

  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/dist_list/css/adminlte.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/slimselect.min.css'); ?>">
  <!-- Application style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/application.css'); ?>">
  <script>
    var base_url = '<?php echo base_url(); ?>';
  </script>
</head>
<body class="hold-transition dark-mode no-sidebar layout-fixed layout-navbar-fixed layout-footer">
<div class="wrapper">
  <?= $this->include('pre-loader'); ?>
  <?= $this->include('nav-header-tv'); ?>
  <?php //$this->include('left-sidebar'); ?>
  <?= $this->renderSection('content'); ?>
  <?= $this->include('nav-footer'); ?>
</div>
<!-- jQuery -->
<script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>

<!-- jQuery UI-->
<script src="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
<!-- Moment -->
<script src="<?php echo base_url('assets/js/moment.min.js'); ?>"></script>
<!-- Datetime picker -->
<script src="<?php echo base_url('assets/js/daterangepicker.min.js'); ?>"></script>

<!-- Bootstrap 4 -->
<script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/dist_list/js/adminlte.min.js'); ?>"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js'); ?>"></script>
<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="<?php echo base_url('assets/plugins/jquery-mousewheel/jquery.mousewheel.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/raphael/raphael.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/jquery-mapael/jquery.mapael.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/jquery-mapael/maps/usa_states.min.js'); ?>"></script>
<!-- ChartJS -->
<script src="<?php echo base_url('assets/plugins/chart.js/Chart.min.js'); ?>"></script>

<script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js'); ?>"></script>

<!-- Toastr -->
<script src="<?php echo base_url('assets/plugins/toastr/toastr.min.js'); ?>"></script>

<!-- Select2 -->
<script src="<?php echo base_url('assets/plugins/select2/js/select2.min.js'); ?>"></script>

<!-- Jquery validations -->
<script src="<?php echo base_url('assets/plugins/jquery-validation/jquery.validate.min.js'); ?>"></script>

<!-- Application Javascript File -->
<script  src="<?php echo base_url('assets/js/file_upload.js'); ?>"></script>
<script  src="<?php echo base_url('assets/js/slimselect.min.js'); ?>"></script>

<script type="module" src="<?php echo base_url('assets/js/application.js'); ?>"></script>
</body>
</html>
