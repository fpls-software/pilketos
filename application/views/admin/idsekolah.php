<?php 
	foreach($idsekolah as $load) {}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data Sekolah</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Identitas Sekolah</li>
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
			<h2 class="card-title"> Identitas Sekolah </h2>
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
			<div style="">
				<?php 
					$form_attribute = array(
						'method'	=> 'post',
						'class'		=> 'form-horizontal'
					);
					echo form_open("admin/updateidsekolah", $form_attribute);
				?>
					<div class="row">
					<div class="col-lg-6">
					<div class="card">
						<div class="box-inner">
							<div class="card-header">
								<h2 class="card-title">Data Sekolah</h2>
							</div>
							<div class="card-body">
								<label class="label-control">NPSN</label>
								<?php
									$form_attribute = array(
										'type'		=> 'text',
										'class'		=> 'form-control',
										'name'		=> 'npsn',
										'value'		=> $load['npsn']
									);
									echo form_input($form_attribute);
								?>
								<label class="label-control">Nama Sekolah</label>
								<?php
									$form_attribute = array(
										'type'		=> 'text',
										'class'		=> 'form-control',
										'name'		=> 'nm_sekolah',
										'value'		=> $load['nm_sekolah']
									);
									echo form_input($form_attribute);
								?>
								<label class="label-control">Alamat Jln</label>
								<?php
									$form_attribute = array(
										'type'		=> 'text',
										'class'		=> 'form-control',
										'name'		=> 'jln',
										'value'		=> $load['jln']
									);
									echo form_input($form_attribute);
								?>
								<label class="label-control">Desa / Kelurahan</label>
								<?php
									$form_attribute = array(
										'type'		=> 'text',
										'class'		=> 'form-control',
										'name'		=> 'desa',
										'value'		=> $load['desa']
									);
									echo form_input($form_attribute);
								?>
								<label class="label-control">Kecamatan</label>
								<?php
									$form_attribute = array(
										'type'		=> 'text',
										'class'		=> 'form-control',
										'name'		=> 'kec',
										'value'		=> $load['kec']
									);
									echo form_input($form_attribute);
								?>
								<label class="label-control">Kabupaten / Kota</label>
								<?php
									$form_attribute = array(
										'type'		=> 'text',
										'class'		=> 'form-control',
										'name'		=> 'kab',
										'value'		=> $load['kab']
									);
									echo form_input($form_attribute);
								?>
							</div>
						</div>
					</div>
					</div>
					<div class="col-lg-6">
						<div class="card">
							<div class="box-inner">
								<div class="card-header">
									<h2 class="card-title">Kepala Sekolah</h2>
								</div>
								<div class="card-body">
									<label class="label-control">Nama Kelapa Sekolah</label>
									<?php
										$form_attribute = array(
											'type'		=> 'text',
											'class'		=> 'form-control',
											'name'		=> 'kpl_sekolah',
											'value'		=> $load['kpl_sekolah']
										);
										echo form_input($form_attribute);
									?>
									<label class="label-control">NIP</label>
									<?php
										$form_attribute = array(
											'type'		=> 'text',
											'class'		=> 'form-control',
											'name'		=> 'nip',
											'value'		=> $load['nip']
										);
										echo form_input($form_attribute);
									?>
									<br/>
									<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Update Data</button>
								</div>
							</div>
						</div>
					</div>
					</div>
				<?php 
					echo form_close();
				?>
			</div>
		</div>
	</div>
</div>