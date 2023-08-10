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
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <span class="fs-4">Web Client</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link active" aria-current="page">
                        <i class="bi-house me-2"></i>
                        Home
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white">
                        <i class="bi-table me-2"></i>
                        Pesanan
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <ul class="nav nav-pills flex-column mb-auto">
                    <li>
                        <a href="#" class="nav-link text-white bg-danger" aria-current="page">
                            <i class="bi-box-arrow-left me-2"></i>
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
