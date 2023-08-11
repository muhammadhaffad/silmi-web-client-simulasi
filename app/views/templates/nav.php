<nav class="fixed-top navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="<?=BASEURL.'/produk'?>">Web Client</a>
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['namapelanggan'])) : ?>
                    <a class="nav-link active" aria-current="page" href="<?=BASEURL.'/keranjang'?>">Keranjang</a>
                    <a class="nav-link" href="<?=BASEURL.'/dashboard'?>"><?=$_SESSION['namapelanggan']?></a>
                <?php else : ?>
                    <a class="nav-link" href="<?=BASEURL.'/login'?>">Masuk</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>