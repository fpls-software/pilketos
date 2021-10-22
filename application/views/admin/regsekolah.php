<div class="ch-container">
    <div class="row">
        
    <div class="row">
        <div class="col-md-12 center login-header">
            <h2>Registrasi Sekolah</h2>
        </div>
        <!--/span-->
    </div><!--/row-->

    <div class="row">
        <div class="well col-md-5 center login-box">
			<?php if($this->session->flashdata('regfailed')) { ?>
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?php echo $this->session->flashdata('regfailed'); ?>
				</div>
			<?php } ?>
			<?php 
				$form_attribute = array(
					'method'	=> 'post',
					'class'		=> 'form-horizontal' 
				);
				echo form_open('admin/simpansekolah', $form_attribute);
			?>
            <form class="form-horizontal" action="index.html" method="post">
                <fieldset>
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-star red"></i></span>
						<?php
							$form_attribute 	= array(
								'type'			=> 'text',
								'class'			=> 'form-control',
                                'name'			=> 'npsn',
                                'placeholder'   => 'NPSN'
							);
							echo form_input($form_attribute);
						?>
                        
                    </div>
                    <div class="clearfix"></div><br>

                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-home red"></i></span>
                        <?php
							$form_attribute 	= array(
								'type'			=> 'text',
								'class'			=> 'form-control',
								'name'			=> 'nm_sekolah',
								'placeholder'	=> 'Nama Sekolah'
							);
							echo form_input($form_attribute);
						?>
                    </div>
                    <div class="clearfix"></div>

                    
                    <div class="clearfix"></div>

                    <p class="center col-md-5">
                        <button type="submit" class="btn btn-primary">Daftar</button>
                    </p>
                </fieldset>
            </form>
        </div>
        <!--/span-->
    </div><!--/row-->
</div><!--/fluid-row-->