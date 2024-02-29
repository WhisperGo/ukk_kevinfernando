 <div class="conatiner-fluid content-inner mt-n5 py-0">
   <div class="row">
      <div class="col-sm-12">
         <div class="card">

            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <a href="<?=base_url('buku/create')?>" class="btn btn-primary"><i class="faj-button fa-solid fa-plus"></i>Tambah</a>
               </div>
            </div>

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
                        <td>
                           <a href="<?php echo base_url('buku/menu_stok/'. $riz->BukuID)?>" class="btn btn-success my-1"><i class="fa-regular fa-box-archive" style="color: #ffffff;"></i></a>

                           <a href="<?php echo base_url('buku/edit/'. $riz->BukuID)?>" class="btn btn-warning my-1"><i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i></a>

                           <a href="<?php echo base_url('buku/delete/'. $riz->BukuID)?>" class="btn btn-danger my-1"><i class="fa-solid fa-trash"></i></a>
                        </td>
                     </tr>
                  <?php } ?>
               </tbody>
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