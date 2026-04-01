<?php

include_once __DIR__ . '/setting_database.php';

// Menentukan homeurl secara dinamis lewat .env
$homeurl = isset($_ENV['APP_URL']) ? rtrim($_ENV['APP_URL'], "/") : "http://" . $_SERVER['HTTP_HOST'];

$uri = $_SERVER['REQUEST_URI'];
if (($pos = strpos($uri, '?')) !== false) {
    $uri = substr($uri, 0, $pos);
}

// Ekstrak base path aplikasi dari APP_URL (misalnya /, atau /candy)
$parsedAppUrl = parse_url($homeurl);
$basePath = isset($parsedAppUrl['path']) ? rtrim($parsedAppUrl['path'], '/') : '';

// Jika aplikasi dijalankan di sub-direktori, hapus nama sub-direktori dari URI asli
if (!empty($basePath) && strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}

// Sekarang URI bersih (misal: /cbtpanel/login.php)
if (empty($uri) || strpos($uri, '/') !== 0) {
    $uri = '/' . $uri;
}

$pageurl = explode("/", $uri);

(isset($pageurl[1])) ? $pg = $pageurl[1] : $pg = '';
(isset($pageurl[2])) ? $ac = $pageurl[2] : $ac = '';
(isset($pageurl[3])) ? $id = $pageurl[3] : $id = 0;


function WaktuLamaCache2()
{ // ganti untuk lama waktu cache
    return 3600; //dalam detik
//1 jam 3600, 30 menit = 1800,10 menit=600,20 menit = 1200,5 menit = 300
}
require "config.database.php";

$setting = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM setting WHERE id_setting='1'"));

//time CBT ------------------------------------
$no = $jam = $mnt = $dtk = 0;
$info = '';
$waktu = date('H:i:s');
$tanggal = date('Y-m-d');
$datetime = date('Y-m-d H:i:s');

?>