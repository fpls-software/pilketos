<?php 
	foreach($jmlcalon as $jumlah) {} 
    foreach($jmlpemilih as $jumlahpemilih) {} 
    foreach($datapilketos as $loaddata) {}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Jumlah Kandidat</span>
                <span class="info-box-number">
                <?php echo $jumlah['jumlah']; ?>
                  <small>Orang</small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Jumlah DPT</span>
                <span class="info-box-number"><?php echo $jumlahpemilih['jumlah']; ?>
                 <small>Orang</small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="box-inner">
                <div class="card-header">
                    <h2 class="card-title">Data Pilketos</h2>
                </div>
                <div class="card-body">
                    <?php if($this->session->flashdata('update')) { ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $this->session->flashdata('update'); ?>
                        </div>
                    <?php } ?>
                    <?php if($this->session->flashdata('updatefailed')) { ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $this->session->flashdata('updatefailed'); ?>
                        </div>
                    <?php } ?>
                    <?php 
                        $form_attribute = array(
                            'method'    => 'post',
                            'class'     => 'form-horizontal'
                        );
                        echo form_open('admin/updatedatapilketos', $form_attribute);
                    ?>
                        <label class="label-control"> Tahun Pelajaran</label>
                        <?php
                            $form_attribute = array(
                                'type'      => 'text',
                                'class'     => 'form-control',
                                'name'      => 'tapel',
                                'value'     => $loaddata['tapel']
                            );
                            echo form_input($form_attribute);
                        ?>
                        <label class="label-control"> Tanggal Pelaksanaan</label>
                        <?php
                            $form_attribute = array(
                                'type'      => 'date',
                                'class'     => 'form-control',
                                'name'      => 'tgl',
                                'value'     => $loaddata['tgl']
                            );
                            echo form_input($form_attribute);
                        ?><br/>
                        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan Data</button>
                    <?php 
                        echo form_close(); 
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
    <div class="card">
            <div class="box-inner">
               <div class="card-header">
                  <h2 class="card-title">Reset Data Pemilihan</h2>
              </div>
             <div class="card-body">
             <p>Fitur ini akan menghapus semua data Kecuali Indentitas Sekolah dan Data Kelas</p>
                <p>Fitur ini digunakan Apabila telah selesai melakukan pemilihan dan telah Mengunduh <a href="<?php echo base_url('index.php/admin/cetakdaftarhadir'); ?>">Daftar Hadir</a> dan <a href="<?php echo base_url('index.php/admin/laporan'); ?>">Laporan Pemilihan</a> dan ingin Melakukan Pemilihan di Tahun berikutnya</p>
                <?php if($this->session->flashdata('reset')) { ?>
			    <div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?php echo $this->session->flashdata('reset'); ?>
			</div>
			<?php } ?>
			<?php if($this->session->flashdata('resetfailed')) { ?>
			<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?php echo $this->session->flashdata('resetfailed'); ?>
			</div>
			<?php } ?>
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#reset"><span class="glyphicon glyphicon-remove"></span> Reset Data Pemilihan</button>
				<div id="reset" class="modal fade" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<b><span class="glyphicon glyphicon-warning"></span> Peringatan</b>
							</div>
							<div class="modal-body">
								<p>Fitur ini akan menghapus semua data Kecuali Indentitas Sekolah dan Data Kelas</p>
								<p>Apakah anda yakin ingin Me-Reset semua data? </p>
							</div>
							<div class="modal-footer">
								<a href="<?php echo base_url('index.php/admin/resetdata'); ?>"><button type="button" class="btn btn-success">Ya</button></a>
								<button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
							</div>
						</div>
					</div>
				</div>
             </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">      
        <div class="card">
            <div class="box-inner">
               <div class="card-header">
                  <h2 class="card-title">Reset User DPT</h2>
              </div>
             <div class="card-body">
                <p>Fitur ini digunakan apabila Seorang Pemilih melaporkan bahwa dia Belum pernah memilih Sebelumnya tetapi Usernya telah dikunci karena Telah Memilih <b>(Usernya digunakan oleh orang lain)</b> </p>
               <hr/>
               <?php if($this->session->flashdata('info')) { ?>
			    <div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?php echo $this->session->flashdata('info'); ?>
			</div>
			<?php } ?>
			<?php if($this->session->flashdata('failed')) { ?>
			<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?php echo $this->session->flashdata('failed'); ?>
			</div>
			<?php } ?>
                <?php
                    $form_attribute = array(
                        'method'    => 'post',
                        'class'     => 'form-horizontal'
                    );
                    echo form_open('admin/resetuser', $form_attribute);
                ?>
                    <label class="label-control"> NISN</label>
                    <?php
                        $form_attribute = array(
                            'type'      => 'text',
                            'class'     => 'form-control',
                            'name'      => 'username',
                            'required'  => ''
                        );
                        echo form_input($form_attribute);
                    ?>
                    <br/>
                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-remove"></span> Reset User</button>
                <?php 
                    echo form_close();
                ?>
             </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
    <div class="card">
            <div class="card-header">
                <h2 class="card-title"><i class="glyphicon glyphicon-info-sign"></i> Tentang E-Pilketos</h2>

                
            </div>
            <div class="card-body">
                <p> E-Pilketos Adalah sebuah aplikasi yang didesain khusus untuk Pemilihan Ketua Osis <br/>
					Aplikasi ini menggunakan Template <b><a href="https://adminlte.io">AdminLTE</a></b> dan dibangun menggunakan Framework <b><a href="https://www.codeigniter.con">CodeIgniter</a></b> 
					<br/><br/>
					Dengan adanya Aplikasi ini saya harap dapat membatu sekolah untuk melakukan Vote Ketua OSIS
				</p>
            </div>
        </div>
    </div>
</div>