<?php if($this->session->flashdata('info')) { ?>
	<script>alert("Berhasil Menghapus Data");</script>
<?php } ?>
<?php if($this->session->flashdata('failed')) { ?>
	<script>alert("Gagal Menghapus Data");</script>
<?php } ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Kandidat Ketua Osis</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Data Kandidat</li>
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
			<h2 class="card-title">Data Calon Ketua OSIS</h2>
		</div>
		<div class="card-body">
			<table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
				<thead>
					<tr>
						<th class="text-center">No</th>
						<th class="text-center">Nama Calon</th>
						<th class="text-center">Photo Calon</th>
						<th class="text-center" width="200">Aksi</th>
					</tr>
				</thead>
				<tbody>
				<?php 
					$no = 1;
					foreach($datacalon as $loaddata) {
				?>
					<tr>
						<td class="text-center"><?php echo $loaddata['no']; ?></td>
						<td><?php echo $loaddata['nama']; ?></td>
						<td class="text-center"><img width="50" height="60" src="<?php echo base_url(); ?>/asset/img/<?php echo $loaddata['photo']; ?>"></td>
						<td>
						
							<a class="btn btn-info" href="<?php echo base_url(); ?>index.php/admin/editcalon/<?php echo $loaddata['nisn']; ?>">
								<i class="glyphicon glyphicon-edit icon-white"></i>
								Edit
							</a>
							<a class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?');" href="<?php echo base_url(); ?>index.php/admin/hapuscalon/<?php echo $loaddata['nisn']; ?>">
								<i class="glyphicon glyphicon-trash icon-white"></i>
								Hapus
							</a>
						</td>
					</tr>
				<?php 
					} 
				?> 
				</tbody>
			</table>
		</div>
	</div>
</div>