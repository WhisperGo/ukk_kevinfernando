<div class="conatiner-fluid content-inner mt-n5 py-0">
   <div>
      <div class="row">
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h4 class="card-title"><?=$subtitle?></h4>
                  <small class="text-danger text-sm">* Biarkan Jika Tidak Diedit</small>
               </div>
            </div>
            <div class="card-body">
               <div class="new-user-info">
                  <form action="<?= base_url('user/aksi_edit')?>" method="post" enctype="multipart/form-data">
                     <div class="row">

                        <input type="hidden" name="id" value="<?php echo $jojo->UserID ?>">

                        <div class="form-group" style="margin-bottom: 6px; margin-top: 6px;">
                           <label for="Foto" class="form-label">Foto Profil (Opsional) <small class="text-danger text-sm">*</small></label>
                           <input type="file" class="logo-perusahaan" id="foto_profil" name="foto_profil" accept="image/*">
                        </div>
                        <input type="hidden" name="old_foto" value="<?= $jojo->foto ?>">
                        <div id="preview">
                           <label for="Foto" class="form-label">Foto Profil Lama</label><br>
                           <?php if ($jojo->foto): ?>
                              <img src="<?=base_url('profile/'. $jojo->foto)?>" width="25%" class="mb-3">
                           <?php endif; ?>
                        </div>

                        <div class="form-group">
                           <label class="form-label" for="fname">Username <small class="text-danger text-sm">*</small></label>
                           <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username" value="<?php echo $jojo->Username ?>" required>
                        </div>

                        <div class="form-group">
                           <label class="form-label" for="fname">Email <small class="text-danger text-sm">*</small></label>
                           <input type="text" class="form-control" id="email" name="email" placeholder="Masukkan Email" value="<?php echo $jojo->Email ?>" required>
                        </div>

                        <div class="form-group">
                           <label class="form-label" for="fname">Nama Lengkap <small class="text-danger text-sm">*</small></label>
                           <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan Nama Lengkap" value="<?php echo $jojo->NamaLengkap ?>" required>
                        </div>

                        <div class="form-group">
                           <label class="form-label" for="fname">Alamat <small class="text-danger text-sm">*</small></label>
                           <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukkan Alamat" value="<?php echo $jojo->Alamat ?>" required>
                        </div>

                        <div class="form-group">
                           <label class="form-label" for="fname">Level <small class="text-danger text-sm">*</small></label>
                           <select class="form-select" id="level" name="level" required>
                              <option>- Pilih -</option>
                              <?php 
                              foreach ($level as $l) {
                                 $selected = ($jojo->level == $l->id_level) ? 'selected' : '';
                                 ?>
                                 <option value="<?=$l->id_level?>" <?=$selected?>><?= $l->nama_level?></option>
                              <?php } ?>
                           </select>
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

<script>
   $(document).ready(function() {
      $('#show-password-btn').click(function() {
         var passwordInput = $('#password-input');
         var passwordInputType = passwordInput.attr('type');
         var showPasswordBtn = $('#show-password-btn');
         if (passwordInputType === 'password') {
            passwordInput.attr('type', 'text');
            showPasswordBtn.html('<i class="fa-solid fa-eye-slash"></i>');
         } else {
            passwordInput.attr('type', 'password');
            showPasswordBtn.html('<i class="fa-solid fa-eye"></i>');
         }
      });
   });
</script>