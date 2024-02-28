<div class="conatiner-fluid content-inner mt-n5 py-0">
   <div>
      <div class="row">
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h4 class="card-title"><?=$subtitle?></h4>
               </div>
            </div>
            <div class="card-body">
               <div class="new-user-info">
                  <form action="<?= base_url('buku/aksi_edit')?>" method="post" enctype="multipart/form-data">

                     <input type="hidden" name="id" value="<?php echo $jojo->BukuID ?>">

                     <div class="row">
                        <div class="form-group" style="margin-bottom: 6px; margin-top: 6px;">
                           <label for="Foto" class="form-label">Cover Buku (Opsional)</label>
                           <input type="file" class="logo-perusahaan" id="cover_buku" name="cover_buku" accept="image/*">
                        </div>
                        <input type="hidden" name="old_cover" value="<?= $jojo->cover_buku ?>">
                        <div id="preview">
                           <label for="Foto" class="form-label">Cover Buku Lama</label><br>
                           <?php if ($jojo->cover_buku): ?>
                              <img src="<?=base_url('cover/'. $jojo->cover_buku)?>" width="10%" class="mb-3">
                           <?php endif; ?>
                        </div>

                        <div class="form-group">
                           <label class="form-label" for="fname">Judul <small class="text-danger text-sm">*</small></label>
                           <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan Judul" value="<?php echo $jojo->Judul ?>" required>
                        </div>

                        <div class="form-group">
                           <label class="form-label" for="fname">Penulis <small class="text-danger text-sm">*</small></label>
                           <input type="text" class="form-control" id="penulis" name="penulis" placeholder="Masukkan Penulis" value="<?php echo $jojo->Penulis ?>" required>
                        </div>

                        <div class="form-group">
                           <label class="form-label" for="fname">Penerbit <small class="text-danger text-sm">*</small></label>
                           <input type="text" class="form-control" id="penerbit" name="penerbit" placeholder="Masukkan Penerbit" value="<?php echo $jojo->Penerbit ?>" required>
                        </div>

                        <div class="form-group">
                           <label class="form-label" for="fname">Tahun Terbit <small class="text-danger text-sm">*</small></label>
                           <input type="text" class="form-control" id="tahun_terbit" name="tahun_terbit" placeholder="Masukkan Tahun Terbit" value="<?php echo $jojo->TahunTerbit ?>" required>
                        </div>

                        <div class="form-group">
                           <label class="form-label" for="fname">Kategori Buku</label>
                           <select class="form-select" id="kategori" name="kategori" required>
                              <option>- Pilih -</option>
                              <?php foreach ($kategori as $k): ?>
                                <?php
                                // Jika KategoriID dari kategori ini sama dengan KategoriID buku yang diedit
                                $selected = ($k->KategoriID == $kategori_buku_id) ? 'selected' : '';
                                ?>
                                  <option value="<?= $k->KategoriID ?>" <?= $selected ?>>
                                    <?= $k->NamaKategori ?>
                                 </option>
                           <?php endforeach; ?>
                        </select>
                     </div>

                     <div class="form-group">
                        <label class="form-label" for="fname">Stok Buku</label>
                        <input type="text" class="form-control" id="stok_buku" name="stok_buku" placeholder="Masukkan Stok Buku" value="<?php echo $jojo->stok_buku ?>" required>
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