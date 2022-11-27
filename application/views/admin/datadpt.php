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
            <h1 class="m-0">Data DPT</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Data DPT</li>
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
        <div class="card-header row" style="padding-bottom: 5px; !important">
        <div class="col-md-6">
					<h2 class="card-title">Data Pemilih Tetap (DPT)</h2>
				</div>
				<div class="col-md-6 text-right">
					<a href="<?php echo base_url(); ?>index.php/admin/hapussemuadpt" onclick="return confirm('Apakah anda yakin ingin menghapus semua data DPT?');"> <button type="button" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span> Hapus Semua Data</button> </a>
				</div>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                <thead>
                    <th class="text-center">No</th>
                    <th class="text-center">NISN</th>
                    <th class="text-center">Nama Siswa</th>
                    <th class="text-center">L/P</th>
                    <th class="text-center">Kelas</th>
                    <th class="text-center" colspan="2">Aksi</th>
                </thead>
                <tbody>
                    <?php
                        $no = 1;
                        foreach($datadpt as $load) {
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $no++; ?></td>
                            <td class="text-center"><?php echo $load['username']; ?></td>
                            <td><?php echo $load['nm_siswa']; ?></td>
                            <td class="text-center"><?php echo $load['jk']; ?></td>
                            <td><?php echo $load['nm_kelas']; ?></td>
                            <td width="100"><a href="<?php echo base_url('index.php/admin/editdpt'); ?>/<?php echo $load['username']; ?>"><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Edit</button></a></td>
                            <td width="100"><a onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')" href="<?php echo base_url('index.php/admin/hapusdpt'); ?>/<?php echo $load['username'];  ?>"><button type="button" class="btn btn-warning"><span class="glyphicon glyphicon-remove"></span> Hapus</button></a></td>
                        </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>