<?php

require("../../config/config.default.php");
require("../../config/config.function.php");
//setting up one redis-----------------------------------------
require "../../vendor/autoload.php";
use RedisClient\RedisClient;
use RedisClient\Client\Version\RedisClient2x6;
use RedisClient\ClientFactory;

$Redis = new RedisClient();

//setting up one redis-----------------------------------------

$kode = $_POST['id'];
cek_session_guru();
$exec = mysqli_query($koneksi, "DELETE FROM materi2 WHERE materi2_id=$kode");
try { $Redis->del("baca_materi".$kode); }catch (Exception $e) { } 

