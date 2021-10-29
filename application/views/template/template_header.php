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

<body>
  <div class="container">
    <center>
      <div class="wrap ">
        <div class="card card-primary text-center" style="width: 60rem; ">
          <div class="card-body">
            <h4 class="card-title" style="text-align:center"><b>Optimization of Food Composition for Patients with Hypertension</b></h4>
            <hr>
            <div class="card-image">
              <div style="float:right">
                <div class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo $nama ?> <i class="fas fa-user-tie fa-2x"></i>
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
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title"><b>Show My Saved</b></h5>
                      <p class="card-text"></p>
                      <a href="<?php echo base_url('User/show'); ?>" class="btn btn-primary" class="btn btn-secondary disabled">Pilih</a>
                    </div>
                  </div>
                </div>
                <div class="col-4">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title"><b>Unduh Dataset</b></h5>
                      <p class="card-text"></p>
                      <a href="<?php echo base_url('Unduh'); ?>" class="btn btn-primary" class="btn btn-secondary disabled">Pilih</a>
                    </div>
                  </div>
                </div>
                <div class="col-4">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title"><b>Dashboard</b></h5>
                      <p class="card-text"></p>
                      <a href="<?php echo base_url('Dashboard'); ?>" class="btn btn-primary" class="btn btn-secondary disabled">Pilih</a>
                    </div>
                  </div>
                </div>
              </div>              
            </div>
            <hr>