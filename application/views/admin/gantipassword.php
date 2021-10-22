<?php foreach($dataadmin as $data) {} ?>
<div class="box">
    <div class="box-inner">
        <div class="box-header well">
            <h2>Ganti Password</h2>
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