<?php

include 'setting_database.php';
$host = $hostdb;
$user = $userdb;
$pass = $passdb;
$debe = $namadb;



$koneksi = mysqli_connect($host, $user, $pass, "");
if ($koneksi) {
  $pilihdb = mysqli_select_db($koneksi, $debe);
  $setting = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM setting WHERE id_setting='1'"));
  mysqli_set_charset($koneksi, 'utf8');
  $sess = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM session WHERE id='1'"));
  date_default_timezone_set($setting['waktu']);
}



//di setting juga ya ^_^
class Db{ //Pengaturan Database Untuk Versi Candy27_butoijo

    private $host1;
    private $user1;
    private $password1;
    private $debe1;
    public $con;
    public $kode_redis;

    function __construct() {
        include 'setting_database.php';
        $this->host1     = $hostdb;
        $this->user1     = $userdb;
        $this->pass1     = $passdb;
        $this->debe1     = $namadb;
        $this->kode_redis = $kodeRedis;
        $this->con   = new mysqli($this->host1, $this->user1, $this->pass1, $this->debe1);
    }
    public function Koneksidb(){
        return $this->con;
    }
}