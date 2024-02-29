<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title"><?=$subtitle?></h4>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="<?= base_url('buku/processForm') ?>">
                        <div class="form-group">
                            <label class="form-label" for="email">Kategori :</label>
                            <select class="form-select" id="kategori" name="kategori" required>
                              <option disabled selected>- Pilih -</option>
                             <?php foreach ($kategori as $k): ?>
                              <option value="<?=$k->KategoriID?>"><?= $k->NamaKategori?></option>
                             <?php endforeach; ?>
                          </select>
                      </div>
                      <button type="submit" class="btn btn-primary mt-3"><i class="faj-button fa fa-search"></i>Cari</button>
                  </form>
              </div>
          </div>
      </div>
  </div>
</div>
