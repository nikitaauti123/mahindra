<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sign In | Mahindra</title>
  <link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.jpg'); ?>" type="image/x-icon">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/fontawesome-free/css/all.min.css'); ?> ">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css'); ?>">
  <!-- Toastr style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/toastr/toastr.min.css'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/dist_list/css/adminlte.min.css'); ?>">

  <!-- Application style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/application.css'); ?>">
  <script>
    var base_url = '<?php echo base_url(); ?>';
  </script>
</head>
<body class="hold-transition login-page">
<?= $this->renderSection('content') ?>
<!-- jQuery -->
<script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<!-- Toastr -->
<script src="<?php echo base_url('assets/plugins/toastr/toastr.min.js'); ?>"></script>

<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/dist_list/js/adminlte.min.js'); ?>"></script>
<!-- Jquery validations -->
<script src="<?php echo base_url('assets/plugins/jquery-validation/jquery.validate.min.js'); ?>"></script>
<!-- Application Javascript File -->
<script type="module" src="<?php echo base_url('assets/js/application.js'); ?>"></script>
</body>
</html>
