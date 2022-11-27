<?php 
	foreach($jmlpemilih as $pemilih) {}
	foreach($jmlvote as $votedata) {}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Hasil Vote</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Hasil Vote</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
<div class="card" id="data">
	<div class="box-inner">
		<div class="card-header">
			<h2 class="card-title">Hasil Voting</h2>
		</div>
		<div class="card-body">
			<div class="row">
				<?php 
					foreach($vote as $datavote) {
				?>
					<div class="col-lg-4">
						<div class="box">
							<div class="box-inner">
								<div class="box-header well">
									<h2>No <?php echo $datavote['no']; ?> | <?php echo $datavote['nama']; ?>
								</div>
								<div class="box-content">
									<img width="100%" height="350" src="<?php echo base_url(); ?>asset/img/<?php echo $datavote['photo']; ?>"/>
									<hr/>
									<div class="text-center">
										<p> Jumlah Vote </p>
										<div><h1> <?php echo $datavote['jumlah']; ?> </h1></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php
					}
				?>
			</div>
			<table border="0">
				<tr>
					<td>Jumlah DPT </td>
					<td>: </td>
					<td> <?php echo $pemilih['jumlah']; ?> </td>
				</tr>
				<tr>
					<td>Jumlah DPT yang memilih </td>
					<td>: </td>
					<td> <?php echo $votedata['jumlah']; ?> </td>
				</tr>
				<tr>
					<td>Jumlah DPT yang tidak memilih </td>
					<td>: </td>
					<td>
						<?php  
							$pemilih = $pemilih['jumlah'];
							$vote	= $votedata['jumlah'];
							echo $pemilih - $vote;
						?>
					</td>
				</tr>
			</table>
			
		</div>
	</div>
</div>
