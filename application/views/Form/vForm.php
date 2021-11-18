<div class="container">
<?php if ($this->session->flashdata('warning')) { ?>
                            <div class="alert alert-warning">
                                <a data-dismiss="alert">&times;</a>
                                <strong>Maaf,</strong> <?php echo $this->session->flashdata('warning'); ?>
                            </div>
                        <?php } ?>
		<div class="">
			<div class="card" style="width: 100%; ">
				<div class="card-body">
					<h5 class="card-title" style="text-align:left"><b>Masukkan Data Diri : </b></h5>
					<hr>					
					<div style="clear:both"></div>	 
                    <div class="wrap">
                        <form action="<?php echo base_url('Optimization/proccess')?>" method="POST">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input id="name" class="form-control" name="name" style="margin-left: 100px;" placeholder="Masukkan Nama" value="<?php echo $nama; ?>" required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="age">Umur</label>
                                        <input id="age" class="form-control" name="age" min="10" max="100" type="number" style="margin-left: 100px;" placeholder="Masukkan Umur" value="<?php echo $age ?>" required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="gender">Jenis Kelamin</label>                                        
                                        <select name="gender" id="gender" class="form-control" style="margin-left: 52px;" required autofocus>
                                            <option value="" selected="false" disabled>--Pilih Jenis Kelamin--</option>
                                            <option value="Laki-laki" <?php if ($user->gender == 'Laki-laki') { ?>
                                                selected = "true"
                                            <?php } ?> >Laki-laki</option>
                                            <option value="Perempuan" <?php if ($user->gender == 'Perempuan') { ?>
                                                selected="true"
                                            <?php } ?>>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="weight">Berat Badan (Kg)</label>
                                        <input id="weight" class="form-control" name="weight" type="number" style="margin-left: 34px;" placeholder="Masukkan Berat Badan (Kg)" required autofocus>
                                    </div>
                                    <div class="form-group" >
                                        <label for="height">Tinggi Badan (Cm)</label>
                                        <input id="height" class="form-control" name="height" type="number" style="margin-left: 21px;" placeholder="Masukkan Tinggi Badan (cm)" required autofocus>
                                    </div>                                
                                </div>                    
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="sistolik">Tekanan darah Sistolik</label>
                                        <input id="sistolik" class="form-control" name="sistolik" style="margin-left: 40px;" type="number" placeholder="Masukkan Tekanan darah Sistolik" required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="diastolik">Tekanan darah Diastolik</label>
                                        <input id="diastolik" class="form-control" name="diastolik" style="margin-left: 32px;" type="number" placeholder="Masukkan Tekanan darah Diastolik" required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="gender">Tingkat Stres</label>
                                        <select name="stress" class="form-control" id="stress" style="margin-left: 95px;" required>
                                            <option selected="false" disabled="true" value="">--Pilih Tingkat Stres--</option>
                                            <option value="1.3">Tidak ada stres</option>
                                            <option value="1.4">Stress ringan</option>
                                            <option value="1.5">Stress sedang</option>
                                            <option value="1.6">Stress berat</option>
                                            <option value="1.7">Stress sangat berat</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="activity">Aktivitas</label>
                                        <select name="activity" class="form-control" id="activity" style="margin-left: 122px;" required autofocus>
                                            <option selected="false" disabled="true" value="">--Pilih Tingkat Aktivitas--</option>
                                            <option value="Sangat ringan" title="Sebuah pola hidup dimana terlibat dalam aktivitas yang cukup seperti pada umumnya yang dianggap hidup sehat">Sangat ringan</option>
                                            <option value="Ringan" title="Sedikitnya tenaga yang dikeluarkan dan mungkin tidak menyebabkan pernapasan atau ketahanan ">Ringan</option>
                                            <option value="Sedang" title="Tenaga yang dibutuhkan intens, kekuatan atau berirama dalam menggerakkan otot.">Sedang</option>
                                            <option value="Berat" title="Membutuhkan kekuatan serta ada kaitannya dengan berolahraga, membuat berkeringat.">Berat</option>
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
