<?php

$db = \Config\Database::connect();
$builder = $db->table('website');
$namaweb = $builder->select('nama_website')
->where('deleted_at', null)
->get()
->getRow();

?>

<div class="conatiner-fluid content-inner mt-n5 py-0">
   <div class="row">
      <div class="col-sm-12">
         <div class="card" data-aos="fade-up" data-aos-delay="200">
            <div class="card-body">
               <h2 class="text-center mb-2">Selamat Datang, <?= session()->get('username')?> di website <?=$namaweb->nama_website?></h2>
               <p class="text-center">Selamat membaca! Semoga pengalaman membaca Anda menyenangkan! :)</p>
            </div>
         </div>
      </div>

      <div class="overflow-hidden d-slider1 ">
         <ul class="p-0 m-0 mb-2 swiper-wrapper list-inline">

            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="200">
               <div class="card-body">
                  <div class="progress-widget">
                     <div id="circle-progress-01" class="text-center circle-progress-01 circle-progress circle-progress-primary" data-min-value="0" data-max-value="100" data-value="100" data-type="percent">
                        <i class="fa-regular fa-database fa-xl card-slie-arrow" style="top: 55px;"></i>
                     </div>
                     <div class="progress-detail">
                        <p class="mb-2">Total Buku</p>
                        <h4 class="counter"><?= $jumlah_buku ?></h4>
                     </div>
                  </div>
                  <div class="text-center">
                     <a href="<?=base_url('buku')?>" class="btn btn-outline-primary rounded-pill mt-3">Detail Buku</a>
                  </div>
               </div>
            </li>

            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="200">
               <div class="card-body">
                  <div class="progress-widget">
                     <div id="circle-progress-02" class="text-center circle-progress-01 circle-progress circle-progress-info" data-min-value="0" data-max-value="100" data-value="100" data-type="percent">
                        <i class="fa-regular fa-user fa-xl card-slie-arrow" style="top: 55px;"></i>
                     </div>
                     <div class="progress-detail">
                        <p class="mb-2">Total Peminjam</p>
                        <h4 class="counter"><?= $jumlah_user ?></h4>
                     </div>
                  </div>
                  <div class="text-center">
                     <a href="<?=base_url('user')?>" class="btn btn-outline-info rounded-pill mt-3">Detail Peminjam</a>
                  </div>
               </div>
            </li>

            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="200">
               <div class="card-body">
                  <div class="progress-widget">
                     <div id="circle-progress-03" class="text-center circle-progress-01 circle-progress circle-progress-success" data-min-value="0" data-max-value="100" data-value="100" data-type="percent">
                        <i class="fa-regular fa-user fa-xl card-slie-arrow" style="top: 55px;"></i>
                     </div>
                     <div class="progress-detail">
                        <p class="mb-2">Total Peminjaman</p>
                        <h4 class="counter"><?= $jumlah_peminjaman ?></h4>
                     </div>
                  </div>
                  <div class="text-center">
                     <a href="<?=base_url('peminjaman')?>" class="btn btn-outline-success rounded-pill mt-3">Detail Peminjaman</a>
                  </div>
               </div>
            </li>
         </ul>

      </div>
   </div>