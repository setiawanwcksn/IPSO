<div class="container">

	<div class="">
		<div class="card" style="width: 100%; ">
			<div class="card-body">
				<div class="wrap">
					<h5 style="text-align:left">Kebutuhan Gizi : </h5>
					<div class="row mt-3">
						<div class="form-group" style="text-align:left">
							<h6>
								<label>Karbohidrat : <?php echo $kebutuhan['0'] ?> gram</label> <br>
								<label>Protein : <?php echo $kebutuhan['1'] ?> gram</label> <br>
								<label>Lemak : <?php echo $kebutuhan['2'] ?> gram</label> <br>
								<label>Natrium : <?php echo $kebutuhan['3'] ?> gram</label> <br>
								<label>Kalium : <?php echo $kebutuhan['4'] ?> gram</label> <br>
							</h6>
						</div>
					</div>
				</div>
				<hr>
				<div id="tab">
					<nav>
						<a href="#" class="active" data-id="1"> Hasil Optimasi</a>
						<a href="#" data-id="2"> Lihat Proses IPSO</a>
					</nav>
					<div class="tab-content active" data-content="1">
						<h5 style="text-align:left">Hasil Optimasi Komposisi Makanan</h5>
						<a href="<?php $y = 1;
									echo base_url("User/save/") ?>"><button type="button" class="btn btn-outline-dark" style="float: right;" <?php if (!$id) { ?>disabled <?php } ?>>Simpan Data </button> </a>
						<a href="#" onclick="pass()"><button type="button" class="btn btn-outline-dark" style="float: right;margin-right: 10px;">Lihat Proses Model IPSO </button> </a>
						<div style="clear:both"></div>
						<div class="wrap">
							<div class="">
								<div class="row mt-2">
									<table id="table_id" class="table table-striped table-hover table-responsive">
										<thead>
											<tr class="text-center">
												<th scope="col">Makanan</th>
												<th scope="col">Makanan Pokok</th>
												<th scope="col">Nabati</th>
												<th scope="col">Hewani</th>
												<th scope="col">Sayuran</th>
												<th scope="col">Buah</th>
											</tr>
										</thead>

										<tbody>

											<?php $y = 0;
											foreach ($makanan as $item) : ?>
												<tr class="text-center">
													<?php if ($y == 0) { ?>
														<td scope="row"><b> Pagi</b> </td>
													<?php  } elseif ($y == 1) { ?>
														<td scope="row"> <b>Siang </b></td>
													<?php } else { ?>
														<td scope="row"> <b>Malam </b></td>
													<?php } ?>
													<td><?php echo $item[0] ?></td>
													<td><?php echo $item[1] ?></td>
													<td><?php echo $item[2] ?></td>
													<td><?php echo $item[3] ?></td>
													<td><?php echo $item[4] ?></td>
												</tr>
												<?php $y++ ?>
											<?php endforeach; ?>
										</tbody>
									</table>
								</div>
								<button type="button" class="btn btn-outline-dark" onClick="window.location.reload();">Ulang Proses</button>
							</div>
						</div>
					</div>
					<div class="tab-content" data-content="2">
						<h5 style="text-align:left">Proses Model IPSO</h5>
						<hr>
						<div style="clear:both"></div>
						<div class="wrap">
							<div class="">
								<div class="row mt-2">
									<table id="table_id" class="table table-striped table-hover table-responsive">
										<thead>
											<tr class="text-center">
												<th scope="col">Iterasi</th>
												<th scope="col">Posisi</th>
												<th scope="col">kecepatan</th>
												<th scope="col">Fitness</th>
												<th scope="col">PBest</th>
												<th scope="col">GBest</th>
											</tr>
										</thead>

										<tbody>

											<?php $y = 0; $a = 1; $iterasi=0;
											for ($i=0; $i < 400; $i++) { if ($y == 4) { $iterasi++;$y = 0; }; ?>
												<tr class="text-center">
													<td><?php if ($i == 0 || $i % 4 == 0) {
														echo $a; $a++;
													} ?></td>
													<td>[<?php for ($j=0; $j < 14; $j++) { 
															echo $process['posisi'][$iterasi][$y][$j].", ";																			
													} ?>]</td>
													<td>[<?php for ($j=0; $j < 14; $j++) { 
															echo $process['kecepatan'][$iterasi][$y][$j].", ";																			
													} ?>]</td>
													<td><?php echo $process['fitness'][$iterasi][$y];?>
													</td>
													<?php if (isset($process['pbest'][$iterasi][$y])) { ?>
														<td><?php echo $process['pbest'][$iterasi][$y]; ?></td>
														<td><?php echo end($process['gbest'][$iterasi]); ?></td>
													<?php }else { ?>
														<td><?php echo " - "; ?></td>
														<td><?php echo " - "; ?></td>
													<?php } ?>
												</tr>												
											<?php $y++; }; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>

		</div>
	</div>
</div>

</div>