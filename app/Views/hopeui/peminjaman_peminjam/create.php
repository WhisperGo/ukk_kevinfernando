<div class="conatiner-fluid content-inner mt-n5 py-0">
   <div>
      <div class="row">
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h4 class="card-title"><?=$subtitle?></h4>
                  <small class="text-danger text-sm">* Data yang Wajib Diisi</small>
                  <?php if (session()->has('error')): ?>
                  <div class="alert alert-danger d-flex align-items-center mt-2" role="alert"><i class="faj-button fa-regular fa-circle-exclamation"></i>
                     <?= session('error') ?></div>
                  <?php endif; ?>
               </div>
            </div>
            <div class="card-body">
               <div class="new-user-info">
                  <form action="<?= base_url('peminjaman_peminjam/aksi_create')?>" method="post" enctype="multipart/form-data">

                     <input type="hidden" name="id" value="<?php echo $jojo2 ?>">

                     <h6 class="card-title mb-3"><strong>Stok Buku : <?=$buku->stok_buku?> buah</strong></h6>

                     <div class="row">
                        <div class="form-group">
                           <label class="form-label" for="fname">Jumlah Peminjaman <small class="text-danger text-sm">*</small></label>
                           <input type="text" class="form-control" id="jumlah_peminjaman" name="jumlah_peminjaman" placeholder="Masukkan Jumlah Peminjaman" required>
                        </div>

                        <div class="form-group">
                           <label class="form-label" for="fname">Tanggal Pengembalian <small class="text-danger text-sm">*</small></label>
                           <input type="date" class="form-control" id="tgl_pengembalian" name="tgl_pengembalian" placeholder="Masukkan Tanggal Pengembalian" required>
                        </div>

                     </div>
                     <a href="javascript:history.back()" class="btn btn-danger mt-4">Cancel</a>
                     <button type="submit" class="btn btn-primary mt-4">Submit</button>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>