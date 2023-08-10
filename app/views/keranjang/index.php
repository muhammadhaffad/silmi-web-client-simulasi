<main>
    <div class="container" style="margin-top: 96px;">
        <div class="d-flex gap-3">
            <div style="width: 70%;">
                <div class="card">
                    <div class="card-body">
                        <table class="w-100">
                            <thead>
                                <tr>
                                    <th style="width: 40%;">Produk</th>
                                    <th style="width: 20%;">Harga satuan</th>
                                    <th style="width: 20%;">Jumlah</th>
                                    <th class="px-4" style="width: 20%;">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data['produk'] as $produkItem): ?>
                                    <?php foreach($produkItem['items'] as $item): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <img src="https://source.unsplash.com/random/300x300/?nature" width="80px" height="80px" class="d-block" alt="...">
                                            <div class="d-block">
                                                <label class="d-block fw-bold"><?=substr($item['keteranganbarangitem'], 0, 30).'...'?></label>
                                                <label class="d-block">Ukuran: <?=$item['ukuranbarangitem']?></label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h6><?=$item['hargabarangitem']?></h6>
                                    </td>
                                    <td class="mx-4">
                                        <form id="form-tambahjumlah-<?=$item['idkeranjang']?>" class="mb-0" action="<?=BASEURL.'/keranjang/tambah_jumlah/'.$item['idkeranjang']?>" method="get">
                                        </form>
                                        <form id="form-kurangjumlah-<?=$item['idkeranjang']?>" class="mb-0" action="<?=BASEURL.'/keranjang/kurang_jumlah/'.$item['idkeranjang']?>" method="get">
                                        </form>
                                        <form id="form-hapusitem-<?=$item['idkeranjang']?>" class="mb-0" action="<?=BASEURL.'/keranjang/hapus_item/'.$item['idkeranjang']?>" method="get">
                                        </form>
                                        <div class="input-group">
                                            <button class="btn btn-outline-secondary" form="form-kurangjumlah-<?=$item['idkeranjang']?>" type="submit">-</button>
                                            <input disabled type="number" class="form-control" value="<?=$item['jumlah']?>">
                                            <button class="btn btn-outline-secondary" form="form-tambahjumlah-<?=$item['idkeranjang']?>" type="submit">+</button>
                                        </div>
                                        </form>
                                        <button form="form-hapusitem-<?=$item['idkeranjang']?>" type="submit" class="btn">Hapus</button>
                                    </td>
                                    <td class="px-4">
                                        <h6 class="fw-bold"><?=$item['totalbarangitem']?></h6>
                                    </td>
                                </tr>
                                        <?php endforeach; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
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
                        <a href="<?=BASEURL.'/order/informasi'?>" class="btn btn-danger fw-bold w-100">Lanjut Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>