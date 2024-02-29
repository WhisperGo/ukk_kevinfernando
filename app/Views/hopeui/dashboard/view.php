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
               <h2 class="text-center mb-2">Selamat Datang, <?= session()->get('namalengkap')?> di website <?=$namaweb->nama_website?></h2>
               <p class="text-center">Selamat membaca! Semoga pengalaman membaca Anda menyenangkan! :)</p>
            </div>
         </div>
      </div>
   </div>