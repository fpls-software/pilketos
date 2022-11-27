<?php foreach($dataadmin as $data) {} ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Pengaturan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Pengaturan</li>
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
            <h2 class="card-title">Ganti Password</h2>
        </div>
        <div class="card-body">
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
                echo form_open('admin/updatepassword', $form_attribute)
            ?>
                <label class="label-control">Username</label>
                <?php
                    $form_attribute = array(
                        'type'      => 'text',
                        'name'      => 'username',
                        'class'     => 'form-control',
                        'value'     => $data['username'],
                        'readonly'  => ''
                    );
                    echo form_input($form_attribute);
                ?>
                <label class="label-control">Password Baru</label>
                <?php
                    $form_attribute = array(
                        'type'      => 'password',
                        'name'      => 'password',
                        'class'     => 'form-control',
                    );
                    echo form_input($form_attribute);
                ?><br/>
                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Update Password</button>
            <?php 
                echo form_close();
            ?>
        </div>
    </div>
</div>