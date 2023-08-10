<main>
    <div class="container" style="margin-top: 96px;">
        <div class="d-flex gap-3">
            <div style="width: 70%;">
                <h3>Data Pemesan</h3>
                <div class="card mb-3">
                    <div class="card-body">
                        <form id="form-datapemesanan" action="<?=BASEURL.'/order/simpan_informasi'?>" method="post">
                            <div class="grid gap-3">
                                <div class="g-col-6">
                                    <label for="namapelanggan" class="form-label">Nama Pelanggan</label>
                                    <input type="namapelanggan" name="nama_pelanggan" class="form-control" id="namapelanggan" aria-describedby="emailHelp">
                                </div>
                                <div class="g-col-6">
                                    <label for="notlp" class="form-label">Nomor Telepon</label>
                                    <input type="notlp" name="no_tlp" class="form-control" id="notlp" aria-describedby="emailHelp">
                                </div>
                                <div class="g-col-12">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea type="alamat" name="alamat" class="form-control" id="alamat" aria-describedby="emailHelp"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div style="width: 30%;">
                <div class="card">
                    <div class="card-body">
                        <h5 class="fw-bold">Total</h5>
                        <hr>
                        <?php
                            $total = 0;
                            foreach ($data['produk'] as $produk) {
                                foreach ($produk['items'] as $produkItem) {
                                    $total += $produkItem['totalbarangitem'];
                                }
                            }
                        ?>
                        <h5 class="fw-bold mb-4" align="right"><?=$total?></h5>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" form="form-datapemesanan" class="btn btn-primary fw-bold">Lanjutkan</button>
    </div>
</main>