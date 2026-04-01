<?php

require "../config/setting_database.php";
error_reporting(0);
//setingan lewat aplikasi di db
// $db_host = $setting['db_host_server'];
// $db_user = $setting['db_user_server'];
// $db_pass = $setting['db_pass_server'];
// $db_name = $setting['db_name_server'];

//setting langsung
$db_host = $hostdb_server;
$db_user = $userdb_server;
$db_pass = $passdb_server;
$db_name = $namadb_server;
$kodeServer = "SR01"; //KODE SERVER PADA PUSAT

$koneksipusat = mysqli_connect($db_host, $db_user, $db_pass);
if ($koneksipusat) {
    $pilihdbpusat = mysqli_select_db($koneksipusat, $db_name);
}


