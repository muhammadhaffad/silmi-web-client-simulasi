<?php 
if( !session_id() ) session_start();

require_once '../app/init.php';
$_SESSION['idpelanggan'] = $_SESSION['idpelanggan'] ?: 1;
$app = new App;