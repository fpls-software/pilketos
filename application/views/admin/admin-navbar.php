<body>
<?php if (!isset($no_visible_elements) || !$no_visible_elements) { ?>
    <!-- topbar starts -->
    <div class="navbar navbar-default" role="navigation">

        <div class="navbar-inner">
            <button type="button" class="navbar-toggle pull-left animated flip">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url('index.php/admin/'); ?>">
                <span>E-Pilketos</span>
			</a>

            <!-- user dropdown starts -->
            <div class="btn-group pull-right">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-user"></i><span class="hidden-sm hidden-xs"> admin</span>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url("index.php/admin/gantipassword"); ?>">Ganti Password</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo base_url("index.php/admin/logout"); ?>">Logout</a></li>
                </ul>
            </div>
            <!-- user dropdown ends -->


            <ul class="collapse navbar-collapse nav navbar-nav top-menu">
                <li><a href="<?php echo base_url('index.php'); ?>"><i class="glyphicon glyphicon-globe"></i> Visit Site</a></li>
            </ul>

        </div>
    </div>
    <!-- topbar ends -->
<?php } ?>
<div class="ch-container">
    <div class="row">
        <?php if (!isset($no_visible_elements) || !$no_visible_elements) { ?>

        <!-- left menu starts -->
        <div class="col-sm-2 col-lg-2">
            <div class="sidebar-nav">
                <div class="nav-canvas">
                    <div class="nav-sm nav nav-stacked">

                    </div>
                    <ul class="nav nav-pills nav-stacked main-menu">
                        <li class="nav-header">MAIN</li>
                        <li><a class="ajax-link" href="<?php echo base_url('index.php/admin'); ?>"><i class="glyphicon glyphicon-home"></i><span> Dashboard</span></a>
                        </li>
						<li class="nav-header">DATA SEKOLAH</li>
						<li><a class="ajax-link" href="<?php echo base_url('index.php/admin/idsekolah'); ?>"><i class="glyphicon glyphicon-list-alt"></i><span> Identitas Sekolah</span></a></li>
						<li><a class="ajax-link" href="<?php echo base_url('index.php/admin/datakelas'); ?>"><i class="glyphicon glyphicon-list-alt"></i><span> Data Kelas</span></a></li>
						<li class="nav-header hidden-md">DATA KANDIDAT KETUA OSIS</li>
                        <li><a class="ajax-link" href="<?php echo base_url('index.php/admin/tambahcalon'); ?>"><i class="glyphicon glyphicon-list-alt"></i><span> Tambah Kandidat</span></a></li>
						<li><a class="ajax-link" href="<?php echo base_url("index.php/admin/datacalon"); ?>"><i class="glyphicon glyphicon-eye-open"></i><span> Lihat Data Kandidat</span></a></li>
						<li class="nav-header hidden-md">DATA DPT</li>
						<li><a class="ajax-link" href="<?php echo base_url('index.php/admin/tambahdpt'); ?>"><i class="glyphicon glyphicon-list-alt"></i><span> Tambah DPT</span></a></li>
						<li><a class="ajax-link" href="<?php echo base_url("index.php/admin/datadpt"); ?>"><i class="glyphicon glyphicon-eye-open"></i><span> Lihat Data DPT</span></a></li>
                        <li class="nav-header hidden-md">HASIL PEMILIHAN</li>
                        <li><a class="ajax-link" href="<?php echo base_url("index.php/admin/hasilvote") ?>"><i class="glyphicon glyphicon-calendar"></i><span> Lihat Hasil</span></a></li>
						<li class="nav-header hidden-md">LAPORAN</li>
						<li><a class="ajax-link" href="<?php echo base_url("index.php/admin/daftarhadir") ?>"><i class="glyphicon glyphicon-calendar"></i><span> Daftar Hadir</span></a></li>
						<li><a class="ajax-link" href="<?php echo base_url("index.php/admin/laporan") ?>"><i class="glyphicon glyphicon-calendar"></i><span> Laporan Pilketos</span></a></li>
					</ul>
                </div>
            </div>
        </div>
        <!--/span-->
        <!-- left menu ends -->

        <noscript>
            <div class="alert alert-block col-md-12">
                <h4 class="alert-heading">Warning!</h4>

                <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a>
                    enabled to use this site.</p>
            </div>
        </noscript>

        <div id="content" class="col-lg-10 col-sm-10">
            <!-- content starts -->
            <?php } ?>
