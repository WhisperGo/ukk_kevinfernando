<div class="conatiner-fluid content-inner mt-n5 py-0">
   <div class="row">
      <div class="col-sm-12">
         <div class="card">

            <div class="card-body">

               <h2 class="text-center">Ulasan Buku</h2>
               <p class="text-danger text-sm text-center mb-4">* Data yang Wajib Diisi</p>

               <?php foreach ($gambar_baru as $image): ?>
                  <div class="position-relative h-100 text-center">
                     <img src="<?= base_url('cover/' . $image->cover_buku) ?>" class="img-fluid mb-2 rounded" style="object-fit: cover; width: 15%; height: 15%;">
                     <p class="text-center mb-2"><?= $image->Judul ?></p>
                     <p class="text-center mb-4">Karya :<?= $image->Penulis ?></p>
                  </div>
               <?php endforeach; ?>

               <!-- Formulir komentar -->
               <form action="<?=base_url('ulasan_buku/aksi_create/') ?>" method="post">

                <input type="hidden" name="id" value="<?php echo $id ?>">

                <div class="row">
                   <div class="form-group mt-2">
                      <label class="form-label" for="fname">Rating : </label>
                      <select class="form-select" id="rating" name="rating" required>
                        <option>- Pilih -</option>
                        <?php 
                        foreach ($rating as $r) {
                           ?>
                           <option value="<?=$r->id_rating?>"><?= $r->nama_rating?></option>
                        <?php } ?>
                     </select>
                  </div>
                  <div class="form-group mt-2">
                     <label class="form-label" for="fname">Ulasan : </label>
                     <textarea class="form-control" name="isi_ulasan" rows="3" placeholder="Silahkan Beri Ulasan Anda" required></textarea>
                  </div>
               </div>

               <div class="mb-4">
                  <div class="text-center"><button type="submit" class="btn btn-primary">Kirim Ulasan</button>
                  </div>
               </div>
            </form>

            <div class="row justify-content-center">
              <div class="col-md-8">
                <div class="card">
                  <div class="card-header">
                    <h3 class="mb-0">Semua Ulasan</h3>
                 </div>
                 <div class="card-body">
                    <?php if (empty($ulasan)): ?>
                      <p class="text-muted">Belum Ada Ulasan</p>
                   <?php else: ?>
                      <?php foreach ($ulasan as $u): ?>
                       <div class="media-body">
                        <small class="text-muted"><?= date('d M Y H:i', strtotime($u->created_at_ulasan)) ?></small>
                         <h5 class="mt-0"><?= $u->Username ?> <span class="badge badge-primary" style="color: black;"><?= $u->nama_rating ?></span></h5>
                         <p><?= $u->Ulasan ?></p>
                      </div>
                   <?php endforeach; ?>
                <?php endif; ?>
             </div>
          </div>
       </div>
    </div>

 </div>
</div>
</div>
</div>
</div>