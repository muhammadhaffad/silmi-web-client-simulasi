<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'] ?: APP_NAME ?></title>
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/bootstrap-docs.min.css?ver=123">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/style.css?ver=123">
    <style>
        @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css");
    </style>

</head>

<body style="height: 100vh;">
    <div class="d-flex" style="height:100%;">
        <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px; height:100%;">
            <a href="<?=BASEURL.'/produk'?>" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <span class="fs-4">Web Client</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="<?= BASEURL . '/dashboard' ?>" class="nav-link <?= (preg_match('#/dashboard$#', $_SERVER['REQUEST_URI'])) ? 'active' : 'text-white' ?>" aria-current="page">
                        <i class="bi-house me-2"></i>
                        Home
                    </a>
                </li>
                <li>
                    <a href="<?= BASEURL . '/dashboard/order' ?>" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/dashboard/order')) ? 'active' : 'text-white' ?>">
                        <i class="bi-table me-2"></i>
                        Pesanan
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <ul class="nav nav-pills flex-column mb-auto">
                    <li>
                        <form action="<?=BASEURL.'/login/logout'?>" class="w-100" method="post">
                            <button type="submit" class="nav-link text-white bg-danger w-100" aria-current="page">
                                <i class="bi-box-arrow-left me-2"></i>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>