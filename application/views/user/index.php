
<div class="container">
<div class="box">
	<div class="box-inner">
		<div class="box-header well">
			<h2>Selamat Datang di E-Pilketos</h2>
		</div>
		<div class="box-content">
			<p>Silahkan Pilih Calon Ketua OSIS dibawah ini </p>
			<hr/>
			<br/><br/>
			<div class="row">
				<?php
					foreach($datacalon as $loaddata) {
				?>
					<div class="col-lg-4">
						<div class="box">
							<div class="box-inner">
								<div class="box-header well">
									<h2 class="text-center"> NO <?php echo $loaddata['no']; ?>  ||  <?php echo $loaddata['nama']; ?> </h2>
								</div>
								<div class="box-content">
									<img width="100%" height="400" src="<?php echo base_url(); ?>asset/img/<?php echo $loaddata['photo']; ?>"/></br/><br/>
									<?php
										$form_attribute	= array(
											'methode'	=> 'post',
											'class'		=> 'form-horizontal'
										);
										echo form_open('user/vote', $form_attribute);
									?>
									<?php 
										$form_attribute	= array(
											'type'		=> 'hidden',
											'name'		=> 'nisn',
											'class'		=> 'form-control',
											'value'		=> $loaddata['nisn']
										);
										echo form_input($form_attribute);
									?>
									<?php 
										$form_attribute	= array(
											'type'		=> 'hidden',
											'name'		=> 'username',
											'class'		=> 'form-control',
											'value'		=> $username
										);
										echo form_input($form_attribute);
									?>
									<button class="btn btn-danger" style="width: 100%;">Pilih NO <?php echo $loaddata['no']; ?></button>
									<?php 
										echo form_close();
									?>
								</div>
							</div>
						</div>
					</div>
				<?php 
					} 
				?>
			</div>
		</div>
	</div>
</div>
</div>