<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<script>
    var base_url = "<?= base_url() ?>";
</script>
  <header class="main-header">

    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>FRAS</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Frasindo</b>SHOP</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li>
            <a target="_blank" href="https://www.frasindo.com"><i class="fa fa-home"></i> Home</a>
          </li>
          <li>
            <a target="_blank" href="https://www.frasindo.com/media/wp-admin/?autologin_code=<?= $this->session->linkLogin ?>" ><i class="fa fa-newspaper-o"></i> Media</a>
          </li>
          <li>
            <a target="_blank" href="<?= base_url("testify") ?>"><i class="fa fa-star"></i> Testify For Us</a>
          </li>
          <li>
            <a href="<?= base_url("logout") ?>" ><i class="fa fa-sign-out"></i> Logout</a>
          </li>
        </ul>
      </div>

    </nav>
  </header>
  <!-- Menu -->
  <?php $this->load->view("adminLTE/_nav"); ?>
  <?php $this->load->view($page,$data_page); ?>



  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong><a href="https://mystellar.org/">PT.Frasindo Lima Mandiri</a></strong> © 2013-Today
  </footer>

</div>
</body>
