 <div class="conatiner-fluid content-inner mt-n5 py-0">
   <div class="row">
      <div class="col-sm-12">
         <div class="card">

         <div class="card-body">
            <div class="table-responsive">
               <table id="datatable" class="table table-striped" data-toggle="data-table">
                  <thead>
                     <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Nama Log</th>
                        <th>Waktu Log</th>
                     </tr>
                  </thead>

                  <tbody>
                     <?php
                     $no=1;
                     foreach ($jojo as $riz) {
                       ?>
                       <tr>
                        <td><?= $no++ ?></td>
                        <td><?php echo $riz->Username ?></td> 
                        <td><?php echo $riz->nama_log ?></td> 
                        <td><?php echo $riz->created_at_log ?></td> 
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