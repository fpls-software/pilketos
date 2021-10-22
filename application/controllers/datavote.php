<div class="row">
				<?php 
					foreach($vote as $datavote1) {
				?>
					<div class="col-lg-4">
						<div class="box">
							<div class="box-inner">
								<div class="box-content">
									<p class="text-center"> Jumlah Vote </p>
									<div class="text-center"><h1> <?php echo $datavote1['jumlah']; ?> </h1></div>
								</div>
							</div>
						</div>
					</div>
				
				<?php 
					} 
				?>
			<table border="0">
				<tr>
					<td>Jumlah Pemilih Terdaftar </td>
					<td>: </td>
					<td> <?php echo $pemilih['jumlah']; ?> </td>
				</tr>
				<tr>
					<td>Jumlah Pemilih yang memilih </td>
					<td>: </td>
					<td> <?php echo $votedata['jumlah']; ?> </td>
				</tr>
				<tr>
					<td>Jumlah Pemilih yang tidak memilih </td>
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
<script src=”jquery-latest.js”></script>
<script type="text/javascript">
var auto_refresh = setInterval(
function () {
    $('#data').load('<?php echo base_url();?>index.php/admin/autorefresh');
}, 1000);
</script>