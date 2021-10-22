<?php foreach($datakddpt as $load) {} ?>
<div class="box">
	<div class="box-inner">
		<div class="box-header well">
			<h2> Update DPT (Daftar Pemilih Tetap) </h2>
		</div>
		<div class="box-content">
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
			echo form_open('admin/updatedpt', $form_attribute);
		?>
		<div style="width: 400px;">
			<label class="label-control">NISN</label>
			<?php
				$form_attribute = array(
					'type'		=> 'text',
					'class'		=> 'form-control',
                    'name'		=> 'nisn',
                    'value'     => $load['username'],
                    'readonly'  => ''
				);
				echo form_input($form_attribute);
			?>
			<label class="label-control">Nama</label>
			<?php
				$form_attribute = array(
					'type'		=> 'text',
					'class'		=> 'form-control',
                    'name'		=> 'nm_siswa',
                    'value'     => $load['nm_siswa']
				);
				echo form_input($form_attribute);
			?>
			<label class="label-control">Jenis Kelamin</label>
			<select class="form-control" name="jk">
				<option selected value="L">L</option>
				<option value="P">P</option>
			</select>
			<label class="label-control">Kelas</label>
			<select class="form-control" name="kd_kelas">
				<?php foreach($datakelas as $load) { ?>
					<option value="<?php echo $load['kd_kelas']; ?>"> <?php echo $load['nm_kelas']; ?> </option>
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
		</div>
	</div>
</div>