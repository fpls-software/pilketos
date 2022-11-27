<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data Kelas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Data Kelas</li>
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
			<h2 class="card-title">Tambah Data Kelas</h2>
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
				$form_attribute = array(
					'method'	=> 'post',
					'class'		=> 'form-horizontal'
				);
				echo form_open('admin/simpankelas', $form_attribute);
			?>
				<label class="label-control">Nama Kelas</label>
				<?php 
					$form_attribute = array(
						'type'		=> 'text',
						'class'		=> 'form-control',
						'name'		=> 'nm_kelas'
					);
					echo form_input($form_attribute);
				?>
				<br/>
				<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan Data</button>
			<?php 
				echo form_close();
			?>
		</div>
	</div>
</div>
<div class="card">
	<div class="box-inner">
		<div class="card-header">
			<div class="row">
				<div class="col-md-6">
					<h2 class="card-title">Data Kelas</h2>
				</div>
				<div class="col-md-6 text-right">
					<a href="<?php echo base_url(); ?>index.php/admin/hapussemuakelas" onclick="return confirm('Apakah anda yakin ingin menghapus semua data kelas?');"> <button type="button" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span> Hapus Semua Data</button> </a>
				</div>
			</div>
			
		</div>
		<div class="card-body"> <br/>
			<table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
				<thead>
					<th width="20">No</th>
					<th>Kode Kelas</th>
					<th>Nama Kelas</th>
					<th>Aksi</th>
				</thead>
				<tbody>
					<?php
						$no = 1;
						foreach($datakelas as $load) {
					?>
						<tr>
							<td><?php echo $no++; ?></td>
							<td><?php echo $load['kd_kelas']; ?></td>
							<td><?php echo $load['nm_kelas']; ?></td>
							<td width="100"><a href="<?php echo base_url('index.php/admin/hapuskelas'); ?>/<?php echo $load['kd_kelas']; ?>"  onClick="return confirm('Apakah anda yakin ingin menghapus data ini?');"><button type="button" class="btn btn-warning"><span class="glyphicon glyphicon-remove"></span> Hapus</button></a></td>
						</tr>
					<?php
						}
					?>
				<tbody>
			</table>
		</div>
	</div>
</div>