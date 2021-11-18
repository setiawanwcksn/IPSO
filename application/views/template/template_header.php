<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
  <!-- Data Table -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <?php
  if (isset($css)) {
    $this->load->view($css);
  }
  ?>

</head>

<body id="body">
  <div class="container mt-4">
    <center>
      <div class="wrap ">
        <div class="card card-primary text-center" style="width: 60rem; ">
          <div class="card-body">
            <h4 class="card-title" style="text-align:center"><b>Optimasi Komposisi Makanan untuk Penderita Hipertensi</b></h4>
            <hr>
            <div class="card-image">
              <div style="float:right">
                <div class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <?php echo $nama ?><i class="fas fa-user-tie fa-2x"></i>
                  </a>
                  <?php if ($id) { ?>                            
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="<?php echo site_url('Auth/LogOut'); ?>">Log Out</a></li>
                  </ul>
                  <?php } ?>
                </div>
              </div>
            </div>            
            <div class="">
              <div class="row">                
                <div class="col-4">
                  <div class="card <?php if ($active == 'saved') { ?>
                    card-primary
                  <?php } ?>">
                    <div class="card-body" style="padding-top: 6px;">
                      <h6 class="card-title"><b>Rekomendasi Tersimpan</b></h6>
                      <p class="card-text"></p>
                      <a href="<?php if ($active != 'saved') {
                        echo base_url('User/show');
                      }else {
                        echo "#";
                      } ?>"><button class="btn btn-primary" <?php if ($active == 'saved') { ?>
                        disabled
                      <?php } ?>><i class="fas fa-save fa-2x"></i></button></a>
                    </div>
                  </div>
                </div>
                <div class="col-4">
                  <div class="card <?php if ($active == 'unduh') { ?>
                    card-primary
                  <?php } ?>">
                    <div class="card-body">
                      <h5 class="card-title"><b>Unduh Dataset</b></h5>
                      <p class="card-text"></p>
                      <a href="<?php if ($active != 'unduh') { echo base_url('Unduh'); }else {
                        echo "#";
                      }  ?>"><button class="btn btn-primary" <?php if ($active == 'unduh') { ?>
                        disabled
                      <?php } ?>><i class="fas fa-download fa-2x"></i></button></a>
                    </div>
                  </div>
                </div>
                <div class="col-4">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title"><b>Dashboard</b></h5>
                      <p class="card-text"></p>
                      <a href="<?php echo base_url('Dashboard'); ?>" class="btn btn-primary"><i class="fas fa-home fa-2x"></i></a>
                    </div>
                  </div>
                </div>
              </div>              
            </div>
            <hr>