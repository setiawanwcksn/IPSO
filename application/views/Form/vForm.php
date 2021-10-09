<div class="container">
		<div class="">
			<div class="card" style="width: 100%; ">
				<div class="card-body">
					<h4 class="card-title" style="text-align:center"><b>Optimization of Food Composition for Patients with Hypertension</b></h4>
					<hr>					
					<div style="clear:both"></div>	 
                    <div class="wrap">
                        <form action="<?php echo base_url('Optimization/proccess')?>" method="POST">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input id="name" class="form-control" name="name" style="margin-left: 100px;" required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="age">umur</label>
                                        <input id="age" class="form-control" name="age" style="margin-left: 100px;" required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="gender">Jenis Kelamin</label>
                                        <input id="gender" class="form-control" name="gender" style="margin-left: 52px;" required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="weight">Berat Badan</label>
                                        <input id="weight" class="form-control" name="weight" style="margin-left: 60px;" required autofocus>
                                    </div>
                                    <div class="form-group" >
                                        <label for="height">Tinggi Badan</label>
                                        <input id="height" class="form-control" name="height" style="margin-left: 55px;" required autofocus>
                                    </div>                                
                                </div>                    
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="gender">Tingkat Hipertensi</label>
                                        <input id="gender" class="form-control" name="gender" style="margin-left: 32px;" required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="gender">Tingkat Stres</label>
                                        <select name="stress" class="form-control" id="stress" style="margin-left: 63px;" required>
                                            <option selected="false" disabled="true" value="">--Pilih Tingkat Stres--</option>
                                            <option value="">aa</option>
                                            <option value="">vv</option>
                                            <option value="">ww</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="gender">Aktivitas</label>
                                        <select name="activity" class="form-control" id="activity" style="margin-left: 87px;" required autofocus>
                                            <option selected="false" disabled="true" value="">--Pilih Tingkat Aktivitas--</option>
                                            <option value="">aa</option>
                                            <option value="">bb</option>
                                            <option value="">cc</option>
                                        </select>
                                    </div>
                                </div>    
                                <div class="col">
                                    <center>
                                    <div class="form-group">
                                        <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block" value="submit">
                                        Proccess
                                        </button>
                                    </div>
                                    </center>
                                </div>                        
                            </div>
                        </form>
                    </div>
				</div>
			</div>
		</div>
</div>
