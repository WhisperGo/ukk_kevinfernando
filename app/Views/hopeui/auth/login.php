<?php

$db = \Config\Database::connect();
$builder = $db->table('website');
$logo = $builder->select('logo_website')
->where('deleted_at', null)
->get()
->getRow();

?>


<div class="wrapper">
   <section class="login-content">
      <div class="row m-0 align-items-center bg-white vh-100">            
         <div class="col-md-6">
            <div class="row justify-content-center">
               <div class="col-md-10">
                  <div class="card card-transparent shadow-none d-flex justify-content-center mb-0 auth-card">
                     <div class="card-body">
                        <a href="dashboard/index.html" class="navbar-brand d-flex align-items-center mb-3">
                           <!--Logo start-->
                           <a class="navbar-brand">
                            <img src="<?=base_url('logo/logo_website/'.$logo->logo_website)?>" width="25%">
                         </a>
                         <!--logo End-->

                         <!-- <h4 class="logo-title ms-3"><?=$namaweb->nama_website?></h4> -->
                      </a>
                      <h2 class="mb-2 text-center">Sign In</h2>
                      <p class="text-center">Login to stay connected.</p>

                      <?php if (session()->has('error')): ?>
                      <div class="alert alert-danger d-flex align-items-center" role="alert"><i class="faj-button fa-regular fa-circle-exclamation"></i>
                       <?= session('error') ?>
                    </div>
                 <?php endif; ?>

                 <?php if (session()->has('success')): ?>
                 <div class="alert alert-success d-flex align-items-center" role="alert"><i class="faj-button fa-regular fa-check-circle"></i>
                    <?= session('success') ?>
                 </div>
              <?php endif; ?>

              <form action="<?= base_url('login/aksi_login')?>" method="post">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="form-group">
                        <label for="text" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username">
                     </div>
                  </div>

                  <div class="col-lg-12">
                   <div class="form-group">
                    <label for="password" class="form-label" style="flex: 1;">Password</label>
                    <div style="position: relative; flex: 1;">
                     <input type="password" class="form-control" id="password-input" placeholder="Masukkan Password" name="password">
                     <button type="button" class="btn btn-outline-primary" id="show-password-btn" style="position: absolute; right: 0; top: 50%; transform: translateY(-50%);">
                      <i class="fa-solid fa-eye"></i>
                   </button>
                </div>
             </div>
          </div>

          <div class="col-lg-12 d-flex justify-content-between">
            <div class="form-check mb-3">
               <input type="checkbox" class="form-check-input" id="flexCheckDefault">
               <label class="form-check-label" for="flexCheckDefault">Remember Me</label>
            </div>
            <!-- <a href="recoverpw.html">Forgot Password?</a> -->
         </div>
      </div>
      <div class="d-flex justify-content-center">
         <button type="submit" class="btn btn-primary">Sign In</button>
      </div>
                     <!-- <p class="text-center my-3">or sign in with other accounts?</p>
                     <div class="d-flex justify-content-center">
                        <ul class="list-group list-group-horizontal list-group-flush">
                           <li class="list-group-item border-0 pb-0">
                              <a href="#"><img src="<?=base_url('assets/images/brands/fb.svg')?>" alt="fb"></a>
                           </li>
                           <li class="list-group-item border-0 pb-0">
                              <a href="#"><img src="<?=base_url('assets/images/brands/gm.svg')?>" alt="gm"></a>
                           </li>
                           <li class="list-group-item border-0 pb-0">
                              <a href="#"><img src="<?=base_url('assets/images/brands/im.svg')?>" alt="im"></a>
                           </li>
                           <li class="list-group-item border-0 pb-0">
                              <a href="#"><img src="<?=base_url('assets/images/brands/li.svg')?>" alt="li"></a>
                           </li>
                        </ul>
                     </div> -->
                     <p class="mt-3 text-center">
                        Don’t have an account? <a href="<?=base_url('register')?>" class="text-underline">Click here to sign up.</a>
                     </p>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
      <img src="<?=base_url('assets/images/auth/01.png')?>" class="img-fluid gradient-main animated-scaleX" alt="images">
   </div>
</div>
</section>
</div>

<script>
   // Saat halaman dimuat
   document.addEventListener("DOMContentLoaded", function() {
  // Cek apakah ada cookie dengan nama "remember_me"
      if (getCookie("remember_me")) {
    // Jika ada, tandai checkbox "Ingat Saya"
         document.getElementById("flexCheckDefault").checked = true;
    // Dan isi field username dan password dengan nilai cookie
         var cookie = JSON.parse(getCookie("remember_me"));
         if (cookie && cookie.username && cookie.password) {
            document.getElementsByName("username")[0].value = cookie.username;
            document.getElementsByName("password")[0].value = cookie.password;
         }
      }
   });

// Saat form login disubmit
   document.querySelector("form").addEventListener("submit", function() {
  // Cek apakah checkbox "Ingat Saya" di-tick
      if (document.getElementById("flexCheckDefault").checked) {
    // Jika iya, buat cookie dengan nama "remember_me" yang berisi nilai username dan password
         var username = document.getElementsByName("username")[0].value;
         var password = document.getElementsByName("password")[0].value;
         if (username && password) {
            var cookie = {
               username: username,
               password: password
            };
            setCookie("remember_me", JSON.stringify(cookie), 30);
         }
      } else {
    // Jika tidak, hapus cookie dengan nama "remember_me" (jika ada)
         deleteCookie("remember_me");
      }
   });

// Fungsi untuk membuat cookie
   function setCookie(name, value, days) {
      var expires = "";
      if (days) {
         var date = new Date();
         date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
         expires = "; expires=" + date.toUTCString();
      }
      document.cookie = name + "=" + (value || "") + expires + "; path=/";
   }

// Fungsi untuk membaca nilai cookie
   function getCookie(name) {
      var nameEQ = name + "=";
      var ca = document.cookie.split(';');
      for (var i = 0; i < ca.length; i++) {
         var c = ca[i];
         while (c.charAt(0) == ' ') c = c.substring(1, c.length);
         if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
      }
      return null;
   }

// Fungsi untuk menghapus cookie
   function deleteCookie(name) {
      document.cookie = name + '=; Max-Age=-99999999;';
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