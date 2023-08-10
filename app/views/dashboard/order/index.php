<main class="w-100">
    <div class="container mx-2 mt-4 overflow-y-auto">
        <h3>Pesanan</h3>
        <?php foreach($data['order'] as $order): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="fw-bold">Order-<?=$order['idorder']?></h5>
                <p class="fw-bold mb-0"><?= $order['namacustomer'] ?></p>
                <p><?= $order['notlp'] ?></p>
                <p class="mb-0"><?= $order['alamat'] ?></p>
                <?php 
                    $kurir = [
                        1 => 'JNE'
                    ];
                ?>
                <p class="mb-0"><?= $kurir[$order['idekspedisi']] ?> - Rp.<?=$order['biayaongkir']?></p>
                <p class="mb-0">Rp.<?= $order['grandtotal'] ?></p>
                <a href="<?=BASEURL.'/dashboard/order/'.$order['idorder']?>" class="mt-2 btn btn-primary">Lihat Detail</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</main>