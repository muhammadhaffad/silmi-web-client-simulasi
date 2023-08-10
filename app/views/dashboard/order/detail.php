<main class="w-100">
    <div class="container mx-2 mt-4 overflow-y-auto">
        <h3>Pesanan</h3>
        <?php foreach ($data['order'] as $order) : ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="fw-bold">Order-<?= $order['idorder'] ?></h5>
                    <p class="fw-bold mb-0"><?= $order['namacustomer'] ?></p>
                    <p><?= $order['notlp'] ?></p>
                    <p class="mb-0"><?= $order['alamat'] ?></p>
                    <?php
                    $kurir = [
                        1 => 'JNE'
                    ];
                    ?>
                    <p class="mb-0"><?= $kurir[$order['idekspedisi']] ?> - Rp.<?= $order['biayaongkir'] ?></p>
                    <p class="mb-0">Rp.<?= $order['grandtotal'] ?></p>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <table class="w-100">
                        <thead>
                            <tr>
                                <th style="width: 40%;">Kode Produk</th>
                                <th style="width: 20%;">Harga satuan</th>
                                <th style="width: 20%;">Jumlah</th>
                                <th style="width: 20%;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($order['items']) == 0) : ?>
                                <h5>Keranjang Kosong</h5>
                            <?php else : ?>
                                <?php foreach ($order['items'] as $produkItem) : ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <img src="<?= $produkItem['imglink'] ?>" width="50px" height="50px" class="d-block" alt="...">
                                                    <div class="d-block">
                                                        <label class="d-block fw-bold"><?= substr($produkItem['keterangan'], 0, 30) . '...' ?></label>
                                                        <label class="d-block">Ukuran: <?= $produkItem['kodesize'] ?></label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <h6><?= $produkItem['harga'] ?></h6>
                                            </td>
                                            <td class="">
                                                <?= $produkItem['jumlah'] ?> pcs
                                            </td>
                                            <td class="">
                                                <h6 class="fw-bold"><?= $produkItem['subtotal'] ?></h6>
                                            </td>
                                        </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>