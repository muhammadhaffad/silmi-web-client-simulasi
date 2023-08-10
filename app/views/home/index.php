    <main>
        <div class="container" style="margin-top: 96px;">
            <div class="row">
                <div class="col-lg-6">
                    <?php Flasher::flash(); ?>
                </div>
            </div>
            <div class="grid gap-3">
                <?php foreach ($data['produk'] as $produk) : ?>
                    <div class="p-2 g-col-3">
                        <div class="card">
                            <img src="<?= $produk['imglink'] ?>" width="100%" height="250" class="card-img-top" alt="gambar">
                            <div class="card-body">
                                <h5 class="card-title"><?= $produk['namamodel'] ?></h5>
                                <p class="card-text"><?= $produk['deskripsi'] ?></p>
                                <a href="<?= BASEURL . '/produk/detail/' . $produk['idmodelbarang'] ?>" class="btn btn-primary">LIHAT DETAIL</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>