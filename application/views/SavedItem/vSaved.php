<div class="container">
    <center>
        <div class="">
            <div class="card" style="width: 100%; ">
                <div class="card-body">
                    <hr>
                    <h5 style="text-align:left">Hasil Optimasi Komposisi Makanan</h5>
                    <div style="clear:both"></div>
                    <div class="wrap">
                        <div class="container">
                            <div id="tab">
                                <nav>
                                    <?php for ($index = 0; $index < count($history); $index++) {                     ?>
                                        <a href="#" <?php if ($index == 0) { ?> class="active" <?php } ?> data-id=<?php echo $index; ?>>Tab <?php echo $index; ?></a>
                                    <?php } ?>
                                </nav>

                                <?php for ($i = 0; $i < $index; $i++) { ?>
                                    <div class="tab-content <?php if ($i == 0) { ?> active <?php } ?>" data-content='<?php echo $i; ?>'>
                                        <div class="row mt-2">
                                            <table id="table_id" class="table table-striped table-hover table-responsive">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th scope="col">Makanan</th>
                                                        <th scope="col">Karbohidrat</th>
                                                        <th scope="col">Nabati</th>
                                                        <th scope="col">Hewani</th>
                                                        <th scope="col">Sayuran</th>
                                                        <th scope="col">Buah</th>
                                                    </tr>
                                                </thead>

                                                <tbody>

                                                    <?php $y = 0;
                                                    foreach ($history[$i]['makanan'] as $item) : ?>
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
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </center>
</div>