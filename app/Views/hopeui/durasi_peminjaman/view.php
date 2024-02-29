 <div class="conatiner-fluid content-inner mt-n5 py-0">
   <div class="row">
      <div class="col-sm-12">
         <div class="card">

          <?php if ($jumlah_data == 0) { ?>
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <a href="<?php echo base_url('durasi_peminjaman/create/') ?>"><button class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah</button></a>
                  </div>
               </div>
            <?php } ?>

         <div class="card-body">
            <div class="table-responsive">
               <table id="datatable" class="table table-striped" data-toggle="data-table">
                  <thead>
                     <tr>
                        <th>No</th>
                        <th>Lama Durasi</th>
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
                        <td><?php echo $riz->lama_durasi ?> hari</td> 
                        <td>
                           <a href="<?php echo base_url('durasi_peminjaman/edit/'. $riz->id_durasi)?>" class="btn btn-warning my-1"><i class="fa-solid fa-pen-to-square" style="color: #ffffff;"></i></a>

                           <a href="<?php echo base_url('durasi_peminjaman/delete/'. $riz->id_durasi)?>" class="btn btn-danger my-1"><i class="fa-solid fa-trash"></i></a>
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