<div class="container">
    <center>
        <div class="">
            <div class="card" style="width: 100%; ">
                <div class="card-body">                    
                    <h5 style="text-align:left">Hasil Optimasi Komposisi Makanan</h5>
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
										
										<?php $y = 0;foreach ($makanan as $item): ?>											
										<tr class="text-center">	
											<?php if ($y == 0) { ?>
												<td scope="row"><b> Pagi</b> </td>	
											<?php  }elseif ($y == 1) { ?>
												<td scope="row"> <b>Siang </b></td>	
											<?php }else { ?>
												<td scope="row"> <b>Malam </b></td>	
											<?php } ?> 
											<td><?php echo $item[0]?></td>
											<td><?php echo $item[1]?></td>	
											<td><?php echo $item[2]?></td>	
											<td><?php echo $item[3]?></td>	
											<td><?php echo $item[4]?></td>																				
										</tr>
										<?php $y++ ?>
										<?php endforeach;?>
									</tbody>
								</table>								
							</div>							
						</div>
                    </div>
                </div>
            </div>
        </div>
    </center>
</div>