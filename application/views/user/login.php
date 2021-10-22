<body style="background-image:url('<?php echo base_url(); ?>asset/img/background.jpg'); background-size: 100%; width: 100%; background-repeat: no-repeat">
<div class="ch-container">
    <div class="row">
        <div class="col-md-12 center login-header">
            <h2>Selamat Datang di E-Pilketos</h2>
        </div>
        <!--/span-->
    </div><!--/row-->

    <div class="row">
        <div class="col-md-5 center login-box">
            <div class="alert alert-info">
                Gunakan NISN anda Sebagai Username dan Password
            </div>
			<?php if($this->session->flashdata('failed')) { ?>
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?php echo $this->session->flashdata('failed'); ?>
				</div>
			<?php } ?>
			<?php if($this->session->flashdata('block')) { ?>
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?php echo $this->session->flashdata('block'); ?>
				</div>
			<?php } ?>
			<?php 
				$form_attribute = array(
					'method'	=> 'post',
					'class'		=> 'form-horizontal' 
				);
				echo form_open('user/loginvalidation', $form_attribute);
			?>
            <form class="form-horizontal" action="index.html" method="post">
                <fieldset>
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user red"></i></span>
						<?php
							$form_attribute 	= array(
								'type'			=> 'text',
								'class'			=> 'form-control',
								'name'			=> 'username',
								'placeholder'	=>	'Username'
							);
							echo form_input($form_attribute);
						?>
                    </div>
                    <div class="clearfix"></div><br>

                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock red"></i></span>
                        <?php
							$form_attribute 	= array(
								'type'			=> 'password',
								'class'			=> 'form-control',
								'name'			=> 'password',
								'placeholder'	=> 'Password'
							);
							echo form_input($form_attribute);
						?>
                    </div>
                    <div class="clearfix"></div>

                    
                    <div class="clearfix"></div>

                    <p class="center col-md-5">
                        <button type="submit" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-log-in"></span> Login</button>
                    </p>
                </fieldset>
            </form>
        </div>
    </div>
</div>