<div class="container">
	<center>
		<?php if ($this->session->flashdata('error')) { ?>
		<div class="alert alert-danger">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
		</div>
		<?php } ?>
		<div class="wrap ">
			<div class="card text-center" style="width: 60rem; ">
				<div class="card-body">
					<h4 class="card-title" style="text-align:center"><b>Optimization of Food Composition for Patients with Hypertension</b></h4>
					<hr>
					<div class="card-image">
                        <div style="float:right">
                            <div class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fas fa-user-tie fa-2x"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">								
                                
                                    <li><a class="dropdown-item" href="<?php echo site_url('Login/LogOut'); ?>">Log Out</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
					<div style="clear:both"></div>	                    
                    <div class="row">
                    <div class="col-6"  style="margin-left:-145px">
                  
                         <img src="<?php echo base_url(); ?>assets/image/bg.png" >
                     
                    </div>						
                    <div class=col-6 width="100%">
                        <div class="row">
                            <div class="col-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><b>Login</b></h5>
                                        <p class="card-text"></p>
                                        <a href="<?php echo base_url('Auth/Login'); ?>" 
                                            class="btn btn-primary" 
                                            class="btn btn-secondary disabled"
                                        >Pilih</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><b>Register</b></h5>
                                        <p class="card-text"></p>
                                        <a href="<?php echo base_url('PerangkatDesa'); ?>"
                                            class="btn btn-primary" 
                                            class="btn btn-secondary disabled"
                                        >Pilih</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><b>Unduh Dataset</b></h5>
                                        <p class="card-text"></p>
                                        <a href="<?php echo base_url('Parameter'); ?>"
                                            class="btn btn-primary" 
                                            class="btn btn-secondary disabled"
                                            >Pilih</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 mt-2">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><b>Show My History</b></h5>
                                        <p class="card-text"></p>
                                        <a href="<?php echo base_url('ProgramKerja'); ?>"
                                            class="btn btn-primary" 
                                            class="btn btn-secondary disabled"
                                            >Pilih</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 mt-2">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><b>Optimization</b></h5>
                                        <p class="card-text"></p>
                                        <a href="<?php echo site_url('Penerimaan'); ?>"
                                            class="btn btn-primary" 									
                                            class="btn btn-secondary disabled"
                                        >Pilih</a>
                                    </div>
                                </div>
                            </div>
                        </div>			
					</div>
                    </div>
				</div>
			</div>
		</div>
	</center>
</div>
