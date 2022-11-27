<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data DPT</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Tambah DPT</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
<div class="card">
	<div class="box-inner">
		<div class="card-header">
			<h2 class="card-title"> Tambah DPT (Daftar Pemilih Tetap) </h2>
		</div>
		<div class="card-body">
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
			$form_attribute = array (
				'method'	=> 'post',
				'class'		=> 'form-horizontal'
			);
			echo form_open_multipart('admin/simpandpt', $form_attribute);
		?>
		<div class="row">
		<div class="col-lg-5">
			<h4>Tambah Data Satu/Satu</h4>
			<hr/>
			<label class="label-control">NISN</label>
			<?php
				$form_attribute = array(
					'type'		=> 'text',
					'class'		=> 'form-control',
					'name'		=> 'nisn',
					'required'	=> 'required'
				);
				echo form_input($form_attribute);
			?>
			<label class="label-control">Nama</label>
			<?php
				$form_attribute = array(
					'type'		=> 'text',
					'class'		=> 'form-control',
					'name'		=> 'nm_siswa',
					'required'	=> 'required'
				);
				echo form_input($form_attribute);
			?>
			<label class="label-control">Jenis Kelamin</label>
			<select class="form-control" name="jk">
				<option selected value="L">L</option>
				<option value="P">P</option>
			</select>
			<label class="label-control">Kelas</label>
			<select class="form-control" name="kd_kelas" required>
				<?php foreach($datakelas as $load) { ?>
					<option value="<?php echo $load['kd_kelas']; ?>"> (<?php echo $load['kd_kelas']; ?>) <?php echo $load['nm_kelas']; ?> </option>
				<?php 
					}
				?>
			</select>
			<br/>
			<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan DPT</button>
		</div>
		<?php 
			echo form_close();
		?>
		<div class="col-lg-6 text-center" style="background: #f0f0f0; padding: 10px; padding-left: 20px; padding-right: 20px;">
			<h4>Tambah Data Massal</h4>
			<hr/>
			<a href="<?php echo base_url(); ?>asset/file/Format_DPT_Pilketos.xls"> <button type="button" class="btn btn-default" style="width: 100%;"><span class="glyphicon glyphicon-cloud-download"></span> Download Format Excel</button></a> <br/> <br/>
			<div class="box">
				<div class="box-inner">
					<div class="box-header well">
						<h2>Upload File Format DPT Pilketos</h2>
					</div>
					<div class="box-content">
						<?php 
						$form_attribute = array (
							'method'	=> 'post',
							'class'		=> 'form-horizontal'
						);
						echo form_open_multipart('admin/simpanmassaldpt', $form_attribute);
						?>
							<input name='datadpt' type="file" required class="form-control"/> <br/>
							<button type="submit" class="btn btn-default" style="width: 100%;"><span class="glyphicon glyphicon-cloud-upload"></span> Upload Data</button>
						<?php 
							echo form_close();
						?>
					</div>
				</div>
			</div>
			
			<br/>
			<span style="color: red;"> Catatan : Format DPT pada kolom Kelas Menggunakan Kode Kelas dan Bukan Nama Kelas Jadi Pastikan anda tidak salah dalam mengimput Kode Kelas. Kode Kelas dapat Dilihat <a href="<?php echo base_url(); ?>index.php/admin/datakelas">Disini</a></span>
		</div>
		</div>
		</div>
	</div>
</div>