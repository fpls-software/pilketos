<body class="hold-transition sidebar-mini">
<?php if (!isset($no_visible_elements) || !$no_visible_elements) { ?>
    <div class="wrapper">

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="index3.html" class="nav-link">Visit Site</a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-user"></i>
        Admin
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        
        <div class="dropdown-divider"></div>
        <a href="<?php echo base_url(); ?>index.php/admin/gantipassword" class="dropdown-item">
          <i class="fas fa-cog"></i> Ganti Password
        </a>
        <div class="dropdown-divider"></div>
        <a href="<?php echo base_url(); ?>index.php/admin/logout" class="dropdown-item">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
        <div class="dropdown-divider"></div>

      </div>
    </li>
  </ul>
</nav>
<!-- /.navbar -->
<?php } ?>
<?php if (!isset($no_visible_elements) || !$no_visible_elements) { ?>
    <aside class="main-sidebar sidebar-light-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
            <img src="<?php echo base_url(); ?>asset/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">AdminLTE 3</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="<?php echo base_url(); ?>asset/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">Alexander Pierce</a>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->

                        <li class="nav-item">
                            <a href="<?php echo base_url('index.php/admin'); ?>" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-school"></i>
                                <p>
                                    Data Sekolah
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo base_url('index.php/admin/idsekolah'); ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Identitas Sekolah</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo base_url('index.php/admin/datakelas'); ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Kelas</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Kandidat Ketua Osis
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo base_url('index.php/admin/tambahcalon'); ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tambah Kandidat</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo base_url("index.php/admin/datacalon"); ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Kandidat</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Data DPT
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo base_url('index.php/admin/tambahdpt'); ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tambah DPT</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo base_url("index.php/admin/datadpt"); ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data DPT</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url("index.php/admin/hasilvote") ?>" class="nav-link">
                            <i class="nav-icon fas fa-eye"></i>
                            <p>
                                Hasil Pemilihan
                            </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-file"></i>
                                <p>
                                    Laporan
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo base_url("index.php/admin/daftarhadir") ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Daftar Hadir</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo base_url("index.php/admin/laporan") ?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Laporan Pilketos</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
       
        <noscript>
            <div class="alert alert-block col-md-12">
                <h4 class="alert-heading">Warning!</h4>

                <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a>
                    enabled to use this site.</p>
            </div>
        </noscript>
<?php } ?>
