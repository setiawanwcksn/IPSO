<div class="container">

	<div class="">
		<div class="card" style="width: 100%; ">
			<div class="card-body">
				<div class="wrap">

				</div>				
				<div id="tab">
					<nav>
						<a href="#" class="active" data-id="1"> Hasil Optimasi</a>
						<a href="#" data-id="2"> Lihat Proses IPSO</a>
						<a href="#" data-id="3"> Data Diri</a>
					</nav>
					<div class="tab-content active" data-content="1">
						<h5 style="text-align:left">Hasil Optimasi Komposisi Makanan</h5>
						<a href="<?php $y = 1;
									echo base_url("User/save/") ?>"><button type="button" class="btn btn-outline-dark" style="float: right;" <?php if (!$id) { ?>disabled <?php } ?>>Simpan Data </button> </a>
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
											$j = 1;
											foreach ($makanan as $item) : ?>
												<tr class="text-center">
													<?php if ($y == 0) { ?>
														<td scope="row"><b> Pagi</b> </td>
													<?php  } elseif ($y == 1) { ?>
														<td scope="row"> <b>Siang </b></td>
													<?php } else { ?>
														<td scope="row"> <b>Malam </b></td>
													<?php } ?>
													<td><?php echo $item[0] ?> <br> <?php echo "( " . $berat[$j][0] . " gr )" ?> </td>
													<td><?php echo $item[1] ?> <br> <?php echo "( " . $berat[$j][1] . " gr )" ?> </td>
													<td><?php echo $item[2] ?> <br> <?php echo "( " . $berat[$j][2] . " gr )" ?> </td>
													<td><?php echo $item[3] ?> <br> <?php echo "( " . $berat[$j][3] . " gr )" ?> </td>
													<td><?php echo $item[4] ?> <br> <?php echo "( " . $berat[$j][4] . " gr )" ?> </td>
												</tr>
												<?php $y++;
												$j++; ?>
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
												<th scope="col">Partikel</th>
												<th scope="col">Posisi</th>
												<th scope="col">kecepatan</th>
												<th scope="col">Fitness</th>
												<th scope="col">PBest</th>
												<th scope="col">GBest</th>
											</tr>
										</thead>

										<tbody>

											<?php $y = 0;
											$a = 1;
											$iterasi = 0;
											for ($i = 0; $i < 400; $i++) {
												if ($y == 4) {
													$iterasi++;
													$y = 0;
												}; ?>
												<tr class="text-center">
													<td><?php if ($i == 0 || $i % 4 == 0) {
															echo $a;
															$a++;
														} ?></td>
													<td><?php echo "x" . ($y + 1) ?></td>
													<td>[<?php for ($j = 0; $j < 14; $j++) {
																echo $process['posisi'][$iterasi][$y][$j] . ", ";
															} ?>]</td>
													<td>[<?php for ($j = 0; $j < 14; $j++) {
																echo $process['kecepatan'][$iterasi][$y][$j] . ", ";
															} ?>]</td>
													<td><?php echo $process['fitness'][$iterasi][$y]; ?>
													</td>
													<?php if (isset($process['pbest'][$iterasi][$y])) { ?>
														<td><?php echo $process['pbest'][$iterasi][$y]; ?></td>
														<td><?php echo end($process['gbest'][$iterasi]); ?></td>
													<?php } else { ?>
														<td><?php echo " - "; ?></td>
														<td><?php echo " - "; ?></td>
													<?php } ?>
												</tr>
											<?php $y++;
											}; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-content" data-content="3">
						<div class="row mt-3">
						<div class="container">
						<h5 style="text-align:left">Kebutuhan Gizi :</h5>
							<table id="table_id" class="table table-striped table-hover table-responsive">
								<thead>
									<tr class="text-center">
										<th>Karbohidrat</th>
										<th>Protein</th>
										<th>Lemak</th>
										<th>Natrium</th>
										<th>Kalium</th>
									</tr>
								</thead>
								<tbody>
									<tr class="text-center">
										<td><?php echo $kebutuhan['0'] ?> gram</td>
										<td><?php echo $kebutuhan['1'] ?> gram</td>
										<td><?php echo $kebutuhan['2'] ?> gram</td>
										<td><?php echo $kebutuhan['3'] ?> gram</td>
										<td><?php echo $kebutuhan['4'] ?> gram</td>
									</tr>
								</tbody>
							</table>
						</div>
							<div class="container">
							<h5 style="text-align:left">Data Diri :</h5>
							<table id="table_id" class="table table-striped table-hover table-responsive" style="font-size: 11px;">
								<thead>
									<tr class="text-center">
										<th>Nama</th>
										<th>Umur</th>
										<th>Jenis Kelamin</th>
										<th>Berat Badan</th>
										<th>Tinggi Badan</th>
										<th>Tek. Sistolik</th>
										<th>Tek. Diastolik</th>
										<th>Tingkat Stres</th>
										<th>Tingkat Aktivitas</th>
									</tr>
								</thead>
								<tbody>
									<tr class="text-center">
										<td><?php echo $dataDiri['name'] ?></td>
										<td><?php echo $dataDiri['age'] ?> Tahun</td>
										<td><?php echo $dataDiri['gender'] ?></td>
										<td><?php echo $dataDiri['weight'] ?> Kg</td>
										<td><?php echo $dataDiri['height'] ?> cm</td>
										<td><?php echo $dataDiri['sistolik'] ?> mmHg</td>
										<td><?php echo $dataDiri['diastolik'] ?> mmHg</td>
										<td><?php echo $dataDiri['stress'] ?> </td>
										<td><?php echo $dataDiri['activity'] ?> </td>
									</tr>
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