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
        <div class="d-block gap-3 d-lg-flex">
            <div style="width: calc(100%/2);">
                <div id="carouselExampleIndicators" class="carousel slide">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <?php foreach($data['produk']['items'] as $item): ?>
                            <?php foreach($item['barang'] as $barang): ?>
                        <div class="carousel-item active">
                            <img src="<?=$barang['imglink']?>" class="d-block w-100" alt="...">
                        </div>
                            <?php endforeach;?>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="d-lg-flex gap-3 flex-row-reverse" style="width: 100%;">
                <div style="width: 100%;">
                    <div class="card">
                        <form id="form-tambahkeranjang" action="<?=BASEURL.'/keranjang/tambah'?>" method="post"></form>
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2">Ukuran</h6>
                            <form action="" method="get">
                                <select name="ukuran" onchange="submit();" class="form-select mb-4" aria-label="Default select example">
                                    <option value="" selected>--PILIH UKURAN--</option>
                                    <?php foreach($data['produk']['items'] as $item): ?>
                                        <?php foreach($item['barang'] as $barang): ?>
                                            <?php if(!isset($_temp[$barang['kodesize']])): ?>
                                                <?php $_temp[$barang['kodesize']]['kodesize'] = $barang['kodesize']; ?>
                                    <option value="<?=$barang['kodesize']?>" <?=($_GET['ukuran'] == $barang['kodesize'])?"selected":""?>><?=$barang['kodesize']?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </select>
                                <h6 class="card-subtitle mb-2">Warna</h6>
                                <select name="warna" onchange="submit();" class="form-select mb-4" aria-label="Default select example">
                                    <option value="" selected>--PILIH WARNA--</option>
                                    <?php foreach($data['produk']['items'] as $item): ?>
                                        <?php foreach($item['barang'] as $barang): ?>
                                            <?php if(!isset($_temp[$barang['kodewarna']])): ?>
                                                <?php $_temp[$barang['kodewarna']]['kodewarna'] = $barang['kodewarna']; ?>
                                    <option value="<?=$barang['kodewarna']?>" <?=($_GET['warna'] == $barang['kodewarna'])?"selected":""?>><?=$barang['kodewarna']?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </select>
                            </form>
                            <select form="form-tambahkeranjang" name="produk_item" class="form-select mb-4">
                                <?php foreach($data['produk']['items'] as $item): ?>
                                <option value="<?=$item['idmodelbarangitem']?>"><?=$item['keteranganbarangitem']?></option>
                                <?php endforeach; ?>
                            </select>
                            <h6 class="card-subtitle mb-2">Jumlah</h6>
                            <div class="input-group mb-4">
                                <input form="form-tambahkeranjang" name="jumlah" type="number" min="1" step="1" class="form-control" placeholder="" value="1">
                            </div>
                            <input type="hidden" name="idmodelbarang" value="<?=$data['produk']['idmodelbarang']?>" form="form-tambahkeranjang">
                            <button form="form-tambahkeranjang" type="submit" class="d-block btn btn-primary w-100">Tambah ke Keranjang</button>
                        </div>
                    </div>
                </div>
                <div style="width: 100%;">
                    <h4><?=$data['produk']['namamodel']?></h4>
                    <h3 class="fw-bold"><?=min(array_column($data['produk']['items'], 'hargabarangitem'))?></h3>
                    <p><?=$data['produk']['deskripsi']?></p>
                </div>
            </div>
        </div>
    </div>
</main>