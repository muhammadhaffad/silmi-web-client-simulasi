    <nav class="fixed-top navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="#">Web Client</a>
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link active" aria-current="page" href="#">Keranjang</a>
                    <a class="nav-link" href="#">Masuk</a>
                </div>
            </div>
        </div>
    </nav>
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