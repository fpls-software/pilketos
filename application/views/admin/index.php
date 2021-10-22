<?php 
	foreach($jmlcalon as $jumlah) {} 
    foreach($jmlpemilih as $jumlahpemilih) {} 
    foreach($datapilketos as $loaddata) {}
?>

<div class=" row">
    <div class="col-md-6 col-sm-6 col-xs-6">
        <div  class="well top-block">
            <i class="glyphicon glyphicon-user blue"></i>

            <div>Jumlah Kandidat</div>
            <div><?php echo $jumlah['jumlah']; ?></div>
        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-xs-6">
        <div  class="well top-block">
            <i class="glyphicon glyphicon-user green"></i>

            <div>Jumlah DPT</div>
            <div><?php echo $jumlahpemilih['jumlah']; ?></div>
            
        </div>
    </div>
</div>
<div class="box">
    <div class="box-inner">
        <div class="box-header well">
            <h2>Data Pilketos</h2>
        </div>
        <div class="box-content">
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
<div class="row">
    <div class="col-lg-6">
        <div class="box">
            <div class="box-inner">
               <div class="box-header well">
                  <h2>Reset Data Pemilihan</h2>
              </div>
             <div class="box-content">
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
    <div class="col-lg-6">      
        <div class="box">
            <div class="box-inner">
               <div class="box-header well">
                  <h2>Reset User DPT</h2>
              </div>
             <div class="box-content">
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
</div>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                <h2><i class="glyphicon glyphicon-info-sign"></i> Tentang E-Pilketos</h2>

                
            </div>
            <div class="box-content">
                <p> E-Pilketos Adalah sebuah aplikasi yang didesain khusus untuk Pemilihan Ketua Osis <br/>
					Aplikasi ini menggunakan Template <b>Charisma</b> dan dibangun menggunakan Framework <b>Code Igniter</b> 
					<br/><br/>
					Dengan adanya Aplikasi ini saya harap dapat membatu sekolah untuk melakukan Vote Ketua OSIS
				</p>
            </div>
        </div>
    </div>
</div>