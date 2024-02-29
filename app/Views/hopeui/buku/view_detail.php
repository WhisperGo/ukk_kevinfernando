<div class="container-fluid content-inner mt-n5 py-0">
   <div class="row">
      <div class="col-sm-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between">
            </div>

            <div class="card-body">
               <?php foreach ($jojo as $riz): ?>
                  <div class="book-detail">
                     <div class="row">
                        <div class="col-md-2">
                           <a href="<?= base_url('cover/' . $riz->cover_buku) ?>">
                              <img src="<?= base_url('cover/' . $riz->cover_buku) ?>" class="img-fluid book-cover" alt="Cover Buku">
                           </a>
                        </div>
                        <div class="col-md-10">
                           <h4 class="mb-2"><?= $riz->Judul ?></h4>
                           <p><strong>Penulis:</strong> <?= $riz->Penulis ?></p>
                           <p><strong>Penerbit:</strong> <?= $riz->Penerbit ?></p>
                           <p><strong>Tahun Terbit:</strong> <?= $riz->TahunTerbit ?></p>
                           <p><strong>Kategori:</strong> <?= $riz->NamaKategori ?></p>
                           <p><strong>Stok:</strong> <?= $riz->stok_buku ?> buah</p>
                        </div>
                     </div>
                  </div>
                  <hr>
               <?php endforeach; ?>
            </div>
         </div>
      </div>
   </div>
</div>
