<main>
    <div class="container">
        <div class="mx-auto vh-100" style="width: 320px; padding-top:120px;">
            <div class="row">
                <div class="w-100">
                    <?php Flasher::flash(); ?>
                </div>
            </div>
            <form method="post" action="<?= BASEURL . '/login/auth' ?>">
                <p>
                    Masukkan pin anda untuk masuk ke website.
                </p>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">PIN</label>
                    <input name="password" type="password" class="form-control" id="exampleInputPassword1">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</main>