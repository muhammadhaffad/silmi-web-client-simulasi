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
        <div class="d-flex gap-3">
            <div style="width: 70%;">
                <h3>Pesanan</h3>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold">Alamat Penerima</h5>
                        <p class="fw-bold mb-0"><?= $data['order']['namacustomer'] ?></p>
                        <p><?= $data['order']['notlp'] ?></p>
                        <p class="mb-0"><?= $data['order']['alamat'] ?></p>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <table class="w-100">
                            <thead>
                                <tr>
                                    <th style="width: 40%;">Produk</th>
                                    <th style="width: 20%;">Harga satuan</th>
                                    <th style="width: 20%;">Jumlah</th>
                                    <th style="width: 20%;">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($data['produk']) == 0) : ?>
                                    <h5>Keranjang Kosong</h5>
                                <?php else : ?>
                                    <?php foreach ($data['produk'] as $produkItem) : ?>
                                        <?php foreach ($produkItem['items'] as $item) : ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <img src="<?=$item['imglink']?>" width="50px" height="50px" class="d-block" alt="...">
                                                        <div class="d-block">
                                                            <label class="d-block fw-bold"><?= substr($item['keteranganbarangitem'], 0, 30) . '...' ?></label>
                                                            <label class="d-block">Ukuran: <?= $item['ukuranbarangitem'] ?></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <h6><?= $item['hargabarangitem'] ?></h6>
                                                </td>
                                                <td class="">
                                                    <?= $item['jumlah'] ?> pcs
                                                </td>
                                                <td class="">
                                                    <h6 class="fw-bold"><?= $item['totalbarangitem'] ?></h6>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <form id="form-placeorder" action="<?=BASEURL.'/order/pesan_order/'.$data['order']['idorder']?>" method="post"></form>
                <h3>Pengiriman</h3>
                <div class="card mb-3">
                    <div class="card-body">
                        <select form="form-placeorder" name="id_kurir" class="form-select" aria-label="Default select example">
                            <option selected>--Pilih Kurir Pengiriman--</option>
                            <option value="1">JNE - Rp.5.000</option>
                        </select>
                    </div>
                </div>
                <h3>Pembayaran</h3>
                <select form="form-placeorder" name="bank" class="form-select mb-5" aria-label="Default select example">
                    <option selected>--Pilih Metode Pembayaran--</option>
                    <option value="BRI">BRI</option>
                    <option value="BNI">BNI</option>
                </select>
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
                        <button form="form-placeorder" type="submit" class="btn btn-success fw-bold w-100">Pesan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>