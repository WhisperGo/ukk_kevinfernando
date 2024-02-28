<div class="conatiner-fluid content-inner mt-n5 py-0">
   <div class="row">
      <div class="col-sm-12">
         <div class="card">

            <div class="card-body">

               <h2 class="text-center mb-4">Area Ulasan</h2>

               <?php foreach ($gambar_baru as $image): ?>
                  <div class="position-relative h-100 text-center">
                     <img src="<?= base_url('cover/' . $image->cover_buku) ?>" class="img-fluid mb-2 rounded" style="object-fit: cover; width: 15%; height: 15%;">
                     <h6 class="text-center mb-4"><?= $image->judul_buku ?></h6>
                  </div>
               <?php endforeach; ?>

               <!-- Formulir komentar -->
               <form action="<?=base_url('ulasan_buku/aksi_create/') ?>" method="post">

                  <input type="hidden" name="id" value="<?php echo $id ?>">

                  <div class="row">
                    <div class="form-group mt-2">
                     <textarea class="form-control" name="isi_ulasan" rows="5" placeholder="Silahkan Beri Ulasan Anda" required></textarea>
                  </div>
               </div>

               <div class="mb-4">
                 <div class="text-center"><button type="submit" class="btn btn-success">Kirim Ulasan</button>
                 </div>
              </div>
           </form>

           <div class="row justify-content-center">
              <div class="mb-4">
               <h3 class="mb-3">Semua Ulasan :</h3> 
               <?php if (empty($ulasan)): ?>
                 <p>Belum Ada Ulasan</p>
              <?php else: ?>
                 <?php foreach ($ulasan as $u): ?>
                  <p><strong><?= $u->username ?></strong>: <?= $u->ulasan ?></p>
               <?php endforeach; ?>
            <?php endif; ?>
         </div>

      </div>
   </div>
</div>
</div>
</div>