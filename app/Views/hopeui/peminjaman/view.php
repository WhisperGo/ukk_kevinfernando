 <div class="conatiner-fluid content-inner mt-n5 py-0">
   <div class="row">
      <div class="col-sm-12">
         <div class="card">

            <div class="card-body">
               <div class="table-responsive">
                  <table id="datatable" class="table table-striped" data-toggle="data-table">
                     <thead>
                        <tr>
                           <th>No.</th>
                           <th>Cover</th>
                           <th>Judul</th>
                           <th>Penulis</th>
                           <th>Kategori</th>
                           <th>Jumlah</th>
                           <th>Status</th>
                           <th>Action</th>
                        </tr>
                     </thead>

                     <tbody>
                        <?php
                        $no=1;
                        foreach ($jojo as $riz) {
                         ?>
                         <tr>
                          <td><?= $no++ ?></td>
                          <td>
                            <a href="<?= base_url('buku/detail_buku/' . $riz->BukuID) ?>">
                              <img src="<?= base_url('cover/' . $riz->cover_buku) ?>" style="object-fit: cover; width: 95px; height: 140px;" alt="Cover Buku">
                           </a>
                        </td>
                        <td><?= $riz->Judul ?></td>
                        <td><?= $riz->Penulis ?></td>
                        <td><?= $riz->NamaKategori ?></td>
                        <td><?= $riz->stok_buku_peminjaman ?> buah</td>
                        <td>
                           <?php
                           if ($riz->StatusPeminjaman == 0) {
                             echo '<span class="badge rounded-pill bg-gray">Pending</span>';
                          } elseif ($riz->StatusPeminjaman == 1) {
                            echo '<span class="badge rounded-pill bg-danger">Dipinjam</span>';
                         } elseif ($riz->StatusPeminjaman == 2) {
                            echo '<span class="badge rounded-pill bg-success">Dikembalikan</span>';
                         } elseif ($riz->StatusPeminjaman == 4) {
                            echo '<span class="badge rounded-pill bg-gray">Tidak Diizinkan</span>';
                         }
                         ?>
                      </td>
                      <td>
                       <?php if ($riz->StatusPeminjaman == 0): ?>
                         <!-- Tombol untuk StatusPeminjaman == 0 -->
                         <a href="<?php echo base_url('peminjaman/beri_izin/' . $riz->PeminjamanID) ?>" class="btn btn-warning my-1"><i class="fa-duotone fa-rotate"></i></a>
                         <a href="<?php echo base_url('peminjaman/tidak_beri_izin/'. $riz->PeminjamanID)?>" class="btn btn-danger my-1"><i class="fa-solid fa-trash"></i></a>
                      <?php elseif ($riz->StatusPeminjaman == 1): ?>
                         <!-- Tombol untuk StatusPeminjaman == 1 -->
                         <a href="<?php echo base_url('peminjaman/edit_status/'. $riz->PeminjamanID)?>" class="btn btn-success my-1"><i class="fa-regular fa-check-to-slot"></i></a>
                      <?php elseif ($riz->StatusPeminjaman == 2): ?>

                      <?php elseif ($riz->StatusPeminjaman == 4): ?>

                      <?php endif; ?>
                   </td>
                </tr>
             <?php } ?>
          </tbody>
              <!--  <tfoot>
                  <tr>
                     <th>No.</th>
                     <th>Foto</th>
                     <th>Username</th>
                     <th>Level</th>
                     <th style="min-width: 100px">Action</th>
                  </tr>
               </tfoot> -->

            </table>
         </div>
      </div>
   </div>
</div>
</div>
</div>

<!-- <script>
   $(document).ready(function() {
      $('#table2').DataTable({
      });
   });
</script> -->