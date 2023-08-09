<?php 
if( !session_id() ) session_start();

require_once '../app/init.php';
$_SESSION['idpelanggan'] = $_SESSION['idpelanggan'] ?: 2;
$app = new App;