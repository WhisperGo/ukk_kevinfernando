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
                  <form action="<?= base_url('register/aksi_register')?>" method="post" enctype="multipart/form-data">
                     <div class="row">

                        <div class="form-group" style="margin-bottom: 6px; margin-top: 6px;">
                           <label for="Foto" class="form-label">Foto Profil (Opsional)</label>
                           <input type="file" class="logo-perusahaan" id="foto_profil" name="foto_profil" accept="image/*">
                        </div>

                        <div class="form-group">
                           <label class="form-label" for="fname">Username <small class="text-danger text-sm">*</small></label>
                           <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username" required>
                        </div>

                        <div class="form-group">
                           <label for="password" class="form-label" style="flex: 1;">Password <small class="text-danger text-sm">*</small></label>
                           <div style="position: relative; flex: 1;">
                              <input type="password" class="form-control" id="password-input" placeholder="Masukkan Password" name="password" required>
                              <button type="button" class="btn btn-outline-primary" id="show-password-btn" style="position: absolute; right: 0; top: 50%; transform: translateY(-50%);">
                               <i class="fa-solid fa-eye"></i>
                            </button>
                         </div>
                      </div>

                      <div class="form-group">
                        <label class="form-label" for="fname">Email <small class="text-danger text-sm">*</small></label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email" required>
                     </div>

                     <div class="form-group">
                        <label class="form-label" for="fname">Nama Lengkap <small class="text-danger text-sm">*</small></label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan Nama Lengkap" required>
                     </div>

                     <div class="form-group">
                        <label class="form-label" for="fname">Alamat <small class="text-danger text-sm">*</small></label>
                        <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukkan Alamat" required>
                     </div>

                  </div>
                  <div class="captcha-container d-flex mt-2">
                    <div class="g-recaptcha" data-sitekey="6LcEfuojAAAAANG5m1V5uLxuVdX1L9ZXYA9XUM9v" data-callback="onCaptchaVerified"></div>
                 </div>
                 <a href="<?= base_url('/') ?>" class="btn btn-danger mt-4">Back to Login</a>
                 <button type="submit" class="btn btn-primary mt-4" id="submitBtn" disabled>Submit</button>
              </form>
           </div>
        </div>
     </div>
  </div>
</div>
</div>

<script>
   function onCaptchaVerified() {
      $('#submitBtn').prop('disabled', false);
   }

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


<script src="https://www.google.com/recaptcha/api.js" async defer></script>